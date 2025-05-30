import React, { useState, useEffect, Suspense } from "react";
import mytranslate from './mytranslate'

import { SelectCtrl, NumberCtrl } from './Ctrl.js';
import RoleBlock from "./RoleBlock.js";
import { SpeakerTimeCount } from "./SpeakerTimeCount.js";

const EvaluationTool = React.lazy(() => import('./EvaluationTool.js'));
import { TemplateAndSettings } from "./TemplateAndSettings.js";
import { SanitizedHTML } from "./SanitizedHTML.js";
import { EditorAgendaNote } from './EditorAgendaNote.js';
import { EditableNote } from './EditableNote.js';
import { SignupNote } from './SignupNote.js';
import Reorganize from './Reorganize';
import ReorgWidget from './ReorgWidget';
import { Inserter } from "./Inserter.js";
import { Absence } from './Absence.js';
import { Hybrid } from './Hybrid.js';
import Voting from './Voting.js';
import { useBlocks, updateAgenda } from './queries.js';
import { useCollapse } from 'react-collapsed';
import { Icon, chevronUp, chevronDown, edit } from '@wordpress/icons';

export default function Agenda(props) {
    let initialPost = 0;

    if ('rsvpmaker' == wpt_rest.post_type) {
        initialPost = wpt_rest.post_id;
    } else {
        initialPost = new URL(document.location).searchParams.get('post_id');
        if (!initialPost) initialPost = 0;
    }

    const [post_id, setPostId] = useState(initialPost);
    const [current_user_id, setCurrentUserId] = useState(0);
    const [mode, setMode] = useState((props.mode_init) ? props.mode_init : 'signup');
    const [showDetails, setshowDetails] = useState('all');
    const [showControls, setShowControls] = useState(-1);
    const [editNotes, setEditNotes] = useState(false);
    const [scrollTo, setScrollTo] = useState('react-agenda');
    const [notification, setNotification] = useState(null);
    const [notificationTimeout, setNotificationTimeout] = useState(null);
    const [evaluate, setEvaluate] = useState(props.evaluation);

    function scrolltoId(id) {
        if (!id) return;
        var access = document.getElementById(id);
        if (!access) {
            console.log('Scroll to ID could not find element' + ' ' + id);
            return;
        }
        access.scrollIntoView({ behavior: 'smooth' }, true);
    }

    function makeNotification(message, prompt = false, otherproperties = null) {
        if (notificationTimeout) clearTimeout(notificationTimeout);
        setNotification({ 'message': message, 'prompt': prompt, 'otherproperties': otherproperties });
        let nt = setTimeout(() => {
            setNotification(null);
        }, 25000);
        setNotificationTimeout(nt);
    }

    const { mutate: agendaMutate } = updateAgenda(post_id, makeNotification, Inserter);

    function NextMeetingPrompt() {
        if (typeof data == 'undefined') return;

        let pid = data.upcoming.findIndex((item) => item.value == post_id);

        if (data.upcoming[pid + 1])
            return (
                <div className="next-meeting-prompt">
                    {mytranslate('Would you like to sign up for the', data)}{' '}
                    <a href={data.upcoming[pid + 1].permalink + '?newsignup'}>
                        {mytranslate('Next meeting?', data)}
                    </a>
                </div>
            );
        else return null;
    }

    useEffect(() => {
        scrolltoId(scrollTo);
        if ('react-agenda' != scrollTo) setScrollTo('react-agenda');
    }, [mode]);

    try {
        const { isLoading, isFetching, isSuccess, isError, data: axiosdata, error, refetch } = useBlocks(post_id);

        if (isError)
            return (
                <p>
                    Error loading agenda data. Try <a href={window.location.href}>
                        reloading the page</a>.
                    You can also
                    <a
                        href={
                            window.location.href.indexOf('?') > 0
                                ? window.location.href + '&revert=1'
                                : window.location.href + '?revert=1'
                        }
                    >
                        use the old version of the signup form
                    </a>.
                </p>
            );

        if (isLoading) return <p>Loading...</p>;

        if (!axiosdata.data.current_user_id)
            return <p>You must be logged in as a member of this website to see the signup form.</p>;

        if (axiosdata) {
            const { permissions } = axiosdata?.data;
        }
        const data = axiosdata.data;

        function calcTimeAllowed(attrs) {
            let time_allowed = 0;
            let count = (attrs.count) ? attrs.count : 1;

            if ('Speaker' == attrs.role)
                time_allowed = count * 7;

            if ('Evaluator' == attrs.role)
                time_allowed = count * 3;

            return time_allowed;
        }

        function getHelpMessage() {
            if ('signup' == mode)
                return mytranslate('Sign yourself up for roles and enter/update speech details.', data);
            if ('edit' == mode)
                return mytranslate('Assign others to roles and edit their speech details. Rearrange or delete assignments.', data);
            if ('assign' == mode)
                return mytranslate('Assign others to roles (grid view).', data);
            if ('suggest' == mode)
                return mytranslate('Nominate another member for a role -- they will get an email notification that makes it easy to say yes.', data);
            if ('evaluation' == mode)
                return mytranslate('Provide written speech feedback using digital versions of the evaluation forms.', data);
            if ('reorganize' == mode)
                return mytranslate('Rearrange roles and other elements on your agenda and adjust the timing.', data);
            if ('settings' == mode)
                return mytranslate('Update your standard meeting template or switch the template for the current meeting. Adjust event date and time. Update settings.', data);
        }

        function ModeControl(props) {
            const modeoptions = [];
            if (props.isTemplate) {
                modeoptions.push({ label: mytranslate('Organize', data), value: 'reorganize' });
                modeoptions.push({ label: mytranslate('Template/Settings', data), value: 'settings' });
            } else {
                modeoptions.push({ label: mytranslate('Sign Up', data), value: 'signup' });
                if (user_can('edit_post') || user_can('organize_agenda') || user_can('edit_signups')) {
                    modeoptions.push({ label: mytranslate('Edit', data), value: 'edit' });
                    modeoptions.push({ label: mytranslate('Assign', data), value: 'assign' });
                }
                modeoptions.push({ label: mytranslate('Evaluation', data), value: 'evaluation' });
                modeoptions.push({ label: mytranslate('Voting', data), value: 'voting' });
                if (user_can('edit_post') || user_can('organize_agenda'))
                    modeoptions.push({ label: mytranslate('Organize', data), value: 'reorganize' });
                if (user_can('edit_post'))
                    modeoptions.push({ label: mytranslate('Settings', data), value: 'settings' });
            }

            return (
                <div id="fixed-mode-control">
                        {notification && notification.message && <div className="mode-control-notification">{notification.message}</div>}
                        <div className="mode-centered">
                        {modeoptions.map((option) => (
                            <button
                                className={mode == option.value ? 'blackButton bottomButton' : 'bottomButton'}
                                key={option.value}
                                onClick={() => {
                                    setMode(option.value);
                                    setScrollTo('react-agenda');
                                }}
                            >
                                {option.label}
                            </button>
                        ))}
                    </div>
                    <p className="mode-help mode-centered">{getHelpMessage()}</p>
                </div>
            );
        }

        function user_can(permission) {
            const permissions = axiosdata.data.permissions;
            let answer = false;

            if (permissions[permission]) {
                answer = permissions[permission];
            }

            return answer;
        }

        const raw = ['core/image', 'core/paragraph', 'core/heading', 'wp4toastmasters-signupnote'];
        const ignore = ['wp4toastmasters/agendanoterich2', 'wp4toastmasters/milestone', 'wp4toastmasters/help'];

        let date = new Date(data.datetime);
        const dateoptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        let datestring = '';

        if (!post_id)
            setPostId(data.post_id);

        if (!current_user_id)
            setCurrentUserId(data.current_user_id);

        if ('settings' == mode) {
            return (
                <div className="agendawrapper">
                    <ModeControl isTemplate={(false !== data.is_template)} post_id={data.post_id} />
                    <TemplateAndSettings makeNotification={makeNotification} setPostId={setPostId} user_can={user_can} data={data} />
                </div>
            );
        }

        if ('evaluation' == mode) {
            return (
                <div className="agendawrapper">
                    <ModeControl />
                    <Suspense fallback={<h1>Loading ...</h1>}>
                        <EvaluationTool scrolltoId={scrolltoId} makeNotification={makeNotification} data={data} evaluate={evaluate} setEvaluate={setEvaluate} />
                    </Suspense>
                </div>
            );
        }

        if ('voting' == mode) {
            return (
                <div className="agendawrapper">
                    <ModeControl />
                    <Suspense fallback={<h1>Loading ...</h1>}>
                        <Voting post_id={post_id} data={data} />
                    </Suspense>
                </div>
            );
        }

        if ('reorganize' == mode)
            return <Suspense fallback={<h1>Loading ...</h1>}><Reorganize data={data} mode={mode} setMode={setMode} post_id={post_id} makeNotification={makeNotification} ModeControl={ModeControl} showDetails={showDetails} setshowDetails={setshowDetails} setScrollTo={setScrollTo} setEvaluate={setEvaluate} setPostId={setPostId} /></Suspense>;

        return (
            <div className="agendawrapper" id={'agendawrapper' + post_id}>
                {'suggest' == mode && (
                    <p>
                        {mytranslate('See also the', data)}{' '}
                        <a href={data.admin_url + 'admin.php?page=wpt_suggest_all_roles&meeting=' + post_id}>
                            {mytranslate('Suggest All Roles', data)}
                        </a>{' '}
                        {mytranslate('tool for sending suggestions in a batch.', data)}
                    </p>
                )}
                <>{('rsvpmaker' != wpt_rest.post_type) && <SelectCtrl label="Choose Event" value={post_id} options={data.upcoming} onChange={(value) => { setPostId(parseInt(value)); makeNotification(mytranslate('Date changed, please wait for the date to change ...', data)); queryClient.invalidateQueries(['blocks-data', post_id]); refetch(); }} />}</>
                <h4>
                    {date.toLocaleDateString('en-US', dateoptions)}{' '}
                    {data.is_template && <span>({mytranslate('Template', data)})</span>}
                </h4>
                <ModeControl makeNotification={makeNotification} isTemplate={false !== data.is_template} post_id={data.post_id} />
                {!Array.isArray(data.blocksdata) && <p>{mytranslate('Error loading agenda', data)} (<a href={window.location.href + '?revert=1'}>{mytranslate('try alternate version', data)}</a>).</p>}
                {('assign' == mode) && <div className="assignment" note="workaround for alignment issue"></div>}
                {Array.isArray(data.blocksdata) && data.blocksdata.map((block, blockindex) => {
                    datestring = date.toLocaleTimeString('en-US', { hour: "2-digit", minute: "2-digit", hour12: true });

                    if(block.rendered && block.rendered.length > 0) {
                        return <SanitizedHTML innerHTML={block.rendered} />
                    }

                    if (block?.attrs?.time_allowed) {
                        date.setMilliseconds(date.getMilliseconds() + (parseInt(block.attrs.time_allowed) * 60000));
                        if (block.attrs.padding_time)
                            date.setMilliseconds(date.getMilliseconds() + (parseInt(block.attrs.padding_time) * 60000));
                        datestring = datestring + ' to ' + date.toLocaleTimeString('en-US', { hour: "2-digit", minute: "2-digit", hour12: true });
                    }

                    if (!block.blockName || !block.attrs)
                        return null;

                    if ('assign' == mode) {
                        if ('wp4toastmasters/role' == block.blockName)
                            return <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block} setMode={setMode} setScrollTo={setScrollTo} setEvaluate={setEvaluate} data={data} />;
                        else
                            return null; // in this mode, we only care about roles to assign
                    }

                    if ('signup' == mode) {
                        if ('wp4toastmasters/role' == block.blockName) {
                            let rolemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup';
                            if ('speakers-evaluators' == showDetails && !['Speaker', 'Evaluator'].includes(block.attrs.role))
                                return null;

                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={rolemode} block={block} setMode={setMode} setScrollTo={setScrollTo} setEvaluate={setEvaluate} setShowControls={setShowControls} data={data} />
                                    <SpeakerTimeCount block={block} makeNotification={makeNotification} data={data} />
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                </div>
                            );
                        }

                        if ('speakers-evaluators' == showDetails)
                            return null;
                        else if (showDetails && 'wp4toastmasters/agendaedit' == block.blockName) {
                            let notemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup';

                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <EditableNote makeNotification={makeNotification} mode={notemode} block={block} blockindex={blockindex} uid={block.attrs.uid} post_id={post_id} />
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                    {showControls != blockindex && user_can('organize_agenda') && <button className="agenda-tooltip" onClick={() => { setShowControls(blockindex) }}><span className="agenda-tooltip-text">{mytranslate('Edit/Organize', data)}</span><Icon icon={edit} /></button>}
                                </div>
                            );
                        }

                        else if (showDetails && 'wp4toastmasters/agendanoterich2' == block.blockName) {
                            let notemode = (user_can('edit_signups') && (showControls == blockindex)) ? 'edit' : 'signup';

                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    {('edit' != notemode || !editNotes) && <SanitizedHTML innerHTML={block.innerHTML} />}
                                    {('edit' == notemode && !editNotes) && <button className="tmsmallbutton" onClick={() => setEditNotes(true)}>{mytranslate('Edit', data)}</button>}
                                    {'edit' == notemode && editNotes && <EditorAgendaNote makeNotification={makeNotification} blockindex={blockindex} block={block} />}
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                    {showControls != blockindex && user_can('organize_agenda') && <button className="agenda-tooltip" onClick={() => { setShowControls(blockindex) }}><span className="agenda-tooltip-text">{mytranslate('Edit/Organize', data)}</span><Icon icon={edit} /></button>}
                                </div>
                            );
                        }

                        else if (showDetails && 'wp4toastmasters/context' == block.blockName) {
                            return (<>{block.innerBlocks.map((ib) => { return <SanitizedHTML innerHTML={ib.innerHTML} /> })}</>);
                        }

                        else if (showDetails && block.innerHTML) {
                            // agenda notes, signup notes and other raw content
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <SanitizedHTML innerHTML={block.innerHTML} />
                                </div>
                            );
                        }

                        else if ('wp4toastmasters/absences' == block.blockName) {
                            return <Absence makeNotification={makeNotification} absences={data.absences} current_user_id={current_user_id} post_id={post_id} mode={mode} />;
                        }

                        else if ('wp4toastmasters/hybrid' == block.blockName) {
                            return <Hybrid makeNotification={makeNotification} current_user_id={current_user_id} post_id={post_id} mode={mode} />;
                        }

                        else
                            return null;
                    } // end signup blocks

                    else if ('edit' == mode) {
                        if ('wp4toastmasters/role' == block.blockName) {
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block} setEvaluate={setEvaluate} setMode={setMode} data={data} />
                                    <SpeakerTimeCount block={block} makeNotification={makeNotification} data={data} />
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                </div>
                            );
                        }

                        else if (showDetails && 'wp4toastmasters/agendaedit' == block.blockName) {
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <EditableNote makeNotification={makeNotification} mode={mode} block={block} blockindex={blockindex} uid={block.attrs.uid} post_id={post_id} />
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                    {showControls != blockindex && user_can('organize_agenda') && <button className="agenda-tooltip" onClick={() => { setShowControls(blockindex) }}><span className="agenda-tooltip-text">{mytranslate('Edit/Organize', data)}</span><Icon icon={edit} /></button>}
                                </div>
                            );
                        }

                        if (showDetails && 'wp4toastmasters/agendanoterich2' == block.blockName && (user_can('edit_post') || user_can('organize_agenda'))) {
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <EditorAgendaNote makeNotification={makeNotification} blockindex={blockindex} block={block} data={data} />
                                    {showControls == blockindex && user_can('organize_agenda') && <ReorgWidget block={block} blockindex={blockindex} data={data} post_id={post_id} makeNotification={makeNotification} setMode={setMode} setShowControls={setShowControls} />}
                                </div>
                            );
                        }

                        else if (showDetails && 'wp4toastmasters/signupnote' == block.blockName && (user_can('edit_post') || user_can('organize_agenda'))) {
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <SignupNote blockindex={blockindex} block={block} />
                                </div>
                            );
                        }

                        else if ('wp4toastmasters/absences' == block.blockName) {
                            return <Absence makeNotification={makeNotification} absences={data.absences} current_user_id={current_user_id} mode={mode} post_id={post_id} />;
                        }

                        else if ('wp4toastmasters/hybrid' == block.blockName) {
                            return <Hybrid makeNotification={makeNotification} current_user_id={current_user_id} post_id={post_id} mode={mode} />;
                        }

                        else
                            return null;
                    } // end edit blocks

                    else if ('suggest' == mode) {
                        if ('wp4toastmasters/role' == block.blockName) {
                            return (
                                <div key={'block' + blockindex} id={'block' + blockindex} className="block">
                                    <div><strong>{datestring}</strong></div>
                                    <RoleBlock makeNotification={makeNotification} showDetails={showDetails} agendadata={data} post_id={post_id} blockindex={blockindex} mode={mode} block={block} data={data} />
                                    <SpeakerTimeCount block={block} makeNotification={makeNotification} data={data} />
                                </div>
                            );
                        }

                        else
                            return null;
                    } // end suggest blocks

                    else
                        return null;
                })}
                <div><button onClick={refetch}>Refresh</button></div>
            </div>
        );
    } catch (error) {
        console.log('Error loading agenda', error);
        return (
            <p>
                Error loading agenda
                <a href={window.location.href + '?revert=1'}>try alternate version</a>
            </p>
        );
    }
}