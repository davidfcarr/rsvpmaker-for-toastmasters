(()=>{"use strict";var e,t={990:()=>{const e=window.wp.blockEditor,t=window.ReactJSXRuntime,{__}=wp.i18n,{registerBlockType:s}=wp.blocks,{Fragment:n}=wp.element,{Component:a}=wp.element,{InspectorControls:r}=wp.blockEditor,{PanelBody:o,ToggleControl:i,SelectControl:l}=wp.components;s("wp4toastmasters/context",{title:"Agenda Display Wrapper",icon:"admin-comments",category:"common",keywords:["Toastmasters","Agenda Wrapper","Wrapper"],attributes:{content:{type:"array",source:"children",selector:"p"},webContext:{type:"boolean",default:!0},emailContext:{type:"boolean",default:!0},agendaContext:{type:"boolean",default:!0},printContext:{type:"boolean",default:!0},anonContext:{type:"boolean",default:!0}},edit:function(s){const{attributes:a,className:r,setAttributes:o,isSelected:i}=s,{webContext:l,emailContext:c,agendaContext:m,printContext:h}=a;return(0,t.jsxs)(n,{children:[(0,t.jsx)(d,{...s}),(0,t.jsxs)("div",{className:r,children:[(0,t.jsx)("div",{class:"context-block-label",children:"CLICK TO SET DISPLAY CONTEXT"}),(0,t.jsx)(e.InnerBlocks,{})]})]})},save:function({attributes:s,className:n}){return(0,t.jsx)("div",{className:n,children:(0,t.jsx)(e.InnerBlocks.Content,{})})}});class d extends a{render(){const{attributes:e,className:s,setAttributes:n,isSelected:a}=this.props,{webContext:l,emailContext:d,agendaContext:c,printContext:m,anonContext:h}=e;return(0,t.jsx)(r,{children:(0,t.jsxs)(o,{title:__("Display","rsvpmaker-for-toastmasters"),children:[(0,t.jsx)(i,{label:"Web / Signup Page",help:l?"Show on website / agenda signup view.":"Do not show on website / agenda signup view.",checked:l,onChange:e=>n({webContext:e})}),(0,t.jsx)(i,{label:"Agenda",help:c?"Show on agenda (email or print).":"Do not show on agenda (email or print).",checked:c,onChange:e=>n({agendaContext:e})}),(0,t.jsx)(i,{label:"Email",help:d?"Show on email agenda.":"Do not show on email agenda.",checked:d,onChange:e=>n({emailContext:e})}),(0,t.jsx)(i,{label:"Print",help:m?"Show on print agenda.":"Do not show on print agenda.",checked:m,onChange:e=>n({printContext:e})}),(0,t.jsx)(i,{label:"Anonymous Users",help:h?"No login required.":"Limit to logged in users and club email notifications.",checked:h,onChange:e=>n({anonContext:e})})]})},"contextInspector")}}const c=window.wp.components,{__:m}=wp.i18n,{registerBlockType:h}=wp.blocks,{RichText:u}=wp.blockEditor,{Component:p,Fragment:b}=wp.element,{InspectorControls:g,PanelBody:x}=wp.blockEditor,{TextareaControl:w,SelectControl:j,ToggleControl:f,TextControl:v,ServerSideRender:y}=wp.components,{subscribe:k}=wp.data;var _=[];wpt_rest.is_agenda&&function(){let e=wpt_rest.url+"rsvptm/v1/tweak_times?post_id="+wpt_rest.post_id;fetch(e,{method:"GET",headers:{"Content-Type":"application/json","X-WP-Nonce":wpt_rest.nonce}}).then((e=>e.json())).then((e=>{_=e})).catch((e=>{console.error("Error:",e)}))}(),h("wp4toastmasters/agendanoterich2",{title:m("Toastmasters Agenda Note"),icon:"admin-comments",category:"common",description:m('Displays "stage directions" for the organization of your meetings.',"rsvpmaker"),keywords:[m("Toastmasters"),m("Agenda"),m("Rich Text")],attributes:{content:{source:"html",selector:"p"},time_allowed:{type:"string",default:"0"},uid:{type:"string",default:""},timing_updated:{type:"int",default:_},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){const{attributes:s,attributes:{show_timing_summary:n,time_allowed:a},className:r,setAttributes:o,isSelected:i}=e;var l=e.attributes.uid;return l||(l="note"+(new Date).getTime()+Math.random(),o({uid:l})),(0,t.jsxs)(b,{children:[(0,t.jsx)(A,{...e}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("p",{children:(0,t.jsx)("strong",{children:"Toastmasters Agenda Note"})}),(0,t.jsx)(u,{tagName:"p",value:s.content,onChange:e=>o({content:e})}),i&&(0,t.jsxs)("div",{children:[(0,t.jsx)("p",{children:(0,t.jsx)("em",{children:"Options: see sidebar"})}),(0,t.jsx)(f,{label:"Show Timing Summary",help:n?"Show":"Do not show",checked:n,onChange:e=>o({show_timing_summary:e})}),n&&(0,t.jsx)(y,{block:"wp4toastmasters/agendanoterich2",attributes:e.attributes})]})]})]})},save:function({attributes:e,className:s}){return(0,t.jsx)(u.Content,{tagName:"p",value:e.content,className:s})}}),h("wp4toastmasters/signupnote",{title:m("Toastmasters Signup Form Note"),icon:"admin-comments",category:"common",description:m("A text block that appears only on the signup form, not on the agenda."),keywords:[m("Toastmasters"),m("Signup"),m("Rich Text")],attributes:{content:{type:"array",source:"children",selector:"p"}},edit:function(e){const{attributes:s,setAttributes:n}=e;return(0,t.jsxs)(b,{children:[(0,t.jsx)(M,{}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("strong",{children:"Toastmasters Signup Form Note"}),(0,t.jsx)(u,{tagName:"p",className:e.className,value:e.attributes.content,onChange:e=>n({content:e})})]})]})},save:function(e){return(0,t.jsx)(u.Content,{tagName:"p",value:e.attributes.content,className:e.className})}}),h("wp4toastmasters/role",{title:m("Toastmasters Agenda Role"),icon:"groups",category:"common",description:m("Defines a meeting role that will appear on the signup form and the agenda."),keywords:[m("Toastmasters"),m("Agenda"),m("Role")],attributes:{role:{type:"string",default:""},custom_role:{type:"string",default:""},count:{type:"int",default:1},start:{type:"int",default:1},agenda_note:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},padding_time:{type:"string",default:"0"},backup:{type:"string",default:""},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){const{attributes:{role:s,custom_role:n,count:a,start:r,agenda_note:o,time_allowed:i,padding_time:l,backup:d,show_timing_summary:c},setAttributes:m,isSelected:h}=e;return(0,t.jsxs)(b,{children:[(0,t.jsx)(C,{...e}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsxs)("strong",{children:["Toastmasters Role ",s," ",n]}),h&&(0,t.jsxs)("div",{children:[(0,t.jsx)("p",{children:(0,t.jsx)("em",{children:"Options: see sidebar"})}),(0,t.jsx)(f,{label:"Show Timing Summary",help:c?"Show":"Do not show",checked:c,onChange:e=>m({show_timing_summary:e})}),c&&(0,t.jsx)(y,{block:"wp4toastmasters/role",attributes:e.attributes})]})]})]})},save:function(e){return null}}),h("wp4toastmasters/agendaedit",{title:m("Toastmasters Editable Note"),icon:"welcome-write-blog",category:"common",keywords:[m("Toastmasters"),m("Agenda"),m("Editable")],description:m("A note that can be edited by a meeting organizer"),attributes:{editable:{type:"string",default:""},uid:{type:"string",default:""},time_allowed:{type:"string",default:"0"},timing_updated:{type:"int",default:0},inline:{type:"int",default:0},show_timing_summary:{type:"boolean",default:!1}},edit:function(e){const{attributes:{editable:s,show_timing_summary:n},setAttributes:a,isSelected:r}=e;var o=e.attributes.uid;return o||(o="editable"+(new Date).getTime()+Math.random(),a({uid:o})),(0,t.jsxs)(b,{children:[(0,t.jsx)(A,{...e}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("p",{class:"dashicons-before dashicons-welcome-write-blog",children:(0,t.jsx)("strong",{children:"Toastmasters Editable Note"})}),(0,t.jsx)(v,{label:"Label",value:s,onChange:e=>a({editable:e})}),r&&(0,t.jsxs)("div",{children:[(0,t.jsx)("em",{children:"Options: see sidebar"}),(0,t.jsx)(f,{label:"Show Timing Summary",help:n?"Show":"Do not show",checked:n,onChange:e=>a({show_timing_summary:e})}),n&&(0,t.jsx)(y,{block:"wp4toastmasters/agendaedit",attributes:e.attributes})]})]})]})},save:function(e){return null}}),h("wp4toastmasters/milestone",{title:m("Toastmasters Milestone"),icon:"welcome-write-blog",category:"common",keywords:[m("Toastmasters"),m("Agenda"),m("Milestone")],description:m("Milestone such as the end of the meeting, displayed with time"),attributes:{label:{type:"string",default:""}},edit:function(e){const{attributes:{label:s},setAttributes:n,isSelected:a}=e;return(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("p",{class:"dashicons-before dashicons-clock",children:(0,t.jsx)("strong",{children:"Toastmasters Agenda Milestone"})}),(0,t.jsx)(v,{label:"Label for Milestone",value:s,onChange:e=>n({label:e})})]})},save:function(e){const{attributes:{label:s}}=e;return(0,t.jsx)("p",{maxtime:"x",children:s})}}),h("wp4toastmasters/absences",{title:m("Toastmasters Absences"),icon:"admin-comments",category:"common",keywords:[m("Toastmasters"),m("Agenda"),m("Absences")],description:m("A button on the signup form where members can record a planned absence."),attributes:{show_on_agenda:{type:"int",default:0}},edit:function(e){const{attributes:{show_on_agenda:s},setAttributes:n,isSelected:a}=e;function r(){const e=event.target.querySelector("#show_on_agenda option:checked");n({show_on_agenda:e.value}),event.preventDefault()}return(0,t.jsxs)(b,{children:[(0,t.jsx)(M,{}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("strong",{children:"Toastmasters Absences"})," placeholder for widget that tracks planned absences",(0,t.jsxs)("form",{onSubmit:r,children:[(0,t.jsx)("label",{children:"Show on Agenda?"})," ",(0,t.jsxs)("select",{id:"show_on_agenda",value:s,onChange:r,children:[(0,t.jsx)("option",{value:"0",children:"No"}),(0,t.jsx)("option",{value:"1",children:"Yes"})]})]})]})]})},save:function(e){return null}}),h("wp4toastmasters/hybrid",{title:m("Toastmasters Hybrid"),icon:"admin-comments",category:"common",keywords:[m("Toastmasters"),m("Agenda"),m("Hybrid")],description:m("Allows hybrid clubs to track which members will attend in person"),attributes:{limit:{type:"int",default:0}},edit:function(e){const{attributes:{limit:s},setAttributes:n,isSelected:a}=e;return(0,t.jsxs)(b,{children:[(0,t.jsx)(S,{...e}),(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsx)("strong",{children:"Toastmasters Hybrid"})," Placeholder for widget that allows hybrid clubs to track who will attend in person, rather than online"]})]})},save:function(e){return null}});class C extends p{render(){const{attributes:e,setAttributes:s,className:n}=this.props,{count:a,time_allowed:r,padding_time:o,agenda_note:i,backup:l,role:d,custom_role:h}=e;return(0,t.jsxs)(g,{children:[(0,t.jsx)(j,{label:m("Role","rsvpmaker-for-toastmasters"),value:d,onChange:e=>s({role:e}),options:toast_roles}),(0,t.jsx)(v,{label:"Custom Role",value:h,onChange:e=>s({custom_role:e})}),(0,t.jsxs)("div",{style:{width:"60%"},children:[" ",(0,t.jsx)(c.__experimentalNumberControl,{label:m("Count","rsvpmaker-for-toastmasters"),value:a,onChange:e=>s({count:e})})]}),(0,t.jsx)("div",{children:(0,t.jsx)("p",{children:(0,t.jsxs)("em",{children:[(0,t.jsx)("strong",{children:"Count"})," sets multiple instances of a role like Speaker or Evaluator."]})})}),"Speaker"==d&&(0,t.jsxs)("div",{children:[(0,t.jsx)("div",{style:{width:"45%",float:"left"},children:(0,t.jsx)(c.__experimentalNumberControl,{label:m("Time Allowed","rsvpmaker-for-toastmasters"),value:r,min:0,onChange:e=>s({time_allowed:e})})}),(0,t.jsx)("div",{style:{width:"45%",float:"left",marginLeft:"5%"},children:(0,t.jsx)(c.__experimentalNumberControl,{label:m("Padding Time","rsvpmaker-for-toastmasters"),min:0,value:o,onChange:e=>s({padding_time:e})})}),(0,t.jsx)("p",{children:(0,t.jsxs)("em",{children:[(0,t.jsx)("strong",{children:"Time Allowed"}),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."]})}),(0,t.jsx)("p",{children:(0,t.jsxs)("em",{children:[(0,t.jsx)("strong",{children:"Padding Time"}),": Typical use is extra time for introductions, beyond the time allowed for speeches."]})})]}),"Speaker"!=d&&(0,t.jsxs)("div",{children:[(0,t.jsx)(c.__experimentalNumberControl,{label:m("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:r,onChange:e=>s({time_allowed:e})}),(0,t.jsx)("p",{children:(0,t.jsxs)("em",{children:[(0,t.jsx)("strong",{children:"Time Allowed"}),": Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes."]})})]}),(0,t.jsx)("div",{children:(0,t.jsxs)("p",{children:["Scheduling overview: ",(0,t.jsx)("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1",children:m("Agenda Time Planner","rsvpmaker")})]})}),(0,t.jsx)(w,{label:"Agenda Note",help:"A note that appears immediately below the role on the agenda and signup form",value:i,onChange:e=>s({agenda_note:T(e)})}),(0,t.jsx)(j,{label:m("Backup for this Role","rsvpmaker-for-toastmasters"),value:l,onChange:e=>s({backup:e}),options:[{value:"0",label:"No"},{value:"1",label:"Yes"}]}),N()]},"roleinspector")}}function T(e){return(e=e.replace('"',"&quot;")).replace('"',"&quot;")}function N(){return(0,t.jsxs)("div",{children:[(0,t.jsx)("p",{children:(0,t.jsx)("a",{href:"https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/",target:"_blank",children:m("Agenda Setup Documentation","rsvpmaker")})}),(0,t.jsx)("p",{children:'Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren\'t visible, start typing "toastmasters" in the search blank as shown below.'}),(0,t.jsx)("p",{children:(0,t.jsx)("img",{src:"/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png"})}),(0,t.jsx)("p",{children:"Most used agenda content blocks:"}),(0,t.jsxs)("ul",{children:[(0,t.jsx)("li",{children:(0,t.jsx)("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/",children:"Agenda Role"})}),(0,t.jsx)("li",{children:(0,t.jsx)("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/",children:"Agenda Note"})}),(0,t.jsx)("li",{children:(0,t.jsx)("a",{target:"_blank",href:"https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/",children:"Editable Note"})}),(0,t.jsx)("li",{children:(0,t.jsx)("a",{target:"_blank",href:"https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/",children:"Toastmasters Absences"})})]})]})}class A extends p{render(){const{attributes:e,setAttributes:s}=this.props,{time_allowed:n,editable:a,inline:r}=e;return(0,t.jsxs)(g,{children:[a&&(0,t.jsx)(f,{label:"Display inline label, bold, instead of headline",help:r?"Inline Label":"Headline",checked:r,onChange:e=>s({inline:e})}),(0,t.jsx)(c.__experimentalNumberControl,{label:m("Time Allowed","rsvpmaker-for-toastmasters"),min:0,value:n,onChange:e=>s({time_allowed:e})}),(0,t.jsxs)("p",{children:["Scheduling overview: ",(0,t.jsx)("a",{href:wp.data.select("core/editor").getPermalink()+"??tweak_times=1",children:m("Agenda Time Planner","rsvpmaker")})]}),N()]},"noteinspector")}}class S extends p{render(){const{attributes:e,setAttributes:s}=this.props,{limit:n}=e;return(0,t.jsxs)(g,{children:[(0,t.jsx)(c.__experimentalNumberControl,{label:m("Attendance limit (0 for none)","rsvpmaker-for-toastmasters"),min:0,value:n,onChange:e=>s({limit:e})}),N()]},"hybridinspector")}}class M extends p{render(){return(0,t.jsx)(g,{children:N()},"docinspector")}}h("wp4toastmasters/duesrenewal",{title:m("Dues Renewal"),icon:"groups",category:"common",description:m("Displays a member dues renewal form."),keywords:[m("Toastmasters"),m("Dues"),m("Payment")],edit:function(e){const{attributes:{amount:s},setAttributes:n,isSelected:a}=e;return(0,t.jsxs)("div",{className:e.className,children:[(0,t.jsxs)("p",{children:[(0,t.jsx)("strong",{children:"Toastmasters Dues Renewal"})," - displays the payment form"]}),(0,t.jsxs)("p",{children:[m("Payment will be calculated according to the dues schedule set in","rsvpmaker-for-toastmasters"),(0,t.jsx)("br",{}),m("Settings > TM Member Application","rsvpmaker-for-toastmasters")]})]})},save:function(e){return null}});const{__:P}=wp.i18n,{registerBlockType:D}=wp.blocks,{InnerBlocks:E}=wp.editor,{FormToggle:O,ServerSideRender:I}=wp.components;void 0!==wpt_rest.special&&"Agenda Layout"==wpt_rest.special&&(D("wp4toastmasters/agenda-wrapper",{title:"Agenda Layout Wrapper",icon:"admin-comments",category:"layout",keywords:["Toastmasters","Agenda","Wrapper"],attributes:{sidebar:{type:"boolean",default:!0}},edit:function(e){const{attributes:s,className:n,setAttributes:a,isSelected:r}=e;return s.sidebar?(0,t.jsx)("div",{className:n,children:(0,t.jsx)("table",{id:"agenda-main",width:"700",children:(0,t.jsx)("tbody",{children:(0,t.jsxs)("tr",{children:[(0,t.jsx)("td",{id:"agenda-sidebar",width:"175",children:(0,t.jsx)(E,{template:[["wp4toastmasters/agendasidebar"]]})}),(0,t.jsxs)("td",{id:"agenda-main",width:"*",children:["Placeholder for role info, agenda notes, etc. ",rsvpmaker_ajax.special,(0,t.jsxs)("p",{children:["Include sidebar: ",(0,t.jsx)(O,{checked:s.sidebar,onChange:function(){a({sidebar:!s.sidebar})}})]})]})]})})})}):(0,t.jsxs)("div",{className:n,children:["Placeholder for role info, agenda notes, etc.",(0,t.jsxs)("p",{children:["Include sidebar: ",(0,t.jsx)(O,{checked:s.sidebar,onChange:function(){a({sidebar:!s.sidebar})}})]})]})},save:function({attributes:e,className:s}){return e.sidebar?(0,t.jsx)("div",{className:s,children:(0,t.jsx)("table",{id:"agenda-main",width:"700",children:(0,t.jsx)("tbody",{children:(0,t.jsxs)("tr",{children:[(0,t.jsx)("td",{id:"agenda-sidebar",width:"175",children:(0,t.jsx)(E.Content,{})}),(0,t.jsx)("td",{id:"agenda-main",width:"*",children:"[tmlayout_main]"})]})})})}):(0,t.jsx)("div",{className:s,children:"[tmlayout_main]"})}}),D("wp4toastmasters/agendasidebar",{title:P("Agenda Sidebar"),icon:"admin-comments",category:"common",keywords:[P("Toastmasters"),P("Agenda"),P("Sidebar")],description:P("Placeholder for sidebar content in the agenda layout. Includes officer listing if specified in Settings -> Toastmasters."),edit:function(e){return(0,t.jsx)("div",{className:"agendaplaceholder",children:"Placeholder: sidebar content"})},save:function(e){return null}}));const{__:R}=wp.i18n,{registerBlockType:B}=wp.blocks,{Component:L,Fragment:F}=wp.element,{InspectorControls:W,PanelBody:H}=wp.blockEditor,{TextControl:q,ToggleControl:Y,SelectControl:X}=wp.components;B("wp4toastmasters/memberaccess",{title:R("Toastmasters Member Access"),icon:"groups",category:"common",description:R("Displays member singup opportunities, profile links, etc."),keywords:[R("Toastmasters"),R("Sidebar"),R("Member")],attributes:{title:{type:"string",default:"Member Access"},dateformat:{type:"string",default:"M j"},limit:{type:"int",default:10},showmore:{type:"int",default:4},showlog:{type:"boolean",default:!0}},edit:function(e){const{title:s,limit:n,showlog:a,showmore:r}=e.attributes,o=[];for(let e=1;e<=n;e++)o.push((0,t.jsx)("div",{children:(0,t.jsx)("div",{class:"meetinglinks",children:(0,t.jsxs)("a",{class:"meeting",href:"#",children:["Toastmasters Meeting Jan ",e]})})}));return(0,t.jsxs)(F,{children:[(0,t.jsx)(z,{...e}),(0,t.jsxs)("div",{className:e.className,children:[s&&(0,t.jsx)("h5",{class:"member-access-title",children:s}),(0,t.jsxs)("ul",{class:"member-access-prompts",children:[(0,t.jsxs)("li",{class:"widgetsignup",children:["Member sign up for roles:",o,r&&(0,t.jsx)("div",{id:"showmorediv",children:(0,t.jsx)("a",{href:"#",id:"showmore",children:"Show More"})})]}),(0,t.jsxs)("li",{children:["Your membership:",(0,t.jsx)("div",{children:(0,t.jsx)("a",{href:"#",children:"Edit Member Profile"})}),(0,t.jsx)("div",{children:(0,t.jsx)("a",{href:"#",children:"Member Dashboard"})})]}),a&&(0,t.jsxs)("li",{children:[(0,t.jsx)("strong",{children:"Activity"}),(0,t.jsx)("br",{}),(0,t.jsxs)("div",{children:[(0,t.jsx)("strong",{children:"Demo Member:"})," signed up for Toastmaster of the Day for December 1st, 2022 ",(0,t.jsx)("small",{children:(0,t.jsx)("em",{children:"(Posted: 11/06/22 13:25)"})})]}),(0,t.jsxs)("div",{children:[(0,t.jsx)("strong",{children:"Demo Member:"})," signed up for Speaker for February 1st, 2023 ",(0,t.jsx)("small",{children:(0,t.jsx)("em",{children:"(Posted: 11/06/22 13:30)"})})]})]})]})]})]})},save:function(e){return null}});class z extends L{render(){const{attributes:e,setAttributes:s}=this.props,{title:n,dateformat:a,limit:r,showmore:o,showlog:i}=e;return console.log(n),console.log(a),console.log(r),console.log(o),console.log(i),(0,t.jsxs)(W,{children:[(0,t.jsx)(q,{label:"Title",value:n,onChange:e=>s({title:e})}),(0,t.jsx)(c.__experimentalNumberControl,{label:R("Number of Meetings Shown","rsvpmaker-for-toastmasters"),min:0,value:r,onChange:e=>s({limit:e})}),(0,t.jsx)(c.__experimentalNumberControl,{label:R("Show More Number","rsvpmaker-for-toastmasters"),min:0,value:o,onChange:e=>s({showmore:e})}),(0,t.jsx)(Y,{label:"Show Activity Log",help:i?"Show":"Do not show",checked:i,onChange:e=>s({showlog:e})}),(0,t.jsx)(q,{label:"Date Format",value:a,onChange:e=>s({dateformat:e})}),(0,t.jsx)("p",{children:(0,t.jsx)("a",{href:"https://www.php.net/manual/en/datetime.format.php",target:"_blank",children:"Uses PHP date format codes"})})]})}}B("wp4toastmasters/blog",{title:R("Toastmasters Public/Private Blogs"),icon:"groups",category:"common",description:R("Club News and Members Only Blog Posts"),keywords:[R("Toastmasters"),R("Sidebar"),R("Blog")],attributes:{title:{type:"string",default:"Members Only"},type:{type:"string",default:"private"},number:{type:"int",default:10}},edit:function(e){const{title:s,type:n,number:a}=e.attributes,r=[];for(let e=1;e<=a;e++)r.push((0,t.jsxs)("li",{children:[(0,t.jsxs)("a",{href:"#",children:["Post Title ",(0,t.jsx)("em",{children:n})]})," Date"]}));return(0,t.jsxs)(F,{children:[(0,t.jsx)(J,{...e}),(0,t.jsxs)("div",{className:e.className,children:[s&&(0,t.jsx)("h5",{children:s}),(0,t.jsx)("ul",{children:r})]})]})},save:function(e){return null}});class J extends L{render(){const{attributes:e,setAttributes:s}=this.props;let{title:n,type:a,number:r}=e;return"private"===a&&"Club News"===n&&(n="Members Only",s({title:n})),"public"===a&&"Members Only"===n&&(n="Club News",s({title:n})),console.log(n),(0,t.jsxs)(W,{children:[(0,t.jsx)(q,{label:"Title",value:n,onChange:e=>s({title:e})}),(0,t.jsx)(X,{label:R("Type","rsvpmaker-for-toastmasters"),value:a,onChange:e=>s({type:e}),options:[{value:"private",label:"private"},{value:"public",label:"public"}]}),(0,t.jsx)(c.__experimentalNumberControl,{label:R("Number of Posts","rsvpmaker-for-toastmasters"),min:0,value:r,onChange:e=>s({number:e})})]})}}B("wp4toastmasters/newestmembers",{title:R("Toastmasters Newest Members"),icon:"groups",category:"common",description:R("Toastmasters newest members by user record"),keywords:[R("Toastmasters"),R("Sidebar"),R("Newest Members")],attributes:{title:{type:"string",default:"Newest Members"},number:{type:"int",default:5}},edit:function(e){const{title:s,number:n}=e.attributes,a=[];for(let e=1;e<=n;e++)a.push((0,t.jsxs)("li",{children:["Member ",e]}));return(0,t.jsxs)(F,{children:[(0,t.jsx)(U,{...e}),(0,t.jsxs)("div",{className:e.className,children:[s&&(0,t.jsx)("h5",{children:s}),(0,t.jsx)("ul",{children:a})]})]})},save:function(e){return null}});class U extends L{render(){const{attributes:e,setAttributes:s}=this.props,{title:n,number:a}=e;return(0,t.jsxs)(W,{children:[(0,t.jsx)(q,{label:"Title",value:n,onChange:e=>s({title:e})}),(0,t.jsx)(c.__experimentalNumberControl,{label:R("Number of Members","rsvpmaker-for-toastmasters"),min:0,value:a,onChange:e=>s({number:e})})]})}}}},s={};function n(e){var a=s[e];if(void 0!==a)return a.exports;var r=s[e]={exports:{}};return t[e](r,r.exports,n),r.exports}n.m=t,e=[],n.O=(t,s,a,r)=>{if(!s){var o=1/0;for(c=0;c<e.length;c++){for(var[s,a,r]=e[c],i=!0,l=0;l<s.length;l++)(!1&r||o>=r)&&Object.keys(n.O).every((e=>n.O[e](s[l])))?s.splice(l--,1):(i=!1,r<o&&(o=r));if(i){e.splice(c--,1);var d=a();void 0!==d&&(t=d)}}return t}r=r||0;for(var c=e.length;c>0&&e[c-1][2]>r;c--)e[c]=e[c-1];e[c]=[s,a,r]},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={401:0,869:0};n.O.j=t=>0===e[t];var t=(t,s)=>{var a,r,[o,i,l]=s,d=0;if(o.some((t=>0!==e[t]))){for(a in i)n.o(i,a)&&(n.m[a]=i[a]);if(l)var c=l(n)}for(t&&t(s);d<o.length;d++)r=o[d],n.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return n.O(c)},s=globalThis.webpackChunktoastmasters_dynamic_agenda=globalThis.webpackChunktoastmasters_dynamic_agenda||[];s.forEach(t.bind(null,0)),s.push=t.bind(null,s.push.bind(s))})();var a=n.O(void 0,[869],(()=>n(990)));a=n.O(a)})();