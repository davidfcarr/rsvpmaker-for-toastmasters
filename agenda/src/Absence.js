import React, {useState, useEffect} from "react"
import {useQuery,useMutation, useQueryClient} from 'react-query';
import {SelectCtrl} from './Ctrl.js'
import apiClient, { setupNonceInterceptor } from './http-common.js';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import { Icon, plusCircle, cancelCircleFilled } from '@wordpress/icons';

export function Absence(props) {
    const {current_user_id, post_id, mode, makeNotification} = props;
    const [addtolist,setAddToList] = useState(0);
    const [until,setUntil] = useState('');
    const rsvpmaker_rest = useRsvpmakerRest();
    
    useEffect(() => {
        if (rsvpmaker_rest?.nonce) {
        setupNonceInterceptor(rsvpmaker_rest.nonce);
        }
    }, [rsvpmaker_rest?.nonce]);

    const { isLoading, isFetching, isSuccess, isError, data, error, refetch} =
    useQuery(['absences-data',post_id], fetchAbsences, { enabled: true, retry: 2, onSuccess, onError, refetchInterval: 60000 });
    function fetchAbsences() {
        return apiClient.get('absences?post_id='+post_id);
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
        async (addremove) => { return await apiClient.post("absences?post_id="+post_id+'&_locale=user', addremove)},
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
        let m = memberlist.find( (item) => { if(item.value == id) return item; } );
        return m?.label;
    }

    function removeAbsence(id,index,until) {
        absMutation.mutate({'operation':'remove','index':index,'ID':id,'until':until});
    }
    function addAbsence(id, selectedUntil = '') {
        absMutation.mutate({'operation':'add','ID':id,'name':getMemberName(id),'until':selectedUntil});
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

    if('edit' == mode)
    return (<div className="absence">
        <h3>Planned Absences</h3>
        {absences.map( (ab, index) => {
            return <p><button className="tmform" onClick={() => {removeAbsence(ab.ID,index,ab.until);} }>Remove</button> {ab.name} { (ab.until && ab.until != '') && <em>until {new Date(ab.until).toLocaleDateString()}</em>}</p>
        } ) }
        <SelectCtrl label="Add Member to List" value={addtolist} options={memberlist} onChange={(id) => { setAddToList(id) }} />
        <SelectCtrl label="One meeting or several?" options={upcoming} value={until} onChange={setUntil} />
        <button className="tmform" onClick={() => {addAbsence(addtolist)} }>Add</button>
    </div>);

    //signup mode
    return (<div className="absence">
    <h3>Planned Absences</h3>
    {absences.map( (ab) => {
    return <p>{ab.name} { (ab.until && ab.until != '') && <em>until {new Date(ab.until).toLocaleDateString()}</em>}</p>
    } ) }
    {(absentIndex > -1) && <div>
        <SelectCtrl label="Absent until" options={upcoming} value={until ? until : meuntil} onChange={extendSelfAbsenceUntil} />
    </div>}
    <p>
        {(absentIndex > -1) && <button className="agenda-tooltip" onClick={() => {removeAbsence(current_user_id,absentIndex,meuntil)} }><span className="agenda-tooltip-text">Remove Me</span><Icon icon={cancelCircleFilled} /></button>}
        {(absentIndex < 0) && <button className="agenda-tooltip" onClick={addSelfSingleMeeting}><span className="agenda-tooltip-text">Add Me</span><Icon icon={plusCircle} /></button>}
    </p>
    </div>);
}