import React, {useState, useEffect} from "react"
import {useQuery,useMutation, useQueryClient} from 'react-query';
import {SelectCtrl} from './Ctrl.js'
import apiClient, { setupNonceInterceptor } from './http-common.js';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import { Icon, plusCircle, cancelCircleFilled, edit } from '@wordpress/icons';

export function Absence(props) {
    const {current_user_id, post_id, mode, makeNotification} = props;
    const [addtolist,setAddToList] = useState(0);
    const [until,setUntil] = useState('');
    const [showEditor,setShowEditor] = useState(false);
    const rsvpmaker_rest = useRsvpmakerRest();

    console.log('absence mode ', mode);
    
    useEffect(() => {
        if (rsvpmaker_rest?.nonce) {
        setupNonceInterceptor(rsvpmaker_rest.nonce);
        }
    }, [rsvpmaker_rest?.nonce]);


    const { isLoading, isFetching, isSuccess, isError, data, error, refetch} =
    useQuery(['absences-data',post_id], fetchAbsences, { enabled: true, retry: 2, onSuccess, onError, refetchInterval: 60000 });
    function fetchAbsences() {
        return apiClient.get('absences?post_id='+post_id+'&user_id='+current_user_id+'&_locale=user');
    }
    function onSuccess(data) {
        //console.log('absences',data);
    }
    function onError(err, variables, context) {
        console.log('absences error',err);
    }

    if(isError)
        return <p>Error loading absences</p>

    const queryClient = useQueryClient();

    const absMutation = useMutation(
        async (addremove) => { return await apiClient.post("absences?post_id="+post_id+'&user_id='+current_user_id+'&_locale=user', addremove)},
        {
            onMutate: async (addremove) => {
                await queryClient.cancelQueries(['absences-data',post_id]);
                const previousData = queryClient.getQueryData(['absences-data',post_id]);
                queryClient.setQueryData(['absences-data',post_id],(oldQueryData) => {
                    if(!oldQueryData || !oldQueryData.data)
                        return oldQueryData;
                    const {data} = oldQueryData;
                    const absences = Array.isArray(data.absences) ? [...data.absences] : [];
                    if('add' == addremove.operation)
                        absences.push({'ID':addremove.ID,'name':addremove.name, 'until': addremove.until});
                    else if('remove' == addremove.operation)
                        absences.splice(addremove.index,1);
                    const newdata = {
                        ...oldQueryData, data: {...data,absences: absences}
                    };
                    return newdata;
                }) 
                makeNotification('Updating ...');
                return {previousData}
            },
            onSettled: () => {
                queryClient.invalidateQueries(['absences-data',post_id]);
            },
            onSuccess: (data, error, variables, context) => {
                makeNotification('Updated');
            },
            onError: (err, variables, context) => {
                makeNotification('Error updating absences '+err.message);
                console.log('mutate assignment error',err);
                queryClient.setQueryData(['absences-data',post_id], context.previousData);
            },
        }
    );

    function getMemberName(id) {
        if(!Array.isArray(memberlist))
            return '';
        let m = memberlist.find((item) => item.value == id);
        return m?.label ? m.label : '';
    }

    function removeAbsence(id,index,until) {
        const normalizedId = parseInt(id, 10);
        if(!normalizedId)
            return;
        absMutation.mutate({'operation':'remove','index':index,'ID':normalizedId,'until':until ? until : ''});
    }
    function addAbsence(id, selectedUntil = '') {
        const normalizedId = parseInt(id, 10);
        if(!normalizedId) {
            makeNotification('Please select a member first.');
            return;
        }
        const normalizedUntil = (selectedUntil === null || typeof selectedUntil === 'undefined') ? '' : selectedUntil;
        absMutation.mutate({'operation':'add','ID':normalizedId,'name':getMemberName(normalizedId),'until':normalizedUntil});
    }

    function formatUntilDate(untilDate) {
        if(!untilDate)
            return '';
        const raw = Number(untilDate);
        if(!Number.isNaN(raw) && raw > 0) {
            const millis = raw < 1000000000000 ? raw * 1000 : raw;
            return new Date(millis).toLocaleDateString();
        }
        return new Date(untilDate).toLocaleDateString();
    }

    function addSelfSingleMeeting() {
        setUntil('');
        addAbsence(current_user_id,'');
    }

    function extendSelfAbsenceUntil(selectedUntil) {
        setUntil(selectedUntil);
        addAbsence(current_user_id,selectedUntil ? selectedUntil : '');
    }
    if(isLoading)
    return <div>Loading absences list ...</div>
    
    const {absences, upcoming,memberlist} = data.data; 
    const canManageOthers = (mode == 'edit') || !!data?.data?.can_manage_others;
    const showManagerPanel = (mode == 'edit') || showEditor;
    console.log('absences',absences);
    console.log('upcoming',upcoming);
    console.log('memberlist',memberlist);

    let absentIndex = -1;
    let meuntil = '';
    if(absences && Array.isArray(absences))
    absences.forEach((ab, index) => {
        if(ab.ID == current_user_id)
            {
                absentIndex = index;
                meuntil = ab.until ? ab.until : '';
            }
    });

    function ManagerPanel() {
        return (<>
        {absences.map( (ab, index) => {
            const name = ab.label ? ab.label : ab.name;
            return <p><button type="button" className="tmform" onClick={() => {removeAbsence(ab.ID,index,ab.until);} }>Remove</button> {name}</p>
        } ) }
        <SelectCtrl label="Add Member to List" value={addtolist} options={memberlist} onChange={(id) => { setAddToList(id) }} />
        <SelectCtrl label="One meeting or several?" options={upcoming} value={until} onChange={setUntil} />
        <button type="button" className="tmform" onClick={() => {addAbsence(addtolist, until)} }>Add</button>
        </>);
    }

    if('edit' == mode)
    return (<div className="absence">
        <h3>Planned Absences</h3>
        <ManagerPanel />
    </div>);

    //signup mode
    return (<div className="absence">
    <h3>Planned Absences</h3>
    {absences.map( (ab) => {
    const name = ab.label ? ab.label : ab.name;
    return <p>{name}</p>
    } ) }
    {(absentIndex > -1) && <div>
        <SelectCtrl label="Absent until" options={upcoming} value={until ? until : meuntil} onChange={extendSelfAbsenceUntil} />
    </div>}
    <p>
        {(absentIndex > -1) && <button type="button" className="agenda-tooltip" onClick={() => {removeAbsence(current_user_id,absentIndex,meuntil)} }><span className="agenda-tooltip-text">Remove Me</span><Icon icon={cancelCircleFilled} /></button>}
        {(absentIndex < 0) && <button type="button" className="agenda-tooltip" onClick={addSelfSingleMeeting}><span className="agenda-tooltip-text">Add Me</span><Icon icon={plusCircle} /></button>}
        {canManageOthers && <button type="button" className="agenda-tooltip" onClick={() => setShowEditor(!showEditor)}><span className="agenda-tooltip-text">Edit Absences</span><Icon icon={edit} /></button>}
    </p>
    {canManageOthers && showManagerPanel && <div className="absence-manager-panel"><ManagerPanel /></div>}
    </div>);
}