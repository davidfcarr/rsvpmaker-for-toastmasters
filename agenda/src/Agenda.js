import React, {useState, useEffect, Suspense} from "react"

import { RadioControl } from '@wordpress/components';

import {SelectCtrl, NumberCtrl} from './Ctrl.js'

import RoleBlock from "./RoleBlock.js";

import {SpeakerTimeCount} from "./SpeakerTimeCount.js";

const EvaluationTool = React.lazy(() => import('./EvaluationTool.js'));

import {TemplateAndSettings} from "./TemplateAndSettings.js";

import {SanitizedHTML} from "./SanitizedHTML.js";

import {EditorAgendaNote} from './EditorAgendaNote.js';

import {EditableNote} from './EditableNote.js';

import {SignupNote} from './SignupNote.js';

import Reorganize from './Reorganize';
import ReorgWidget from './ReorgWidget';

import {Inserter} from "./Inserter.js";

import {Absence} from './Absence.js';

import {Hybrid} from './Hybrid.js';

import {useBlocks,updateAgenda} from './queries.js';
import { useCollapse } from 'react-collapsed';
import { Icon, chevronUp, chevronDown } from '@wordpress/icons';

export default function Agenda(props) {

    let initialPost = 0;

    if('rsvpmaker' == wpt_rest.post_type) {

        initialPost = wpt_rest.post_id;

    } else {

        initialPost = new URL(document.location).searchParams.get('post_id');

        if(!initialPost)

            initialPost = 0;

    }

    const [post_id, setPostId] = useState(initialPost);

    const [current_user_id,setCurrentUserId] = useState(0);

    const [mode, setMode] = useState((props.mode_init) ? props.mode_init : 'signup');

    const [showDetails, setshowDetails] = useState('all');

    const [showControls,setShowControls] = useState(-1);
    const [editNotes,setEditNotes] = useState(false);

    const [scrollTo,setScrollTo] = useState('react-agenda');

    const [notification,setNotification] = useState(null);

    const [notificationTimeout,setNotificationTimeout] = useState(null);

    const [evaluate,setEvaluate] = useState(props.evaluation);

    function scrolltoId(id){

        if(!id)

            return;

        var access = document.getElementById(id);

        if(!access)

            {

                console.log('scroll to id could not find element '+id);

                return;

            }

        access.scrollIntoView({behavior: 'smooth'}, true);

    }



    function makeNotification(message, prompt = false, otherproperties = null) {

        if(notificationTimeout)

            clearTimeout(notificationTimeout);

        setNotification({'message':message,'prompt':prompt,'otherproperties':otherproperties});

        let nt = setTimeout(() => {

            setNotification(null);

        },25000);

        setNotificationTimeout(nt);

    }

    const {mutate:agendaMutate} = updateAgenda(post_id, makeNotification,Inserter);    

    function NextMeetingPrompt() {

        if(typeof data == 'undefined')

            return;



        let pid = data.upcoming.findIndex((item) => item.value == post_id);

        if(data.upcoming[pid +1])

            return <div className="next-meeting-prompt">Would you like to sign up for the <a href={data.upcoming[pid +1].permalink+'?newsignup'}>Next meeting?</a></div>

        else

            return null;

    }


    useEffect(() => {scrolltoId(scrollTo); if('react-agenda' != scrollTo) setScrollTo('react-agenda'); },[mode])

try {

    const { isLoading, isFetching, isSuccess, isError, data:axiosdata, error, refetch} = useBlocks(post_id);

    if(isError)

        return <p>Error loading agenda data. Try <a href={window.location.href}>reloading the page</a>. You can also <a href={(window.location.href.indexOf('?') > 0) ? window.location.href +'&revert=1' : window.location.href +'?revert=1'}>use the old version of the signup form</a>.</p>

    

    if(axiosdata) {

        const {permissions} = axiosdata?.data;

    }



    function calcTimeAllowed(attrs) {

        let time_allowed = 0;

        let count = (attrs.count) ? attrs.count : 1;

        if('Speaker' == attrs.role)

            time_allowed = count * 7;

        if('Evaluator' == attrs.role)

            time_allowed = count * 3;

        return time_allowed;

    }





function ModeControl(props) {

    const [isExpanded, setExpanded] = useState(true);
    const { getCollapseProps, getToggleProps } = useCollapse({ isExpanded });

    useEffect(() => {
        const timer = setTimeout(() => {setExpanded(false); }, 5000);
    }, []);

    const {note} = props;

    const modeoptions = [];

    if(props.isTemplate) {

        modeoptions.push({'label': 'Organize', 'value':'reorganize'});

        modeoptions.push({'label': 'Template/Settings', 'value':'settings'});

    } else {

        modeoptions.push({'label': 'SignUp', 'value':'signup'});

        modeoptions.push({'label': 'Suggest', 'value':'suggest'});

        modeoptions.push({'label': 'Evaluation', 'value':'evaluation'});

        if(user_can('edit_post') || user_can('organize_agenda') || user_can('edit_signups')) {

            modeoptions.push({'label': 'Edit', 'value':'edit'});

            modeoptions.push({'label': 'Assign', 'value':'assign'});

        }

        if(user_can('edit_post') || user_can('organize_agenda'))

            modeoptions.push({'label': 'Organize', 'value':'reorganize'});

        if(user_can('edit_post'))

            modeoptions.push({'label': 'Template/Settings', 'value':'settings'});

    }

    const viewoptions = ('reorganize' == mode) ? [{'value':'all','label':'Show All'},{'value':'','label':'Outline View'},{'value':'speakers-evaluators','label':'Speakers and Evaluators Only'},{'value':'timed','label':'Timed Elements Only'}] : [{'value':'all','label':'Show Details'},{'value':'','label':'Outline View'},{'value':'speakers-evaluators','label':'Speakers and Evaluators Only'}];    

    return (

    <div id="fixed-mode-control">
        {!isExpanded && <button style={{'verticalAlign':'middle'}}
        {...getToggleProps({
          onClick: () => setExpanded((prevExpanded) => !prevExpanded),
        })}
      >
      <Icon icon={chevronUp} />
        Show Agenda Views
      </button>}
      <section {...getCollapseProps()}>
      <div  className="showtoggle">
      <button style={{'verticalAlign':'middle'}}
        {...getToggleProps({
          onClick: () => setExpanded((prevExpanded) => !prevExpanded),
        })}
      >
      <Icon icon={chevronDown} /> Hide Agenda Views
      </button>
      </div>
        <p className="modenote">{props.isTemplate && <strong>Editing Template - <a target="_blank" href={'/wp-admin/edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t='+props.post_id}>Create/Update</a> - </strong>} {note}</p>

        {notification && <div className="tm-notification tm-notification-success suggestion-notification"> <SanitizedHTML innerHTML={notification.message} /> {notification.prompt && <NextMeetingPrompt />} {notification.otherproperties && notification.otherproperties.map( (property) => {if(property.template_prompt) return <div className="next-meeting-prompt"><a target="_blank" href={'/wp-admin/edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t='+property.template_prompt}>Create/Update</a> - copy content to new and existing events</div>} )} {isFetching && <em>Fetching fresh data ...</em>}</div>}

        <RadioControl className="radio-mode" selected={mode} label="Mode" onChange={(value)=> { setScrollTo('react-agenda');setMode(value); }  } options={modeoptions}/>
        <p className="mode-help">{getHelpMessage()}</p>
        </section>
        </div>)

}



function getHelpMessage() {

    if('signup' == mode)

    return 'Sign yourself up for roles and enter/update speech details';

if('edit' == mode)

    return 'Assign others to roles and edit their speech details. Rearrange or delete assignments.';

if('assign' == mode)

    return 'Assign others to roles (grid view)';

if('suggest' == mode)

    return 'Nominate another member for a role -- they will get an email notification that makes it easy to say yes';

if('evaluation' == mode)

    return 'Provide written speech feedback using digital versions of the evaluation forms';

if('reorganize' == mode)

    return 'Rearrange roles and other elements on your agenda and adjust the timing';

if('settings' == mode)

    return 'Update your standard meeting template or switch the template for the current meeting. Adjust event date and time. Update settings.';

}

    function user_can(permission) {

        const permissions = axiosdata.data.permissions;

        let answer = false;

        if(permissions[permission]) {

            answer = permissions[permission];

        }

        return answer;

    }



    if(isLoading)

        return <p>Loading ...</p>;

    if(!axiosdata.data.current_user_id) 

        return <p>You must be logged in as a member of this website to see the signup form.</p>

    const data = axiosdata.data;

    const raw = ['core/image','core/paragraph','core/heading','wp4toastmasters-signupnote']

    const ignore = ['wp4toastmasters/agendanoterich2','wp4toastmasters/milestone','wp4toastmasters/help']

    let date = new Date(data.datetime);

    const dateoptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

    let datestring = '';

    if(!post_id)

        setPostId(data.post_id);

    if(!current_user_id)

        setCurrentUserId(data.current_user_id);



    if('settings' == mode)

    {

        return(

            <div className="agendawrapper">

            <ModeControl isTemplate={(false !== data.is_template)} post_id={data.post_id} />

            <TemplateAndSettings makeNotification={makeNotification} setPostId={setPostId} user_can={user_can} data={data} />

            </div>

        );

    }



    if('evaluation' == mode)

    {

        return(

            <div className="agendawrapper">

            <ModeControl />

            <Suspense fallback={<h1>Loading ...</h1>}>

            <EvaluationTool scrolltoId={scrolltoId} makeNotification={makeNotification} data={data} evaluate={evaluate} setEvaluate={setEvaluate} />

            </Suspense>

            </div>

        );

    }



    if('reorganize' == mode)

        return <Suspense fallback={<h1>Loading ...</h1>}><Reorganize data={data} mode={mode} setMode={setMode} post_id={post_id} makeNotification={makeNotification} ModeControl={ModeControl} showDetails={showDetails} setshowDetails={setshowDetails} setScrollTo={setScrollTo} setEvaluate={setEvaluate} setPostId={setPostId} /></Suspense>



    return (

        <div className="agendawrapper" id={"agendawrapper"+post_id}>

            <>{'suggest' == mode && <p>See also the <a href={data.admin_url+'admin.php?page=wpt_suggest_all_roles&meeting='+post_id}>Suggest All Roles</a> tool for sending suggestions in a batch.</p>}</>

            <>{('rsvpmaker' != wpt_rest.post_type) && <SelectCtrl label="Choose Event" value={post_id} options={data.upcoming} onChange={(value) => {setPostId(parseInt(value)); makeNotification('Date changed, please wait for the date to change ...'); queryClient.invalidateQueries(['blocks-data',post_id]); refetch();}} />}</>

            <h4>{date.toLocaleDateString('en-US',dateoptions)} {data.is_template && <span>(Template)</span>}</h4>

            <ModeControl makeNotification={makeNotification} isTemplate={(false !== data.is_template)} post_id={data.post_id} />

            {!Array.isArray(data.blocksdata) && <p>Error loading agenda (<a href={window.location.href+'?revert=1'}>try alternate version</a>).</p>}

            {('assign' == mode) && <div className="assignment" note="workaround for alignment issue"></div>} 

            {Array.isArray(data.blocksdata) && data.blocksdata.map((block, blockindex) => {

                datestring = date.toLocaleTimeString('en-US',{hour: "2-digit", minute: "2-digit",hour12:true});

                if(block?.attrs?.time_allowed) {

                    date.setMilliseconds(date.getMilliseconds() + (parseInt(block.attrs.time_allowed) * 60000) );

                    if(block.attrs.padding_time)

                        date.setMilliseconds(date.getMilliseconds() + (parseInt(block.attrs.padding_time) * 60000) );

                    datestring = datestring+' to '+ date.toLocaleTimeString('en-US',{hour: "2-digit", minute: "2-digit",hour12:true});

                }

                if(!block.blockName || !block.attrs)

                    return null;

                    if('assign' == mode) {

                        if ('wp4toastmasters/role' == block.blockName)

                            return <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block}  setMode={setMode} setScrollTo={setScrollTo} setEvaluate={setEvaluate} />

                        else

                            return null;//in this mode, we only care about roles to assign                        

                    } 

                    if('signup' == mode) {

                        if('wp4toastmasters/role' == block.blockName) {

                            let rolemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup'; 
                            if('speakers-evaluators' == showDetails && !['Speaker','Evaluator'].includes(block.attrs.role))

                                return null;

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block" onMouseEnter={() => {setShowControls(blockindex);}} >

                            <div><strong>{datestring}</strong></div>

                            <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={rolemode} block={block}  setMode={setMode} setScrollTo={setScrollTo} setEvaluate={setEvaluate} />

                            <SpeakerTimeCount block={block}  makeNotification={makeNotification} />
                            {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}

                            </div>

                            )

                        }

                        if('speakers-evaluators' == showDetails)

                            return null;

                        else if(showDetails && 'wp4toastmasters/agendaedit' == block.blockName) {
                            let notemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup'; 

                            return (

                                <div key={'block'+blockindex} id={'block'+blockindex} className="block" onMouseEnter={() => {setShowControls(blockindex);}} >
                                <div><strong>{datestring}</strong></div>
                                <EditableNote  makeNotification={makeNotification} mode={notemode} block={block} blockindex={blockindex} uid={block.attrs.uid} post_id={post_id} />
                                {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}

                                </div>

                            );

                        }

                        else if(showDetails && 'wp4toastmasters/agendanoterich2' == block.blockName) {
                            let notemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup'; 

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block" onMouseEnter={() => {setShowControls(blockindex);}} >

                            <div><strong>{datestring}</strong></div>

                            {('edit' != notemode || !editNotes ) && <SanitizedHTML innerHTML={block.innerHTML} />}
                            {('edit' == notemode && !editNotes ) && <button class="tmsmallbutton" onClick={()=> setEditNotes(true)}>Edit</button>}
                            {'edit' == notemode && editNotes && <EditorAgendaNote  makeNotification={makeNotification} blockindex={blockindex} block={block} />}
                            {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}

                            </div>)

                        }

                        else if (showDetails && 'wp4toastmasters/context' == block.blockName ) {

                            return (<>{ block.innerBlocks.map( (ib) => { return <SanitizedHTML innerHTML={ib.innerHTML} /> } ) }</>);

                        }

                        else if(showDetails && block.innerHTML) {

                            // agenda notes, signup notes and other raw content

                            return (<div key={'block'+blockindex} id={'block'+blockindex} className="block" >

                            <SanitizedHTML innerHTML={block.innerHTML} />

                            </div>);

                        }

                        else if ('wp4toastmasters/absences'==block.blockName) {

                            return <Absence  makeNotification={makeNotification} absences={data.absences} current_user_id={current_user_id} post_id={post_id} mode={mode} />

                        }

                        else if ('wp4toastmasters/hybrid'==block.blockName) {

                            return <Hybrid makeNotification={makeNotification} current_user_id={current_user_id} post_id={post_id} mode={mode} />

                        }

                        else

                            return null;

                    }//end signup blocks

                    else if ('edit' == mode) {

                        if('wp4toastmasters/role' == block.blockName) {

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block" onMouseEnter={() => {setShowControls(blockindex);}}>

                            <div><strong>{datestring}</strong></div>

                            <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block} setEvaluate={setEvaluate} setMode={setMode} />

                            <SpeakerTimeCount block={block}  makeNotification={makeNotification} />
                            {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}

                            </div>

                            )

                        }

                        else if(showDetails && 'wp4toastmasters/agendaedit' == block.blockName) {

                            return (

                                <div key={'block'+blockindex} id={'block'+blockindex} className="block" onMouseEnter={() => {setShowControls(blockindex); }} >

                                <div><strong>{datestring}</strong></div>

                                <EditableNote  makeNotification={makeNotification} mode={mode} block={block} blockindex={blockindex} uid={block.attrs.uid} post_id={post_id} />
                                {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}
                                </div>

                            );

                        }

                        if(showDetails && 'wp4toastmasters/agendanoterich2' == block.blockName && (user_can('edit_post') || user_can('organize_agenda')) ) {

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block"  onMouseEnter={() => {setShowControls(blockindex); }} >

                            <div><strong>{datestring}</strong></div>

                            <EditorAgendaNote  makeNotification={makeNotification} blockindex={blockindex} block={block} />
                            {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} />}

                            </div>)

                        }

                        else if(showDetails && 'wp4toastmasters/signupnote' == block.blockName && (user_can('edit_post') || user_can('organize_agenda'))) {

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block">

                            <div><strong>{datestring}</strong></div>

                            <SignupNote blockindex={blockindex} block={block}  />

                            </div>)

                        }

                        else if ('wp4toastmasters/absences'==block.blockName) {

                            return <Absence makeNotification={makeNotification} absences={data.absences} current_user_id={current_user_id} mode={mode} post_id={post_id} />

                        }

                        else if ('wp4toastmasters/hybrid'==block.blockName) {

                            return <Hybrid makeNotification={makeNotification} current_user_id={current_user_id} post_id={post_id} mode={mode} />

                        }

                        else 

                            return null;

                    }//end edit blocks

                    

                    else if ('suggest' == mode) {

                        if('wp4toastmasters/role' == block.blockName) {

                            return (

                            <div key={'block'+blockindex} id={'block'+blockindex} className="block">

                            <div><strong>{datestring}</strong></div>

                            <RoleBlock  makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block}  />

                            <SpeakerTimeCount block={block} makeNotification={makeNotification} />

                            </div>

                            )

                        }

                        else 

                            return null;

                    }//end suggest blocks

                    else

                        return null;

            })}

        </div>

)

    

}    

catch (error) {
    console.log('error loading agenda',error);
    return <p>Error loading agenda (<a href={window.location.href+'?revert=1'}>try alternate version</a>)</p>
}

}


/*
                            {showControls == blockindex && user_can('organize_agenda') && <div className="tmflexrow"><div className="tmflex30"><NumberCtrl label="Signup Slots" min="1" value={(block.attrs.count) ? block.attrs.count : 1} onChange={ (value) => { data.blocksdata[blockindex].attrs.count = value; if(['Speaker','Evaluator'].includes(block.attrs.role)) { data.blocksdata[blockindex].attrs.time_allowed = calcTimeAllowed(block.attrs); data.blocksdata = syncToEvaluator(data.blocksdata,value); } agendaMutate(data); }} /></div><div className="tmflex30"><NumberCtrl label="Time Allowed" value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { data.blocksdata[blockindex].attrs.time_allowed = value; agendaMutate(data); }} /></div> {('Speaker' == block.attrs.role) && <div className="tmflex30"><NumberCtrl label="Padding Time" min="0" value={block.attrs.padding_time} onChange={(value) => {data.blocksdata[blockindex].attrs.padding_time = value; agendaMutate(data);}} /></div>}</div>}
                            {showControls == blockindex && user_can('organize_agenda') && <p>More options: <button class="tmsmallbutton" onClick={() =>{setMode('reorganize');}}>Organize</button></p>}

*/