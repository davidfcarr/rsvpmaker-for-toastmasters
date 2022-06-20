!function(e){function t(a){if(n[a])return n[a].exports;var l=n[a]={i:a,l:!1,exports:{}};return e[a].call(l.exports,l,l.exports,t),l.l=!0,l.exports}var n={};t.m=e,t.c=n,t.d=function(e,n,a){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:a})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=2)}([function(e,t){},function(e,t){},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=(n(3),n(8),n(9));n.n(a)},function(e,t,n){"use strict";function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function l(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function r(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}function o(e){return e=e.replace('"',"&quot;"),e=e.replace('"',"&quot;")}function s(){return wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("a",{href:"https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/",target:"_blank"},__("Agenda Setup Documentation","rsvpmaker"))),wp.element.createElement("p",null,'Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren\'t visible, start typing "toastmasters" in the search blank as shown below.'),wp.element.createElement("p",null,wp.element.createElement("img",{src:"/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png"})),wp.element.createElement("p",null,"Most used agenda content blocks:"),wp.element.createElement("ul",null,wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/"},"Agenda Role")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/"},"Agenda Note")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/"},"Editable Note")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/"},"Toastmasters Absences"))))}var i=n(0),m=(n.n(i),n(1)),c=(n.n(m),n(4),n(6)),p=(n.n(c),n(7)),u=(n.n(p),function(){function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(t,n,a){return n&&e(t.prototype,n),a&&e(t,a),t}}()),__=wp.i18n.__,d=wp.blocks.registerBlockType,w=wp.blockEditor.RichText,g=wp.element,b=g.Component,h=g.Fragment,f=wp.blockEditor,v=f.InspectorControls,E=f.PanelBody,y=wp.components,_=y.TextareaControl,k=y.SelectControl,T=y.ToggleControl,C=y.TextControl,x=y.ServerSideRender,N=(wp.data.subscribe,[]);wpt_rest.is_agenda&&function(){var e=wpt_rest.url+"rsvptm/v1/tweak_times?post_id="+wpt_rest.post_id;fetch(e,{method:"GET",headers:{"Content-Type":"application/json","X-WP-Nonce":wpt_rest.nonce}}).then(function(e){return e.json()}).then(function(e){N=e}).catch(function(e){console.error("Error:",e)})}(),d("wp4toastmasters/agendanoterich2",{title:__("Toastmasters Agenda Note"),icon:"admin-comments",category:"common",description:__('Displays "stage directions" for the organization of your meetings.',"rsvpmaker"),keywords:[__("Toastmasters"),__("Agenda"),__("Rich Text")],attributes:{content:{type:"array",source:"children",selector:"p"},time_allowed:{type:"string",default:"0"},uid:{type:"string",default:""},timing_updated:{type:"int",default:N},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){var t=e.attributes,n=e.attributes,a=n.show_timing_summary,l=(n.time_allowed,e.className,e.setAttributes),r=e.isSelected,o=e.attributes.uid;if(!o){o="note"+(new Date).getTime()+Math.random(),l({uid:o})}return wp.element.createElement(h,null,wp.element.createElement(S,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("p",null,wp.element.createElement("strong",null,"Toastmasters Agenda Note")),wp.element.createElement(w,{tagName:"p",value:t.content,multiline:" ",onChange:function(e){return l({content:e})}}),r&&wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("em",null,"Options: see sidebar")),wp.element.createElement(T,{label:"Show Timing Summary",help:a?"Show":"Do not show",checked:a,onChange:function(e){return l({show_timing_summary:e})}}),a&&wp.element.createElement(x,{block:"wp4toastmasters/agendanoterich2",attributes:e.attributes}))))},save:function(e){var t=e.attributes,n=e.className;return wp.element.createElement(w.Content,{tagName:"p",value:t.content,className:n})}}),d("wp4toastmasters/signupnote",{title:__("Toastmasters Signup Form Note"),icon:"admin-comments",category:"common",description:__("A text block that appears only on the signup form, not on the agenda."),keywords:[__("Toastmasters"),__("Signup"),__("Rich Text")],attributes:{content:{type:"array",source:"children",selector:"p"}},edit:function(e){var t=(e.attributes,e.setAttributes);return wp.element.createElement(h,null,wp.element.createElement(O,null),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Signup Form Note"),wp.element.createElement(w,{tagName:"p",className:e.className,value:e.attributes.content,onChange:function(e){return t({content:e})}})))},save:function(e){return wp.element.createElement(w.Content,{tagName:"p",value:e.attributes.content,className:e.className})}}),d("wp4toastmasters/role",{title:__("Toastmasters Agenda Role"),icon:"groups",category:"common",description:__("Defines a meeting role that will appear on the signup form and the agenda."),keywords:[__("Toastmasters"),__("Agenda"),__("Role")],attributes:{role:{type:"string",default:""},custom_role:{type:"string",default:""},count:{type:"int",default:1},start:{type:"int",default:1},agenda_note:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},padding_time:{type:"string",default:"0"},backup:{type:"string",default:""},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){var t=e.attributes,n=t.role,a=t.custom_role,l=(t.count,t.start,t.agenda_note,t.time_allowed,t.padding_time,t.backup,t.show_timing_summary),r=e.setAttributes,o=e.isSelected;return wp.element.createElement(h,null,wp.element.createElement(A,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Role ",n," ",a),o&&wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("em",null,"Options: see sidebar")),wp.element.createElement(T,{label:"Show Timing Summary",help:l?"Show":"Do not show",checked:l,onChange:function(e){return r({show_timing_summary:e})}}),l&&wp.element.createElement(x,{block:"wp4toastmasters/role",attributes:e.attributes}))))},save:function(e){return null}}),d("wp4toastmasters/agendaedit",{title:__("Toastmasters Editable Note"),icon:"welcome-write-blog",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Editable")],description:__("A note that can be edited by a meeting organizer"),attributes:{editable:{type:"string",default:""},uid:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},inline:{type:"int",default:0},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){var t=e.attributes,n=t.editable,a=t.show_timing_summary,l=e.setAttributes,r=e.isSelected,o=e.attributes.uid;if(!o){o="editable"+(new Date).getTime()+Math.random(),l({uid:o})}return wp.element.createElement(h,null,wp.element.createElement(S,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("p",{class:"dashicons-before dashicons-welcome-write-blog"},wp.element.createElement("strong",null,"Toastmasters Editable Note")),wp.element.createElement(C,{label:"Label",value:n,onChange:function(e){return l({editable:e})}}),r&&wp.element.createElement("div",null,wp.element.createElement("em",null,"Options: see sidebar"),wp.element.createElement(T,{label:"Show Timing Summary",help:a?"Show":"Do not show",checked:a,onChange:function(e){return l({show_timing_summary:e})}}),a&&wp.element.createElement(x,{block:"wp4toastmasters/agendaedit",attributes:e.attributes}))))},save:function(e){return null}}),d("wp4toastmasters/milestone",{title:__("Toastmasters Milestone"),icon:"welcome-write-blog",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Milestone")],description:__("Milestone such as the end of the meeting, displayed with time"),attributes:{label:{type:"string",default:""}},edit:function(e){var t=e.attributes.label,n=e.setAttributes;e.isSelected;return wp.element.createElement("div",{className:e.className},wp.element.createElement("p",{class:"dashicons-before dashicons-clock"},wp.element.createElement("strong",null,"Toastmasters Agenda Milestone")),wp.element.createElement(C,{label:"Label for Milestone",value:t,onChange:function(e){return n({label:e})}}))},save:function(e){var t=e.attributes.label;return wp.element.createElement("p",{maxtime:"x"},t)}}),d("wp4toastmasters/absences",{title:__("Toastmasters Absences"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Absences")],description:__("A button on the signup form where members can record a planned absence."),attributes:{show_on_agenda:{type:"int",default:0}},edit:function(e){function t(){var e=event.target.querySelector("#show_on_agenda option:checked");a({show_on_agenda:e.value}),event.preventDefault()}var n=e.attributes.show_on_agenda,a=e.setAttributes;e.isSelected;return wp.element.createElement(h,null,wp.element.createElement(O,null),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Absences")," placeholder for widget that tracks planned absences",function(){return wp.element.createElement("form",{onSubmit:t},wp.element.createElement("label",null,"Show on Agenda?")," ",wp.element.createElement("select",{id:"show_on_agenda",value:n,onChange:t},wp.element.createElement("option",{value:"0"},"No"),wp.element.createElement("option",{value:"1"},"Yes")))}()))},save:function(e){return null}}),d("wp4toastmasters/hybrid",{title:__("Toastmasters Hybrid"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Hybrid")],description:__("Allows hybrid clubs to track which members will attend in person"),attributes:{limit:{type:"int",default:0}},edit:function(e){e.attributes.limit,e.setAttributes,e.isSelected;return wp.element.createElement(h,null,wp.element.createElement(P,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Hybrid")," Placeholder for widget that allows hybrid clubs to track who will attend in person, rather than online"))},save:function(e){return null}});var A=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=(e.className,t.count),l=t.time_allowed,r=t.padding_time,i=t.agenda_note,m=t.backup,c=t.role,u=t.custom_role;return wp.element.createElement(v,{key:"roleinspector"},wp.element.createElement(k,{label:__("Role","rsvpmaker-for-toastmasters"),value:c,onChange:function(e){return n({role:e})},options:toast_roles}),wp.element.createElement(C,{label:"Custom Role",value:u,onChange:function(e){return n({custom_role:e})}}),wp.element.createElement("div",{style:{width:"60%"}}," ",wp.element.createElement(p.__experimentalNumberControl,{label:__("Count","rsvpmaker-for-toastmasters"),value:a,onChange:function(e){return n({count:e})}})),wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Count")," sets multiple instances of a role like Speaker or Evaluator."))),"Speaker"==c&&wp.element.createElement("div",null,wp.element.createElement("div",{style:{width:"45%",float:"left"}},wp.element.createElement(p.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),value:l,min:0,onChange:function(e){return n({time_allowed:e})}})),wp.element.createElement("div",{style:{width:"45%",float:"left",marginLeft:"5%"}},wp.element.createElement(p.__experimentalNumberControl,{label:__("Padding Time","rsvpmaker-for-toastmasters"),min:0,value:r,onChange:function(e){return n({padding_time:e})}})),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Time Allowed"),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes.")),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Padding Time"),": Typical use is extra time for introductions, beyond the time allowed for speeches."))),"Speaker"!=c&&wp.element.createElement("div",null,wp.element.createElement(p.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:l,onChange:function(e){return n({time_allowed:e})}}),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Time Allowed"),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."))),wp.element.createElement("div",null,wp.element.createElement("p",null,"Scheduling overview: ",wp.element.createElement("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1"},__("Agenda Time Planner","rsvpmaker")))),wp.element.createElement(_,{label:"Agenda Note",help:"A note that appears immediately below the role on the agenda and signup form",value:i,onChange:function(e){return n({agenda_note:o(e)})}}),wp.element.createElement(k,{label:__("Backup for this Role","rsvpmaker-for-toastmasters"),value:m,onChange:function(e){return n({backup:e})},options:[{value:"0",label:"No"},{value:"1",label:"Yes"}]}),s())}}]),t}(b),S=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=t.time_allowed,l=t.editable,r=t.inline;return wp.element.createElement(v,{key:"noteinspector"},l&&wp.element.createElement(T,{label:"Display inline label, bold, instead of headline",help:r?"Inline Label":"Headline",checked:r,onChange:function(e){return n({inline:e})}}),wp.element.createElement(p.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:a,onChange:function(e){return n({time_allowed:e})}}),wp.element.createElement("p",null,"Scheduling overview: ",wp.element.createElement("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1"},__("Agenda Time Planner","rsvpmaker"))),s())}}]),t}(b),P=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=t.limit;return wp.element.createElement(v,{key:"hybridinspector"},wp.element.createElement(p.__experimentalNumberControl,{label:__("Attendance limit (0 for none)","rsvpmaker-for-toastmasters"),min:0,value:a,onChange:function(e){return n({limit:e})}}),s())}}]),t}(b),O=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){return wp.element.createElement(v,{key:"docinspector"},s())}}]),t}(b);d("wp4toastmasters/duesrenewal",{title:__("Dues Renewal"),icon:"groups",category:"common",description:__("Displays a member dues renewal form."),keywords:[__("Toastmasters"),__("Dues"),__("Payment")],edit:function(e){e.attributes.amount,e.setAttributes,e.isSelected;return wp.element.createElement("div",{className:e.className},wp.element.createElement("p",null,wp.element.createElement("strong",null,"Toastmasters Dues Renewal")," - displays the payment form"),wp.element.createElement("p",null,__("Payment will be calculated according to the dues schedule set in","rsvpmaker-for-toastmasters"),wp.element.createElement("br",null),__("Settings > TM Member Application","rsvpmaker-for-toastmasters")))},save:function(e){return null}}),d("wp4toastmasters/navigation",{title:__("Toastmasters Navigation"),icon:"admin-comments",category:"common",description:__("Meant for Full Site Editing block themes. Dropdown with member access to login/dashboard, password reset, upcoming meetings","rsvpmaker"),keywords:[__("Toastmasters"),__("Navigation"),__("Full Site Editing")],attributes:{count:{type:"int",default:5},hidelogo:{type:"boolean",default:!1}},edit:function(e){var t=(e.attributes,e.attributes),n=(t.count,t.hidelogo);e.className,e.setAttributes,e.isSelected;return n?wp.element.createElement(h,null,wp.element.createElement(j,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("nav",{class:"wp-container-620833bf95386 is-responsive items-justified-right wp-block-navigation"},wp.element.createElement("button",{"aria-haspopup":"true","aria-label":"Open menu",class:"wp-block-navigation__responsive-container-open ","data-micromodal-trigger":"modal-620833bf94e39"},wp.element.createElement("svg",{width:"24",height:"24",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("rect",{x:"4",y:"7.5",width:"16",height:"1.5"}),wp.element.createElement("rect",{x:"4",y:"15",width:"16",height:"1.5"}))),wp.element.createElement("div",{class:"wp-block-navigation__responsive-container  ",id:"modal-620833bf94e39"},wp.element.createElement("div",{class:"wp-block-navigation__responsive-close",tabindex:"-1","data-micromodal-close":!0},wp.element.createElement("div",{class:"wp-block-navigation__responsive-dialog","aria-label":"Menu"},wp.element.createElement("button",{"aria-label":"Close menu","data-micromodal-close":!0,class:"wp-block-navigation__responsive-container-close"},wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",width:"24",height:"24",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("path",{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"}))),wp.element.createElement("div",{class:"wp-block-navigation__responsive-container-content",id:"modal-620833bf94e39-content"},wp.element.createElement("ul",{class:"wp-block-navigation__container"},wp.element.createElement("li",{class:" wp-block-navigation-item has-child open-on-hover-click wp-block-navigation-submenu"},wp.element.createElement("a",{class:"wp-block-navigation-item__content",href:"#"},"Dashboard"),wp.element.createElement("button",{"aria-label":"Dashboard submenu",class:"wp-block-navigation__submenu-icon wp-block-navigation-submenu__toggle","aria-expanded":"false"},wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:"12",height:"12",viewBox:"0 0 12 12",fill:"none",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("path",{d:"M1.50002 4L6.00002 8L10.5 4","stroke-width":"1.5"}))),wp.element.createElement("ul",{class:"wp-block-navigation__submenu-container"},wp.element.createElement("li",{class:"wp-block-navigation-item wp-block-navigation-link"},wp.element.createElement("a",{class:"wp-block-navigation-item__content",href:"#"},wp.element.createElement("span",{class:"wp-block-navigation-item__label"},"Profile"))))))))))))):wp.element.createElement(h,null,wp.element.createElement(j,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("nav",{class:"wp-container-620833bf95386 is-responsive items-justified-right wp-block-navigation"},wp.element.createElement("button",{"aria-haspopup":"true","aria-label":"Open menu",class:"wp-block-navigation__responsive-container-open ","data-micromodal-trigger":"modal-620833bf94e39"},wp.element.createElement("svg",{width:"24",height:"24",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("rect",{x:"4",y:"7.5",width:"16",height:"1.5"}),wp.element.createElement("rect",{x:"4",y:"15",width:"16",height:"1.5"}))),wp.element.createElement("div",{class:"wp-block-navigation__responsive-container  ",id:"modal-620833bf94e39"},wp.element.createElement("div",{class:"wp-block-navigation__responsive-close",tabindex:"-1","data-micromodal-close":!0},wp.element.createElement("div",{class:"wp-block-navigation__responsive-dialog","aria-label":"Menu"},wp.element.createElement("button",{"aria-label":"Close menu","data-micromodal-close":!0,class:"wp-block-navigation__responsive-container-close"},wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",width:"24",height:"24",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("path",{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"}))),wp.element.createElement("div",{class:"wp-block-navigation__responsive-container-content",id:"modal-620833bf94e39-content"},wp.element.createElement("ul",{class:"wp-block-navigation__container"},wp.element.createElement("li",{class:" wp-block-navigation-item"},wp.element.createElement("a",{href:"#"},wp.element.createElement("img",{src:"https://toastmost.org/tmbranding/toastmasters-50.png",height:"41",width:"50"}))),wp.element.createElement("li",{class:" wp-block-navigation-item has-child open-on-hover-click wp-block-navigation-submenu"},wp.element.createElement("a",{class:"wp-block-navigation-item__content",href:"#"},"Dashboard"),wp.element.createElement("button",{"aria-label":"Dashboard submenu",class:"wp-block-navigation__submenu-icon wp-block-navigation-submenu__toggle","aria-expanded":"false"},wp.element.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:"12",height:"12",viewBox:"0 0 12 12",fill:"none",role:"img","aria-hidden":"true",focusable:"false"},wp.element.createElement("path",{d:"M1.50002 4L6.00002 8L10.5 4","stroke-width":"1.5"}))),wp.element.createElement("ul",{class:"wp-block-navigation__submenu-container"},wp.element.createElement("li",{class:"wp-block-navigation-item wp-block-navigation-link"},wp.element.createElement("a",{class:"wp-block-navigation-item__content",href:"#"},wp.element.createElement("span",{class:"wp-block-navigation-item__label"},"Profile")))))))))))))},save:function(){return null}});var j=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=t.count,l=t.hidelogo;return wp.element.createElement(v,{key:"navinspector"},wp.element.createElement(T,{label:"Hide Logo",help:l?"Hide":"Show",checked:l,onChange:function(e){return n({hidelogo:e})}}),wp.element.createElement(p.__experimentalNumberControl,{label:__("Events to Show","rsvpmaker-for-toastmasters"),value:a,onChange:function(e){return n({count:e})}}))}}]),t}(b);d("wp4toastmasters/logo",{title:__("Toastmasters Logo"),icon:"shield",category:"common",keywords:[__("toastmasters"),__("logo"),__("header")],attributes:{src:{type:"string",default:"https://toastmost.org/tmbranding/toastmasters-75.png"}},edit:function(e){var t=e.attributes.src;return wp.element.createElement(h,null,wp.element.createElement(D,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("img",{src:t})))},save:function(e){var t=e.attributes.src;return wp.element.createElement("div",{className:e.className},wp.element.createElement("a",{href:"/"},wp.element.createElement("img",{src:t})))}});var D=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes.src,n=e.setAttributes;e.isSelected;return wp.element.createElement(v,{key:"upcominginspector"},wp.element.createElement(E,{title:__("Logo Version","rsvpmaker")},wp.element.createElement(k,{label:__("Choice","rsvpmaker"),value:t,options:[{value:"https://toastmost.org/tmbranding/toastmasters-75.png",label:__("Default 75px")},{value:"https://toastmost.org/tmbranding/Toastmasters150-125.png",label:__("150px")},{value:"https://toastmost.org/tmbranding/Toastmasters180-150.png",label:__("180px")},{value:"https://toastmost.org/tmbranding/Toastmasters200-167.png",label:__("200px")},{value:"https://toastmost.org/tmbranding/Toastmasters240-200.png",label:__("240px")},{value:"https://toastmost.org/tmbranding/Toastmasters300-250.png",label:__("300px")}],onChange:function(e){n({src:e})}}),"    "))}}]),t}(b)},function(e,t,n){"use strict";function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function l(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function r(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var o=n(5),s=(n.n(o),function(){function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(t,n,a){return n&&e(t.prototype,n),a&&e(t,a),t}}()),__=wp.i18n.__,i=wp.blocks.registerBlockType,m=wp.element.Fragment,c=wp.element.Component,p=wp.blockEditor.InspectorControls,u=wp.components,d=u.PanelBody,w=u.ToggleControl;u.SelectControl;i("wp4toastmasters/context",{title:"Agenda Display Wrapper",icon:"admin-comments",category:"common",keywords:["Toastmasters","Agenda Wrapper","Wrapper"],attributes:{content:{type:"array",source:"children",selector:"p"},webContext:{type:"boolean",default:!0},emailContext:{type:"boolean",default:!0},agendaContext:{type:"boolean",default:!0},printContext:{type:"boolean",default:!0},anonContext:{type:"boolean",default:!0}},edit:function(e){var t=e.attributes,n=e.className;e.setAttributes,e.isSelected,t.webContext,t.emailContext,t.agendaContext,t.printContext;return wp.element.createElement(m,null,wp.element.createElement(g,e),wp.element.createElement("div",{className:n},wp.element.createElement("div",{class:"context-block-label"},"CLICK TO SET DISPLAY CONTEXT"),wp.element.createElement(o.InnerBlocks,null)))},save:function(e){var t=(e.attributes,e.className);return wp.element.createElement("div",{className:t},wp.element.createElement(o.InnerBlocks.Content,null))}});var g=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),s(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=(e.className,e.setAttributes),a=(e.isSelected,t.webContext),l=t.emailContext,r=t.agendaContext,o=t.printContext,s=t.anonContext;return wp.element.createElement(p,{key:"contextInspector"},wp.element.createElement(d,{title:__("Display","rsvpmaker-for-toastmasters")},wp.element.createElement(w,{label:"Web / Signup Page",help:a?"Show on website / agenda signup view.":"Do not show on website / agenda signup view.",checked:a,onChange:function(e){return n({webContext:e})}}),wp.element.createElement(w,{label:"Agenda",help:r?"Show on agenda (email or print).":"Do not show on agenda (email or print).",checked:r,onChange:function(e){return n({agendaContext:e})}}),wp.element.createElement(w,{label:"Email",help:l?"Show on email agenda.":"Do not show on email agenda.",checked:l,onChange:function(e){return n({emailContext:e})}}),wp.element.createElement(w,{label:"Print",help:o?"Show on print agenda.":"Do not show on print agenda.",checked:o,onChange:function(e){return n({printContext:e})}}),wp.element.createElement(w,{label:"Anonymous Users",help:s?"No login required.":"Limit to logged in users and club email notifications.",checked:s,onChange:function(e){return n({anonContext:e})}})))}}]),t}(c)},function(e,t){e.exports=wp.blockEditor},function(e,t){function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function a(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function l(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var r=function(){function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(t,n,a){return n&&e(t.prototype,n),a&&e(t,a),t}}(),__=wp.i18n.__,o=wp.blocks.registerBlockType,s=wp.components,i=s.PanelBody,m=s.SelectControl,c=wp.blockEditor.InspectorControls,p=wp.element,u=p.Component,d=p.Fragment;o("wp4toastmasters/logo",{title:__("Toastmasters Logo"),icon:"shield",category:"common",keywords:[__("toastmasters"),__("logo"),__("header")],attributes:{src:{type:"string",default:"https://toastmost.org/tmbranding/toastmasters-75.png"}},edit:function(e){var t=e.attributes.src;return wp.element.createElement(d,null,wp.element.createElement("div",{className:e.className},wp.element.createElement(w,e),wp.element.createElement("img",{src:t})))},save:function(e){var t=e.attributes.src;return wp.element.createElement("div",{className:e.className},wp.element.createElement("a",{href:"/"},wp.element.createElement("img",{src:t})))}});var w=function(e){function t(){return n(this,t),a(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return l(t,e),r(t,[{key:"render",value:function(){var e=this.props,t=e.attributes.src,n=e.setAttributes;e.isSelected;return wp.element.createElement(c,{key:"upcominginspector"},wp.element.createElement(i,{title:__("Logo Version","rsvpmaker")},wp.element.createElement(m,{label:__("Choice","rsvpmaker"),value:t,options:[{value:"https://toastmost.org/tmbranding/toastmasters-75.png",label:__("Default 75px")},{value:"https://toastmost.org/tmbranding/Toastmasters150-125.png",label:__("150px")},{value:"https://toastmost.org/tmbranding/Toastmasters180-150.png",label:__("180px")},{value:"https://toastmost.org/tmbranding/Toastmasters200-167.png",label:__("200px")},{value:"https://toastmost.org/tmbranding/Toastmasters240-200.png",label:__("240px")},{value:"https://toastmost.org/tmbranding/Toastmasters300-250.png",label:__("300px")}],onChange:function(e){n({src:e})}}),"    "))}}]),t}(u)},function(e,t){e.exports=wp.components},function(e,t,n){"use strict";var a=n(0),l=(n.n(a),n(1)),__=(n.n(l),wp.i18n.__),r=wp.blocks.registerBlockType,o=wp.editor.InnerBlocks,s=wp.components,i=s.FormToggle,m=s.ServerSideRender;"undefined"!==typeof wpt_rest.special&&"Agenda Layout"==wpt_rest.special&&(r("wp4toastmasters/agenda-wrapper",{title:"Agenda Layout Wrapper",icon:"admin-comments",category:"layout",keywords:["Toastmasters","Agenda","Wrapper"],attributes:{sidebar:{type:"boolean",default:!0}},edit:function(e){var t=[["wp4toastmasters/agendasidebar"]],n=e.attributes,a=e.className,l=e.setAttributes;e.isSelected;return n.sidebar?wp.element.createElement("div",{className:a},wp.element.createElement("table",{id:"agenda-main",width:"700"},wp.element.createElement("tbody",null,wp.element.createElement("tr",null,wp.element.createElement("td",{id:"agenda-sidebar",width:"175"},wp.element.createElement(o,{template:t})),wp.element.createElement("td",{id:"agenda-main",width:"*"},"Placeholder for role info, agenda notes, etc. ",rsvpmaker_ajax.special,wp.element.createElement("p",null,"Include sidebar: ",wp.element.createElement(i,{checked:n.sidebar,onChange:function(){l({sidebar:!n.sidebar})}}))))))):wp.element.createElement("div",{className:a},"Placeholder for role info, agenda notes, etc.",wp.element.createElement("p",null,"Include sidebar: ",wp.element.createElement(i,{checked:n.sidebar,onChange:function(){l({sidebar:!n.sidebar})}})))},save:function(e){var t=e.attributes,n=e.className;return t.sidebar?wp.element.createElement("div",{className:n},wp.element.createElement("table",{id:"agenda-main",width:"700"},wp.element.createElement("tbody",null,wp.element.createElement("tr",null,wp.element.createElement("td",{id:"agenda-sidebar",width:"175"},wp.element.createElement(o.Content,null)),wp.element.createElement("td",{id:"agenda-main",width:"*"},"[tmlayout_main]"))))):wp.element.createElement("div",{className:n},"[tmlayout_main]")}}),r("wp4toastmasters/agendasidebar",{title:__("Agenda Sidebar"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Sidebar")],description:__("Placeholder for sidebar content in the agenda layout. Includes officer listing if specified in Settings -> Toastmasters."),edit:function(e){return wp.element.createElement("div",{className:"agendaplaceholder"},"Placeholder: sidebar content")},save:function(e){return null}}),r("wp4toastmasters/agendamain",{title:__("Agenda Main Content"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Main")],description:__("Placeholder for main content (roles and agenda notes) in the agenda layout"),edit:function(e){var t=e.attributes;return wp.element.createElement("div",{className:"agendaplaceholder"},"Placeholder: agenda main content",wp.element.createElement(m,{block:"wp4toastmasters/agendamain",attributes:t}))},save:function(e){return null}}),r("wp4toastmasters/officers",{title:__("Agenda Officers Listing"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Officers")],description:__("Placeholder for output of officers listing, based on data from Settings -> Toastmasters."),edit:function(e){return wp.element.createElement("div",null,wp.element.createElement("div",{className:"agendaplaceholder"},"From Settings -> Toastmasters"),wp.element.createElement(m,{block:"wp4toastmasters/officers"}))},save:function(e){return null}}))},function(e,t){var __=wp.i18n.__;(0,wp.blocks.registerBlockType)("wp4toastmasters/help",{title:__("Toastmasters Agenda Help"),icon:"editor-help",category:"common",description:__("Provides links to help resources within the agenda document"),keywords:[__("Toastmasters"),__("Agenda"),__("Help")],attributes:{},edit:function(e){var t=e.isSelected;return wp.element.createElement("div",{className:e.className},wp.element.createElement("h2",null,"How to Edit The Agenda - Click for Help"),t&&wp.element.createElement("div",null,wp.element.createElement("p",null,"The WordPress for Toastmasters system represents meeting agendas as a series of content blocks that you work with within the same editor used for blog posts and web pages. Although it can include standard content blocks (paragraphs, headings, images), you primarily work with ",wp.element.createElement("strong",null,"Role")," blocks and a ",wp.element.createElement("strong",null,"Note"),' blocks (the "stage directions" of your meetings). ',wp.element.createElement("strong",null,"Event Templates"),' define an abstract model of a "typical" meeting, contest, or other event, but you can use the same techniques to modify a specific event (for example, to change the number and order of roles for a given meeting).'),wp.element.createElement("p",null,"For details, see the ",wp.element.createElement("a",{target:"_blank",href:"https://www.wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/"},"Knowledge Base articles")," on the WordPress for Toastmasters website."),wp.element.createElement("p",null,"This special help tips block will not appear on the website or your agenda. You can delete it or leave it here to refer back to later. ",wp.element.createElement("em",null,"Click anywhere outside of this box to close it."))))},save:function(e){return null}})}]);