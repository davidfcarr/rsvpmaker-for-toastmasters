function decodeUnicodeTokens(value = '') {
	if (!value || typeof value !== 'string') {
		return '';
	}

	const decodeHex = (_, hex) => {
		const codePoint = parseInt(hex, 16);
		if (!Number.isFinite(codePoint)) {
			return _;
		}
		return String.fromCharCode(codePoint);
	};

	return value
		.replace(/\\+u([0-9a-fA-F]{4})/g, decodeHex)
		.replace(/u([0-9a-fA-F]{4})/g, decodeHex);
}

export function decodeAgendaText(value = '') {
	if (!value || typeof value !== 'string') {
		return '';
	}

	return decodeUnicodeTokens(value)
		.replace(/\\n/g, '\n')
		.replace(/\\r/g, '\r');
}

export function decodeAgendaHtml(value = '') {
	const decoded = decodeAgendaText(value);

	return decoded
		.replace(/<\/p>\s*n\s*<p/gi, '</p>\n<p')
		.replace(/(<\/p>)(?:\s*<p>(?:\s|&nbsp;|<br\s*\/?\s*>)*<\/p>\s*)+(<p)/gi, '$1$2')
		.replace(/<\/p>\s+<p/gi, '</p><p');
}