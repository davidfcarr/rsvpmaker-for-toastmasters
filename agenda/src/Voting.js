import React, {useState, useEffect, useRef} from "react"
import {SelectCtrl} from './Ctrl.js'
import {SanitizedHTML} from "./SanitizedHTML.js";
import {useVoting,initVoting} from './queries.js';
import { TextControl, ToggleControl } from '@wordpress/components';
import {CopyToClipboard} from 'react-copy-to-clipboard';
import mytranslate from './mytranslate'

const VOTING_ID_KEY = 'toastmastersVoting';
const MIN_SAVING_INDICATOR_MS = 700;

function readCookie(name) {
    if (typeof document === 'undefined' || !document.cookie) {
        return '';
    }
    const nameEq = name + '=';
    const parts = document.cookie.split(';');
    for (let i = 0; i < parts.length; i++) {
        let c = parts[i].trim();
        if (c.indexOf(nameEq) === 0) {
            return decodeURIComponent(c.substring(nameEq.length));
        }
    }
    return '';
}

function writeCookie(name, value, days = 3650) {
    if (typeof document === 'undefined') {
        return;
    }
    const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
    const secure = (typeof window !== 'undefined' && window.location && window.location.protocol === 'https:') ? '; Secure' : '';
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax${secure}`;
}

function getLocalStorageValue(key) {
    try {
        if (typeof window === 'undefined' || !window.localStorage) {
            return '';
        }
        return window.localStorage.getItem(key) || '';
    } catch (e) {
        return '';
    }
}

function setLocalStorageValue(key, value) {
    try {
        if (typeof window === 'undefined' || !window.localStorage) {
            return;
        }
        window.localStorage.setItem(key, value);
    } catch (e) {
        // Ignore storage write failures (private mode / blocked storage).
    }
}

function generateVotingIdentifier() {
    if (typeof crypto !== 'undefined' && typeof crypto.randomUUID === 'function') {
        return crypto.randomUUID();
    }
    if (typeof crypto !== 'undefined' && typeof crypto.getRandomValues === 'function') {
        const bytes = new Uint8Array(16);
        crypto.getRandomValues(bytes);
        const hex = Array.from(bytes).map((b) => b.toString(16).padStart(2, '0')).join('');
        return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${hex.slice(12, 16)}-${hex.slice(16, 20)}-${hex.slice(20)}`;
    }
    return `${Date.now().toString(36)}-${Math.random().toString(36).slice(2, 14)}`;
}

function getVotingIdentity() {
    const existingLocal = getLocalStorageValue(VOTING_ID_KEY);
    if (existingLocal) {
        return { identifier: existingLocal, source: 'localStorage' };
    }

    const existingCookie = readCookie(VOTING_ID_KEY);
    if (existingCookie) {
        setLocalStorageValue(VOTING_ID_KEY, existingCookie);
        return { identifier: existingCookie, source: 'cookie' };
    }

    const generated = generateVotingIdentifier();
    setLocalStorageValue(VOTING_ID_KEY, generated);
    writeCookie(VOTING_ID_KEY, generated);
    return { identifier: generated, source: 'generated' };
}

function voteIdDebugEnabled() {
    if (typeof window === 'undefined') {
        return false;
    }
    try {
        return new URLSearchParams(window.location.search).get('vote_id_debug') === '1';
    } catch (e) {
        return false;
    }
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
    const [explanation,setExplanation] = useState('Please vote using the link below. For subsequent votes, click "Refresh" if the ballot of choices is not displayed');
    const [savingVoteFor, setSavingVoteFor] = useState('');
    const [savingPublishFor, setSavingPublishFor] = useState('');
    const [addingBallot, setAddingBallot] = useState(false);
    const [closingBallot, setClosingBallot] = useState(false);
    const [resettingBallot, setResettingBallot] = useState(false);
    const identityRef = useRef(getVotingIdentity());
    const identifier = identityRef.current.identifier;
    const identifierSource = identityRef.current.source;

    useEffect(() => {
        if (voteIdDebugEnabled()) {
            console.log('Voting identifier debug', {
                identifier,
                source: identifierSource,
                hasLocalStorage: !!getLocalStorageValue(VOTING_ID_KEY),
                hasCookie: !!readCookie(VOTING_ID_KEY),
            });
        }
    }, [identifier, identifierSource]);

    const styles = {
        button: {minWidth: '120px',backgroundColor: 'black',padding: '10px',borderRadius:'4px', marginRight: '10px'},
        plusbutton: {backgroundColor: 'black',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        minusbutton: {backgroundColor: 'red',padding: '10px',borderRadius:'4px',marginRight: '10px'},
        buttonText: {color:'white'},
        h1: {fontSize: '30px',fontWeight:'bold'},
        h2: {fontSize: '25px'},
    }

    function clearSavingStateWithMinimumDelay(startedAt, clearFn) {
        const elapsed = Date.now() - startedAt;
        const waitMs = Math.max(0, MIN_SAVING_INDICATOR_MS - elapsed);
        setTimeout(() => {
            clearFn();
        }, waitMs);
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
            {copied ? <button style={styles.button} ><span style={{color:'green',backgroundColor:'white',padding:'5px'}}>{mytranslate('Copied!',votingdata)}</span></button> : <CopyToClipboard text={explanation+"\n\n"+votingdata.url} onCopy={() => {setCopied(true); setTimeout(() => {setCopied(false)},9000)}} >
            <button style={styles.button}><span style={styles.buttonText}>{mytranslate('Copy Voting Link',votingdata)}</span></button>
            </CopyToClipboard>}
                <button style={styles.button} onClick={() => {setControls('counting')}}><span style={styles.buttonText}>{mytranslate('Vote Count',votingdata)}</span></button> <button style={styles.button} onClick={() => {setControls('ballot')}}><span style={styles.buttonText}>Ballot</span></button> <button style={styles.button} onClick={() => {refetch()}}><span style={styles.buttonText}>Refresh</span></button>
            </div>
            
                {contestlist.map(
                (c, cindex) => {
                    if(('Template' == c) || ('C' == c) || ('c' == c))
                        return;
                    const currentBallot = votingdata.ballot[c];
                    const ballotIsClosed = currentBallot.status == 'closed';
                    const canCloseSignedBallot = (currentBallot.status == 'publish') && currentBallot.signature_required && currentBallot.ballot_post_id && votingdata.can_close_signed_ballots;
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
                        {ballotIsClosed ? <p style={{fontStyle:'italic'}}>{mytranslate('Voting closed. This ballot cannot be reopened.',votingdata)}</p> : null}
                        {currentBallot.status == 'publish' ? <div><p><button disabled={savingPublishFor !== ''} aria-busy={savingPublishFor === c} style={{...styles.button,opacity:savingPublishFor !== '' ? 0.7 : 1,cursor:savingPublishFor !== '' ? 'wait' : 'pointer'}} onClick={() => { const update = {...currentBallot,status:'draft'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; const startedAt = Date.now(); setSavingPublishFor(c); console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setSavingPublishFor(''))});} }><span style={styles.buttonText}>{savingPublishFor === c ? mytranslate('Unpublishing...',votingdata) : 'Unpublish'}</span></button>
                        {canCloseSignedBallot ? <button disabled={closingBallot} aria-busy={closingBallot} style={{...styles.button,opacity:closingBallot ? 0.7 : 1,cursor:closingBallot ? 'wait' : 'pointer'}} onClick={() => { const startedAt = Date.now(); setClosingBallot(true); sendVotingUpdate({close_ballot:currentBallot.ballot_post_id,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setClosingBallot(false))});}}><span style={styles.buttonText}>{closingBallot ? mytranslate('Closing...',votingdata) : mytranslate('Close Voting',votingdata)}</span></button> : null}
                        </p>
                        {savingPublishFor === c ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving ballot status...',votingdata)}</p> : null}
                        {closingBallot && canCloseSignedBallot ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving closed ballot...',votingdata)}</p> : null}
                        {copied ? <button style={styles.button} ><span style={{color:'green',backgroundColor:'white',padding:'5px'}}>{mytranslate('Copied!',votingdata)}</span></button> : <CopyToClipboard text={explanation+"\n\n"+(currentBallot.signature_required ? votingdata.signed_ballot_link : votingdata.url)} onCopy={() => {setCopied(true); setExplanation(''); setTimeout(() => {setCopied(false)},9000)}} >
                        <button style={styles.button}><span style={styles.buttonText}>{(currentBallot.signature_required ? mytranslate('Copy Signed Ballot Link',votingdata) : mytranslate('Copy Voting Link',votingdata))}</span></button>
                        </CopyToClipboard>}
                        </div>
                        : (ballotIsClosed ? null :
                        <div>
                        <p><button disabled={savingPublishFor !== ''} aria-busy={savingPublishFor === c} style={{...styles.button,opacity:savingPublishFor !== '' ? 0.7 : 1,cursor:savingPublishFor !== '' ? 'wait' : 'pointer'}} onClick={() => { const update = {...currentBallot,status:'publish'}; const bigUpdate = {...votingdata.ballot}; bigUpdate[c] = update; const startedAt = Date.now(); setSavingPublishFor(c); console.log('ballot update for '+c,bigUpdate); sendVotingUpdate({ballot:bigUpdate,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setSavingPublishFor(''))}); setCopied(false);} }><span style={styles.buttonText}>{savingPublishFor === c ? mytranslate('Publishing...',votingdata) : mytranslate('Publish',votingdata)}</span></button></p>
                        {savingPublishFor === c ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving ballot status...',votingdata)}</p> : null}
                        </div>)
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
            <button disabled={addingBallot} aria-busy={addingBallot} style={{...styles.button,opacity:addingBallot ? 0.7 : 1,cursor:addingBallot ? 'wait' : 'pointer'}} onClick={() => { const ballotName = newBallot ? newBallot.trim() : ''; if(!ballotName || addingBallot) return; const newBallotEntry = {...votingdata.ballot}; newBallotEntry[ballotName] = {...votingdata.ballot.Template,signature_required:signatureRequired,everyMeeting: everyMeeting,contestants: (yesNo) ? ['Yes','No','Abstain'] : [] }; console.log('newBallotEntry',newBallotEntry); setVotingdata({...votingdata,ballot:newBallotEntry}); const startedAt = Date.now(); setAddingBallot(true); sendVotingUpdate({ballot:newBallotEntry,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setAddingBallot(false))}); setNewBallot('');}}><span style={styles.buttonText}>{addingBallot ? mytranslate('Adding ballot...',votingdata) : mytranslate('Add Ballot',votingdata)}</span></button>
            {addingBallot ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving new ballot...',votingdata)}</p> : null}
            </div>
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
                <p><button disabled={closingBallot} aria-busy={closingBallot} style={{...styles.button,opacity:closingBallot ? 0.7 : 1,cursor:closingBallot ? 'wait' : 'pointer'}} onClick={() => { if(closingBallot) return; const update = {...votingdata,close_ballot:close}; setVotingdata(update); const startedAt = Date.now(); setClosingBallot(true); sendVotingUpdate({close_ballot:close,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setClosingBallot(false))}); setClose({'value':0,'label':'Select Ballot to Close'}) } }><span style={styles.buttonText}>{closingBallot ? mytranslate('Closing...',votingdata) : mytranslate('Close',votingdata)}</span></button></p>
                {closingBallot ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving closed ballot...',votingdata)}</p> : null}
                </div> : null
            }
            <p style={styles.h2}>{mytranslate('Reset',votingdata)}</p>
            <p><button disabled={resettingBallot} aria-busy={resettingBallot} style={{...styles.button,opacity:resettingBallot ? 0.7 : 1,cursor:resettingBallot ? 'wait' : 'pointer'}} onClick={() => { if(resettingBallot) return; const startedAt = Date.now(); setResettingBallot(true); sendVotingUpdate({reset:true,post_id:post_id,identifier:identifier},{onSettled:() => clearSavingStateWithMinimumDelay(startedAt,() => setResettingBallot(false))});} }><span style={styles.buttonText}>{resettingBallot ? mytranslate('Resetting...',votingdata) : mytranslate('Reset Ballot',votingdata)}</span></button></p>
            {resettingBallot ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving reset...',votingdata)}</p> : null}
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
                        {currentBallot.contestants.map((contestant,index) => {
                            const voteButtonKey = c+'::'+contestant;
                            const thisVoteIsSaving = savingVoteFor === voteButtonKey;
                            const anyVoteSaving = savingVoteFor !== '';
                            return <div key={'contestant'+index}><p><button disabled={anyVoteSaving} aria-busy={thisVoteIsSaving} style={{backgroundColor: 'black',padding:'10px',opacity:anyVoteSaving ? 0.7 : 1,cursor:anyVoteSaving ? 'wait' : 'pointer'}} onClick={() => {const vote = {'vote':contestant,'key':c,identifier:identifier,post_id:currentBallot.post_id ? currentBallot.post_id : post_id,signature:(currentBallot.signature_required) ? votingdata.current_user_name : ''}; setSavingVoteFor(voteButtonKey); console.log('vote',vote); sendVotingUpdate(vote,{onSettled:() => setSavingVoteFor('')});} }><span style={styles.buttonText}>{thisVoteIsSaving ? mytranslate('Saving vote...',votingdata) : mytranslate('Vote for',votingdata)}</span></button> {contestant}</p></div>
                        })}
                        {savingVoteFor !== '' ? <p style={{fontStyle:'italic'}}>{mytranslate('Saving your vote...',votingdata)}</p> : null}
                        {currentBallot.signature_required ? <p style={{style:'italic'}}>{mytranslate('Vote will be recorded as signed by',votingdata)+' '+votingdata.current_user_name}</p> : null}
                    </div>)
                }
            )}
            {'tmminutes' == votingdata.post_type && votingdata.recent_closed_signed_ballot_titles.length ? <div><h3>Voting Closed</h3>{votingdata.recent_closed_signed_ballot_titles.map((title,index) => <p key={'closed'+index}>{title}</p>)}</div> : null }
            {!votingdata.is_vote_counter && 'rsvpmaker' == votingdata.post_type && !openBallots ? 
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
