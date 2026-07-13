import { useSelect } from '@wordpress/data';
import { useRsvpmakerRest } from './useRsvpmakerRest.js';

function parseHoursMinutes(value) {
	if (!value) {
		return null;
	}

	const text = String(value).trim();
	const twentyFourHour = text.match(/(\d{1,2}):(\d{2})(?::\d{2})?/);
	if (twentyFourHour) {
		const hours = parseInt(twentyFourHour[1], 10);
		const minutes = parseInt(twentyFourHour[2], 10);
		if (Number.isInteger(hours) && Number.isInteger(minutes) && hours >= 0 && hours <= 23 && minutes >= 0 && minutes <= 59) {
			return { hours, minutes };
		}
	}

	const meridiem = text.match(/(\d{1,2}):(\d{2})\s*([AaPp][Mm])/);
	if (!meridiem) {
		return null;
	}

	let hours = parseInt(meridiem[1], 10);
	const minutes = parseInt(meridiem[2], 10);
	const marker = meridiem[3].toLowerCase();

	if (!Number.isInteger(hours) || !Number.isInteger(minutes) || minutes < 0 || minutes > 59 || hours < 1 || hours > 12) {
		return null;
	}

	if (marker === 'pm' && hours < 12) {
		hours += 12;
	}
	if (marker === 'am' && hours === 12) {
		hours = 0;
	}

	return { hours, minutes };
}

function getStartTime(rest) {
	const rawDate = rest?.date || rest?.datetime || '';
	const normalizedDate = String(rawDate).replace(' ', 'T');
	const parsed = new Date(normalizedDate);

	if (!Number.isNaN(parsed.getTime())) {
		return parsed;
	}

	const fallbackSources = [
		rawDate,
		rest?.start_time,
		rest?.time,
		rest?.meeting_time,
		rest?.start,
	];

	const now = new Date();
	now.setSeconds(0, 0);

	for (const source of fallbackSources) {
		const hm = parseHoursMinutes(source);
		if (!hm) {
			continue;
		}
		now.setHours(hm.hours, hm.minutes, 0, 0);
		return now;
	}

	now.setHours(0, 0, 0, 0);
	return now;
}

export default function EndTime() {
	const rsvpmaker_rest = useRsvpmakerRest();
	const start_time = getStartTime(rsvpmaker_rest);

	const allBlocks = useSelect((select) => select('core/block-editor').getBlocks(), []);

	let total_time = 0;
    allBlocks.forEach((block) => {
        if (block.attributes && typeof block.attributes.time_allowed !== 'undefined') {
	        total_time += parseInt(block.attributes.time_allowed, 10) || 0;
		}
        if (block.attributes && typeof block.attributes.padding_time !== 'undefined') {
	        total_time += parseInt(block.attributes.padding_time, 10) || 0;
		}
    });
	const end_time = new Date(start_time.getTime() + total_time * 60000);
	const formatted_time = (rsvpmaker_rest.hour12) ? end_time.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true }) : end_time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
	return <div className="endtime">Estimated meeting end time: {formatted_time}</div>;
}
