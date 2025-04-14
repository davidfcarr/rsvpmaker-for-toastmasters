import React, { useRef, useState } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import mytranslate from './mytranslate'

export function EditorAgendaNote(props) {
  const editorRef = useRef(null);
  const {block, blockindex, replaceBlock,data} = props;

  function save() {
      block.innerHTML = editorRef.current.getContent();
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
          menubar: false,
          toolbar: 'undo redo | bold italic | removeformat',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }}
      />
      <p><button className="tmform" onClick={save}>{mytranslate('Update', data)}</button></p>
      <p><em>{mytranslate('Agenda notes are the "stage directions" for your meeting. For elements like meeting theme that change from meeting to meeting, use an Editable Note instead.', data)}</em></p>
    </>
  );
}