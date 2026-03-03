/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { __experimentalNumberControl as NumberControl, TextControl, ToggleControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ attributes, attributes: { title, limit, showlog, showmore, dateformat }, setAttributes, isSelected, className, clientId }) {

const dates = [];
for(let i=1; i <= limit; i++) {
    dates.push(<div ><div class="meetinglinks"><a class="meeting" href="#">Toastmasters Meeting Jan {i}</a></div></div>);
} 

    return (

<div { ...useBlockProps() }>
{title && <h5 class="member-access-title">{title}</h5>}	  
<ul class="member-access-prompts">
<li class="widgetsignup">Member sign up for roles:
{dates}
{showmore && <div id="showmorediv"><a href="#" id="showmore">Show More</a></div>}
</li>
<li>Your membership:<div><a href="#">Edit Member Profile</a></div><div><a href="#">Member Dashboard</a></div></li>
{showlog && <li><strong>Activity</strong><br />
<div><strong>Demo Member:</strong> signed up for Toastmaster of the Day for December 1st, 2022 <small><em>(Posted: 11/06/22 13:25)</em></small></div>
<div><strong>Demo Member:</strong> signed up for Speaker for February 1st, 2023 <small><em>(Posted: 11/06/22 13:30)</em></small></div>
</li>}
</ul>
<InspectorControls key="memberoptions">
            <TextControl
        label="Title"
        value={ title }
        onChange={ ( title ) => setAttributes( { title } ) }
    />
        <NumberControl
                label={ __( 'Number of Meetings Shown', 'rsvpmaker-for-toastmasters' ) }
                min={0}
                value={ limit }
                onChange={ ( limit ) => setAttributes({ limit }) }
            />
            <NumberControl
                label={ __( 'Show More Number', 'rsvpmaker-for-toastmasters' ) }
                min={0}
                value={ showmore }
                onChange={ ( showmore ) => setAttributes({ showmore }) }
            />
        <ToggleControl
            label="Show Activity Log"
            help={
                showlog
                    ? 'Show'
                    : 'Do not show'
            }
            checked={ showlog }
			onChange={ (showlog) => setAttributes( {showlog} ) }
		/>
<TextControl
        label="Date Format"
        value={ dateformat }
        onChange={ ( dateformat ) => setAttributes( { dateformat } ) }
    />
    <p><a href="https://www.php.net/manual/en/datetime.format.php" target="_blank">Uses PHP date format codes</a></p>
</InspectorControls>
</div>
	);
}
