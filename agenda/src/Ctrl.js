import React, {useState, useEffect, useRef} from "react"
import Select, { components } from 'react-select';

// Updated Custom Input that won't cover up selected values
const CustomInput = (props) => {
    return (
        <components.Input
            {...props}
            style={{
                width: '100%',
                minWidth: '120px',
                gridArea: '1 / 2', // Restores grid overlay alignment
                background: 'transparent', // Stops background from hiding text below
            }}
        />
    );
};

export function SelectCtrl(props) {
    if (!props.options) {
        console.log('SelectCtrl called without props.options', props);
        return null;
    }

    // Ensure props.value matches option object
    const selectedOption = props.options.find(o => o.value == props.value) || null;
    console.log('SelectCtrl selectedOption', selectedOption);

    const style = {
        'display': props.display ? props.display : 'block',
        'maxWidth': props.width ? props.width : '325px'
    };

    // Style overrides to ensure the single value layer renders properly
    const customStyles = {
        valueContainer: (base) => ({
            ...base,
            display: 'grid', // Keeps singleValue and input stacked on top of each other
            gridTemplateColumns: '1fr',
        }),
        singleValue: (base, state) => ({
            ...base,
            gridArea: '1 / 2', // Stacks value underneath input
            // Visually dim or hide the label only when actively typing a new search
            opacity: state.selectProps.inputValue ? 0.3 : 1, 
        }),
        placeholder: (base) => ({
            ...base,
            gridArea: '1 / 2',
        })
    };

    return (
        <div style={style}>
            <label style={{ 'display': 'block', 'fontSize': '11px', 'textTransform': 'uppercase', 'marginBottom': '4px' }}>
                {props.label} {selectedOption ? `: ${selectedOption.label}` : ''}
            </label>
            
            <Select
                options={props.options}
                value={selectedOption}
                onChange={(option) => props.onChange(option ? option.value : null)}
                components={{ Input: CustomInput }}
                styles={customStyles}
                isSearchable={true}
                isClearable={true}
            />
        </div>
    );
}
export function NumberCtrl (props) {

    const style = {'display': (props.display) ? props.display : 'block', 'maxWidth': (props.maxWidth) ? props.maxWidth : '300px' };

    return (

        <div style={style}>

            <label style={{'display':'block','fontSize':'11px','textTransform':'uppercase'}}>{props.label}</label>

            <input type="number" value={(props.value) ? props.value : 0} onChange={(e) => props.onChange(e.target.value)} />

        </div>

    )

}

