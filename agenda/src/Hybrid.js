import React, { useState, useEffect } from "react";
import mytranslate from './mytranslate'
import { SelectCtrl } from './Ctrl.js';
import { useQuery, useMutation, useQueryClient } from 'react-query';
import apiClient from './http-common.js';

export function Hybrid(props) {
    const { current_user_id, post_id, mode, makeNotification } = props;
    const [addtolist, setAddToList] = useState(0);

    const queryClient = useQueryClient();
    const { isLoading, isFetching, isSuccess, isError, data, error, refetch } =
        useQuery(['hybrid-data', post_id], fetchInPersons, { enabled: true, retry: 2, onSuccess, onError, refetchInterval: 60000 });

    function fetchInPersons() {
        return apiClient.get('hybrid?post_id=' + post_id);
    }

    function onSuccess(data) {
        console.log('hybrid data', data);
    }

    function onError(err, variables, context) {
        console.log('hybrid error', err);
    }

    if (isError)
        return <p>{__('Error loading Hybrid.js data', 'rsvpmaker-for-toastmasters')}</p>;

    const hybridMutation = useMutation(
        async (addremove) => { return await apiClient.post("hybrid?post_id=" + post_id, addremove) },
        {
            onMutate: async (addremove) => {
                await queryClient.cancelQueries(['hybrid-data', post_id]);
                const previousData = queryClient.getQueryData(['blocks-data', post_id]);
                queryClient.setQueryData(['hybrid-data', post_id], (oldQueryData) => {
                    const { data } = oldQueryData;
                    const { hybrid } = data;
                    if ('add' == addremove.operation)
                        hybrid.push({ 'ID': addremove.ID, 'name': addremove.name });
                    else if ('remove' == addremove.operation)
                        hybrid.splice(addremove.index, 1);
                    const newdata = {
                        ...oldQueryData, data: { ...data, hybrid: hybrid }
                    };
                    return newdata;
                });
                makeNotification(__('Updating ...', 'rsvpmaker-for-toastmasters'));
                return { previousData };
            },
            onSettled: (data, error, variables, context) => {
                queryClient.invalidateQueries(['hybrid-data', variables.post_id]);
            },
            onSuccess: (data, error, variables, context) => {
                makeNotification(__('Updated', 'rsvpmaker-for-toastmasters'));
            },
            onError: (err, variables, context) => {
                makeNotification(__('update hybrid error', 'rsvpmaker-for-toastmasters'));
                console.log('mutate hybrid error', err);
                queryClient.setQueryData("hybrid-data", context.previousData);
            },
        }
    );

    if (isLoading)
        return <div>{__('Loading hybrid list ...', 'rsvpmaker-for-toastmasters')}</div>;

    const { hybrid, memberlist } = data.data;

    function getMemberName(id) {
        if (!Array.isArray(memberlist))
            return 'User ' + id;
        let m = memberlist.find((item) => { if (item.value == id) return item; });
        return m?.label;
    }

    function removeInPerson(id, index) {
        hybridMutation.mutate({ 'operation': 'remove', 'index': index, 'ID': id });
    }

    function addInPerson(id) {
        hybridMutation.mutate({ 'operation': 'add', 'ID': id, 'name': getMemberName(id) });
    }

    let absentIndex = -1;
    let meuntil = '';
    if (Array.isArray(hybrid))
        hybrid.forEach((ab, index) => {
            if (ab.ID == current_user_id) {
                absentIndex = index;
            }
        });

    if ('edit' == mode)
        return (
            <div className="absence">
                <h3>{__('In Person Attendance', 'rsvpmaker-for-toastmasters')}</h3>
                {hybrid.map((ab, index) => {
                    return (
                        <p>
                            <button className="tmform" onClick={() => { removeInPerson(ab.ID, index, ab.until); }}>
                                {__('Remove', 'rsvpmaker-for-toastmasters')}
                            </button>{' '}
                            {ab.name}
                        </p>
                    );
                })}
                <SelectCtrl
                    label={__('Add Member to List', 'rsvpmaker-for-toastmasters')}
                    value={addtolist}
                    options={memberlist}
                    onChange={(id) => { setAddToList(id); }}
                />
                <button className="tmform" onClick={() => { addInPerson(addtolist); }}>
                    {__('Add', 'rsvpmaker-for-toastmasters')}
                </button>
            </div>
        );

    // Signup mode
    return (
        <div className="hybrid">
            <h3>{__('In Person Attendance', 'rsvpmaker-for-toastmasters')}</h3>
            {hybrid.map((ab) => {
                return <p>{ab.name}</p>;
            })}
            <p>
                {absentIndex > -1 && (
                    <button className="tmform" onClick={() => { removeInPerson(current_user_id, absentIndex); }}>
                        {__('Remove Me', 'rsvpmaker-for-toastmasters')}
                    </button>
                )}
                {absentIndex < 0 && (
                    <button className="tmform" onClick={() => { addInPerson(current_user_id); }}>
                        {__('Add Me', 'rsvpmaker-for-toastmasters')}
                    </button>
                )}
            </p>
        </div>
    );
}