/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/gblocks/agenda-layout.js":
/*!**************************************!*\
  !*** ./src/gblocks/agenda-layout.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./src/gblocks/style.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/gblocks/editor.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__);
/**

 * BLOCK: rsvpmaker-for-toastmasters agenda wrapper

 *

 */

//  Import CSS.




const {
  __
} = wp.i18n;
const {
  registerBlockType
} = wp.blocks;
const {
  InnerBlocks
} = wp.editor;
const {
  FormToggle,
  ServerSideRender
} = wp.components;
if (typeof wpt_rest.special !== 'undefined' && wpt_rest.special == 'Agenda Layout') {
  // only initialize these blocks for Agenda Layout document

  registerBlockType('wp4toastmasters/agenda-wrapper', {
    title: 'Agenda Layout Wrapper',
    // Block title.

    icon: 'admin-comments',
    category: 'layout',
    keywords: ['Toastmasters', 'Agenda', 'Wrapper'],
    attributes: {
      sidebar: {
        type: 'boolean',
        default: true
      }
    },
    edit: function (props) {
      const TEMPLATE = [['wp4toastmasters/agendasidebar']];
      const {
        attributes,
        className,
        setAttributes,
        isSelected
      } = props;
      if (attributes.sidebar) return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: className,
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("table", {
          id: "agenda-main",
          width: "700",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("tbody", {
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("tr", {
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("td", {
                id: "agenda-sidebar",
                width: "175",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(InnerBlocks, {
                  template: TEMPLATE
                })
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("td", {
                id: "agenda-main",
                width: "*",
                children: ["Placeholder for role info, agenda notes, etc. ", rsvpmaker_ajax.special, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("p", {
                  children: ["Include sidebar: ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(FormToggle, {
                    checked: attributes.sidebar,
                    onChange: function () {
                      setAttributes({
                        sidebar: !attributes.sidebar
                      });
                    }
                  })]
                })]
              })]
            })
          })
        })
      });

      // no sidebar

      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("div", {
        className: className,
        children: ["Placeholder for role info, agenda notes, etc.", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("p", {
          children: ["Include sidebar: ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(FormToggle, {
            checked: attributes.sidebar,
            onChange: function () {
              setAttributes({
                sidebar: !attributes.sidebar
              });
            }
          })]
        })]
      });
    },
    save: function ({
      attributes,
      className
    }) {
      if (attributes.sidebar) return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: className,
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("table", {
          id: "agenda-main",
          width: "700",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("tbody", {
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsxs)("tr", {
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("td", {
                id: "agenda-sidebar",
                width: "175",
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)(InnerBlocks.Content, {})
              }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("td", {
                id: "agenda-main",
                width: "*",
                children: "[tmlayout_main]"
              })]
            })
          })
        })
      });

      //no sidebar

      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: className,
        children: "[tmlayout_main]"
      });
    }
  });
  registerBlockType('wp4toastmasters/agendasidebar', {
    // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

    title: __('Agenda Sidebar'),
    // Block title.

    icon: 'admin-comments',
    // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

    category: 'common',
    // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

    keywords: [__('Toastmasters'), __('Agenda'), __('Sidebar')],
    description: __('Placeholder for sidebar content in the agenda layout. Includes officer listing if specified in Settings -> Toastmasters.'),
    edit: function (props) {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_2__.jsx)("div", {
        className: "agendaplaceholder",
        children: "Placeholder: sidebar content"
      });
    },
    save: function (props) {
      return null;
    }
  });

  /*
  
  registerBlockType( 'wp4toastmasters/agendamain', {
  
  	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  
  	title: __( 'Agenda Main Content' ), // Block title.
  
  	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  
  	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  
  	keywords: [
  
  		__( 'Toastmasters' ),
  
  		__( 'Agenda' ),
  
  		__( 'Main' ),
  
  	],
  
  	description: __('Placeholder for main content (roles and agenda notes) in the agenda layout'),
  
      edit: function( props ) {
  
  	const { attributes } = props;	
  
  
  
  	return (
  
  		<div className="agendaplaceholder">Placeholder: agenda main content
  
  		 <ServerSideRender
  
                  block="wp4toastmasters/agendamain"
  
  				attributes={ attributes }
  
              />
  
  		</div>
  
  );
  
  	
  
      },
  
      save: function(props) {
  
      return null;
  
      }
  
  } ); 
  
  
  
  registerBlockType( 'wp4toastmasters/officers', {
  
  	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  
  	title: __( 'Agenda Officers Listing' ), // Block title.
  
  	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  
  	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  
  	keywords: [
  
  		__( 'Toastmasters' ),
  
  		__( 'Agenda' ),
  
  		__( 'Officers' ),
  
  	],
  
  	description: __('Placeholder for output of officers listing, based on data from Settings -> Toastmasters.'),
  
      edit: function( props ) {	
  
  
  
  	return (
  
  		<div>
  
  		<div className="agendaplaceholder">From Settings -&gt; Toastmasters</div>
  
  		 <ServerSideRender
  
                  block="wp4toastmasters/officers"
  
              />
  
  		</div>
  
  );	
  
      },
  
      save: function(props) {
  
      return null;
  
      }
  
  } ); 
  */
} // end of check that this is an Agenda Layout document

/***/ }),

/***/ "./src/gblocks/agenda_context.js":
/*!***************************************!*\
  !*** ./src/gblocks/agenda_context.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);
/**
 * BLOCK: Agenda context display
 *
 */

const {
  __
} = wp.i18n;
const {
  registerBlockType
} = wp.blocks;
const {
  Fragment
} = wp.element;


const {
  Component
} = wp.element;
const {
  InspectorControls
} = wp.blockEditor;
const {
  PanelBody,
  ToggleControl,
  SelectControl
} = wp.components;
registerBlockType('wp4toastmasters/context', {
  title: 'Agenda Display Wrapper',
  // Block title.
  icon: 'admin-comments',
  category: 'common',
  keywords: ['Toastmasters', 'Agenda Wrapper', 'Wrapper'],
  attributes: {
    content: {
      type: 'array',
      source: 'children',
      selector: 'p'
    },
    webContext: {
      type: 'boolean',
      default: true
    },
    emailContext: {
      type: 'boolean',
      default: true
    },
    agendaContext: {
      type: 'boolean',
      default: true
    },
    printContext: {
      type: 'boolean',
      default: true
    },
    anonContext: {
      type: 'boolean',
      default: true
    }
  },
  edit: function (props) {
    const {
      attributes,
      className,
      setAttributes,
      isSelected
    } = props;
    const {
      webContext,
      emailContext,
      agendaContext,
      printContext
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ContextInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
          class: "context-block-label",
          children: "CLICK TO SET DISPLAY CONTEXT"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InnerBlocks, {})]
      })]
    });
  },
  save: function ({
    attributes,
    className
  }) {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
      className: className,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InnerBlocks.Content, {})
    });
  }
});
class ContextInspector extends Component {
  render() {
    const {
      attributes,
      className,
      setAttributes,
      isSelected
    } = this.props;
    const {
      webContext,
      emailContext,
      agendaContext,
      printContext,
      anonContext
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(InspectorControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(PanelBody, {
        title: __('Display', 'rsvpmaker-for-toastmasters'),
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
          label: "Web / Signup Page",
          help: webContext ? 'Show on website / agenda signup view.' : 'Do not show on website / agenda signup view.',
          checked: webContext,
          onChange: webContext => setAttributes({
            webContext
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
          label: "Agenda",
          help: agendaContext ? 'Show on agenda (email or print).' : 'Do not show on agenda (email or print).',
          checked: agendaContext,
          onChange: agendaContext => setAttributes({
            agendaContext
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
          label: "Email",
          help: emailContext ? 'Show on email agenda.' : 'Do not show on email agenda.',
          checked: emailContext,
          onChange: emailContext => setAttributes({
            emailContext
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
          label: "Print",
          help: printContext ? 'Show on print agenda.' : 'Do not show on print agenda.',
          checked: printContext,
          onChange: printContext => setAttributes({
            printContext
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
          label: "Anonymous Users",
          help: anonContext ? 'No login required.' : 'Limit to logged in users and club email notifications.',
          checked: anonContext,
          onChange: anonContext => setAttributes({
            anonContext
          })
        })]
      })
    }, "contextInspector");
  }
}

/***/ }),

/***/ "./src/gblocks/block.js":
/*!******************************!*\
  !*** ./src/gblocks/block.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./src/gblocks/style.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./src/gblocks/editor.scss");
/* harmony import */ var _agenda_context_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./agenda_context.js */ "./src/gblocks/agenda_context.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);
/**

 * BLOCK: wpt

 *

 * Registering a basic block with Gutenberg.

 * Simple block, renders and saves the same content without any interactivity.

 */

//  Import CSS.





//import './logo.js';

const {
  __
} = wp.i18n; // Import __() from wp.i18n

const {
  registerBlockType
} = wp.blocks; // Import registerBlockType() from wp.blocks

const {
  RichText
} = wp.blockEditor;
const {
  Component,
  Fragment
} = wp.element;
const {
  InspectorControls,
  PanelBody
} = wp.blockEditor;
const {
  TextareaControl,
  SelectControl,
  ToggleControl,
  TextControl,
  ServerSideRender
} = wp.components;


const {
  subscribe
} = wp.data;
var agenda = [];
var master_agenda_update = 0;
function agenda_update() {
  let geturl = wpt_rest.url + 'rsvptm/v1/tweak_times?post_id=' + wpt_rest.post_id;
  fetch(geturl, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'X-WP-Nonce': wpt_rest.nonce
    }
  }).then(response => response.json()).then(data => {
    agenda = data;
  }).catch(error => {
    console.error('Error:', error);
  });
}
if (wpt_rest.is_agenda) agenda_update();

/**

 * Register: aa Gutenberg Block.

 *

 * Registers a new block provided a unique name and an object defining its

 * behavior. Once registered, the block is made editor as an option to any

 * editor interface where blocks are implemented.

 *

 * @link https://wordpress.org/gutenberg/handbook/block-api/

 * @param  {string}   name     Block name.

 * @param  {Object}   settings Block settings.

 * @return {?WPBlock}          The block, if it has been successfully

 *                             registered; otherwise `undefined`.

 */

registerBlockType('wp4toastmasters/agendanoterich2', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Agenda Note'),
  // Block title.

  icon: 'admin-comments',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  description: __('Displays "stage directions" for the organization of your meetings.', 'rsvpmaker'),
  keywords: [__('Toastmasters'), __('Agenda'), __('Rich Text')],
  attributes: {
    content: {
      source: 'html',
      selector: 'p'
    },
    time_allowed: {
      type: 'string',
      default: '0'
    },
    uid: {
      type: 'string',
      default: ''
    },
    timing_updated: {
      type: 'int',
      default: agenda
    },
    show_timing_summary: {
      type: 'boolean',
      default: false
    }
  },
  edit: function (props) {
    const {
      attributes,
      attributes: {
        show_timing_summary,
        time_allowed
      },
      className,
      setAttributes,
      isSelected
    } = props;
    var uid = props.attributes.uid;
    if (!uid) {
      var date = new Date();
      uid = 'note' + date.getTime() + Math.random();
      setAttributes({
        uid
      });
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(NoteInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
            children: "Toastmasters Agenda Note"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(RichText, {
          tagName: "p",
          value: attributes.content,
          onChange: content => setAttributes({
            content
          })
        }), isSelected && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("em", {
              children: "Options: see sidebar"
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ToggleControl, {
            label: "Show Timing Summary",
            help: show_timing_summary ? 'Show' : 'Do not show',
            checked: show_timing_summary,
            onChange: show_timing_summary => setAttributes({
              show_timing_summary
            })
          }), show_timing_summary && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ServerSideRender, {
            block: "wp4toastmasters/agendanoterich2",
            attributes: props.attributes
          })]
        })]
      })]
    });
  },
  save: function ({
    attributes,
    className
  }) {
    //return null;

    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(RichText.Content, {
      tagName: "p",
      value: attributes.content,
      className: className
    });
  }
});
registerBlockType('wp4toastmasters/signupnote', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Signup Form Note'),
  // Block title.

  icon: 'admin-comments',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  description: __('A text block that appears only on the signup form, not on the agenda.'),
  keywords: [__('Toastmasters'), __('Signup'), __('Rich Text')],
  attributes: {
    content: {
      type: 'array',
      source: 'children',
      selector: 'p'
    }
  },
  edit: function (props) {
    const {
      attributes,
      setAttributes
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(DocInspector, {}), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
          children: "Toastmasters Signup Form Note"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(RichText, {
          tagName: "p",
          className: props.className,
          value: props.attributes.content,
          onChange: content => setAttributes({
            content
          })
        })]
      })]
    });
  },
  save: function (props) {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(RichText.Content, {
      tagName: "p",
      value: props.attributes.content,
      className: props.className
    });
  }
});
registerBlockType('wp4toastmasters/role', {
  // Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Agenda Role'),
  // Block title.

  icon: 'groups',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  description: __('Defines a meeting role that will appear on the signup form and the agenda.'),
  keywords: [__('Toastmasters'), __('Agenda'), __('Role')],
  attributes: {
    role: {
      type: 'string',
      default: ''
    },
    custom_role: {
      type: 'string',
      default: ''
    },
    count: {
      type: 'int',
      default: 1
    },
    start: {
      type: 'int',
      default: 1
    },
    agenda_note: {
      type: 'string',
      default: ''
    },
    time_allowed: {
      type: 'string',
      default: '0'
    },
    timing_updated: {
      type: 'int',
      default: 0
    },
    padding_time: {
      type: 'string',
      default: '0'
    },
    backup: {
      type: 'string',
      default: ''
    },
    show_timing_summary: {
      type: 'boolean',
      default: false
    }
  },
  edit: function (props) {
    const {
      attributes: {
        role,
        custom_role,
        count,
        start,
        agenda_note,
        time_allowed,
        padding_time,
        backup,
        show_timing_summary
      },
      setAttributes,
      isSelected
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(RoleInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("strong", {
          children: ["Toastmasters Role ", role, " ", custom_role]
        }), isSelected && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
            children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("em", {
              children: "Options: see sidebar"
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ToggleControl, {
            label: "Show Timing Summary",
            help: show_timing_summary ? 'Show' : 'Do not show',
            checked: show_timing_summary,
            onChange: show_timing_summary => setAttributes({
              show_timing_summary
            })
          }), show_timing_summary && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ServerSideRender, {
            block: "wp4toastmasters/role",
            attributes: props.attributes
          })]
        })]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
registerBlockType('wp4toastmasters/agendaedit', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Editable Note'),
  // Block title.

  icon: 'welcome-write-blog',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  keywords: [__('Toastmasters'), __('Agenda'), __('Editable')],
  description: __('A note that can be edited by a meeting organizer'),
  attributes: {
    editable: {
      type: 'string',
      default: ''
    },
    uid: {
      type: 'string',
      default: ''
    },
    time_allowed: {
      type: 'string',
      default: '0'
    },
    timing_updated: {
      type: 'int',
      default: 0
    },
    inline: {
      type: 'int',
      default: 0
    },
    show_timing_summary: {
      type: 'boolean',
      default: false
    }
  },
  edit: function (props) {
    const {
      attributes: {
        editable,
        show_timing_summary
      },
      setAttributes,
      isSelected
    } = props;
    var uid = props.attributes.uid;
    if (!uid) {
      var date = new Date();
      uid = 'editable' + date.getTime() + Math.random();
      setAttributes({
        uid
      });
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(NoteInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          class: "dashicons-before dashicons-welcome-write-blog",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
            children: "Toastmasters Editable Note"
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(TextControl, {
          label: "Label",
          value: editable,
          onChange: editable => setAttributes({
            editable
          })
        }), isSelected && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("em", {
            children: "Options: see sidebar"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ToggleControl, {
            label: "Show Timing Summary",
            help: show_timing_summary ? 'Show' : 'Do not show',
            checked: show_timing_summary,
            onChange: show_timing_summary => setAttributes({
              show_timing_summary
            })
          }), show_timing_summary && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ServerSideRender, {
            block: "wp4toastmasters/agendaedit",
            attributes: props.attributes
          })]
        })]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
registerBlockType('wp4toastmasters/milestone', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Milestone'),
  // Block title.

  icon: 'welcome-write-blog',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  keywords: [__('Toastmasters'), __('Agenda'), __('Milestone')],
  description: __('Milestone such as the end of the meeting, displayed with time'),
  attributes: {
    label: {
      type: 'string',
      default: ''
    }
  },
  edit: function (props) {
    const {
      attributes: {
        label
      },
      setAttributes,
      isSelected
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: props.className,
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
        class: "dashicons-before dashicons-clock",
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
          children: "Toastmasters Agenda Milestone"
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(TextControl, {
        label: "Label for Milestone",
        value: label,
        onChange: label => setAttributes({
          label
        })
      })]
    });
  },
  save: function (props) {
    const {
      attributes: {
        label
      }
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
      maxtime: "x",
      children: label
    });
  }
});
registerBlockType('wp4toastmasters/absences', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Absences'),
  // Block title.

  icon: 'admin-comments',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  keywords: [__('Toastmasters'), __('Agenda'), __('Absences')],
  description: __('A button on the signup form where members can record a planned absence.'),
  attributes: {
    show_on_agenda: {
      type: 'int',
      default: 0
    }
  },
  edit: function (props) {
    const {
      attributes: {
        show_on_agenda
      },
      setAttributes,
      isSelected
    } = props;
    function setShowOnAgenda() {
      const selected = event.target.querySelector('#show_on_agenda option:checked');
      setAttributes({
        show_on_agenda: selected.value
      });
      event.preventDefault();
    }
    function showForm() {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("form", {
        onSubmit: setShowOnAgenda,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("label", {
          children: "Show on Agenda?"
        }), " ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("select", {
          id: "show_on_agenda",
          value: show_on_agenda,
          onChange: setShowOnAgenda,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("option", {
            value: "0",
            children: "No"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("option", {
            value: "1",
            children: "Yes"
          })]
        })]
      });
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(DocInspector, {}), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
          children: "Toastmasters Absences"
        }), " placeholder for widget that tracks planned absences", showForm()]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
registerBlockType('wp4toastmasters/hybrid', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Toastmasters Hybrid'),
  // Block title.

  icon: 'admin-comments',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  keywords: [__('Toastmasters'), __('Agenda'), __('Hybrid')],
  description: __('Allows hybrid clubs to track which members will attend in person'),
  attributes: {
    limit: {
      type: 'int',
      default: 0
    }
  },
  edit: function (props) {
    const {
      attributes: {
        limit
      },
      setAttributes,
      isSelected
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(HybridInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        className: props.className,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
          children: "Toastmasters Hybrid"
        }), " Placeholder for widget that allows hybrid clubs to track who will attend in person, rather than online"]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
class RoleInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes,
      className
    } = this.props;
    const {
      count,
      time_allowed,
      padding_time,
      agenda_note,
      backup,
      role,
      custom_role
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(SelectControl, {
        label: __('Role', 'rsvpmaker-for-toastmasters'),
        value: role,
        onChange: role => setAttributes({
          role
        }),
        options: toast_roles
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(TextControl, {
        label: "Custom Role",
        value: custom_role,
        onChange: custom_role => setAttributes({
          custom_role
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        style: {
          width: '60%'
        },
        children: [" ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
          label: __('Count', 'rsvpmaker-for-toastmasters'),
          value: count,
          onChange: count => setAttributes({
            count
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("em", {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
              children: "Count"
            }), " sets multiple instances of a role like Speaker or Evaluator."]
          })
        })
      }), role == 'Speaker' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
          style: {
            width: '45%',
            float: 'left'
          },
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
            label: __('Time Allowed', 'rsvpmaker-for-toastmasters'),
            value: time_allowed,
            min: 0,
            onChange: time_allowed => setAttributes({
              time_allowed
            }) //  setAttributes( { time_allowed } ) }
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
          style: {
            width: '45%',
            float: 'left',
            marginLeft: '5%'
          },
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
            label: __('Padding Time', 'rsvpmaker-for-toastmasters'),
            min: 0,
            value: padding_time,
            onChange: padding_time => setAttributes({
              padding_time
            })
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("em", {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
              children: "Time Allowed"
            }), ": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."]
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("em", {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
              children: "Padding Time"
            }), ": Typical use is extra time for introductions, beyond the time allowed for speeches."]
          })
        })]
      }), role != 'Speaker' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
          label: __('Time Allowed', 'rsvpmaker-for-toastmasters'),
          min: 0,
          value: time_allowed,
          onChange: time_allowed => setAttributes({
            time_allowed
          }) //  setAttributes( { time_allowed } ) }
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("em", {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
              children: "Time Allowed"
            }), ": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."]
          })
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("div", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("p", {
          children: ["Scheduling overview: ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
            href: wp.data.select('core/editor').getPermalink() + '??tweak_times=1',
            children: __('Agenda Time Planner', 'rsvpmaker')
          })]
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(TextareaControl, {
        label: "Agenda Note",
        help: "A note that appears immediately below the role on the agenda and signup form",
        value: agenda_note,
        onChange: agenda_note => setAttributes({
          agenda_note: fix_quotes_in_note(agenda_note)
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(SelectControl, {
        label: __('Backup for this Role', 'rsvpmaker-for-toastmasters'),
        value: backup,
        onChange: backup => setAttributes({
          backup
        }),
        options: [{
          value: '0',
          label: 'No'
        }, {
          value: '1',
          label: 'Yes'
        }]
      }), docContent()]
    }, "roleinspector");
  }
}
function fix_quotes_in_note(agenda_note) {
  agenda_note = agenda_note.replace('"', '\u0026quot;');
  agenda_note = agenda_note.replace('\u0022', '\u0026quot;');
  return agenda_note;
}
function docContent() {
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
        href: "https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/",
        target: "_blank",
        children: __('Agenda Setup Documentation', 'rsvpmaker')
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
      children: "Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren't visible, start typing \"toastmasters\" in the search blank as shown below."
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("img", {
        src: "/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png"
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("p", {
      children: "Most used agenda content blocks:"
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("ul", {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("li", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
          target: "_blank",
          href: "https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/",
          children: "Agenda Role"
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("li", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
          target: "_blank",
          href: "https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/",
          children: "Agenda Note"
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("li", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
          target: "_blank",
          href: "https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/",
          children: "Editable Note"
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("li", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
          target: "_blank",
          href: "https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/",
          children: "Toastmasters Absences"
        })
      })]
    })]
  });
}
class NoteInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    const {
      time_allowed,
      editable,
      inline
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(InspectorControls, {
      children: [editable && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(ToggleControl, {
        label: "Display inline label, bold, instead of headline",
        help: inline ? 'Inline Label' : 'Headline',
        checked: inline,
        onChange: inline => setAttributes({
          inline
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
        label: __('Time Allowed', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: time_allowed,
        onChange: time_allowed => setAttributes({
          time_allowed
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("p", {
        children: ["Scheduling overview: ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("a", {
          href: wp.data.select('core/editor').getPermalink() + '??tweak_times=1',
          children: __('Agenda Time Planner', 'rsvpmaker')
        })]
      }), docContent()]
    }, "noteinspector");
  }
}
class HybridInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    const {
      limit
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)(InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalNumberControl, {
        label: __('Attendance limit (0 for none)', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: limit,
        onChange: limit => setAttributes({
          limit
        })
      }), docContent()]
    }, "hybridinspector");
  }
}
class DocInspector extends Component {
  render() {
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(InspectorControls, {
      children: docContent()
    }, "docinspector");
  }
}
registerBlockType('wp4toastmasters/duesrenewal', {
  // Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.

  title: __('Dues Renewal'),
  // Block title.

  icon: 'groups',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.

  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.

  description: __('Displays a member dues renewal form.'),
  keywords: [__('Toastmasters'), __('Dues'), __('Payment')],
  edit: function (props) {
    const {
      attributes: {
        amount
      },
      setAttributes,
      isSelected
    } = props;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("div", {
      className: props.className,
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("p", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("strong", {
          children: "Toastmasters Dues Renewal"
        }), " - displays the payment form"]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsxs)("p", {
        children: [__('Payment will be calculated according to the dues schedule set in', 'rsvpmaker-for-toastmasters'), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)("br", {}), __('Settings > TM Member Application', 'rsvpmaker-for-toastmasters')]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});

/***/ }),

/***/ "./src/gblocks/editor.scss":
/*!*********************************!*\
  !*** ./src/gblocks/editor.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/gblocks/index.js":
/*!******************************!*\
  !*** ./src/gblocks/index.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _block_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./block.js */ "./src/gblocks/block.js");
/* harmony import */ var _agenda_layout_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./agenda-layout.js */ "./src/gblocks/agenda-layout.js");
/* harmony import */ var _sidebar_blocks_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./sidebar-blocks.js */ "./src/gblocks/sidebar-blocks.js");




/***/ }),

/***/ "./src/gblocks/sidebar-blocks.js":
/*!***************************************!*\
  !*** ./src/gblocks/sidebar-blocks.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__);
const {
  __
} = wp.i18n; // Import __() from wp.i18n
const {
  registerBlockType
} = wp.blocks; // Import registerBlockType() from wp.blocks
const {
  Component,
  Fragment
} = wp.element;
const {
  InspectorControls,
  PanelBody
} = wp.blockEditor;
const {
  TextControl,
  ToggleControl,
  SelectControl
} = wp.components;


registerBlockType('wp4toastmasters/memberaccess', {
  // Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Toastmasters Member Access'),
  // Block title.
  icon: 'groups',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  description: __('Displays member singup opportunities, profile links, etc.'),
  keywords: [__('Toastmasters'), __('Sidebar'), __('Member')],
  attributes: {
    title: {
      type: 'string',
      default: 'Member Access'
    },
    dateformat: {
      type: 'string',
      default: 'M j'
    },
    limit: {
      type: 'int',
      default: 10
    },
    showmore: {
      type: 'int',
      default: 4
    },
    showlog: {
      type: 'boolean',
      default: true
    }
  },
  edit: function (props) {
    const {
      title,
      limit,
      showlog,
      showmore
    } = props.attributes;
    const dates = [];
    for (let i = 1; i <= limit; i++) {
      dates.push(/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
          class: "meetinglinks",
          children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
            class: "meeting",
            href: "#",
            children: ["Toastmasters Meeting Jan ", i]
          })
        })
      }));
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(MemberAccessInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: props.className,
        children: [title && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h5", {
          class: "member-access-title",
          children: title
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("ul", {
          class: "member-access-prompts",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("li", {
            class: "widgetsignup",
            children: ["Member sign up for roles:", dates, showmore && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
              id: "showmorediv",
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
                href: "#",
                id: "showmore",
                children: "Show More"
              })
            })]
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("li", {
            children: ["Your membership:", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
                href: "#",
                children: "Edit Member Profile"
              })
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("div", {
              children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
                href: "#",
                children: "Member Dashboard"
              })
            })]
          }), showlog && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("li", {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("strong", {
              children: "Activity"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("br", {}), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("strong", {
                children: "Demo Member:"
              }), " signed up for Toastmaster of the Day for December 1st, 2022 ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("small", {
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("em", {
                  children: "(Posted: 11/06/22 13:25)"
                })
              })]
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("strong", {
                children: "Demo Member:"
              }), " signed up for Speaker for February 1st, 2023 ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("small", {
                children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("em", {
                  children: "(Posted: 11/06/22 13:30)"
                })
              })]
            })]
          })]
        })]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
class MemberAccessInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    const {
      title,
      dateformat,
      limit,
      showmore,
      showlog
    } = attributes;
    console.log(title);
    console.log(dateformat);
    console.log(limit);
    console.log(showmore);
    console.log(showlog);
    /*
     key="memberaccessinspector"
    */
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(TextControl, {
        label: "Title",
        value: title,
        onChange: title => setAttributes({
          title
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.__experimentalNumberControl, {
        label: __('Number of Meetings Shown', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: limit,
        onChange: limit => setAttributes({
          limit
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.__experimentalNumberControl, {
        label: __('Show More Number', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: showmore,
        onChange: showmore => setAttributes({
          showmore
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToggleControl, {
        label: "Show Activity Log",
        help: showlog ? 'Show' : 'Do not show',
        checked: showlog,
        onChange: showlog => setAttributes({
          showlog
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(TextControl, {
        label: "Date Format",
        value: dateformat,
        onChange: dateformat => setAttributes({
          dateformat
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("p", {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("a", {
          href: "https://www.php.net/manual/en/datetime.format.php",
          target: "_blank",
          children: "Uses PHP date format codes"
        })
      })]
    });
  }
}
registerBlockType('wp4toastmasters/blog', {
  // Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Toastmasters Public/Private Blogs'),
  // Block title.
  icon: 'groups',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  description: __('Club News and Members Only Blog Posts'),
  keywords: [__('Toastmasters'), __('Sidebar'), __('Blog')],
  attributes: {
    title: {
      type: 'string',
      default: 'Members Only'
    },
    type: {
      type: 'string',
      default: 'private'
    },
    number: {
      type: 'int',
      default: 10
    }
  },
  edit: function (props) {
    const {
      title,
      type,
      number
    } = props.attributes;
    const dates = [];
    for (let i = 1; i <= number; i++) {
      dates.push(/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("li", {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("a", {
          href: "#",
          children: ["Post Title ", /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("em", {
            children: type
          })]
        }), " Date"]
      }));
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToastBlogInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: props.className,
        children: [title && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h5", {
          children: title
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
          children: dates
        })]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
class ToastBlogInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    let {
      title,
      type,
      number
    } = attributes;
    if ('private' === type && 'Club News' === title) {
      title = 'Members Only';
      setAttributes({
        title
      });
    }
    if ('public' === type && 'Members Only' === title) {
      title = 'Club News';
      setAttributes({
        title
      });
    }
    console.log(title);
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(TextControl, {
        label: "Title",
        value: title,
        onChange: title => setAttributes({
          title
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(SelectControl, {
        label: __('Type', 'rsvpmaker-for-toastmasters'),
        value: type,
        onChange: type => setAttributes({
          type
        }),
        options: [{
          value: 'private',
          label: 'private'
        }, {
          value: 'public',
          label: 'public'
        }]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.__experimentalNumberControl, {
        label: __('Number of Posts', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: number,
        onChange: number => setAttributes({
          number
        })
      })]
    });
  }
}
registerBlockType('wp4toastmasters/newestmembers', {
  // Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Toastmasters Newest Members'),
  // Block title.
  icon: 'groups',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  description: __('Toastmasters newest members by user record'),
  keywords: [__('Toastmasters'), __('Sidebar'), __('Newest Members')],
  attributes: {
    title: {
      type: 'string',
      default: 'Newest Members'
    },
    number: {
      type: 'int',
      default: 5
    }
  },
  edit: function (props) {
    const {
      title,
      number
    } = props.attributes;
    const dates = [];
    for (let i = 1; i <= number; i++) {
      dates.push(/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("li", {
        children: ["Member ", i]
      }));
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(ToastNewInspector, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)("div", {
        className: props.className,
        children: [title && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("h5", {
          children: title
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)("ul", {
          children: dates
        })]
      })]
    });
  },
  save: function (props) {
    return null;
  }
});
class ToastNewInspector extends Component {
  render() {
    const {
      attributes,
      setAttributes
    } = this.props;
    const {
      title,
      number
    } = attributes;
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsxs)(InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(TextControl, {
        label: "Title",
        value: title,
        onChange: title => setAttributes({
          title
        })
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_1__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_0__.__experimentalNumberControl, {
        label: __('Number of Members', 'rsvpmaker-for-toastmasters'),
        min: 0,
        value: number,
        onChange: number => setAttributes({
          number
        })
      })]
    });
  }
}

/***/ }),

/***/ "./src/gblocks/style.scss":
/*!********************************!*\
  !*** ./src/gblocks/style.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["ReactJSXRuntime"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"gblocks/index": 0,
/******/ 			"gblocks/style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunktoastmasters_dynamic_agenda"] = globalThis["webpackChunktoastmasters_dynamic_agenda"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["gblocks/style-index"], () => (__webpack_require__("./src/gblocks/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map