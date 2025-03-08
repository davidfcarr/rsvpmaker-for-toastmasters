import React, {useState, useEffect} from "react"
import { RadioControl, ToggleControl } from '@wordpress/components';
import {SelectCtrl, NumberCtrl} from './Ctrl.js'
import {SanitizedHTML} from "./SanitizedHTML.js";
import {useBlocks,updateAgenda,useVoting,initVoting} from './queries.js';
import { TextControl } from '@wordpress/components';
import { formatStrikethrough } from "@wordpress/icons";
import {CopyToClipboard} from 'react-copy-to-clipboard';

export default function Voting({post_id}) {
    const [votingdata,setVotingdata] = useState({});
    const {mutate:sendVotingUpdate} = initVoting(setVotingdata);
    const scrollTo = 'react-agenda';
    const memberDefault = {'value':'','label':'Select Member'};
    const [candidate, setCandidate] = useState(memberDefault);
    const [custom,setCustom] = useState({key:'',label:'',options:[],signature:false});
    const [yesno,setYesno] = useState(false);
    const [signature,setSignature] = useState(false);
    const [controls,setControls] = useState('');
    const [guest,setGuest] = useState('');
    const [newBallot,setNewBallot] = useState('');
    const [votesToAdd,setVotesToAdd] = useState(false);
    const [copied,setCopied] = useState(false);

    const styles = {
        button: {minWidth: '120px',backgroundColor: 'black',padding: '10px',borderRadius:'4px', marginRight: '10px'},
        plusbutton: {backgroundColor: 'black',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        minusbutton: {backgroundColor: 'red',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        buttonText: {color:'white'},
        h1: {fontSize: '30px',fontWeight:'bold'},
        h2: {fontSize: '25px'},
    }

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
    let identifier = localStorage.getItem("toastmastersVoting");
    if(identifier)
    {
    console.log('stored_token',identifier);
    } 
    else
    {
        identifier = new Date().getTime()+Math.random();
        localStorage.setItem("toastmastersVoting",identifier);
        console.log('new token',identifier);
    }
    
    function removeCandidate(selectedBallotIndex,optindex) {
        const newcandidates = [...votingdata.meetingvotes]; console.log('newcandidates',newcandidates); newcandidates[selectedBallotIndex].options.splice(optindex,1); setCandidate(''); setGuestBlank(false); setCandidates(newcandidates); sendVotingUpdate({candidates:newcandidates,post_id:post_id,identifier:identifier});
    }

    function addCandidate(add, selectedBallotIndex) {
        const newcandidates = [...votingdata.meetingvotes]; console.log('newcandidates',newcandidates); newcandidates[selectedBallotIndex].options.push(candidate); setCandidate(''); setGuestBlank(false); setCandidates(newcandidates); sendVotingUpdate({candidates:newcandidates,post_id:post_id,identifier:identifier});
    }
    function addBallot() {
        const newcandidates = [...votingdata.meetingvotes]; newcandidates.push(custom); setBallotToUpdate(custom.key); setCustom({key:'',label:'',options:[],signature:false}); setCandidates(newcandidates); sendVotingUpdate({candidates:newcandidates,post_id:post_id,identifier:identifier});
    }

    useEffect(() => {scrolltoId(scrollTo); if('react-agenda' != scrollTo) setScrollTo('react-agenda'); },[])
    const { isLoading, isFetching, isSuccess, isError, data, error, refetch} = useVoting(identifier, post_id, setVotingdata);
    if(isError)
        return <p>Error loading agenda data. Try <a href={window.location.href}>reloading the page</a>. You can also <a href={(window.location.href.indexOf('?') > 0) ? window.location.href +'&revert=1' : window.location.href +'?revert=1'}>use the old version of the signup form</a>.</p>
    if(isLoading || isFetching || !data) {
        console.log('isLoading',isLoading);
        console.log('isFetching',isFetching);
        console.log('data',data);
        return <p>Loading ...</p>
    }
    console.log('speaker results',votingdata.speaker_results);
    const contestlist = Object.keys(votingdata.ballot);
    const ballotCopy = {... votingdata.ballot};
    contestlist.forEach(
        (c) => {
            if('Template' == c)
                return;
            console.log('contest',c);
            console.log(votingdata.ballot[c]);
        }
    );
    console.log('votingdata',votingdata);
    console.log('ballot keys',Object.keys(votingdata.ballot));
    console.log('ballot entries',Object.entries(votingdata.ballot));

    for( const [key,value] in Object.entries(votingdata.ballot) ) {
        console.log('ballot',key);
        console.log('ballot value',value);
    }

    if(votingdata.is_vote_counter && 'counting' == controls) {
        return (
            <div>
                <p style={styles.h1}>Vote Counter's Tool: Vote Count</p>
                <p><button style={styles.button} onClick={() => {setControls('')}}><span style={styles.buttonText}>Ballot Setup</span></button>  <button style={styles.button} onClick={() => {setControls('ballot')}}><span style={styles.buttonText}>Ballot</span></button> <button style={styles.button} onClick={() => {refetch()}}><span style={styles.buttonText}>Refresh</span></button></p>
                <SanitizedHTML innerHTML={votingdata.votecount} />
            </div>)
    }

    if(votingdata.is_vote_counter && '' == controls) {
        return (
            <div>
            <p style={styles.h1}>Vote Counter's Tool: Ballot Setup</p>
            {copied ? <p style={{color:'green'}}>Copied!</p>: null}
            <div style={{display:'flex',flex:1,flexDirection:'row'}}>
            <CopyToClipboard text={votingdata.url} onCopy={() => setCopied(true)} >
            <button style={styles.button}><span style={styles.buttonText}>Copy Voting Link</span></button>
            </CopyToClipboard>
                <button style={styles.button} onClick={() => {setControls('counting')}}><span style={styles.buttonText}>Vote Count</span></button> <button style={styles.button} onClick={() => {setControls('ballot')}}><span style={styles.buttonText}>Ballot</span></button> <button style={styles.button} onClick={() => {refetch()}}><span style={styles.buttonText}>Refresh</span></button>
            </div>
                {contestlist.map(
                (c, cindex) => {
                    if(('Template' == c) || ('C' == c) || ('c' == c))
                        return;
                    const currentBallot = votingdata.ballot[c];
                    return <div key={'contest'+cindex}>
                        <p style={styles.h2}>{c}</p>
                        {currentBallot.contestants.map((contestant,index) => {return <p key={'contestant'+index}><button style={styles.minusbutton} onClick={() => {currentBallot.deleted.push(contestant);currentBallot.contestants.splice(index,1); const ballotCopy = {...votingdata.ballot,c:currentBallot}; ballotCopy[c].status = 'draft'; console.log('altered ballot',ballotCopy[c]); setVotingdata({...votingdata,ballot:ballotCopy}); }}><span style={styles.buttonText}>-</span></button> {contestant}</p>})}
                        {currentBallot.new.length ? <div><p>Pending:</p>{currentBallot.new.map((maybecontestant,index) => {return <p key={'pending'+index}><button style={styles.plusbutton} onClick={() => {currentBallot.contestants.push(maybecontestant);currentBallot.new.splice(index,1); const ballotCopy = {...votingdata.ballot,c:currentBallot}; ballotCopy[c].status = 'draft'; console.log('altered ballot',ballotCopy[c]);  setVotingdata({...votingdata,ballot:ballotCopy}); }}><span style={styles.buttonText}>+</span></button> {maybecontestant}</p>})}</div> : null}
                        {currentBallot.deleted.length ? <div><p>Deleted:</p>{currentBallot.deleted.map((deletedcontestant,index) => {return <p key={'deleted'+index} style={{textDecoration:'line-through'}}><button style={styles.plusbutton} onClick={() => {currentBallot.contestants.push(deletedcontestant);currentBallot.deleted.splice(index,1); const ballotCopy = {...votingdata.ballot,c:currentBallot}; ballotCopy[c].status = 'draft'; console.log('altered ballot',ballotCopy[c]); setVotingdata({...votingdata,ballot:ballotCopy}); }}><span style={styles.buttonText}>+</span></button> {deletedcontestant}</p>})}</div> : null}
                        <p><SelectCtrl label="Member to Add" value={candidate} options={[memberDefault,...votingdata.memberlist]} onChange={(choice) => { if(!choice) return; console.log('add on select',choice); currentBallot.contestants.push(choice); const ballotCopy = {...votingdata.ballot,c:currentBallot}; ballotCopy[c].status = 'draft'; console.log('altered ballot',ballotCopy[c]);  setVotingdata({...votingdata,ballot:ballotCopy}); } } /></p>
                        <div style={{display: 'flex',flex:1,flexDirection:'row'}}><div><TextControl label="Type Choice to Add" value={guest} onChange={ (value) => { setGuest(value); } } /></div><div style={{padding: '20px'}}><button style={styles.plusbutton} onClick={() => {currentBallot.contestants.push(guest); setGuest(''); const ballotCopy = {...votingdata.ballot,c:currentBallot}; ballotCopy[c].status = 'draft'; console.log('altered ballot',ballotCopy[c]);  setVotingdata({...votingdata,ballot:ballotCopy});}}><span style={styles.buttonText}>+</span></button></div></div>                    
                        {currentBallot.status == 'publish' ? <div><p><button style={styles.button} onClick={() => { const update = {...currentBallot,status:'draft'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier});} }><span style={styles.buttonText}>Unpublish</span></button></p></div> 
                        : <p><button style={styles.button} onClick={() => { const update = {...currentBallot,status:'publish'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier});} }><span style={styles.buttonText}>Publish</span></button></p>}
                    </div>
                }
            )}
            <p style={styles.h2}>New Ballot</p>
            <div style={{display: 'flex',flex:1,flexDirection:'row'}}><div><TextControl label="Contest or Question" value={newBallot} onChange={ (value) => { setNewBallot(value); } } /></div><div style={{padding: '20px'}}><button style={styles.plusbutton} onClick={() => {const newBallotEntry = {...votingdata.ballot}; newBallotEntry[newBallot] = {...votingdata.ballot.Template}; setVotingdata({...votingdata,ballot:newBallotEntry}); setNewBallot('');}}><span style={styles.buttonText}>+</span></button></div></div>
            {contestlist.map(
                (c, cindex) => {
                    if(('Template' == c) || ('C' == c) || ('c' == c))
                        return;
                    const currentBallot = votingdata.ballot[c];
                    if(currentBallot.status != 'publish')
                        return;
                    const added_votes = [...votingdata.added_votes];
                    return <div key={'contestadd'+cindex}>
                        <p style={styles.h2}>Add Votes: {c}</p>
                        <p>If you received votes from outside of this app, you can add them here.</p>
                        {currentBallot.contestants.map((contestant,index) => {let addvote = added_votes.find((item,itemindex) => {if(item.ballot == c && item.contestant == contestant) {item.index = itemindex; return item;} }); if(!addvote) {addvote = {'ballot':c,'contestant':contestant,add:0,index:added_votes.length}; added_votes.push(addvote); console.log('created addvote object',addvote)} 
                        return <p key={'addvotes'+index}>
                        <button style={styles.plusbutton} onClick={() => {console.log('add vote',contestant); setVotesToAdd(true); addvote.add++; console.log(addvote); added_votes[addvote.index].add = addvote.add; console.log('added',added_votes); const update = {...votingdata,added_votes:added_votes}; console.log('added update',update); setVotingdata(update); } }><span style={styles.buttonText}>+</span></button> 
                        <button style={styles.minusbutton} onClick={() => {console.log('add vote',contestant);  setVotesToAdd(true); if(addvote.add > 0) addvote.add--; console.log(addvote); added_votes[addvote.index].add = addvote.add; console.log('added',added_votes); const update = {...votingdata,added_votes:added_votes}; console.log('added update',update); setVotingdata(update); } }><span style={styles.buttonText}>-</span></button> 
                        {contestant} +{addvote.add}</p>})}
                        {votesToAdd ? <p><button style={styles.button} onClick={() =>{ sendVotingUpdate({added:votingdata.added_votes,post_id:post_id,identifier:identifier}); setVotesToAdd(false); }}><span style={styles.buttonText}>Update</span></button></p> : null}
                    </div>
                }
            )}
            <p style={styles.h2}>Reset</p>
            <p><button style={styles.button} onClick={() => { sendVotingUpdate({reset:true,post_id:post_id,identifier:identifier});} }><span style={styles.buttonText}>Reset Ballot</span></button></p>
        </div>
        );
    }    

    let openBallots = false;
    return (
        <div>
            <p style={styles.h1}>Voting</p>
            <p><button style={styles.button} onClick={() => {refetch()}}><span style={styles.buttonText}>Refresh</span></button></p>
            {votingdata.is_vote_counter ? <p><button style={styles.button} onClick={() => {setControls('')}}><span style={styles.buttonText}>Ballot Setup</span></button> <button style={styles.button} onClick={() => {setControls('counting')}}><span style={styles.buttonText}>Vote Count</span></button></p> : null}
                {contestlist.map(
                (c, cindex) => {
                    if('Template' == c)
                        return;
                    const currentBallot = votingdata.ballot[c];
                    if(currentBallot.status != 'publish')
                        return null;
                    openBallots = true; //at least one open ballot
                    if(votingdata.myvotes.includes(c))
                        return (<div key={'contest'+cindex}>
                    <p style={styles.h2}>{c}</p>
                    <p>Voted</p>
                    </div>)
                    return (<div key={'contest'+cindex}>
                        <p style={styles.h2}>{c}</p>
                        {currentBallot.contestants.length ? <p>Vote for:</p> : null}
                        {currentBallot.contestants.map((contestant,index) => {return <div key={'contestant'+index}><p><button style={styles.button} onClick={() => {const vote = {'vote':contestant,'key':c,identifier:identifier,post_id:post_id}; console.log('vote',vote); sendVotingUpdate(vote);} }><span style={styles.buttonText}>{contestant}</span></button></p></div>})}
                    </div>)
                }
            )}
            {!votingdata.is_vote_counter && !openBallots ? 
            <div><p>The current vote counter is "{votingdata.vote_counter_name}" but no ballots have been created yet.</p>
            <p style={styles.h2}>Assume the role of Vote Counter?</p>
            <p>If no Vote Counter is available, any member can assume the role.</p>
            {votingdata.authorized_user ? <p><button style={styles.button} onClick={() => {sendVotingUpdate({post_id:post_id,identifier:identifier,take_vote_counter:true}) }}><span style={styles.buttonText}>Take Vote Counter Role</span></button></p> : <p><a href={votingdata.login_url}>Please login first</a></p>}

            </div> : null}
            {votingdata.is_vote_counter ? <div><p style={styles.h2}>Back to Vote Counter Controls?</p>
            <p><button style={styles.button} onClick={() => {setControls('')} }><span style={styles.buttonText}>Go Back</span></button></p></div> : null}
        </div>
    );
}
