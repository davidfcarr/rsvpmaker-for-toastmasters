import React, { useRef } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import mytranslate from './mytranslate'
import simplifyPastedHtml from './simplifyPastedHtml';

export function EditorAgendaNote(props) {
  const editorRef = useRef(null);
  const {block, blockindex, replaceBlock,data} = props;

  function save() {
      const currentContent = editorRef.current ? editorRef.current.getContent() : '';
      block.innerHTML = simplifyPastedHtml(currentContent);
      replaceBlock(blockindex, block);
  }

  return (
    <>
     <h4>{mytranslate('Agenda Note', data)}</h4>
     <Editor
        onInit={(evt, editor) => editorRef.current = editor}
        initialValue={block.innerHTML}
        init={{
          height: 100,
          plugins: 'link autolink',
          toolbar: 'undo redo | bold italic | link | removeformat',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }}
      />
      <p><button className="tmform" onClick={save}>{mytranslate('Update', data)}</button></p>
      <p><em>{mytranslate('Agenda notes are the "stage directions" for your meeting. For elements like meeting theme that change from meeting to meeting, use an Editable Note instead.', data)}</em></p>
    </>
  );
}