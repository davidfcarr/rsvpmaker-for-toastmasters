import React, { useRef } from 'react';
import { Editor } from '@tinymce/tinymce-react';
import mytranslate from './mytranslate'
import simplifyPastedHtml from './simplifyPastedHtml';

export function EditorAgendaNote(props) {
  const editorRef = useRef(null);
  const {block, blockindex, replaceBlock,data} = props;

  function normalizeToSingleParagraph(html) {
    const parser = new DOMParser();
    const sourceDoc = parser.parseFromString(html || '', 'text/html');
    const paragraphs = Array.from(sourceDoc.body.querySelectorAll('p'));

    if (!paragraphs.length) {
      const fallback = sourceDoc.body.innerHTML ? sourceDoc.body.innerHTML.trim() : '';
      return fallback ? `<p>${fallback}</p>` : '<p></p>';
    }

    const merged = paragraphs
      .map((paragraph) => paragraph.innerHTML.trim())
      .filter((part) => part !== '')
      .join('<br><br>');

    return `<p>${merged}</p>`;
  }

  function save() {
      const currentContent = editorRef.current ? editorRef.current.getContent() : '';
    const simplified = simplifyPastedHtml(currentContent);
    const normalized = normalizeToSingleParagraph(simplified);
    const content = normalized.replace(/^<p[^>]*>/i, '').replace(/<\/p>\s*$/i, '');

    const nextBlock = {
      ...block,
      innerHTML: normalized,
      attrs: {
        ...(block?.attrs || {}),
        content,
      },
    };

    replaceBlock(blockindex, nextBlock);
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