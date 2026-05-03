import React, { useRef } from 'react';
import { RadioControl } from '@wordpress/components';

export function EvaluationPrompt(props) {
const {item,promptindex,note,response,setResponses,setNotes} = props;

const notefield = useRef('');

function save (e) {
    e.preventDefault();
      setNotes((prev) => {
        const next = [...prev];
        next[promptindex] = notefield.current.value;
        return next;
      });
} 

  return (
    <div>
     <p><strong>{item.prompt}</strong> {response}</p>
     {item.choices && (item.choices.length > 0) && <div><RadioControl className="radio-mode" options={item.choices} selected={response} onChange={(value) => { setResponses((prev) => {let newd = [...prev]; newd[promptindex] = value; return newd }); }}  /></div>}
     <p><textarea className="evaluation-note" defaultValue={note || ''} ref={notefield} onBlur={save} /></p>
    </div>
  );
}
