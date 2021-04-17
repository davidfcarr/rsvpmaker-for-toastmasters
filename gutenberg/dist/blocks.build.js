!function(e){function t(a){if(n[a])return n[a].exports;var l=n[a]={i:a,l:!1,exports:{}};return e[a].call(l.exports,l,l.exports,t),l.l=!0,l.exports}var n={};t.m=e,t.c=n,t.d=function(e,n,a){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:a})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=2)}([function(e,t){},function(e,t){},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});n(3),n(5)},function(e,t,n){"use strict";function a(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function l(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!==typeof t&&"function"!==typeof t?e:t}function r(e,t){if("function"!==typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}function o(e){return e=e.replace('"',"&quot;"),e=e.replace('"',"&quot;")}function s(){return wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("a",{href:"https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/",target:"_blank"},__("Agenda Setup Documentation","rsvpmaker"))),wp.element.createElement("p",null,'Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren\'t visible, start typing "toastmasters" in the search blank as shown below.'),wp.element.createElement("p",null,wp.element.createElement("img",{src:"/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png"})),wp.element.createElement("p",null,"Most used agenda content blocks:"),wp.element.createElement("ul",null,wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/"},"Agenda Role")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/"},"Agenda Note")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/"},"Editable Note")),wp.element.createElement("li",null,wp.element.createElement("a",{target:"_blank",href:"https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/"},"Toastmasters Absences"))))}var m=n(0),i=(n.n(m),n(1)),c=(n.n(i),n(4)),u=(n.n(c),function(){function e(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}return function(t,n,a){return n&&e(t.prototype,n),a&&e(t,a),t}}()),__=wp.i18n.__,p=wp.blocks.registerBlockType,d=wp.blockEditor.RichText,w=wp.element,g=w.Component,f=w.Fragment,b=wp.editor,h=b.InspectorControls,E=(b.PanelBody,wp.components),v=E.TextareaControl,y=E.SelectControl,_=E.ToggleControl,k=E.TextControl,T=(wp.data.subscribe,[]);!function(){var e=wpt_rest.url+"rsvptm/v1/tweak_times?post_id="+wpt_rest.post_id;fetch(e,{method:"GET",headers:{"Content-Type":"application/json","X-WP-Nonce":wpt_rest.nonce}}).then(function(e){return e.json()}).then(function(e){T=e}).catch(function(e){console.error("Error:",e)})}(),p("wp4toastmasters/agendanoterich2",{title:__("Toastmasters Agenda Note"),icon:"admin-comments",category:"common",description:__('Displays "stage directions" for the organization of your meetings.',"rsvpmaker"),keywords:[__("Toastmasters"),__("Agenda"),__("Rich Text")],attributes:{content:{type:"array",source:"children",selector:"p"},time_allowed:{type:"string",default:"0"},uid:{type:"string",default:""},timing_updated:{type:"int",default:T}},edit:function(e){var t=e.attributes,n=(e.attributes.time_allowed,e.className,e.setAttributes),a=(e.isSelected,e.attributes.uid);if(!a){a="note"+(new Date).getTime()+Math.random(),n({uid:a})}return wp.element.createElement(f,null,wp.element.createElement(N,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("p",null,wp.element.createElement("strong",null,"Toastmasters Agenda Note")," ",wp.element.createElement("em",null,"Timing: See sidebar")),wp.element.createElement(d,{tagName:"p",value:t.content,multiline:" ",onChange:function(e){return n({content:e})}})))},save:function(e){var t=e.attributes,n=e.className;return wp.element.createElement(d.Content,{tagName:"p",value:t.content,className:n})}}),p("wp4toastmasters/signupnote",{title:__("Toastmasters Signup Form Note"),icon:"admin-comments",category:"common",description:__("A text block that appears only on the signup form, not on the agenda."),keywords:[__("Toastmasters"),__("Signup"),__("Rich Text")],attributes:{content:{type:"array",source:"children",selector:"p"}},edit:function(e){var t=(e.attributes,e.setAttributes);return wp.element.createElement(f,null,wp.element.createElement(A,null),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Signup Form Note"),wp.element.createElement(d,{tagName:"p",className:e.className,value:e.attributes.content,onChange:function(e){return t({content:e})}})))},save:function(e){return wp.element.createElement(d.Content,{tagName:"p",value:e.attributes.content,className:e.className})}}),p("wp4toastmasters/role",{title:__("Toastmasters Agenda Role"),icon:"groups",category:"common",description:__("Defines a meeting role that will appear on the signup form and the agenda."),keywords:[__("Toastmasters"),__("Agenda"),__("Role")],attributes:{role:{type:"string",default:""},custom_role:{type:"string",default:""},count:{type:"int",default:1},start:{type:"int",default:1},agenda_note:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},padding_time:{type:"string",default:"0"},backup:{type:"string",default:""}},edit:function(e){function t(){"custom"==document.querySelector("#role option:checked").value?customline.style="display: block;":(document.getElementById("custom_role").value="",customline.style="display: none;")}function n(){var e=event.target.querySelector("#role option:checked");s({role:e.value});document.getElementById("customline");t(),event.preventDefault()}function a(e){var t=document.getElementById("custom_role").value;s({custom_role:t}),e.preventDefault()}var l=e.attributes,r=l.role,o=l.custom_role,s=(l.count,l.start,l.agenda_note,l.time_allowed,l.padding_time,l.backup,e.setAttributes),m=e.isSelected;return wp.element.createElement(f,null,wp.element.createElement(C,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Role ",r," ",o),m&&wp.element.createElement("em",null,"More options: see sidebar"),function(){return m?wp.element.createElement("form",{onSubmit:a},wp.element.createElement("div",null,wp.element.createElement("label",null,"Role:"),wp.element.createElement("select",{id:"role",value:r,onChange:n},wp.element.createElement("option",{value:""}),wp.element.createElement("option",{value:"custom"},"Custom Role"),wp.element.createElement("option",{value:"Ah Counter"},"Ah Counter"),wp.element.createElement("option",{value:"Body Language Monitor"},"Body Language Monitor"),wp.element.createElement("option",{value:"Evaluator"},"Evaluator"),wp.element.createElement("option",{value:"General Evaluator"},"General Evaluator"),wp.element.createElement("option",{value:"Grammarian"},"Grammarian"),wp.element.createElement("option",{value:"Humorist"},"Humorist"),wp.element.createElement("option",{value:"Speaker"},"Speaker"),wp.element.createElement("option",{value:"Backup Speaker"},"Backup Speaker"),wp.element.createElement("option",{value:"Topics Master"},"Topics Master"),wp.element.createElement("option",{value:"Table Topics"},"Table Topics"),wp.element.createElement("option",{value:"Timer"},"Timer"),wp.element.createElement("option",{value:"Toastmaster of the Day"},"Toastmaster of the Day"),wp.element.createElement("option",{value:"Vote Counter"},"Vote Counter"),wp.element.createElement("option",{value:"Contest Chair"},"Contest Chair"),wp.element.createElement("option",{value:"Contest Master"},"Contest Master"),wp.element.createElement("option",{value:"Chief Judge"},"Chief Judge"),wp.element.createElement("option",{value:"Ballot Counter"},"Ballot Counter"),wp.element.createElement("option",{value:"Contestant"},"Contestant"))),wp.element.createElement("p",{id:"customline"},wp.element.createElement("label",null,"Custom Role:")," ",wp.element.createElement("input",{type:"text",id:"custom_role",onChange:a,defaultValue:o})),wp.element.createElement("div",null)):wp.element.createElement("em",null," Click to show options")}()))},save:function(e){return null}}),p("wp4toastmasters/agendaedit",{title:__("Toastmasters Editable Note"),icon:"welcome-write-blog",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Editable")],description:__("A note that can be edited by a meeting organizer"),attributes:{editable:{type:"string",default:""},uid:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},inline:{type:"int",default:0}},edit:function(e){var t=e.attributes,n=t.editable,a=(t.inline,e.setAttributes),l=(e.isSelected,e.attributes.uid);if(!l){l="editable"+(new Date).getTime()+Math.random(),a({uid:l})}return wp.element.createElement(f,null,wp.element.createElement(N,e),wp.element.createElement("div",{className:e.className},wp.element.createElement("p",{class:"dashicons-before dashicons-welcome-write-blog"},wp.element.createElement("strong",null,"Toastmasters Editable Note")),wp.element.createElement(k,{label:"Label",value:n,onChange:function(e){return a({editable:e})}})))},save:function(e){return null}}),p("wp4toastmasters/milestone",{title:__("Toastmasters Milestone"),icon:"welcome-write-blog",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Milestone")],description:__("Milestone such as the end of the meeting, displayed with time"),attributes:{label:{type:"string",default:""}},edit:function(e){var t=e.attributes.label,n=e.setAttributes;e.isSelected;return wp.element.createElement("div",{className:e.className},wp.element.createElement("p",{class:"dashicons-before dashicons-clock"},wp.element.createElement("strong",null,"Toastmasters Agenda Milestone")),wp.element.createElement(k,{label:"Label for Milestone",value:t,onChange:function(e){return n({label:e})}}))},save:function(e){var t=e.attributes.label;return wp.element.createElement("p",{maxtime:"x"},t)}}),p("wp4toastmasters/absences",{title:__("Toastmasters Absences"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Absences")],description:__("A button on the signup form where members can record a planned absence."),attributes:{show_on_agenda:{type:"int",default:0}},edit:function(e){function t(){var e=event.target.querySelector("#show_on_agenda option:checked");a({show_on_agenda:e.value}),event.preventDefault()}var n=e.attributes.show_on_agenda,a=e.setAttributes;e.isSelected;return wp.element.createElement(f,null,wp.element.createElement(A,null),wp.element.createElement("div",{className:e.className},wp.element.createElement("strong",null,"Toastmasters Absences")," placeholder for widget that tracks planned absences",function(){return wp.element.createElement("form",{onSubmit:t},wp.element.createElement("label",null,"Show on Agenda?")," ",wp.element.createElement("select",{id:"show_on_agenda",value:n,onChange:t},wp.element.createElement("option",{value:"0"},"No"),wp.element.createElement("option",{value:"1"},"Yes")))}()))},save:function(e){return null}});var C=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=(e.className,t.count),l=t.time_allowed,r=t.padding_time,m=t.agenda_note,i=t.backup,u=t.role;return wp.element.createElement(h,{key:"roleinspector"},wp.element.createElement("p",null,"Role: ",u),wp.element.createElement("div",{style:{width:"60%"}}," ",wp.element.createElement(c.__experimentalNumberControl,{label:__("Count","rsvpmaker-for-toastmasters"),value:a,onChange:function(e){return n({count:e})}})),wp.element.createElement("div",null,wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Count")," sets multiple instances of a role like Speaker or Evaluator."))),"Speaker"==u&&wp.element.createElement("div",null,wp.element.createElement("div",{style:{width:"45%",float:"left"}},wp.element.createElement(c.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),value:l,min:0,onChange:function(e){return n({time_allowed:e})}})),wp.element.createElement("div",{style:{width:"45%",float:"left",marginLeft:"5%"}},wp.element.createElement(c.__experimentalNumberControl,{label:__("Padding Time","rsvpmaker-for-toastmasters"),min:0,value:r,onChange:function(e){return n({padding_time:e})}})),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Time Allowed"),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes.")),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Padding Time"),": Typical use is extra time for introductions, beyond the time allowed for speeches."))),"Speaker"!=u&&wp.element.createElement("div",null,wp.element.createElement(c.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:l,onChange:function(e){return n({time_allowed:e})}}),wp.element.createElement("p",null,wp.element.createElement("em",null,wp.element.createElement("strong",null,"Time Allowed"),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."))),wp.element.createElement("div",null,wp.element.createElement("p",null,"Scheduling overview: ",wp.element.createElement("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1"},__("Agenda Time Planner","rsvpmaker")))),wp.element.createElement(v,{label:"Agenda Note",help:"A note that appears immediately below the role on the agenda and signup form",value:m,onChange:function(e){return n({agenda_note:o(e)})}}),wp.element.createElement(y,{label:__("Backup for this Role","rsvpmaker-for-toastmasters"),value:i,onChange:function(e){return n({backup:e})},options:[{value:"0",label:"No"},{value:"1",label:"Yes"}]}),s())}}]),t}(g),N=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){var e=this.props,t=e.attributes,n=e.setAttributes,a=t.time_allowed,l=t.editable,r=t.inline;return wp.element.createElement(h,{key:"noteinspector"},l&&wp.element.createElement(_,{label:"Display inline label, bold, instead of headline",help:r?"Inline Label":"Headline",checked:r,onChange:function(e){return n({inline:e})}}),wp.element.createElement(c.__experimentalNumberControl,{label:__("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:a,onChange:function(e){return n({time_allowed:e})}}),wp.element.createElement("p",null,"Scheduling overview: ",wp.element.createElement("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1"},__("Agenda Time Planner","rsvpmaker"))),s())}}]),t}(g),A=function(e){function t(){return a(this,t),l(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments))}return r(t,e),u(t,[{key:"render",value:function(){return wp.element.createElement(h,{key:"docinspector"},s())}}]),t}(g)},function(e,t){e.exports=wp.components},function(e,t,n){"use strict";var a=n(0),l=(n.n(a),n(1)),__=(n.n(l),wp.i18n.__),r=wp.blocks.registerBlockType,o=wp.editor.InnerBlocks,s=wp.components.FormToggle;"undefined"!==typeof toastmasters_special&&"Agenda Layout"==toastmasters_special&&(r("wp4toastmasters/agenda-wrapper",{title:"Agenda Layout Wrapper",icon:"admin-comments",category:"layout",keywords:["Toastmasters","Agenda","Wrapper"],attributes:{sidebar:{type:"boolean",default:!0}},edit:function(e){var t=[["wp4toastmasters/agendasidebar"]],n=e.attributes,a=e.className,l=e.setAttributes;e.isSelected;return n.sidebar?wp.element.createElement("div",{className:a},wp.element.createElement("table",{id:"agenda-main",width:"700"},wp.element.createElement("tbody",null,wp.element.createElement("tr",null,wp.element.createElement("td",{id:"agenda-sidebar",width:"175"},wp.element.createElement(o,{template:t})),wp.element.createElement("td",{id:"agenda-main",width:"*"},"Placeholder for role info, agenda notes, etc. ",rsvpmaker_ajax.special,wp.element.createElement("p",null,"Include sidebar: ",wp.element.createElement(s,{checked:n.sidebar,onChange:function(){l({sidebar:!n.sidebar})}}))))))):wp.element.createElement("div",{className:a},"Placeholder for role info, agenda notes, etc.",wp.element.createElement("p",null,"Include sidebar: ",wp.element.createElement(s,{checked:n.sidebar,onChange:function(){l({sidebar:!n.sidebar})}})))},save:function(e){var t=e.attributes,n=e.className;return t.sidebar?wp.element.createElement("div",{className:n},wp.element.createElement("table",{id:"agenda-main",width:"700"},wp.element.createElement("tbody",null,wp.element.createElement("tr",null,wp.element.createElement("td",{id:"agenda-sidebar",width:"175"},wp.element.createElement(o.Content,null)),wp.element.createElement("td",{id:"agenda-main",width:"*"},"[tmlayout_main]"))))):wp.element.createElement("div",{className:n},"[tmlayout_main]")}}),r("wp4toastmasters/agendasidebar",{title:__("Agenda Sidebar"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Sidebar")],description:__("Placeholder for sidebar content in the agenda layout. Includes officer listing if specified in Settings -> Toastmasters."),edit:function(e){return wp.element.createElement("div",{className:"agendaplaceholder"},"Placeholder: sidebar content")},save:function(e){return null}}),r("wp4toastmasters/agendamain",{title:__("Agenda Main Content"),icon:"admin-comments",category:"common",keywords:[__("Toastmasters"),__("Agenda"),__("Main")],description:__("Placeholder for main content (roles and agenda notes) in the agenda layout"),edit:function(e){return wp.element.createElement("div",{className:"agendaplaceholder"},"Placeholder: agenda main content")},save:function(e){return null}}))}]);