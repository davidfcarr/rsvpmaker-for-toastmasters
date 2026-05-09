import React, {useState, useEffect, useRef} from "react"

import {TextControl } from '@wordpress/components';

import { Editor } from '@tinymce/tinymce-react';

import {SelectCtrl} from './Ctrl.js'
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import simplifyPastedHtml from "./simplifyPastedHtml.js";

export default function ProjectChooser(props) {

    const [choices, setChoices] = useState([]);

    const [path, setPath] = useState('Path Not Set');

    const [manual, setManual] = useState(props.manual);

    const [project, setProject] = useState((props.project) ? props.project : '');

    const [title, setTitle] = useState(props.title);

    const [display_time, setDisplayTime] = useState(props.display_time);

    const [maxtime, setMaxTime] = useState(props.maxtime);

    const editorRef = useRef(null);
    const wpt_rest = useRsvpmakerRest();

    useEffect( () => {

        fetch(wpt_rest.url + 'rsvptm/v1/paths_and_projects', {headers: {'X-WP-Nonce': wpt_rest.nonce}})

        .then((response) => response.json())

        .then((data) => {

            if(data.paths) {

                setChoices(data);

            } 

        });



        if(props.project)

        {

            startFromProject(props.project);

        }

    },[]);

    useEffect(() => {
        setManual(props.manual ? props.manual : '');
        setProject(props.project ? props.project : '');
        setTitle(props.title ? props.title : '');
        setDisplayTime(props.display_time ? props.display_time : '5 - 7 minutes');
        setMaxTime(props.maxtime ? props.maxtime : 7);
        if (props.project) {
            startFromProject(props.project);
        } else if (props.manual) {
            startFromManual(props.manual);
        } else {
            setPath('Path Not Set');
        }
    }, [props.assignment?.ID]);



    function startFromProject(project) {

        let manual = project.replace(/([\s0-9]+)$/,'');

        startFromManual(manual);

        if(!props.manual && manual)

            setManual(manual);

    }

    function startFromManual(manualValue) {
        if (!manualValue) {
            setPath('Path Not Set');
            return;
        }
        let derivedPath = manualValue.replace(/ Level.+/,'');
        setPath(derivedPath || 'Path Not Set');
    }



    function projectTime(project) {

        let value = (typeof choices['maxtime'][project] == 'undefined') ? '7' : choices['maxtime'][project];

        setMaxTime(value);

        value = (typeof choices['display_time'][project] == 'undefined') ? '5 - 7 minutes' : choices['display_time'][project];

        setDisplayTime(value);

    }



    function updateSpeech(overrides = {}) {

    const currentContent = editorRef.current ? editorRef.current.getContent() : '';
    const simplifiedContent = simplifyPastedHtml(currentContent);

        const nextManual = (typeof overrides.manual !== 'undefined') ? overrides.manual : manual;
        const nextProject = (typeof overrides.project !== 'undefined') ? overrides.project : project;
        const nextTitle = (typeof overrides.title !== 'undefined') ? overrides.title : title;
        const nextMaxTime = (typeof overrides.maxtime !== 'undefined') ? overrides.maxtime : maxtime;
        const nextDisplayTime = (typeof overrides.display_time !== 'undefined') ? overrides.display_time : display_time;
        const nextIntro = (typeof overrides.intro !== 'undefined') ? overrides.intro : simplifiedContent;

        let newrole = {
            ...props.assignment,
            'role': 'Speaker',
            'ID': props.assignment.ID,
            'roleindex': props.roleindex,
            'blockindex': props.blockindex,
            'manual': nextManual,
            'project': nextProject,
            'title': nextTitle,
            'intro': nextIntro,
            'start': props.attrs.start,
            'maxtime': nextMaxTime,
            'display_time': nextDisplayTime,
            'count': props.attrs.count
        };

        props.updateAssignment(newrole);

    }


    if(!choices || typeof choices.manuals == 'undefined')

        return <p>Loading project choices</p>

    return (

        <>

        <div><SelectCtrl options={choices['paths']} value={path} label="Path" onChange={(value) => {
            setPath(value);
            const nextManual = '';
            const nextProject = '';
            setManual(nextManual);
            setProject(nextProject);
            setDisplayTime('5 - 7 minutes');
            setMaxTime(7);
            updateSpeech({ manual: nextManual, project: nextProject, display_time: '5 - 7 minutes', maxtime: 7 });
        }} /></div>

        <div><SelectCtrl options={choices['manuals'][path] ? choices['manuals'][path] : [{'value':'','label':'Choose Path first'}]} value={manual} label="Level" onChange={(value) => {
            const nextManual = value;
            const nextProject = '';
            setManual(nextManual);
            setProject(nextProject);
            setDisplayTime('5 - 7 minutes');
            setMaxTime(7);
            updateSpeech({ manual: nextManual, project: nextProject, display_time: '5 - 7 minutes', maxtime: 7 });
        }} /></div>

        <div><SelectCtrl options={(choices['projects'][manual]) ? choices['projects'][manual] : [{'value':'',label:'Set Path and Level to See Projects'}] } value={project} label="Project" onChange={(value) => {
            setProject(value);
            let nextMaxTime = (typeof choices['maxtime'][value] == 'undefined') ? '7' : choices['maxtime'][value];
            let nextDisplayTime = (typeof choices['display_time'][value] == 'undefined') ? '5 - 7 minutes' : choices['display_time'][value];
            setMaxTime(nextMaxTime);
            setDisplayTime(nextDisplayTime);
            updateSpeech({ project: value, maxtime: nextMaxTime, display_time: nextDisplayTime });
        } } /></div>

        <div className="tmflexrow">

        <div className="tmflex50">

        <TextControl label="Display Time" onChange={(value) => { setDisplayTime(value); updateSpeech({ display_time: value }); } } value={display_time} />

        </div>

        <div className="tmflex50">

        <TextControl label="Maximum Time Allowed" onChange={(value) => { setMaxTime(value); updateSpeech({ maxtime: value }); }} value={maxtime} />

        </div>

        </div>

        <p><strong>Title</strong> <TextControl value={title} onChange={(value) => {setTitle(value); }} onMouseLeave={() => updateSpeech({ title: title })} /></p>

        <p><strong>Intro</strong> 

        <Editor

        onInit={(evt, editor) => editorRef.current = editor}

        initialValue={props.intro}

        init={{

          height: 100,

          menubar: false,

          toolbar: 'undo redo | bold italic | removeformat',

          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'

        }}

      />        

        </p>

        <p><button className="tmform" onClick={updateSpeech}>Save</button></p>

        </>

    )

}

