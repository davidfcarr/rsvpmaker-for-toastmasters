function isValidDate(value) {
	return value instanceof Date && !Number.isNaN(value.getTime());
}

function parseHoursMinutes(value) {
	if (!value && value !== 0) {
		return null;
	}

	const text = String(value).trim();
	const match = text.match(/^(\d{1,2}):(\d{1,2})(?::(\d{1,2}))?$/);
	if (!match) {
		return null;
	}

	const hours = parseInt(match[1], 10);
	const minutes = parseInt(match[2], 10);
	const seconds = match[3] ? parseInt(match[3], 10) : 0;

	if (
		!Number.isInteger(hours) ||
		!Number.isInteger(minutes) ||
		!Number.isInteger(seconds) ||
		hours < 0 ||
		hours > 23 ||
		minutes < 0 ||
		minutes > 59 ||
		seconds < 0 ||
		seconds > 59
	) {
		return null;
	}

	return { hours, minutes, seconds };
}

function parseDateCandidate(rawValue) {
	if (!rawValue) {
		return null;
	}

	const value = String(rawValue).trim();
	if (!value) {
		return null;
	}

	const direct = new Date(value);
	if (isValidDate(direct)) {
		return direct;
	}

	const normalized = new Date(value.replace(' ', 'T'));
	if (isValidDate(normalized)) {
		return normalized;
	}

	const fullDateTime = value.match(/^(\d{4})-(\d{1,2})-(\d{1,2})[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?$/);
	if (fullDateTime) {
		const year = parseInt(fullDateTime[1], 10);
		const month = parseInt(fullDateTime[2], 10);
		const day = parseInt(fullDateTime[3], 10);
		const hours = parseInt(fullDateTime[4], 10);
		const minutes = parseInt(fullDateTime[5], 10);
		const seconds = fullDateTime[6] ? parseInt(fullDateTime[6], 10) : 0;

		const parsed = new Date(year, month - 1, day, hours, minutes, seconds, 0);
		if (isValidDate(parsed)) {
			return parsed;
		}
	}

	const hm = parseHoursMinutes(value);
	if (hm) {
		const today = new Date();
		today.setHours(hm.hours, hm.minutes, hm.seconds, 0);
		return today;
	}

	return null;
}

export function getAgendaStartDate(data) {
	const candidates = [
		data?.datetime,
		data?.date,
		data?.start_time,
		data?.time,
		data?.meeting_time,
		data?.start,
	];

	for (const candidate of candidates) {
		const parsed = parseDateCandidate(candidate);
		if (parsed) {
			return parsed;
		}
	}

	const templateHour = data?.is_template?.hour;
	const templateMinutes = data?.is_template?.minutes;
	const templateTime = parseHoursMinutes(`${templateHour ?? ''}:${templateMinutes ?? ''}`);

	const fallback = new Date();
	fallback.setSeconds(0, 0);

	if (templateTime) {
		fallback.setHours(templateTime.hours, templateTime.minutes, templateTime.seconds, 0);
	} else {
		fallback.setHours(0, 0, 0, 0);
	}

	return fallback;
}