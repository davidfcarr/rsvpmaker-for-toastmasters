import React, { useState, useEffect } from "react";
import { TextControl } from '@wordpress/components';
import mytranslate from './mytranslate'
import { SelectCtrl } from './Ctrl.js';
import ProjectChooser from "./ProjectChooser.js";
import Suggest from "./Suggest.js";
import { Up, Down, Top, Close } from './icons.js';
import apiClient from './http-common.js';
import { useMutation, useQueryClient } from 'react-query';
import { updatePreference } from "./queries.js";
import { Icon, plusCircle, chevronRight, cancelCircleFilled, edit, tool } from '@wordpress/icons';

export default function RoleBlock(props) {
    const { agendadata, mode, showDetails, blockindex, setMode, setScrollTo, block, makeNotification, post_id, setEvaluate, setShowControls, data } = props;
    const { assignments, attrs, memberoptions } = block;
    const [itemMode, setItemMode] = useState({ item: null, mode: '' });

    if (!attrs || !attrs.role)
        return null;

    const queryClient = useQueryClient();
    const { current_user_id, current_user_name, request_evaluation } = agendadata;
    const [guests, setGuests] = useState([].fill('', 0, attrs.count));
    const { mutate: mutatePreference } = updatePreference(makeNotification);

    if (!attrs.role)
        return null;

    function user_can(permission) {
        let answer = false;
        if (agendadata.permissions[permission]) {
            answer = agendadata.permissions[permission];
        }
        return answer;
    }

    let roletagbase = '_role_' + attrs.role.replaceAll(/[^A-Za-z]/g, '_') + '_';
    const [viewTop, setViewTop] = useState('');
    let roles = [];
    var start = (attrs.start) ? parseInt(attrs.start) : 1;
    if (!start)
        start = 1;

    let count = (attrs.count) ? attrs.count : 1;
    let openslots = [];
    let filledslots = [];
    let role = attrs.role;
    let role_label = mytranslate(attrs.role,data);

    function updateAssignment(assignment, blockindex = null, start = 1, count = 1) {
        if (Array.isArray(assignment)) {
            assignment = assignment.map((a) => { return { ...a, post_id: post_id, count: count } });
            return multiAssignmentMutation.mutate({ 'assignments': assignment, 'blockindex': blockindex, 'start': 1 });
        } else {
            assignment.post_id = post_id;
            assignmentMutation.mutate(assignment);
        }
    }

    const assignmentMutation = useMutation(
        async (assignment) => { return await apiClient.post("json_assignment_post", assignment) },
        {
            onMutate: async (assignment) => {
                await queryClient.cancelQueries(['blocks-data', post_id]);
                const previousData = queryClient.getQueryData(['blocks-data', post_id]);
                queryClient.setQueryData(['blocks-data', post_id], (oldQueryData) => {
                    const { blockindex, roleindex } = assignment;
                    const { data } = oldQueryData;
                    const { blocksdata } = data;
                    blocksdata[blockindex].assignments[roleindex] = assignment;
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
                queryClient.setQueryData("blocks-data", context.previousData);
                makeNotification(mytranslate('Error updating assignment ', data) + err.message);
            },
        }
    );

    const multiAssignmentMutation = useMutation(
        async (multi) => { return await apiClient.post("json_multi_assignment_post", multi) },
        {
            onMutate: async (multi) => {
                await queryClient.cancelQueries(['blocks-data', post_id]);
                const previousValue = queryClient.getQueryData(['blocks-data', post_id]);
                queryClient.setQueryData(['blocks-data', post_id], (oldQueryData) => {
                    const { blockindex } = multi;
                    const { data } = oldQueryData;
                    const { blocksdata } = data;
                    blocksdata[blockindex].assignments = multi.assignments;
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
                queryClient.setQueryData("blocks-data", context.previousValue);
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
        let myassignment = assignments[roleindex];
        myassignment.role = attrs.role;
        let newassignments = [];
        assignments.forEach((prevassignment, previndex) => {
            prevassignment.role = attrs.role;
            if ((previndex == newindex) && (newindex < roleindex)) {
                newassignments.push(myassignment); //insert before
                newassignments.push(prevassignment);
            } else if ((previndex == newindex) && (newindex > roleindex)) {
                newassignments.push(prevassignment);
                newassignments.push(myassignment); //insert after
            } else if (previndex != roleindex) // skip spot my assignment previously occupied
                newassignments.push(prevassignment);
        });
        updateAssignment(newassignments, blockindex, start, count);
        scrolltoId('block' + blockindex);
    }

    function removeBlanks() {
        let newassignments = [];
        let removed = [];
        assignments.forEach((prevassignment, previndex) => {
            prevassignment.role = attrs.role;
            if ((prevassignment.ID != 0) && (prevassignment.ID != "0")) {
                newassignments.push(prevassignment);
            } else {
                removed.push(prevassignment);
            }
        });
        removed.forEach((r) => { newassignments.push(r); });
        updateAssignment(newassignments, blockindex, start, count);
    }

    function getMemberName(id) {
        let m = memberoptions.find((item) => { if (item.value == id) return item; });
        return m?.value;
    }

    function MoveButtons(props) {
        const { assignments, roleindex, filledslots, openslots, attrs, shownumber } = props;
        let showclose = false;
        if (filledslots.length > 0 && openslots.length > 0) {
            if (filledslots[filledslots.length - 1] > openslots[0]) {
                showclose = true;
            }
        }
        return (
            <p>
                <span className="moveup">{assignments.length > 1 && roleindex > 0 && <>
                    <button className="tmform" onClick={() => { moveItem(roleindex, 0) }}>
                        <Top type={attrs.role + ' ' + shownumber} />
                    </button>
                    <button className="tmform" onClick={() => { moveItem(roleindex, roleindex - 1) }}>
                        <Up type={attrs.role + ' ' + shownumber} />
                    </button>
                </>}</span>
                <span className="movedown">{assignments.length > 1 && roleindex < (assignments.length - 1) && attrs.role.search('Backup') < 0 &&
                    <button className="tmform" onClick={() => { moveItem(roleindex, roleindex + 1) }}>
                        <Down type={attrs.role + ' ' + shownumber} />
                    </button>}</span>
                <span className="closegaps">{showclose && <button className="tmform" onClick={removeBlanks}><Close /></button>}</span>
            </p>
        )
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

                return (<div id={id} key={id}>
                    <div className="roleheader">
                        <div div className="role-buttons">
                            {isOpen && <button className="agenda-tooltip" onClick={function (event) {
                                if ('Speaker' == role) updateAssignment({
                                    'ID': current_user_id, 'name': current_user_name, 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'maxtime': 7, 'display_time': '5 - 7 minutes', 'wasopen': true
                                }); updateAssignment({
                                    'ID': current_user_id, 'name': current_user_name, 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'wasopen': true
                                })
                            }} ><span class="agenda-tooltip-text">{mytranslate('Take Role', data)}</span><Icon icon={plusCircle} /></button>}
                            {isMe && <button onClick={function (event) {
                                let a = ('Speaker' == role) ? {
                                    'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count, 'intro': '', 'title': '', 'manual': '', 'project': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                                } : {
                                    'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count
                                }; updateAssignment(a)
                            }} className="agenda-tooltip" ><span class="agenda-tooltip-text">{mytranslate('Cancel', data)}</span><Icon icon={cancelCircleFilled} /></button>}
                            {(isOpen || isMe) && <button className="agenda-tooltip" onClick={() => {
                                if (isMe) {
                                    let a = ('Speaker' == role) ? {
                                        'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count, 'intro': '', 'title': '', 'manual': '', 'project': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                                    } : {
                                        'ID': 0, 'name': '', 'role': role, 'blockindex': blockindex, 'roleindex': roleindex, 'start': start, 'count': count
                                    }; updateAssignment(a)
                                } setScrollTo(id); setMode('suggest')
                            }} ><span class="agenda-tooltip-text">{mytranslate('Suggest', data)}</span><Icon icon={chevronRight} /></button>}
                            {(user_can('edit_post') || user_can('organize_agenda') || user_can('edit_signups')) && <button className="agenda-tooltip" onClick={() => { setItemMode({ item: roleindex, mode: 'edit' }) }}><span class="agenda-tooltip-text">{mytranslate('Edit', data)}</span><Icon icon={edit} /></button>}
                            {(user_can('edit_post') || user_can('organize_agenda')) && <button className="agenda-tooltip" onClick={() => { setShowControls(blockindex) }}><span class="agenda-tooltip-text">{mytranslate('Organize', data)}</span><Icon icon={tool} /></button>}
                        </div>
                        <h3 className="role-label">
                            {role_label} {shownumber} {assignment.name}
                        </h3>
                    </div>
                    {attrs.agenda_note && <p><em>{attrs.agenda_note}</em></p>}
                    <>{'suggest' == mode && (isMe || isOpen) && <Suggest memberoptions={memberoptions} roletag={roletagbase + (roleindex + 1)} post_id={props.post_id} current_user_id={current_user_id} />}</>
                    <>{('edit' == mode || (itemMode.mode == 'edit' && itemMode.item == roleindex)) && <SelectCtrl label={mytranslate('Select Member', data)} value={assignment.ID} options={memberoptions} onChange={(id) => {
                        if ('Speaker' == role) updateAssignment({
                            'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count, 'manual': '', 'title': '', 'project': '', 'intro': '', 'maxtime': 7, 'display_time': '5 - 7 minutes'
                        }); else updateAssignment({
                            'ID': id, 'name': getMemberName(id), 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count
                        })
                    }} />}</>
                    <>{'edit' == mode && assignment.ID == 'Guest' && <div className="tmflexrow"><div className="tmflex30"><TextControl label={mytranslate('Guest Name', data)} value={guests[roleindex]} onChange={(id) => {
                        let newguests = [...guests]; newguests[roleindex] = id; setGuests(newguests);
                    }} /></div><div className="tmflex30"><br /><button className="tmform" onClick={() => {
                        updateAssignment({
                            'ID': guests[roleindex], 'name': guests[roleindex] + ' (guest)', 'role': role, 'roleindex': roleindex, 'blockindex': blockindex, 'start': start, 'count': count
                        }); let newguests = [...guests]; newguests[roleindex] = ''; setGuests(newguests);
                    }} >{mytranslate('Add', data)}</button></div></div>}</>
                    <>{'suggest' != mode && ('edit' == mode || (itemMode.mode == 'edit' && itemMode.item == roleindex) || (current_user_id == assignment.ID)) && ((assignment.ID > 0) || (typeof assignment.ID == 'string' && assignment.ID != '')) && (role.search('Speaker') > -1) && (role.search('Backup') == -1) && showDetails && <ProjectChooser attrs={attrs} assignment={assignment} project={assignment.project} title={assignment.title} intro={assignment.intro} manual={assignment.manual} maxtime={assignment.maxtime} display_time={assignment.display_time} updateAssignment={updateAssignment} roleindex={roleindex} blockindex={blockindex} />}</>
                    <>{!!('edit' == mode) && assignments.length > 1 && <MoveButtons assignments={assignments} roleindex={roleindex} filledslots={filledslots} openslots={openslots} attrs={attrs} shownumber={shownumber} />}</>
                    {assignment.ID > 0 && 'Speaker' == attrs.role && <div className="evaluation-request"><a href={assignment.evaluation_link} onClick={(e) => { e.preventDefault(); setEvaluate(assignment); setMode('evaluation') }} >{mytranslate('Evaluation Form', data)}</a> <span style={{ fontSize: '10px' }}>({mytranslate('copy-paste text below to share', data)})</span><br /><textarea rows="3" style={{ fontSize: '8px' }} value={mytranslate('Evaluation link for ', data) + assignment.name + '\n' + assignment.evaluation_link} /></div>}
                </div>)
            })}
        </>
    );
}
