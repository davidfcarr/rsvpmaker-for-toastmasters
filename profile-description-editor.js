(function ($) {
	function sanitizeUrl(url) {
		if (!url) {
			return '';
		}
		var value = String(url).trim();
		if (/^(https?:|mailto:|tel:|\/|#)/i.test(value)) {
			return value;
		}
		return '';
	}

	function sanitizeHtml(html) {
		var parser = new DOMParser();
		var doc = parser.parseFromString('<div>' + (html || '') + '</div>', 'text/html');
		var root = doc.body.firstElementChild;

		function walk(node, ownerDoc) {
			if (!node) {
				return ownerDoc.createDocumentFragment();
			}

			if (node.nodeType === Node.TEXT_NODE) {
				return ownerDoc.createTextNode(node.nodeValue || '');
			}

			if (node.nodeType !== Node.ELEMENT_NODE) {
				return ownerDoc.createDocumentFragment();
			}

			var tag = node.tagName.toLowerCase();
			if (tag === 'b') {
				tag = 'strong';
			}
			if (tag === 'i') {
				tag = 'em';
			}

			var allowed = {
				p: true,
				strong: true,
				em: true,
				a: true
			};

			if (!allowed[tag]) {
				var fragment = ownerDoc.createDocumentFragment();
				Array.prototype.forEach.call(node.childNodes, function (child) {
					fragment.appendChild(walk(child, ownerDoc));
				});
				return fragment;
			}

			var cleanEl = ownerDoc.createElement(tag);
			if (tag === 'a') {
				var href = sanitizeUrl(node.getAttribute('href'));
				if (href) {
					cleanEl.setAttribute('href', href);
				}
				var target = node.getAttribute('target');
				if (target === '_blank') {
					cleanEl.setAttribute('target', '_blank');
					cleanEl.setAttribute('rel', 'noopener noreferrer');
				}
			}

			Array.prototype.forEach.call(node.childNodes, function (child) {
				cleanEl.appendChild(walk(child, ownerDoc));
			});

			return cleanEl;
		}

		var outputDoc = document.implementation.createHTMLDocument('');
		var outputRoot = outputDoc.createElement('div');
		Array.prototype.forEach.call(root.childNodes, function (child) {
			outputRoot.appendChild(walk(child, outputDoc));
		});

		return outputRoot.innerHTML;
	}

	function sanitizeTextarea() {
		var textarea = document.getElementById('description');
		if (!textarea) {
			return;
		}
		textarea.value = sanitizeHtml(textarea.value);
	}

	function initProfileDescriptionEditor() {
		if (!window.tinymce || !document.getElementById('description')) {
			return;
		}

		var setCleanState = function () {
			var editor = window.tinymce.get('description');
			if (editor && typeof editor.setDirty === 'function') {
				editor.setDirty(false);
			}
		};

		if (window.wp && window.wp.editor && typeof window.wp.editor.initialize === 'function') {
			window.wp.editor.initialize('description', {
				tinymce: {
					wpautop: true,
					menubar: false,
					toolbar1: 'bold italic | link unlink',
					toolbar2: '',
					plugins: 'link paste',
					valid_elements: 'p,strong/b,em/i,a[href|target|rel]',
					paste_preprocess: function (plugin, args) {
						args.content = sanitizeHtml(args.content);
					},
					setup: function (editor) {
						editor.on('init', function () {
							window.setTimeout(setCleanState, 0);
						});
						editor.on('Paste', function () {
							window.setTimeout(function () {
								editor.save();
								sanitizeTextarea();
								setCleanState();
							}, 0);
						});
					}
				},
				quicktags: false,
				mediaButtons: false
			});
		} else {
			window.tinymce.init({
				selector: '#description',
				menubar: false,
				toolbar: 'bold italic | link unlink',
				plugins: 'link paste',
				valid_elements: 'p,strong/b,em/i,a[href|target|rel]',
				paste_preprocess: function (plugin, args) {
					args.content = sanitizeHtml(args.content);
				},
				setup: function (editor) {
					editor.on('init', function () {
						window.setTimeout(setCleanState, 0);
					});
					editor.on('Paste', function () {
						window.setTimeout(function () {
							editor.save();
							sanitizeTextarea();
							setCleanState();
						}, 0);
					});
				}
			});
		}
	}

	$(function () {
		initProfileDescriptionEditor();
		$(document).on('paste', '#description', function () {
			window.setTimeout(sanitizeTextarea, 0);
		});
		$(document).on('submit', 'form', function () {
			if (window.tinyMCE && typeof window.tinyMCE.triggerSave === 'function') {
				window.tinyMCE.triggerSave();
			}
			sanitizeTextarea();
		});
	});
})(jQuery);
