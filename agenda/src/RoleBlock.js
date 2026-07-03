import React, { useState, useEffect, Suspense, useRef } from "react";
import { TextControl } from '@wordpress/components';
import mytranslate from './mytranslate'
import { SelectCtrl } from './Ctrl.js';
const ProjectChooser = React.lazy(() => import('./ProjectChooser.js'));
const OtherRoleTitle = React.lazy(() => import('./OtherRoleTitle.js'));
const Suggest = React.lazy(() => import('./Suggest.js'));
import { Up, Down, Top, Close, Move } from './icons.js';
import apiClient, { setupNonceInterceptor } from './http-common.js';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import { useMutation, useQueryClient } from 'react-query';
import { Icon, plusCircle, chevronRight, cancelCircleFilled, edit, tool } from '@wordpress/icons';

export default function RoleBlock(props) {
    const { agendadata, mode, showDetails, blockindex, setMode, setScrollTo, block, makeNotification, post_id, setEvaluate, setShowControls, data } = props;
    const { assignments, attrs, attrs: {titlePrompt}, memberoptions } = block;
    const [itemMode, setItemMode] = useState({ item: null, mode: '' });
    const rsvpmaker_rest = useRsvpmakerRest();

    useEffect(() => {
        if (rsvpmaker_rest?.nonce) {
        setupNonceInterceptor(rsvpmaker_rest.nonce);
        }
    }, [rsvpmaker_rest?.nonce]);

    if (!attrs || !attrs.role)
        return null;

    //console.log('RoleBlock attrs', attrs );
    //console.log('RoleBlock titlePrompt', titlePrompt );

    const queryClient = useQueryClient();
    const { current_user_id, current_user_name } = agendadata;
    const [guests, setGuests] = useState([].fill('', 0, attrs.count));
    const [draggedRoleIndex, setDraggedRoleIndex] = useState(null);
    const [dropRoleIndex, setDropRoleIndex] = useState(null);
    const autoScrollIntervalRef = useRef(null);
    const autoScrollDirectionRef = useRef(0);
    const urlParams = new URLSearchParams(window.location.search || '');
    const assignmentDebugSuffix = urlParams.get('agenda_debug') ? '?agenda_debug=1' : '';

    if (!attrs.role)
        return null;

    function user_can(permission) {
        let answer = false;
        if (agendadata.permissions[permission]) {
            answer = agendadata.permissions[permission];
        }
        return answer;
    }

    const roletagbase = '_role_' + attrs.role.replaceAll(/[^A-Za-z]/g, '_') + '_';
    var start = (attrs.start) ? parseInt(attrs.start) : 1;
    if (!start)
        start = 1;

    let count = (attrs.count) ? attrs.count : 1;
    let openslots = [];
    let filledslots = [];
    let role = attrs.role;
    let role_label = mytranslate(attrs.role,data);

    function updateAssignment(assignment, blockindex = null, start = 1, count = 1) {
        console.log('updateAssignment', assignment, blockindex, start, count);
        if (Array.isArray(assignment)) {
            const assignments = assignment.map((a) => { return { ...a, post_id: post_id, count: count } });
            return multiAssignmentMutation.mutate({ 'assignments': assignments, 'blockindex': blockindex, 'start': 1 });
        } else {
            assignment.post_id = post_id;
            assignmentMutation.mutate(assignment);
        }
    }

    function normalizeSpeakerAssignment(assignment = {}) {
        return {
            ...assignment,
            manual: assignment?.manual ?? '',
            title: assignment?.title ?? '',
            project: assignment?.project ?? '',
            intro: assignment?.intro ?? '',
            maxtime: assignment?.maxtime ?? 7,
            display_time: assignment?.display_time ?? '5 - 7 minutes',
        };
    }

    const assignmentMutation = useMutation(
        async (assignment) => { return await apiClient.post("json_assignment_post" + assignmentDebugSuffix, assignment) },
        {
            onMutate: async (assignment) => {
                await queryClient.cancelQueries(['blocks-data', post_id]);
                const previousData = queryClient.getQueryData(['blocks-data', post_id]);
                queryClient.setQueryData(['blocks-data', post_id], (oldQueryData) => {
                    if (!oldQueryData?.data?.blocksdata)
                        return oldQueryData;
                    const { blockindex, roleindex } = assignment;
                    console.log('assignmentMutation setQueryData blockindex / roleindex', blockindex, roleindex);
                    const { data } = oldQueryData;
                    const blocksdata = data.blocksdata.map((block, bi) => {
                        if (bi !== blockindex)
                            return block;
                        const nextAssignments = Array.isArray(block.assignments) ? [...block.assignments] : [];
                        nextAssignments[roleindex] = assignment;
                        return { ...block, assignments: nextAssignments };
                    });
                    const newdata = {
                        ...oldQueryData, data: { ...data, blocksdata: blocksdata }
                    };
                    return newdata;
                });
                makeNotification(mytranslate('Updating ...', data));
                return { previousData };
            },
            onSettled: (data, error, variables, context) => {
                queryClient.invalidateQueries(['blocks-data', post_id]);
            },
            onSuccess: (data, error, variables, context) => {
                if(data.data.taken) 
                    makeNotification('Role already taken: ' + data.data.taken);
                else
                    makeNotification('Updated assignment: ' + data.data.role, true);
            },
            onError: (err, variables, context) => {
                console.log(mytranslate('Mutate assignment error', data), err);
                queryClient.setQueryData(['blocks-data', post_id], context.previousData);
                makeNotification(mytranslate('Error updating assignment ', data) + err.message);
            },
        }
    );

    const multiAssignmentMutation = useMutation(
        async (multi) => { return await apiClient.post("json_multi_assignment_post" + assignmentDebugSuffix, multi) },
        {
            onMutate: async (multi) => {
                await queryClient.cancelQueries(['blocks-data', post_id]);
                const previousValue = queryClient.getQueryData(['blocks-data', post_id]);
                queryClient.setQueryData(['blocks-data', post_id], (oldQueryData) => {
                    if (!oldQueryData?.data?.blocksdata)
                        return oldQueryData;
                    const { blockindex } = multi;
                    const { data } = oldQueryData;
                    const blocksdata = data.blocksdata.map((block, bi) => {
                        if (bi !== blockindex)
                            return block;
                        return { ...block, assignments: [...multi.assignments] };
                    });
                    const newdata = {
                        ...oldQueryData, data: { ...data, blocksdata: blocksdata }
                    };
                    return newdata;
                });
                makeNotification(mytranslate('Updating ...', data));
                return { previousValue };
            },
            onSettled: (data, error, variables, context) => {
                queryClient.invalidateQueries(['blocks-data', post_id]);
            },
            onSuccess: (data, error, variables, context) => {
                makeNotification(mytranslate('Updated', data));
            },
            onError: (err, variables, context) => {
                makeNotification(mytranslate('Error updating assignments ', data) + err.message);
                queryClient.setQueryData(['blocks-data', post_id], context.previousValue);
            },
        }
    );
    
    function scrolltoId(id) {
        if (!id)
            return;
        var access = document.getElementById(id);
        if (!access) {
            return;
        }
        access.scrollIntoView({ behavior: 'smooth' }, true);
    }

    function moveItem(roleindex, newindex) {
        const myassignment = { ...assignments[roleindex], role: attrs.role };
        let newassignments = [];
        assignments.forEach((prevassignment, previndex) => {
            const normalized = { ...prevassignment, role: attrs.role };
            if ((previndex == newindex) && (newindex < roleindex)) {
                newassignments.push(myassignment); //insert before
                newassignments.push(normalized);
            } else if ((previndex == newindex) && (newindex > roleindex)) {
                newassignments.push(normalized);
                newassignments.push(myassignment); //insert after
            } else if (previndex != roleindex) // skip spot my assignment previously occupied
                newassignments.push(normalized);
        });
        if (attrs.role && attrs.role.includes('Speaker')) {
            newassignments = newassignments.map((a) => normalizeSpeakerAssignment(a));
        }
        updateAssignment(newassignments, blockindex, start, count);
        scrolltoId('block' + blockindex);
    }

    function removeBlanks() {
        let newassignments = [];
        let removed = [];
        assignments.forEach((prevassignment, previndex) => {
            const normalized = { ...prevassignment, role: attrs.role };
            if ((normalized.ID != 0) && (normalized.ID != "0")) {
                newassignments.push(normalized);
            } else {
                removed.push(normalized);
            }
        });
        removed.forEach((r) => { newassignments.push(r); });
        if (attrs.role && attrs.role.includes('Speaker')) {
            newassignments = newassignments.map((a) => normalizeSpeakerAssignment(a));
        }
        updateAssignment(newassignments, blockindex, start, count);
    }

    function handleAssignmentDragStart(event, roleindex) {
        if ('edit' != mode)
            return;
        setDraggedRoleIndex(roleindex);
        setDropRoleIndex(roleindex);
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/plain', String(roleindex));
    }

    function stopAutoScroll() {
        if (autoScrollIntervalRef.current) {
            clearInterval(autoScrollIntervalRef.current);
            autoScrollIntervalRef.current = null;
        }
        autoScrollDirectionRef.current = 0;
    }

    function startAutoScroll(direction) {
        if (autoScrollDirectionRef.current === direction && autoScrollIntervalRef.current)
            return;
        stopAutoScroll();
        autoScrollDirectionRef.current = direction;
        autoScrollIntervalRef.current = setInterval(() => {
            window.scrollBy(0, direction * 18);
        }, 16);
    }

    function updateAutoScrollFromClientY(clientY) {
        if (draggedRoleIndex === null) {
            stopAutoScroll();
            return;
        }
        const edgeThreshold = 100;
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
        if (clientY < edgeThreshold) {
            startAutoScroll(-1);
        } else if (clientY > (viewportHeight - edgeThreshold)) {
            startAutoScroll(1);
        } else {
            stopAutoScroll();
        }
    }

    function handleAssignmentDragOver(event, roleindex) {
        if ('edit' != mode || draggedRoleIndex === null)
            return;
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        updateAutoScrollFromClientY(event.clientY);
        if (roleindex !== dropRoleIndex) {
            setDropRoleIndex(roleindex);
        }
    }

    function handleAssignmentDrop(event, roleindex) {
        if ('edit' != mode)
            return;
        event.preventDefault();
        event.stopPropagation();
        stopAutoScroll();
        const sourceIndex = (draggedRoleIndex === null)
            ? parseInt(event.dataTransfer.getData('text/plain'), 10)
            : draggedRoleIndex;
        if (Number.isNaN(sourceIndex) || sourceIndex === roleindex) {
            setDraggedRoleIndex(null);
            setDropRoleIndex(null);
            return;
        }
        let destinationIndex = sourceIndex < roleindex ? roleindex - 1 : roleindex;
        if (destinationIndex < 0)
            destinationIndex = 0;
        if (destinationIndex !== sourceIndex)
            moveItem(sourceIndex, destinationIndex);
        setDraggedRoleIndex(null);
        setDropRoleIndex(null);
    }

    function handleAssignmentDropAtEnd(event) {
        if ('edit' != mode)
            return;
        event.preventDefault();
        event.stopPropagation();
        stopAutoScroll();
        const sourceIndex = (draggedRoleIndex === null)
            ? parseInt(event.dataTransfer.getData('text/plain'), 10)
            : draggedRoleIndex;
        const destinationIndex = assignments.length - 1;
        if (Number.isNaN(sourceIndex) || sourceIndex === destinationIndex) {
            setDraggedRoleIndex(null);
            setDropRoleIndex(null);
            return;
        }
        moveItem(sourceIndex, destinationIndex);
        setDraggedRoleIndex(null);
        setDropRoleIndex(null);
    }

    useEffect(() => {
        if (draggedRoleIndex === null)
            return;
        function handleWindowDragOver(event) {
            updateAutoScrollFromClientY(event.clientY);
        }
        window.addEventListener('dragover', handleWindowDragOver);
        return () => {
            window.removeEventListener('dragover', handleWindowDragOver);
            stopAutoScroll();
        };
    }, [draggedRoleIndex]);

    function handleAssignmentDragEnd() {
        stopAutoScroll();
        setDraggedRoleIndex(null);
        setDropRoleIndex(null);
    }

    function getMemberName(id) {
        let m = memberoptions.find((item) => { if (item.value == id) return item; });
        return m?.value;
    }


    return (
        <>
            {assignments && Array.isArray(assignments) && assignments.map((assignment, roleindex) => {
                if (("0" == assignment.ID) || (0 == assignment.ID))
                    openslots.push(roleindex);
                else
                    filledslots.push(roleindex);
                let shownumber = ((attrs.count && (attrs.count > 1)) || (start > 1)) ? '#' + (roleindex + start) : '';
                if (roleindex == count) {
                    role_label = mytranslate('Backup ', data) + role;
                    shownumber = '';
                } else if (roleindex > count) {
                    return null;
                }
                let id = 'role' + attrs.role.replaceAll(/[^A-z]/g, '') + roleindex;

                if ('assign' == mode) {
                    return (
                        <div id={id} key={id} className="assignment">
                            <div className="assignment-assigned">
                                <SelectCtrl label={role_label + ' ' + shownumber} value={assignment.ID} options={memberoptions} onChange={(id) => {
                                    if ('Speaker' == role) updateAssignment({
                                        'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'manual': '', 'title': '', 'project': '', 'intro': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                                    }); else updateAssignment({
                                        'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'display': 'inline', 'width': ''
                                    })
                                }} />
                            </div>
                        </div>
                    )
                }

                let isMe = current_user_id == assignment.ID;
                let isOpen = (0 == assignment.ID) || (assignment.ID == '0') || (assignment.ID == '');
                let showclose = false;
                if (filledslots.length > 0 && openslots.length > 0) {
                    if (filledslots[filledslots.length - 1] > openslots[0]) showclose = true;
                }

                const showDropZoneAbove = draggedRoleIndex !== null && dropRoleIndex === roleindex && draggedRoleIndex !== roleindex;
                return (<div id={id} key={id}
                    onDragOver={(event) => handleAssignmentDragOver(event, roleindex)}
                    onDrop={(event) => handleAssignmentDrop(event, roleindex)}>
                    {showDropZoneAbove && <div style={{
                        marginBottom: '4px',
                        padding: '10px',
                        textAlign: 'center',
                        backgroundColor: '#bbb',
                        border: '2px dashed #999',
                        color: '#666',
                        borderRadius: '4px',
                        fontSize: '0.9em'
                    }}>{mytranslate('Drop here', data)}</div>}
                    <div className="roleheader">
                        <div className="role-buttons">
                            {isOpen && <button className="agenda-tooltip" onClick={function (event) {
                                if ('Speaker' == role) {
                                    updateAssignment({
                                        'ID': current_user_id, 'name': current_user_name, 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'manual': '', 'title': '', 'project': '', 'intro': '', 'maxtime': 7, 'display_time': '5 - 7 minutes', 'wasopen': true
                                    });
                                } else {
                                    updateAssignment({
                                        'ID': current_user_id, 'name': current_user_name, 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'wasopen': true
                                    });
                                }
                            }} ><span className="agenda-tooltip-text">{mytranslate('Take Role', data)}</span><Icon icon={plusCircle} /></button>}
                            {isMe && <button onClick={function (event) {
                                let a = ('Speaker' == role) ? {
                                    'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count, 'intro': '', 'title': '', 'manual': '', 'project': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                                } : {
                                    'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count
                                }; updateAssignment(a)
                            }} className="agenda-tooltip" ><span className="agenda-tooltip-text">{mytranslate('Cancel', data)}</span><Icon icon={cancelCircleFilled} /></button>}
                            {(isOpen || isMe) && <button className="agenda-tooltip" onClick={() => {
                                if (isMe) {
                                    let a = ('Speaker' == role) ? {
                                        'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count, 'intro': '', 'title': '', 'manual': '', 'project': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                                    } : {
                                        'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count
                                    }; updateAssignment(a)
                                } setScrollTo(id); setMode('suggest')
                            }} ><span className="agenda-tooltip-text">{mytranslate('Suggest', data)}</span><Icon icon={chevronRight} /></button>}
                            {(user_can('edit_post') || user_can('organize_agenda') || user_can('edit_signups')) && <button className="agenda-tooltip" onClick={() => { setItemMode({ item: roleindex, mode: 'edit' }) }}><span className="agenda-tooltip-text">{mytranslate('Edit', data)}</span><Icon icon={edit} /></button>}
                            {(user_can('edit_post') || user_can('organize_agenda')) && <button className="agenda-tooltip" onClick={() => { setShowControls(blockindex) }}><span className="agenda-tooltip-text">{mytranslate('Organize', data)}</span><Icon icon={tool} /></button>}
                        </div>
                        <div className="role-buttons">
                            {('edit' == mode) && assignments.length > 1 && roleindex > 0 && <button className="agenda-tooltip" onClick={() => { moveItem(roleindex, 0) }}><span className="agenda-tooltip-text">{mytranslate('Move to Top', data)}</span><span style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px'}}><Top type={attrs.role + ' ' + shownumber} /></span></button>}
                            {('edit' == mode) && assignments.length > 1 && roleindex > 0 && <button className="agenda-tooltip" onClick={() => { moveItem(roleindex, roleindex - 1) }}><span className="agenda-tooltip-text">{mytranslate('Move Up', data)}</span><span style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px'}}><Up type={attrs.role + ' ' + shownumber} /></span></button>}
                            {('edit' == mode) && assignments.length > 1 && roleindex < (assignments.length - 1) && attrs.role.search('Backup') < 0 && <button className="agenda-tooltip" onClick={() => { moveItem(roleindex, roleindex + 1) }}><span className="agenda-tooltip-text">{mytranslate('Move Down', data)}</span><span style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px'}}><Down type={attrs.role + ' ' + shownumber} /></span></button>}
                            {('edit' == mode) && showclose && <button className="agenda-tooltip" onClick={removeBlanks}><span className="agenda-tooltip-text">{mytranslate('Close Gaps', data)}</span><span style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px'}}><Close /></span></button>}
                            {('edit' == mode) && assignments.length > 1 && <button
                                className="agenda-tooltip"
                                draggable={true}
                                onDragStart={(event) => handleAssignmentDragStart(event, roleindex)}
                                onDragEnd={handleAssignmentDragEnd}
                                style={{ cursor: 'grab' }}
                                title={mytranslate('Drag to reorder', data)}
                            ><span className="agenda-tooltip-text">{mytranslate('Drag to reorder', data)}</span><span style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px'}}><Move /></span></button>}
                        </div>
                        <h3 className="role-label">
                             {assignment.avatar && <div style={{float:'left',marginRight:'10px'}}><img src={assignment.avatar} className="tm_avatar" alt={assignment.name} /></div>} {role_label} {shownumber} {assignment.name} {assignment.suggestion && <span className="suggestion">{assignment.suggestion}</span>}
                        </h3>
                    </div>
                    {attrs.agenda_note && assignments.length - 1 == roleindex ? <p><em>{attrs.agenda_note}</em></p> : null}
                    <>{'suggest' == mode && (isMe || isOpen) && <Suspense fallback={<p>{mytranslate('Loading ...', data)}</p>}><Suggest memberoptions={memberoptions} roletag={roletagbase + (roleindex + 1)} post_id={props.post_id} current_user_id={current_user_id} /></Suspense>}</>
                    <>{('edit' == mode || (itemMode.mode == 'edit' && itemMode.item == roleindex)) && <SelectCtrl label={mytranslate('Select Member', data)} value={assignment.ID} options={memberoptions} onChange={(id) => {
                        if ('Speaker' == role) updateAssignment({
                            'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'manual': '', 'title': '', 'project': '', 'intro': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                        }); else updateAssignment({
                            'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count
                        })
                    }} />}</>
                    <>{assignment.ID == 'Guest' && <div className="tmflexrow"><div className="tmflex30"><TextControl label={mytranslate('Guest Name', data)} value={guests[roleindex]} onChange={(id) => {
                        let newguests = [...guests]; newguests[roleindex] = id; setGuests(newguests);
                    }} /></div><div className="tmflex30"><br /><button className="tmform" onClick={() => {
                        updateAssignment({
                            'ID': guests[roleindex], 'name': guests[roleindex] + ' (guest)', 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count
                        }); let newguests = [...guests]; newguests[roleindex] = ''; setGuests(newguests);
                    }} >{mytranslate('Add', data)}</button></div></div>}</>
                    <>{'suggest' != mode && ('edit' == mode || (itemMode.mode == 'edit' && itemMode.item == roleindex) || (current_user_id == assignment.ID)) && ((assignment.ID > 0) || (typeof assignment.ID == 'string' && assignment.ID != '')) && role.includes('Speaker') && (role.includes('Backup') == false) && showDetails && <Suspense fallback={<p>{mytranslate('Loading ...', data)}</p>}><ProjectChooser key={'projectchooser-' + blockindex + '-' + roleindex + '-' + assignment.ID} attrs={attrs} assignment={assignment} project={assignment.project} title={assignment.title} intro={assignment.intro} manual={assignment.manual} maxtime={assignment.maxtime} display_time={assignment.display_time} updateAssignment={updateAssignment} roleindex={roleindex} blockindex={blockindex} /></Suspense>}</>
                    <>{titlePrompt && ('edit' == mode || (itemMode.mode == 'edit' && itemMode.item == roleindex) || (current_user_id == assignment.ID)) && showDetails && <Suspense fallback={<p>{mytranslate('Loading ...', data)}</p>}><OtherRoleTitle role={role} attrs={attrs} assignment={assignment} title={assignment.title} updateAssignment={updateAssignment} roleindex={roleindex} blockindex={blockindex} /></Suspense>}</>

                    {assignment.ID > 0 && 'Speaker' == attrs.role && <div className="evaluation-request"><a href={assignment.evaluation_link} onClick={(e) => { e.preventDefault(); setEvaluate(assignment); setMode('evaluation') }} >{mytranslate('Evaluation Form', data)}</a> <span style={{ fontSize: '10px' }}>({mytranslate('copy-paste text below to share', data)})</span><br /><textarea rows="3" style={{ fontSize: '8px' }} value={mytranslate('Evaluation link for ', data) + assignment.name + '\n' + assignment.evaluation_link} /></div>}
                </div>)
            })}
            {('edit' == mode) && assignments && Array.isArray(assignments) && assignments.length > 1 && draggedRoleIndex !== null && <div
                onDragOver={(event) => handleAssignmentDragOver(event, assignments.length)}
                onDrop={handleAssignmentDropAtEnd}
                style={{
                    marginTop: '4px',
                    padding: '10px',
                    textAlign: 'center',
                    backgroundColor: (dropRoleIndex === assignments.length) ? '#bbb' : '#e0e0e0',
                    border: '2px dashed #999',
                    color: '#666',
                    borderRadius: '4px',
                    fontSize: '0.9em'
                }}
            >{mytranslate('Drop here', data)}</div>}
        </>
    );
}
