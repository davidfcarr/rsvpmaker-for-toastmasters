import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { useEffect, useState } from '@wordpress/element';
import { SelectControl, ToggleControl, PanelBody } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { useRsvpmakerRest } from '../useRsvpmakerRest.js';
import './editor.scss';

export default function Edit({ attributes, attributes: { identifier,showPicture,pictureSize,pictureShape,nameFontSize,titleFontSize,showEmail,showEmailAlias,showBio,joinedClub,joinedTm,showLinks,showEdAwards,centerHeading }, setAttributes, isSelected, className, clientId }) {
const [options, setOptions] = useState([]);
const [list, setList] = useState([]);
const [profile, setProfile] = useState(null);
const [map, setMap] = useState(null);
const [previousMemberIds, setPreviousMemberIds] = useState(new Set());
const { updateBlockAttributes } = useDispatch( 'core/block-editor' );
const rsvpmaker_rest = useRsvpmakerRest();
const defaultProfileMap = {
	facebook_url: 'Facebook',
	x_url: 'X (Formerly Twitter)',
	linkedin_url: 'LinkedIn',
	bluesky_url: 'Bluesky',
	business_url: 'Business Website',
	user_email: 'Email',
	other_email: 'Other Email',
	toastmasters_id: 'Toastmasters ID',
	education_awards: 'Toastmasters Awards (DTM etc)',
};

useEffect(() => {
const rest_urlendpoint = rsvpmaker_rest.rest_url + 'rsvptm/v1/members/' + identifier + '?pictureSize=' + pictureSize;
console.log('Fetching member profile data from:', rest_urlendpoint);
fetch(rest_urlendpoint, { headers: { 'X-WP-Nonce': rsvpmaker_rest.nonce } }).then(response => response.json())
.then(data => {
	console.log('Fetched member profile data:', data);
	setProfile(data.profile);
	setMap(data.map);
	setOptions(data.options);
	setList(data.list);
})
.catch(error => {
	console.error('Error fetching member profile:', error);
});
}, [identifier, pictureSize]);

const mpBlocks = useSelect( ( select ) => {
	const editor = select( 'core/block-editor' );
	const rootClientId = editor.getBlockRootClientId( clientId );
	const collectMemberProfileBlocks = ( blocks ) => {
		return ( blocks || [] ).flatMap( ( block ) => {
			const nestedMatches = collectMemberProfileBlocks( block.innerBlocks );
			return block.name === 'wp4toastmasters/memberprofile'
				? [ block, ...nestedMatches ]
				: nestedMatches;
		} );
	};

	return collectMemberProfileBlocks( editor.getBlocks( rootClientId ) );
}, [ clientId ] );

const rounding = pictureShape === 'rounded' ? '10px' : pictureShape === 'circle' ? '50%' : '0';
const profileMap = map || defaultProfileMap;
const excludeFromContacts = ['ID', 'toastmasters_id', 'education_awards','joined_club','original_join_date'];

const getMemberId = (member) => member?.ID ?? member?.id ?? member?.user_id ?? null;

useEffect(() => {
	let isActive = true;
	const blockIndex = mpBlocks.findIndex((block) => block.clientId === clientId);
	if (blockIndex <= 0) {
		setPreviousMemberIds(new Set());
		return () => {
			isActive = false;
		};
	}

	const previousBlocks = mpBlocks.slice(0, blockIndex);
	const previousIdentifiers = [
		...new Set(
			previousBlocks
				.map((block) => block?.attributes?.identifier)
				.filter(Boolean)
		),
	];

	if (previousIdentifiers.length === 0) {
		setPreviousMemberIds(new Set());
		return () => {
			isActive = false;
		};
	}

	const fetchPreviousMemberIds = async () => {
		const idSet = new Set();
		await Promise.all(
			previousIdentifiers.map(async (previousIdentifier) => {
				const endpoint = `${rsvpmaker_rest.rest_url}rsvptm/v1/members/${previousIdentifier}?pictureSize=${pictureSize}`;
				try {
					const response = await fetch(endpoint, { headers: { 'X-WP-Nonce': rsvpmaker_rest.nonce } });
					const data = await response.json();
					const priorMembers = [];
					if (Array.isArray(data?.list)) {
						priorMembers.push(...data.list);
					}
					if (Array.isArray(data?.profile?.list)) {
						priorMembers.push(...data.profile.list);
					}
					if (data?.profile && !Array.isArray(data.profile)) {
						priorMembers.push(data.profile);
					}

					priorMembers.forEach((member) => {
						const memberId = getMemberId(member);
						if (memberId !== null && memberId !== undefined && memberId !== '') {
							idSet.add(String(memberId));
						}
					});
				} catch (error) {
					console.error('Error fetching previous member profile:', error);
				}
			})
		);

		if (isActive) {
			setPreviousMemberIds(idSet);
		}
	};

	fetchPreviousMemberIds();

	return () => {
		isActive = false;
	};
}, [mpBlocks, clientId, rsvpmaker_rest.rest_url, rsvpmaker_rest.nonce, pictureSize]);

const renderContactDetails = (member) => {
	if (!showLinks || !member) {
		return null;
	}

	return (
		<div>
			{Object.entries(profileMap).map(([key, label]) => {
				if (excludeFromContacts.includes(key)) return null;
				const value = member?.[key];
				if (!value || (typeof value === 'string' && !value.trim())) {
					return null;
				}

				const isUrl = /^https?:\/\//i.test(value);
				const isEmail = key.includes('email');
				if (isEmail && !showEmail) {
					return null;
				}

				return (
					<div className="contactdetails" key={key}>
						<label>{label}:</label>{' '}
						{isUrl ? (
							<a href={value} target="_blank" rel="noreferrer">{value}</a>
						) : isEmail ? (
							<a href={`mailto:${value}`}>{value}</a>
						) : (
							<span>{value}</span>
						)}
					</div>
				);
			})}
			{joinedClub && member?.joined_club ? <div className="contactdetails"><label>Joined Club:</label> {member.joined_club}</div> : null}
			{joinedTm && member?.original_join_date ? <div className="contactdetails"><label>Joined Toastmasters:</label> {member.original_join_date}</div> : null}
		</div>
	);
};

const renderMemberProfile = (member, keyPrefix = 'member') => {
	if (!member) {
		return null;
	}

	if (typeof member !== 'object') {
		return <div key={keyPrefix}>{String(member)}</div>;
	}

	return (
		<div key={keyPrefix} >
			<div style={{ textAlign: centerHeading ? 'center' : 'left' }}>
			{showPicture ? <div><img src={member?.avatar ?? ''} alt={member?.display_name ?? ''} style={{ borderRadius: rounding }} /></div> : null}
			<h2 style={{ fontSize: nameFontSize }}>{member?.display_name ?? ''}{showEdAwards && member?.education_awards ? `, ${member.education_awards}` : ''}</h2>
			<h3 style={{ fontSize: titleFontSize }}>{member?.title ?? ''}</h3>
			{showEmailAlias && member?.alias ? <p><a href={`mailto:${member.alias}`}>{member.alias}</a></p> : null}
			</div>
			{showBio && member?.description ? <p dangerouslySetInnerHTML={{ __html: member.description.replace(/\n/g, '<br />') }} /> : null}
			{renderContactDetails(member)}
		</div>
	);
};

function syncAttributes() {
	const { identifier: _ignoredIdentifier, ...attributesToCopy } = attributes;
	mpBlocks.forEach( ( block ) => {
		updateBlockAttributes(block.clientId, attributesToCopy);
	});
}

const membersToRender = Array.isArray(list) && list.length > 0
	? list
	: (Array.isArray(profile?.list) ? profile.list : []);

const seenMemberIds = new Set();
const filteredMembersToRender = membersToRender.filter((member) => {
	const memberId = getMemberId(member);
	if (memberId === null || memberId === undefined || memberId === '') {
		return true;
	}
	const key = String(memberId);
	if (previousMemberIds.has(key) || seenMemberIds.has(key)) {
		return false;
	}
	seenMemberIds.add(key);
	return true;
});

const singleProfileId = getMemberId(profile);
const shouldRenderSingleProfile = !singleProfileId || !previousMemberIds.has(String(singleProfileId));

return (			
<div {...useBlockProps()}>
{('any' != identifier) && (list.length === 0 || !list[0]) ? <div>{__('Loading ...', 'rsvpmaker-for-toastmasters')}</div> : null}
{('any' == identifier) ? <div>{__('Choose an option', 'rsvpmaker-for-toastmasters')+'...'}</div> : null}
<div>
{filteredMembersToRender.length > 0
	? filteredMembersToRender.map((item, index) => renderMemberProfile(item, `list-${index}`))
	: (shouldRenderSingleProfile ? renderMemberProfile(profile, 'single-profile') : null)}

<InspectorControls>
	<PanelBody title={ __( 'Member Profile Settings', 'rsvpmaker-for-toastmasters' ) }>
	<SelectControl	
					label={ __( 'Officer Title, Member, or List', 'rsvpmaker-for-toastmasters' ) }
	
					value={ identifier }
	
					onChange={ ( identifier ) => {
						setAttributes( { identifier } );
				} }
					options={ options }	
	/>
	<p><strong>Notes:</strong> Duplicate entries will be filtered out. For example, you can add a profile block for the President or District Director with special formatting, followed by a block that lists all officers, and the featured officer profiles will not be repeated.</p>
	<ToggleControl
		label={ __( 'Show picture', 'rsvpmaker-for-toastmasters' ) }
		checked={ showPicture }
		onChange={ ( showPicture ) => setAttributes( { showPicture } ) }
	/>
	<SelectControl	
					label={ __( 'Picture Size', 'rsvpmaker-for-toastmasters' ) }
	
					value={ pictureSize }
	
					onChange={ ( pictureSize ) => {
						setAttributes( { pictureSize } );
				} }
					options={ [{label: 'Small', value: '100'}, {label: 'Medium', value: '200'}, {label: 'Large', value: '300'}, {label: 'Extra Large', value: '400'}] }	
	/>
	<SelectControl	
					label={ __( 'Picture Shape', 'rsvpmaker-for-toastmasters' ) }
	
					value={ pictureShape }
	
					onChange={ ( pictureShape ) => {
						setAttributes( { pictureShape } );
				} }
					options={ [{label: 'Square', value: 'square'}, {label: 'Rounded Corners', value: 'rounded'}, {label: 'Circle', value: 'circle'}] }	
	/>
	<SelectControl	
					label={ __( 'Font Size for Name', 'rsvpmaker-for-toastmasters' ) }
	
					value={ nameFontSize }
	
					onChange={ ( nameFontSize ) => {
						setAttributes( { nameFontSize } );
				} }
					options={ [{label: 'H2 default', value: ''}, {label: 'Small', value: '1.2rem'}, {label: 'Medium', value: '1.5rem'}, {label: 'Large', value: '2rem'}, {label: 'Extra Large', value: '2.5rem'}] }	
	/>
	<SelectControl	
					label={ __( 'Font Size for Title', 'rsvpmaker-for-toastmasters' ) }
	
					value={ titleFontSize }
	
					onChange={ ( titleFontSize ) => {
						setAttributes( { titleFontSize } );
				} }
					options={ [{label: 'H3 default', value: ''}, {label: 'Small', value: '1.1rem'}, {label: 'Medium', value: '1.3rem'}, {label: 'Large', value: '1.5rem'}, {label: 'Extra Large', value: '2rem'}] }	
	/>
	<ToggleControl
		label={ __( 'Show bio', 'rsvpmaker-for-toastmasters' ) }
		checked={ showBio }
		onChange={ ( showBio ) => setAttributes( { showBio } ) }
	/>
	<ToggleControl
		label={ __( 'Center Heading (name, title, image)', 'rsvpmaker-for-toastmasters' ) }
		checked={ centerHeading }
		onChange={ ( centerHeading ) => setAttributes( { centerHeading } ) }
	/>
	<ToggleControl
		label={ __( 'Show links', 'rsvpmaker-for-toastmasters' ) }
		checked={ showLinks }
		onChange={ ( showLinks ) => setAttributes( { showLinks } ) }
	/>
	<ToggleControl
		label={ __( 'Show email (only shown publicly with user\'s permisson)', 'rsvpmaker-for-toastmasters' ) }
		checked={ showEmail }
		onChange={ ( showEmail ) => setAttributes( { showEmail } ) }
	/>
	<ToggleControl
		label={ __( 'Show email alias', 'rsvpmaker-for-toastmasters' ) }
		checked={ showEmailAlias }
		onChange={ ( showEmailAlias ) => setAttributes( { showEmailAlias } ) }
	/>
	<ToggleControl
		label={ __( 'Show joined TM date', 'rsvpmaker-for-toastmasters' ) }
		checked={ joinedTm }
		onChange={ ( joinedTm ) => setAttributes( { joinedTm } ) }
	/>
	<ToggleControl
		label={ __( 'Show joined club date', 'rsvpmaker-for-toastmasters' ) }
		checked={ joinedClub }
		onChange={ ( joinedClub ) => setAttributes( { joinedClub } ) }
	/>
	<ToggleControl
		label={ __( 'Show education awards', 'rsvpmaker-for-toastmasters' ) }
		checked={ showEdAwards }
		onChange={ ( showEdAwards ) => setAttributes( { showEdAwards } ) }
	/>
<p>Edit officer titles on the <a href={rsvpmaker_rest.admin_url + 'options-general.php?page=wp4toastmasters_settings'}>Settings -&gt; Toastmasters</a> screen.</p>
<p>Member details can be edited on the <a href={rsvpmaker_rest.admin_url + 'users.php'}>Users</a> screen member profiles.</p>
<button className="syncAttributes" onClick={syncAttributes}>{__('Copy to All Member Profile Blocks', 'rsvpmaker-for-toastmasters')}</button>
<p>{__('This will copy the current settings (except officer/list/member selection) to all member profile blocks.', 'rsvpmaker-for-toastmasters')}</p>
</PanelBody>
</InspectorControls>

</div>
</div>
		);
}
