import React, {useState, useEffect, useRef} from "react"

import apiClient from './http-common.js';

import { TextControl, ToggleControl, RadioControl } from '@wordpress/components';

import RoleBlock from "./RoleBlock.js";

import DeleteButton from "./Delete.js";

import {SpeakerTimeCount} from "./SpeakerTimeCount.js";

import {Inserter} from "./Inserter.js";

import {SanitizedHTML} from "./SanitizedHTML.js";

import {EditorAgendaNote} from './EditorAgendaNote.js';

import {SignupNote} from './SignupNote.js';

import {EditableNote} from './EditableNote.js';

import {Up, Down, DownUp} from './icons.js';

import {updateAgenda,copyToTemplate} from './queries.js';

import {SelectCtrl, NumberCtrl} from './Ctrl.js'

export default function ReorgWidget(props) {

    const {data, post_id, makeNotification, block, blockindex, setMode, setShowControls} = props;

    const [sync,setSync] = useState(true);
    const [showall,setShowall] = useState(false);

    const {mutate:agendaMutate} = updateAgenda(post_id, makeNotification,Inserter);
    const {mutate:copyToMutate} = copyToTemplate(post_id, data.has_template);

    let movechoices = [{'label':'Where to?','value':''},{'label':'Move to Top','value':'top'}];

    let label = '';

    let choicesForBlock;

    {data.blocksdata && Array.isArray(data.blocksdata) && data.blocksdata.map((block, blockindex) => {

        if(!block.blockName)

            return null;

        label = 'After: '+block.blockName.replace(/^[^/]+\//,'').replace('agendanoterich2','agenda note');

        if(block.attrs.role)

            label = label.concat(' '+block.attrs.role);

        if(block.attrs.editable)

            label = label.concat(' '+block.attrs.editable);

        if(block.innerHTML)

            label = label.concat(' '+makeExcerpt(block.innerHTML));
        if(label.length > 60)
            label = label.substring(0,60)+'...';
    
        movechoices.push({'value':blockindex,'label':label});

    })}

    choicesForBlock = [];

    movechoices.forEach(

    (choice) => {

        if(choice.value != blockindex)

            choicesForBlock.push(choice);

    });

    function calcTimeAllowed(attrs) {

        let time_allowed = 0;

        let count = (attrs.count) ? attrs.count : 1;

        if('Speaker' == attrs.role)

            time_allowed = count * 7;

        if('Evaluator' == attrs.role)

            time_allowed = count * 3;

        return time_allowed;

    }

    function getMoveAbleBlocks () {

        let moveableBlocks = [];

        if(data.blocksdata && Array.isArray(data.blocksdata))

        data.blocksdata.map((block, blockindex) => {

            moveableBlocks.push(blockindex);

        })

        return moveableBlocks;

    }

    function moveBlock(blockindex, direction = 'up') {

        if((blockindex == 0) && (direction == 'up'))

            return; // ignore

        let moveableBlocks = getMoveAbleBlocks();

        let newposition = parseInt(direction);//in case it's a number

        let foundindex = moveableBlocks.indexOf(blockindex);

        if(direction == 'up')

            newposition = moveableBlocks[foundindex - 1];

        else if(direction == 'down')

            newposition = moveableBlocks[foundindex + 2];

        if(direction == 'delete') {

            data.blocksdata.splice(blockindex,1);

        }

        else {

            let currentblock = data.blocksdata[blockindex];

            data.blocksdata[blockindex] = {'blockName':null};

            data.blocksdata.splice(newposition,0,currentblock);

        }

        

        data.changed = 'blocks';

        agendaMutate(data);

    }



    function insertBlock(blockindex, attributes={}, blockname = 'wp4toastmasters/role',innerHTML='', edithtml='') {

        let newblocks = [];

        if(Array.isArray(data.blocksdata))

        data.blocksdata.forEach(

            (block, index) => {

                newblocks.push(block);

                if(index == blockindex) {

                    newblocks.push({'blockName': blockname, 'assignments': [], 'attrs': attributes,'innerHTML':innerHTML,'edithtml':edithtml});

                }

            }

        );

        data.blocksdata = newblocks;

        agendaMutate(data);

    }

    function replaceBlock(blockindex, newblock) {

        let newblocks = [];

        data.blocksdata.forEach(

            (block, index) => {

                

                if(index == blockindex) {

                    newblocks.push(newblock);

                }

                else {

                    newblocks.push(block);

                }

            }

        );

        data.blocksdata = newblocks;

        agendaMutate(data);

    }



    function makeExcerpt(html) {

        let excerpt =  html.replaceAll(/<[^>]+>/g,' ');
        excerpt = excerpt.trim();
        if(excerpt.length > 60)
        excerpt = excerpt.substring(0,60) + '...';

        return excerpt;

    }


function selectMove(source,destination) {

    console.log('selectMove '+source+' to '+destination);

    const items = [];

    let myblock = data.blocksdata[source];

    console.log('drag source',source);

    console.log('drag destination',destination);

    if('top' == destination) {

        items.push(myblock);

        myblock = null;

    }

    data.blocksdata.forEach((block,index) => {

        if(index == source) {

            console.log('selectMove skip '+index);

            return;

        }

        items.push(block);

        if(index == destination) {

            console.log('selectMove insert '+index);

            items.push(myblock);

            myblock = null;

        }

    });

    if(myblock) // something went wrong, add it to the end

        items.push(myblock);

    agendaMutate({...data,blocksdata: items});

}

    const moveableBlocks = getMoveAbleBlocks ();

    function syncToEvaluator(blocksdata,count) {

        if(!sync)

            return blocksdata;

        blocksdata.forEach((block,blockindex) => {

            if('Evaluator' == block.attrs.role) {

                blocksdata[blockindex].attrs.count = count;

                blocksdata[blockindex].attrs.time_allowed = count * 3;    

            }

        } );

        return blocksdata;

    }    

    function CopyToTemplateButton () {
        return <button class="tmsmallbutton" onClick={() => {data.copyToTemplate = true; agendaMutate(data)} }>Apply to All</button>
    }

    let summary = (block.innerHTML) ? block.innerHTML.replace(/<[^>]+>/,'').trim() : '';
    if(summary.length > 20) {
        summary = summary.substring(0,20) + '...';
    }

    let roleslug = (block.attrs.role) ? block.attrs.role : '';
    if(roleslug.length > 12)
        roleslug = roleslug.substr(0,12) + '...';
//             {!showall && <>SET TIMING, MOVE, ADD, DELETE</>}

    return (

        <fieldset className="reorgwidget" >
             <legend>Organize</legend>
             <>
                {'wp4toastmasters/role' == block.blockName && (
                <div>
                <p className="tmflexrow"><div className="tmflex30"><NumberCtrl label={'Signup Slots ('+roleslug+')'} min="1" value={(block.attrs.count) ? block.attrs.count : 1} onChange={ (value) => { data.blocksdata[blockindex].attrs.count = value; if(['Speaker','Evaluator'].includes(block.attrs.role)) { data.blocksdata[blockindex].attrs.time_allowed = calcTimeAllowed(block.attrs); data.blocksdata = syncToEvaluator(data.blocksdata,value); } agendaMutate(data); }} /></div><div className="tmflex30"><NumberCtrl label={"Time Allowed ("+roleslug+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { data.blocksdata[blockindex].attrs.time_allowed = value; agendaMutate(data); }} /></div> {('Speaker' == block.attrs.role) && <div className="tmflex30"><NumberCtrl label="Padding Time" min="0" value={block.attrs.padding_time} onChange={(value) => {data.blocksdata[blockindex].attrs.padding_time = value; agendaMutate(data);}} /></div>}</p>
                {('Speaker' == block.attrs.role) && 
(<div>

<p><ToggleControl label="Sync Number of Speakers and Evaluators"

help={

    (true == sync)

        ? 'Number of evaluators will automatically changed with number of speakers'

        : 'Let me manage this manually'

}

checked={ sync }

onChange={ () => {setSync(!sync);}} /></p>

</div>)}
            </div>)}
            {'wp4toastmasters/agendaedit' == block.blockName && (
                <div>
                <p><NumberCtrl label={"Time Allowed (" +block.attrs.editable+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { data.blocksdata[blockindex].attrs.time_allowed = value; agendaMutate(data); }} /></p>
            </div>)}
            {'wp4toastmasters/agendanoterich2' == block.blockName && (
                <div>
                <p><NumberCtrl label={"Time Allowed ("+summary+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { data.blocksdata[blockindex].attrs.time_allowed = value; agendaMutate(data); }} /></p>
            </div>)}
            <div className="tmflexrow"><div><button className="blockmove" onClick={() => { moveBlock(blockindex, 'up') } }><Up /></button></div><div><button className="blockmove" onClick={() => { moveBlock(blockindex, 'down') } }><Down /></button></div><div><SelectCtrl label="Move" options={choicesForBlock} onChange={(value) => selectMove(blockindex,value)} /></div></div>
            <div><DeleteButton makeNotification={makeNotification} blockindex={blockindex} moveBlock={moveBlock} post_id={post_id} /> {data.has_template && <>Copy to template and future agendas: <CopyToTemplateButton /></>} </div>                
            <div><Inserter makeNotification={makeNotification} blockindex={blockindex} insertBlock={insertBlock} moveBlock={moveBlock} post_id={post_id} /> </div>
            <div style={{marginTop: '10px'}}><button onClick={() => setShowControls(null)}>Done</button></div>
             </>
    </fieldset>)
}