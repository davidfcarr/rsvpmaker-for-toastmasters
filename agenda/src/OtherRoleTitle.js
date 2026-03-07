import {useState} from "react"
import {TextControl } from '@wordpress/components';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';
import { __ } from '@wordpress/i18n';

export default function OtherRoleTitle(props) {
    console.log('OtherRoleTitle props', props);
    const [title, setTitle] = useState(props.assignment.title);
    const wpt_rest = useRsvpmakerRest();
    function updateTitle() {
        let newrole = {...props.assignment, ...props.attrs, 'roleindex': props.roleindex, 'blockindex': props.blockindex, 'title':title};
        props.updateAssignment(newrole);
    }

    return (

        <>

        <p><strong>{__('Note or Title','rsvpmaker-for-toastmasters')}</strong> <TextControl value={title} onChange={(value) => {setTitle(value); }} onMouseLeave={() => updateTitle()} /></p>

        <p><button className="tmform" onClick={updateTitle}>{__('Save','rsvpmaker-for-toastmasters')}</button></p>

        </>

    )

}

