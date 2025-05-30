import React, {useState} from "react"

import apiClient from './http-common.js';

import {useQuery, useMutation, useQueryClient} from 'react-query';


export function useBlocks(post_id,mode='',admin = false) {

    function fetchBlockData(queryobj) {

        admin = window.location.href.indexOf('wp-admin') != -1;

        return apiClient.get('blocks_data/'+post_id+'?mode='+mode+'&admin='+admin+'&_locale=user');

    }

    return useQuery(['blocks-data',post_id], fetchBlockData, { enabled: true, retry: 2, onSuccess, onError, refetchInterval: 60000, 'meta': mode });

}



export function useMemberEvaluation(member,project) {

    function fetchMemberEvaluation(queryobj) {

        return apiClient.get('member_evaluation?member='+member+'&project='+project+'&_locale=user');

    }

    return useQuery(['member-evaluation'], fetchMemberEvaluation, { enabled: true, retry: 2, refetchInterval: false});

}

export function initSendEvaluation(post_id, setSent, makeNotification) {

    async function postEvaluation (evaluation) {

        evaluation.post_id = post_id;

        return await apiClient.post('evaluation?_locale=user', evaluation);

    }

    return useMutation(postEvaluation, {

        onSuccess: (data, error, variables, context) => {

            makeNotification(data.data.status);

            setSent(data.data.message);

        },

        onError: (err, variables, context) => {

            makeNotification('error posting evaluation');

            console.log('error posting evaluation',err);

          },

    

          }

)

}

export function initChangeBlockAttribute(post_id,blockindex) {

    const queryClient = useQueryClient();

    const prev = queryClient.getQueryData(['blocks-data',post_id]);

    function changeBlockAttribute(key,value) {

        const prevdata = prev.data;

        prevdata.blocksdata[blockindex].attrs[key] = value;

        return prevdata;

    }

    return changeBlockAttribute;

}

async function updateAgendaPost (agenda) {

    return await apiClient.post('update_agenda?_locale=user', agenda);

}

export function updateAgenda(post_id,makeNotification=null,Inserter = null) {

    const queryClient = useQueryClient();

    return useMutation(updateAgendaPost, {

        onMutate: async (agenda) => {

            await queryClient.cancelQueries(['blocks-data',post_id]);

            const previousValue = queryClient.getQueryData(['blocks-data',post_id]);

            queryClient.setQueryData(['blocks-data',post_id],(oldQueryData) => {

                //function passed to setQueryData

                const {data} = oldQueryData;

                const newdata = {

                    ...oldQueryData, data: {...data,blocksdata: agenda.blocksdata}

                };

                return newdata;

            }) 

            if(makeNotification)
                makeNotification('Updating ...');

            if(Inserter && Inserter.setInsert)

                Inserter.setInsert('');

            return {previousValue}

        },

        onSettled: (data, error, variables, context) => {

            queryClient.invalidateQueries(['blocks-data',variables.post_id]);

        },

        onSuccess: (data, error, variables, context) => {
            if(makeNotification)
            makeNotification('Updated');

        },

        onError: (err, variables, context) => {

            if(makeNotification)
                makeNotification('Error '+err.message);

            console.log('updateAgenda error',err);

            queryClient.setQueryData("blocks-data", context.previousValue);

        },    

    }

)

}

async function copyToTemplatePost (post_id,template_id) {
    return await apiClient.post('update_agenda?_locale=user', {'post_id':post_id,'template_id':template_id});
}

export function copyToTemplate(post_id,template_id) {
    const queryClient = useQueryClient();
    return useMutation(copyToTemplatePost, {
        onSuccess: (data, error, variables, context) => {
            makeNotification('Agenda Copied');
        },
        onError: (err, variables, context) => {
            makeNotification('Error '+err.message);
            console.log('updateAgenda error',err);
            queryClient.setQueryData("blocks-data", context.previousValue);
        },
    }
)
}


function onSuccess(e) {

        if(e.current_user_id) {

            setCurrentUserId(e.current_user_id);

            setPostId(e.post_id);

        }

    }

function onError(e) {

    console.log('error downloading data',e);

}



export function useEvaluation(project,speaker_id,evalSuccess) {

    function fetchEvaluation(queryobj) {

        return apiClient.get('evaluation/?project='+project+'&speaker='+speaker_id+'&_locale=user');

    }

    return useQuery(['evaluation',project], fetchEvaluation, { enabled: true, retry: 2, onSuccess: evalSuccess, onError, refetchInterval: false, refetchOnWindowFocus: false, });

}



export function updatePreference(makeNotification) {

    async function postPreference (keyValue) {

        return await apiClient.post('user_meta?_locale=user', keyValue);

    }


    return useMutation(postPreference, {

        onSuccess: (data, error, variables, context) => {

            makeNotification(data.data.status);

        },

        onError: (err, variables, context) => {

            makeNotification('error posting preference');

            console.log('error posting preference',err);

          },

    

          }

)

}

export function useVoting(identifier,post_id=0, setVotingdata) {
    function fetchVotingData(queryobj) {
        const ts = new Date().getTime();
        console.log('get','regularvoting/'+post_id+'?mobile='+identifier+'&ts='+ts);
        const result = apiClient.get('regularvoting/'+post_id+'?mobile='+identifier+'&ts='+ts+'&_locale=user');
        console.log('result',result);
        return result;
    }
    return useQuery(['voting',post_id], fetchVotingData, { enabled: true, retry: 2, onSuccess: (data) => {setVotingdata(data.data); console.log('voting data fetched',data)}, onError, refetchInterval: 60000 });
}

export function initVoting(setVotingdata) {

    async function postVoting (postdata) {
        const ts = new Date().getTime();
        console.log('voting postdata',postdata);
        return await apiClient.post('regularvoting/'+postdata.post_id+'?mobile='+postdata.identifier+'&ts='+ts+'&_locale=user', postdata);
    }
    return useMutation(postVoting, {
        
        onSuccess: (data, error, variables, context) => {
            setVotingdata(data.data);
            console.log('data returned',data);
        },

        onError: (err, variables, context) => {
            console.log('error posting evaluation',err);
        },
    }
)
}
