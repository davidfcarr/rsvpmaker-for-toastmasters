import React, { useRef, useEffect, useState } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import apiClient, { setupNonceInterceptor } from './http-common.js';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import {useMutation, useQueryClient} from 'react-query';
import {SanitizedHTML} from './SanitizedHTML.js';
import { __experimentalNumberControl as NumberControl, TextControl } from '@wordpress/components';
import {initChangeBlockAttribute,updateAgenda} from './queries.js'

function decodeAgendaHtml(value = '') {
  if (!value || typeof value !== 'string') {
    return '';
  }

  const decoded = value
    .replace(/\\u003c|u003c/gi, '<')
    .replace(/\\u003e|u003e/gi, '>')
    .replace(/\\u0026|u0026/gi, '&')
    .replace(/\\u0022|u0022/gi, '"')
    .replace(/\\u0027|u0027/gi, "'")
    .replace(/\\n/g, "\n")
    .replace(/\\r/g, "\r")
    .replace(/<\/p>\s*n\s*<p/gi, '</p>\n<p');

  return decoded
    // remove accidental empty paragraphs inserted between non-empty paragraphs
    .replace(/(<\/p>)(?:\s*<p>(?:\s|&nbsp;|<br\s*\/?\s*>)*<\/p>\s*)+(<p)/gi, '$1$2')
    // normalize paragraph boundary whitespace to avoid visual double spacing in editors
    .replace(/<\/p>\s+<p/gi, '</p><p');
}

function hasMeaningfulContent(html = '') {
  return html
    .replace(/<[^>]*>/g, ' ')
    .replace(/&nbsp;/gi, ' ')
    .trim().length > 0;
}

export function EditableNote(props) {
    const editorRef = useRef(null);
    const {post_id, block, makeNotification, insertBlock, blockindex, setInsert} = props;
    const [att,setAtt] = useState(block.attrs);
    const [submitted,setSubmitted] = useState(false);
    const [liveHtml, setLiveHtml] = useState(null);

    const {mutate:agendaMutate} = updateAgenda(post_id, makeNotification);
    const changeBlockAttribute = initChangeBlockAttribute(post_id,blockindex);

    const rsvpmaker_rest = useRsvpmakerRest();
    
    useEffect(() => {
        if (rsvpmaker_rest?.nonce) {
        setupNonceInterceptor(rsvpmaker_rest.nonce);
        }
    }, [rsvpmaker_rest?.nonce]);

    const isTemplateDoc = !!props.isTemplate || rsvpmaker_rest?.post_type === 'rsvpmaker_template';
    const metaContent = decodeAgendaHtml(block?.edithtml || '');
    const defaultContent = decodeAgendaHtml(att?.defaultContent || block?.attrs?.defaultContent || '');
    const displayHtml = hasMeaningfulContent(metaContent) ? metaContent : defaultContent;
    const renderedHtml = liveHtml !== null ? liveHtml : displayHtml;

    useEffect(() => {
      setLiveHtml(null);
    }, [post_id, blockindex, block?.attrs?.uid]);

    function save() {
      if(insertBlock) {
        const editorContent = editorRef.current ? editorRef.current.getContent() : '';
        const nextAtt = {...att, 'uid': Date.now(), 'defaultContent': editorContent};
        setLiveHtml(editorContent);
        setAtt(nextAtt);
        insertBlock(blockindex,nextAtt,'wp4toastmasters/agendaedit','','');//use defaultContent; no postmeta override yet
        setInsert('');
      } else {
        const editorContent = editorRef.current ? editorRef.current.getContent() : '';
        setLiveHtml(editorContent);
        setSubmitted(true);
        if (isTemplateDoc) {
          const change = changeBlockAttribute('editable', att.editable);
          change.blocksdata[blockindex].attrs.defaultContent = editorContent;
          change.blocksdata[blockindex].edithtml = editorContent;
          agendaMutate(change);
          makeNotification('Updated template default content');
          return;
        }

        if ((att?.editable || '') !== (block?.attrs?.editable || '')) {
          const change = changeBlockAttribute('editable', att.editable);
          agendaMutate(change);
        }

        const submitnote = {'note':editorContent,'uid':att.uid,'post_id':props.post_id,'editable':att.editable};
        editEditable.mutate(submitnote);
      }
  }

  const queryClient = useQueryClient();

  const editEditable = useMutation(
      (edit) => { apiClient.post("editable_note_json", edit)},
      {

        onMutate: async (edit) => {
          await queryClient.cancelQueries(['blocks-data',post_id]);
          const previousData = queryClient.getQueryData(['blocks-data',post_id]);
          queryClient.setQueryData(['blocks-data',post_id],(oldQueryData) => {
              //function passed to setQueryData
              const {data} = oldQueryData;
              const {blocksdata} = data;
              blocksdata[blockindex].edithtml = edit.note;
                blocksdata[blockindex].attrs.defaultContent = edit.note;
              const newdata = {
                  ...oldQueryData, data: {...data,blocksdata: blocksdata}
              };
              return newdata;
  }) 
          makeNotification('Updating ...');
          setSubmitted(true);
          return {previousData}
      },
        // On failure, roll back to the previous value
        onError: (err, variables, previousValue) => {
          makeNotification('Error updating editable note '+err.message);
          console.log('error updating editable note',err);
          setLiveHtml(null);
          queryClient.setQueryData(['blocks-data',post_id], previousValue);
        },
        // After success or failure, refetch the todos query
        onSettled: (data, error, variables, context) => {
          queryClient.invalidateQueries(['blocks-data',variables.post_id]);
      },
      onSuccess: (data, error, variables, context) => {
          if (data?.data?.note) {
            setLiveHtml(decodeAgendaHtml(data.data.note));
          }
          if (data?.data?.note) {
            queryClient.setQueryData(['blocks-data',post_id],(oldQueryData) => {
              if (!oldQueryData?.data?.blocksdata?.[blockindex]) {
                return oldQueryData;
              }

              const { data: queryData } = oldQueryData;
              const blocksdata = [...queryData.blocksdata];
              const blockData = {
                ...blocksdata[blockindex],
                attrs: {
                  ...blocksdata[blockindex].attrs,
                  defaultContent: data.data.note,
                },
                edithtml: data.data.note,
              };

              blocksdata[blockindex] = blockData;

              return {
                ...oldQueryData,
                data: {
                  ...queryData,
                  blocksdata,
                },
              };
            });
          }
          makeNotification('Updated');
      },
    }
  );

  if(!submitted && ((['edit','reorganize'].includes(props.mode)) || insertBlock))
  return (
    <>
    {!!att.editable && <h3>{att.editable}</h3>}
    <p><TextControl label="heading" value={att.editable} onChange={ (title) => {setAtt( (prev) => {return {...prev,'editable':title} } )} }  /></p>
      <Editor
        onInit={(evt, editor) => editorRef.current = editor}
        initialValue={renderedHtml}
        init={{
          height: 100,
          menubar: false,
          toolbar: 'undo redo | bold italic | removeformat',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }}
      />
<>{insertBlock && <div className="tmflexrow"><div className="tmflex30"><NumberControl label="Time Allowed" value={att.time_allowed} onChange={ (value) => { setAtt((prev) => { return {...prev,time_allowed:value} }  ); }} /></div></div>}</>            
<p><button className="tmform" onClick={save}>Update</button></p>
<p><em>Editable notes are for content that changes from meeting to meeting, such as a meeting theme.</em></p>
    </>
  );

  //view logic 
  return (
    <>
    {!!att.editable && <h3>{att.editable}</h3>}
    <SanitizedHTML innerHTML={renderedHtml} />
    {(submitted && (('edit' == props.mode) || insertBlock)) && <p><button onClick={() => setSubmitted(false)}>Edit</button></p>}
    </>
  );
}