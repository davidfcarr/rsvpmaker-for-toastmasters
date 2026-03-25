export default function simplifyPastedHtml(html) {
  const parser = new DOMParser();
  const sourceDoc = parser.parseFromString(html, 'text/html');
  const outputDoc = document.implementation.createHTMLDocument('');
  const allowedInlineTags = new Set(['strong', 'b', 'em', 'i', 'br', 'a']);
  const blockTags = new Set([
    'address', 'article', 'aside', 'blockquote', 'div', 'dl', 'dt', 'dd',
    'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3',
    'h4', 'h5', 'h6', 'header', 'hr', 'li', 'main', 'nav', 'ol', 'p', 'pre',
    'section', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'tr', 'ul'
  ]);

  function hasContent(node) {
    return node.innerHTML.replace(/<br\s*\/?>/gi, '').trim() !== '';
  }

  function appendInlineContent(sourceNode, targetNode) {
    if (sourceNode.nodeType === Node.TEXT_NODE) {
      targetNode.appendChild(outputDoc.createTextNode(sourceNode.textContent));
      return;
    }

    if (sourceNode.nodeType !== Node.ELEMENT_NODE) {
      return;
    }

    const tag = sourceNode.tagName.toLowerCase();

    if (allowedInlineTags.has(tag)) {
      const cleanNode = outputDoc.createElement(tag);
      Array.from(sourceNode.childNodes).forEach((child) => {
        appendInlineContent(child, cleanNode);
      });
      if (tag === 'a' && sourceNode.getAttribute('href')) {
        cleanNode.setAttribute('href', sourceNode.getAttribute('href'));
      }
      targetNode.appendChild(cleanNode);
      return;
    }

    Array.from(sourceNode.childNodes).forEach((child) => {
      appendInlineContent(child, targetNode);
    });
  }

  function collectParagraphs(sourceNode, paragraphs) {
    if (sourceNode.nodeType === Node.TEXT_NODE) {
      if (sourceNode.textContent.trim()) {
        const paragraph = outputDoc.createElement('p');
        paragraph.appendChild(outputDoc.createTextNode(sourceNode.textContent.trim()));
        paragraphs.push(paragraph);
      }
      return;
    }

    if (sourceNode.nodeType !== Node.ELEMENT_NODE) {
      return;
    }

    const tag = sourceNode.tagName.toLowerCase();
    const isBlock = blockTags.has(tag);

    if (!isBlock) {
      const paragraph = outputDoc.createElement('p');
      appendInlineContent(sourceNode, paragraph);
      if (hasContent(paragraph)) {
        paragraphs.push(paragraph);
      }
      return;
    }

    let paragraph = outputDoc.createElement('p');
    Array.from(sourceNode.childNodes).forEach((child) => {
      const childIsBlock = child.nodeType === Node.ELEMENT_NODE && blockTags.has(child.tagName.toLowerCase());

      if (childIsBlock) {
        if (hasContent(paragraph)) {
          paragraphs.push(paragraph);
          paragraph = outputDoc.createElement('p');
        }
        collectParagraphs(child, paragraphs);
        return;
      }

      appendInlineContent(child, paragraph);
    });

    if (hasContent(paragraph)) {
      paragraphs.push(paragraph);
    }
  }

  const paragraphs = [];
  Array.from(sourceDoc.body.childNodes).forEach((node) => {
    collectParagraphs(node, paragraphs);
  });

  return paragraphs.map((paragraph) => paragraph.outerHTML).join('');
}