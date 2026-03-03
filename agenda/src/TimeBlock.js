import { useSelect } from '@wordpress/data';
import { useRsvpmakerRest } from '../../../rsvpmaker/admin/src/queries.js';

export default function TimeBlock({clientId}) {
	const rsvpmaker_rest = useRsvpmakerRest();
	const start_time = new Date(rsvpmaker_rest.date.replace(' ', 'T'));

	const { previousBlocks, nextBlocks } = useSelect((select) => {
	const allBlocks = select('core/block-editor').getBlocks();
	const currentIndex = allBlocks.findIndex(
		(block) => block.clientId === clientId
	);
	console.log('clientId', clientId);
	console.log('currentIndex', currentIndex);
	return {
			previousBlocks: allBlocks.slice(0, currentIndex),
			nextBlocks: allBlocks.slice(currentIndex + 1),
		};
	}, [clientId]);

	let total_time = 0;
    previousBlocks.forEach((block) => {
        if(block.attributes && block.attributes.time_allowed)
        	total_time += parseInt(block.attributes.time_allowed);
        if(block.attributes && block.attributes.padding_time)
        	total_time += parseInt(block.attributes.padding_time);
		const end_time = new Date(start_time.getTime() + total_time * 60000);
    });
	const end_time = new Date(start_time.getTime() + total_time * 60000);
	const formatted_time = (rsvpmaker_rest.hour12) ? end_time.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true }) : end_time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
	return <div className="blocktime">{formatted_time}</div>;
}
