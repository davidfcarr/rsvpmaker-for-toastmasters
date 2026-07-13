import React, {useState, useEffect, useRef} from "react"
import {SelectCtrl} from './Ctrl.js'
import {SanitizedHTML} from "./SanitizedHTML.js";
import {useVoting,initVoting} from './queries.js';
import { TextControl, ToggleControl } from '@wordpress/components';
import {CopyToClipboard} from 'react-copy-to-clipboard';
import mytranslate from './mytranslate'

function getVotingIdentifier() {
    const existing = localStorage.getItem("toastmastersVoting");
    if (existing) {
        return existing;
    }
    const generated = new Date().getTime() + Math.random();
    localStorage.setItem("toastmastersVoting", generated);
    return generated;
}

export default function Voting({post_id}) {
    const [votingdata,setVotingdata] = useState({});
    const {mutate:sendVotingUpdate} = initVoting(setVotingdata);
    const scrollTo = 'react-agenda';
    const memberDefault = {'value':'','label':'Select Member'};
    const [candidate, setCandidate] = useState(memberDefault);
    const [yesNo,setYesNo] = useState(false);
    const [everyMeeting,setEveryMeeting] = useState(false);
    const [signatureRequired,setSignatureRequired] = useState(false);
    const [controls,setControls] = useState('');
    const [guest,setGuest] = useState('');
    const [newBallot,setNewBallot] = useState('');
    const [copied,setCopied] = useState(false);
    const [close,setClose] = useState(0);
    const identifierRef = useRef(getVotingIdentifier());
    const identifier = identifierRef.current;

    const styles = {
        button: {minWidth: '120px',backgroundColor: 'black',padding: '10px',borderRadius:'4px', marginRight: '10px'},
        plusbutton: {backgroundColor: 'black',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        minusbutton: {backgroundColor: 'red',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        buttonText: {color:'white'},
        h1: {fontSize: '30px',fontWeight:'bold'},
        h2: {fontSize: '25px'},
    }

    function updateContestBallot(contestKey, updater, persist = false) {
        const source = votingdata?.ballot?.[contestKey];
        if (!source) {
            return;
        }
        const updatedContest = { ...updater(source), status: 'draft' };
        const updatedBallot = { ...votingdata.ballot, [contestKey]: updatedContest };
        const updatedVotingData = { ...votingdata, ballot: updatedBallot };
        setVotingdata(updatedVotingData);
        if (persist) {
            sendVotingUpdate({ ballot: updatedBallot, post_id: post_id, identifier: identifier });
        }
    }

    function updateAddedVotes(contestKey, contestant, delta) {
        const addedVotes = Array.isArray(votingdata.added_votes) ? votingdata.added_votes : [];
        let found = false;
        const updated = addedVotes.map((item) => {
            if (item.ballot === contestKey && item.contestant === contestant) {
                found = true;
                const nextAdd = Math.max(0, (parseInt(item.add) || 0) + delta);
                return { ...item, add: nextAdd };
            }
            return item;
        });

        const withInsert = (!found && delta > 0)
            ? [...updated, { ballot: contestKey, contestant, add: delta }]
            : updated;

        setVotingdata({ ...votingdata, added_votes: withInsert });
        sendVotingUpdate({ added: withInsert, post_id: post_id, identifier: identifier });
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
    useEffect(() => { scrolltoId(scrollTo); },[])
    const { isLoading, isFetching, isSuccess, isError, data, error, refetch} = useVoting(identifier, post_id, setVotingdata);
    if(isError)
        return <p>Error loading agenda data. Try <a href={window.location.href}>reloading the page</a>. You can also <a href={(window.location.href.indexOf('?') > 0) ? window.location.href +'&revert=1' : window.location.href +'?revert=1'}>use the old version of the signup form</a>.</p>
    if((isLoading || isFetching) && !data) {
        console.log('isLoading',isLoading);
        console.log('isFetching',isFetching);
        return <p>Loading ...</p>
    }
    if (!votingdata.ballot) {
        return <p>Loading ...</p>;
    }

    const contestlist = Object.keys(votingdata.ballot);

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
            <p style={styles.h1}>{mytranslate('Vote Counter\'s Tool',votingdata)}: {mytranslate('Ballot Setup',votingdata)}</p>
            <div style={{display:'flex',flex:1,flexDirection:'row'}}>
            {copied ? <button style={styles.button} ><span style={{color:'green',backgroundColor:'white',padding:'5px'}}>{mytranslate('Copied!',votingdata)}</span></button> : <CopyToClipboard text={mytranslate('Please vote using the link below. For subsequent votes, click "Refresh" if the ballot of choices is not displayed')+"\n\n"+votingdata.url} onCopy={() => {setCopied(true); setTimeout(() => {setCopied(false)},9000)}} >
            <button style={styles.button}><span style={styles.buttonText}>{mytranslate('Copy Voting Link',votingdata)}</span></button>
            </CopyToClipboard>}
                <button style={styles.button} onClick={() => {setControls('counting')}}><span style={styles.buttonText}>{mytranslate('Vote Count',votingdata)}</span></button> <button style={styles.button} onClick={() => {setControls('ballot')}}><span style={styles.buttonText}>Ballot</span></button> <button style={styles.button} onClick={() => {refetch()}}><span style={styles.buttonText}>Refresh</span></button>
            </div>
            
                {contestlist.map(
                (c, cindex) => {
                    if(('Template' == c) || ('C' == c) || ('c' == c))
                        return;
                    const currentBallot = votingdata.ballot[c];
                    return <div key={'contest'+cindex}>
                        <p style={styles.h2}>{c}</p>
                        {currentBallot.contestants.map((contestant,index) => {return <p key={'contestant'+index}><button style={styles.minusbutton} onClick={() => {updateContestBallot(c, (ballot) => ({...ballot, contestants: ballot.contestants.filter((_, i) => i !== index), deleted: [...(ballot.deleted || []), contestant]}));}}><span style={styles.buttonText}>-</span></button> {contestant}</p>})}
                        {currentBallot.new.length ? <div><p>Pending:</p>{currentBallot.new.map((maybecontestant,index) => {return <p key={'pending'+index}><button style={styles.plusbutton} onClick={() => {updateContestBallot(c, (ballot) => ({...ballot, contestants: [...ballot.contestants, maybecontestant], new: ballot.new.filter((_, i) => i !== index)}));}}><span style={styles.buttonText}>+</span></button> {maybecontestant}</p>})}</div> : null}
                        {currentBallot.deleted.length ? <div><p>Deleted:</p>{currentBallot.deleted.map((deletedcontestant,index) => {return <p key={'deleted'+index} style={{textDecoration:'line-through'}}><button style={styles.plusbutton} onClick={() => {updateContestBallot(c, (ballot) => ({...ballot, contestants: [...ballot.contestants, deletedcontestant], deleted: ballot.deleted.filter((_, i) => i !== index)}));}}><span style={styles.buttonText}>+</span></button> {deletedcontestant}</p>})}</div> : null}
                        <p><SelectCtrl label="Member to Add" value={candidate} options={[memberDefault,...votingdata.memberlist]} onChange={(choice) => { if(!choice) return; updateContestBallot(c, (ballot) => ({...ballot, contestants: [...ballot.contestants, choice]}), true); } } /></p>
                        <div style={{display: 'flex',flex:1,flexDirection:'row'}}><div><TextControl label="Type Choice to Add" value={guest} onChange={ (value) => { setGuest(value); } } /></div><div style={{padding: '20px'}}><button style={styles.plusbutton} onClick={() => { const nextGuest = guest ? guest.trim() : ''; if(!nextGuest) return; updateContestBallot(c, (ballot) => ({...ballot, contestants: [...ballot.contestants, nextGuest]}), true); setGuest(''); }}><span style={styles.buttonText}>+</span></button></div></div>                    
                        <p><ToggleControl label={mytranslate('Require Signature',votingdata)} help={
                                (true == currentBallot.signature_required)
                                    ? mytranslate('Vote must be "signed" by a logged in member',votingdata)
                                    : mytranslate('Anonymous voting is allowed',votingdata)
                            }
                            checked={ currentBallot.signature_required }
                        onChange={ () => { const ballotCopy = {...currentBallot}; ballotCopy.signature_required = !currentBallot.signature_required; console.log('modified ballot',ballotCopy); const ballots = {...votingdata.ballot}; ballots[c] =ballotCopy; console.log('modified ballots',ballots); const votingCopy = {...votingdata, ballot: ballots}; console.log('modified voting data',votingCopy); setVotingdata(votingCopy);}} /></p>
                        {currentBallot.status == 'publish' ? <div><p><button style={styles.button} onClick={() => { const update = {...currentBallot,status:'draft'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier});} }><span style={styles.buttonText}>Unpublish</span></button></p>                        
                        {copied ? <button style={styles.button} ><span style={{color:'green',backgroundColor:'white',padding:'5px'}}>{mytranslate('Copied!',votingdata)}</span></button> : <CopyToClipboard text={mytranslate('Please vote using the link below. For subsequent votes, click "Refresh" if the ballot of choices is not displayed')+"\n\n"+votingdata.url} onCopy={() => {setCopied(true); setTimeout(() => {setCopied(false)},9000)}} >
                        <button style={styles.button}><span style={styles.buttonText}>{mytranslate('Copy Voting Link',votingdata)}</span></button>
                        </CopyToClipboard>}
                        </div> 
                        : 
                        <p><button style={styles.button} onClick={() => { const update = {...currentBallot,status:'publish'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier}); setCopied(false);} }><span style={styles.buttonText}>{mytranslate('Publish',votingdata)}</span></button></p>
                        }
                    </div>
                }
            )}
            <p style={styles.h2}>{mytranslate('New Ballot',votingdata)}</p>
            <div><TextControl label="Contest or Question" value={newBallot} onChange={ (value) => { setNewBallot(value); } } /></div><div style={{padding: '20px'}}>
            <p><ToggleControl label={mytranslate('Include for Every Meeting',votingdata)}                            help={
                                (everyMeeting)
                                    ? mytranslate('Included on ballot for every meeting',votingdata)
                                    : mytranslate('Only for this meeting',votingdata)
                            }
                            checked={ everyMeeting }
                        onChange={ () => { setEveryMeeting(previousValue => !previousValue);}} /></p>
            <p><ToggleControl label={mytranslate('Require Signature',votingdata)}                            help={
                    (signatureRequired)
                        ? mytranslate('Vote must be "signed" by a logged in member',votingdata)
                        : mytranslate('Anonymous voting is allowed',votingdata)
                }
                checked={ signatureRequired }
            onChange={ () => { setSignatureRequired(prev => !prev) }} /></p>
            <p><ToggleControl label={mytranslate('Make choices Yes/No/Abstain',votingdata)}                            help={
                                (yesNo)
                                    ? mytranslate('Choices will default to Yes/No/Abstain',votingdata)
                                    : mytranslate('Choices to be entered',votingdata)
                            }
                            checked={ yesNo }
                        onChange={ () => { setYesNo(previousValue => !previousValue);}} /></p>
            <button style={styles.button} onClick={() => {const newBallotEntry = {...votingdata.ballot}; newBallotEntry[newBallot] = {...votingdata.ballot.Template,signature_required:signatureRequired,everyMeeting: everyMeeting,contestants: (yesNo) ? ['Yes','No','Abstain'] : [] }; console.log('newBallotEntry',newBallotEntry); setVotingdata({...votingdata,ballot:newBallotEntry}); setNewBallot('');}}><span style={styles.buttonText}>{mytranslate('Add Ballot',votingdata)}</span></button></div>
            {contestlist.map(
                (c, cindex) => {
                    if(('Template' == c) || ('C' == c) || ('c' == c))
                        return;
                    const currentBallot = votingdata.ballot[c];
                    if(currentBallot.status != 'publish' || currentBallot.signature_required)
                        return;

                    const added_votes = Array.isArray(votingdata.added_votes) ? votingdata.added_votes : [];
                    return <div key={'contestadd'+cindex}>
                        <p style={styles.h2}>{mytranslate('Add Votes',votingdata)}: {c}</p>
                        <p>If you received votes from outside of this app, you can add them here.</p>
                        {currentBallot.contestants.map((contestant,index) => {const addvote = added_votes.find((item) => item.ballot == c && item.contestant == contestant); const addAmount = addvote ? addvote.add : 0;
                        return <p key={'addvotes'+index}>
                        <button style={styles.plusbutton} onClick={() => {updateAddedVotes(c, contestant, 1);} }><span style={styles.buttonText}>+</span></button> 
                        <button style={styles.minusbutton} onClick={() => {if(addAmount > 0) updateAddedVotes(c, contestant, -1);} }><span style={styles.buttonText}>-</span></button> 
                        {contestant} +{addAmount}</p>})}
                        </div>
                }
            )}
            {(votingdata.open_club_ballots && votingdata.open_club_ballots.length) ? <div>
                <p style={styles.h2}>{mytranslate('Close Ballots (Signed Votes)',votingdata)}</p>
                <p>{mytranslate('Once you have received the required number of votes, close the voting. Voting results will be saved as a club minutes document on the website.',votingdata)}</p>
                <SelectCtrl label={mytranslate('Select Ballot to Close',votingdata)} value={close} options={[{'value':0,'label':'Select Ballot to Close'},...votingdata.open_club_ballots]} onChange={(choice) => { setClose(choice); console.log('setClose',close); } } />
                <p><button style={styles.button} onClick={() => { const update = {...votingdata,close_ballot:close}; setVotingdata(update); sendVotingUpdate({close_ballot:close,post_id:post_id,identifier:identifier}); setClose({'value':0,'label':'Select Ballot to Close'}) } }><span style={styles.buttonText}>{mytranslate('Close',votingdata)}</span></button></p>
                </div> : null
            }
            <p style={styles.h2}>{mytranslate('Reset',votingdata)}</p>
            <p><button style={styles.button} onClick={() => { sendVotingUpdate({reset:true,post_id:post_id,identifier:identifier});} }><span style={styles.buttonText}>{mytranslate('Reset Ballot',votingdata)}</span></button></p>
        </div>
        );
    }    

    let openBallots = false;
    return (
        <div>
            <p style={styles.h1}>{mytranslate('Voting',votingdata)}</p>
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
                    <h3>✔ Voted</h3>
                    </div>)
                    if(currentBallot.signature_required && !votingdata.authorized_user) {
                        return (<div key={'contest'+cindex}>
                            <p style={styles.h2}>{c}</p>
                            <p style={{color:'red'}}>{mytranslate('You must be logged in to vote on this question',votingdata)}</p>
                            <p><a href={votingdata.login_url}>{mytranslate('Please login',votingdata)}</a></p>
                        </div>)
                    }
                    return (<div key={'contest'+cindex}>
                        <p style={styles.h2}>{c}</p>
                        {currentBallot.contestants.length ? <p>{mytranslate('Vote for',votingdata)}:</p> : null}
                        {currentBallot.contestants.map((contestant,index) => {return <div key={'contestant'+index}><p><button style={{backgroundColor: 'black',padding:'10px'}} onClick={() => {const vote = {'vote':contestant,'key':c,identifier:identifier,post_id:currentBallot.post_id ? currentBallot.post_id : post_id,signature:(currentBallot.signature_required) ? votingdata.current_user_name : ''}; console.log('vote',vote); sendVotingUpdate(vote);} }><span style={styles.buttonText}>{mytranslate('Vote for',votingdata)}</span></button> {contestant}</p></div>})}
                        {currentBallot.signature_required ? <p style={{style:'italic'}}>{mytranslate('Vote will be recorded as signed by',votingdata)+' '+votingdata.current_user_name}</p> : null}
                    </div>)
                }
            )}
            {!votingdata.is_vote_counter && !openBallots ? 
            <div><p>Current vote counter: "{votingdata.vote_counter_name}." No ballots have been created yet.</p>
            {!votingdata.vote_counter_logged_in ? <div>
                <p style={styles.h2}>Assume the role of Vote Counter?</p>
            <p>If no Vote Counter is available, any member can assume the role.</p>
            {votingdata.authorized_user ? <p><button style={styles.button} onClick={() => {sendVotingUpdate({post_id:post_id,identifier:identifier,take_vote_counter:true}) }}><span style={styles.buttonText}>Take Vote Counter Role</span></button></p> : <p><a href={votingdata.login_url}>Please login first</a></p>}
            </div>
                 : null}            
            </div> : null}
            {votingdata.is_vote_counter ? <div><p style={styles.h2}>Back to Vote Counter Controls?</p>
            <p><button style={styles.button} onClick={() => {setControls('')} }><span style={styles.buttonText}>Go Back</span></button></p></div> : null}
        </div>
    );
}
