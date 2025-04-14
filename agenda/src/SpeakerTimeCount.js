import React, { useState } from "react";
import mytranslate from './mytranslate'

export function SpeakerTimeCount(props) {
    const { attrs, assignments, makeNotification, data } = props.block;
    const [warningGiven, setWarningGiven] = useState(false);

    if (attrs.role != 'Speaker') return null;

    const { time_allowed, count } = attrs;
    const time_allowed_text = time_allowed ? mytranslate(' out of ', data) + time_allowed + mytranslate(' allowed', data) : '';
    let totaltime = 0;

    Array.isArray(assignments) &&
        assignments.forEach((assignment, aindex) => {
            if (assignment.ID && aindex < count) // Count time for speakers but not backup speaker
                totaltime += parseInt(assignment.maxtime);
        });

    if (!totaltime) return null;

    function delayedNotification(message) {
        if (!makeNotification) return;
        setTimeout(() => {
            makeNotification(message);
        }, 1000);
        setWarningGiven(true);
    }

    if (totaltime > time_allowed) {
        if (!warningGiven)
            delayedNotification(
                mytranslate('Speakers have reserved ', data) +
                totaltime +
                mytranslate(' minutes', data) +
                time_allowed_text +
                mytranslate('. Meeting organizers may change the time allowed for different parts of the meeting on the Organize tab.', data)
            );
        return (
            <div>
                <p className="speakertime speakertime-warning">
                    {mytranslate('Speakers have reserved ', data)}
                    {totaltime}
                    {time_allowed_text}
                </p>
            </div>
        );
    } else
        return (
            <div>
                <p className="speakertime">
                    {mytranslate('Speakers have reserved ', data)}
                    {totaltime}
                    {time_allowed_text}
                </p>
            </div>
        );
}
