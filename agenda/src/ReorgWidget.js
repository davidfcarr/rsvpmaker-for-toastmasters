import {useState} from "react"

import { ToggleControl } from '@wordpress/components';

import DeleteButton from "./Delete.js";

import {Inserter} from "./Inserter.js";

import {Up, Down} from './icons.js';

import {updateAgenda} from './queries.js';

import {SelectCtrl, NumberCtrl} from './Ctrl.js'

export default function ReorgWidget(props) {

    const {data, post_id, makeNotification, block, blockindex, setMode, setShowControls} = props;

    const [sync,setSync] = useState(true);
    const {mutate:agendaMutate} = updateAgenda(post_id, makeNotification,Inserter);

    function commitAgenda(blocksdata, extra = {}) {
        agendaMutate({ ...data, ...extra, blocksdata });
    }

    function updateBlockAttrs(targetBlockIndex, attrsPatch) {
        if (!Array.isArray(data.blocksdata)) {
            return;
        }
        const nextBlocks = data.blocksdata.map((b, idx) => {
            if (idx !== targetBlockIndex) {
                return b;
            }
            return {
                ...b,
                attrs: {
                    ...(b.attrs || {}),
                    ...attrsPatch,
                },
            };
        });
        commitAgenda(nextBlocks);
    }

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

        const nextBlocks = Array.isArray(data.blocksdata) ? [...data.blocksdata] : [];

        if(direction == 'delete') {

            nextBlocks.splice(blockindex,1);

        }

        else {

            let currentblock = nextBlocks[blockindex];

            nextBlocks[blockindex] = {'blockName':null};

            nextBlocks.splice(newposition,0,currentblock);

        }

        commitAgenda(nextBlocks, { changed: 'blocks' });

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

        commitAgenda(newblocks);

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

        commitAgenda(newblocks);

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

    commitAgenda(items);

}

    const moveableBlocks = getMoveAbleBlocks ();

    function syncToEvaluator(blocksdata,count) {

        if(!sync)

            return blocksdata;

        return blocksdata.map((block) => {
            if (block?.attrs?.role !== 'Evaluator') {
                return block;
            }
            return {
                ...block,
                attrs: {
                    ...block.attrs,
                    count,
                    time_allowed: count * 3,
                },
            };
        });

    }    

    function CopyToTemplateButton () {
        return <button className="tmsmallbutton" onClick={() => {agendaMutate({ ...data, copyToTemplate: true });} }>Apply to All</button>
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
                <p className="tmflexrow"><div className="tmflex30"><NumberCtrl label={'Signup Slots ('+roleslug+')'} min="1" value={(block.attrs.count) ? block.attrs.count : 1} onChange={ (value) => { value = Math.abs(parseInt(value)); const baseBlocks = Array.isArray(data.blocksdata) ? data.blocksdata.map((b, idx) => idx === blockindex ? { ...b, attrs: { ...(b.attrs || {}), count: value, time_allowed: ['Speaker','Evaluator'].includes(block.attrs.role) ? calcTimeAllowed({ ...block.attrs, count: value }) : (b.attrs?.time_allowed) } } : b) : []; const syncedBlocks = ['Speaker','Evaluator'].includes(block.attrs.role) ? syncToEvaluator(baseBlocks, value) : baseBlocks; commitAgenda(syncedBlocks); }} /></div><div className="tmflex30"><NumberCtrl label={"Time Allowed ("+roleslug+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { value = Math.abs(parseInt(value)); updateBlockAttrs(blockindex, { time_allowed: value }); }} /></div> {('Speaker' == block.attrs.role) && <div className="tmflex30"><NumberCtrl label="Padding Time" min="0" value={block.attrs.padding_time} onChange={(value) => {value = Math.abs(parseInt(value)); updateBlockAttrs(blockindex, { padding_time: value });}} /></div>}</p>
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
                <p><NumberCtrl label={"Time Allowed (" +block.attrs.editable+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => {value = Math.abs(parseInt(value)); updateBlockAttrs(blockindex, { time_allowed: value }); }} /></p>
            </div>)}
            {'wp4toastmasters/agendanoterich2' == block.blockName && (
                <div>
                <p><NumberCtrl label={"Time Allowed ("+summary+")"} value={(block.attrs?.time_allowed) ? block.attrs?.time_allowed : calcTimeAllowed(block.attrs)} onChange={ (value) => { value = Math.abs(parseInt(value)); updateBlockAttrs(blockindex, { time_allowed: value }); }} /></p>
            </div>)}
            <div className="tmflexrow"><div><button className="blockmove" onClick={() => { moveBlock(blockindex, 'up') } }><Up /></button></div><div><button className="blockmove" onClick={() => { moveBlock(blockindex, 'down') } }><Down /></button></div><div><SelectCtrl label="Move" options={choicesForBlock} onChange={(value) => selectMove(blockindex,value)} /></div></div>
            <div><DeleteButton makeNotification={makeNotification} blockindex={blockindex} moveBlock={moveBlock} post_id={post_id} /> {data.has_template && <>Copy to template and future agendas: <CopyToTemplateButton /></>} </div>                
            <div><Inserter makeNotification={makeNotification} blockindex={blockindex} insertBlock={insertBlock} moveBlock={moveBlock} post_id={post_id} /> </div>
            <div style={{marginTop: '10px'}}><button onClick={() => setShowControls(null)}>Done</button></div>
             </>
    </fieldset>)
}