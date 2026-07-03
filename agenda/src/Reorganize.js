import React, { useEffect, useMemo, useState, useRef } from "react";

import { TextControl, ToggleControl, RadioControl } from '@wordpress/components';

import RoleBlock from "./RoleBlock.js";

import { SpeakerTimeCount } from "./SpeakerTimeCount.js";

import { Inserter } from "./Inserter.js";

import { SanitizedHTML } from "./SanitizedHTML.js";

import { EditorAgendaNote } from './EditorAgendaNote.js';

import { SignupNote } from './SignupNote.js';

import { EditableNote } from './EditableNote.js';

import { Up, Down, Move } from './icons.js';

import { updateAgenda } from './queries.js';

import { SelectCtrl, NumberCtrl } from './Ctrl.js';

import AgendaEditBlockEdit from './agendaedit/edit.js';
import AgendaNoteBlockEdit from './agendanoterich2/edit.js';
import SignupNoteBlockEdit from './signupnote/edit.js';
import AbsencesBlockEdit from './absences/edit.js';
import SpeakerEvaluatorBlockEdit from './speaker-evaluator/edit.js';
import HelpBlockEdit from './help/edit.js';

const WIDGET_EDITORS = {
    'wp4toastmasters/agendaedit': AgendaEditBlockEdit,
    'wp4toastmasters/agendanoterich2': AgendaNoteBlockEdit,
    'wp4toastmasters/signupnote': SignupNoteBlockEdit,
    'wp4toastmasters/absences': AbsencesBlockEdit,
    'wp4toastmasters/speaker-evaluator': SpeakerEvaluatorBlockEdit,
    'wp4toastmasters/help': HelpBlockEdit,
};

const NOTE_BLOCKS = ['wp4toastmasters/agendanoterich2', 'wp4toastmasters/signupnote'];

function stripHtml(html = '') {
    return html.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
}

function makeExcerpt(html = '', length = 80) {
    const excerpt = stripHtml(html);
    if (excerpt.length <= length) {
        return excerpt;
    }
    return `${excerpt.substring(0, length).trim()}...`;
}

function blockLabel(block) {
    if (!block?.blockName) {
        return 'Block';
    }

    const attrs = block.attrs || {};
    
    // For role blocks, just show the role name without "role" prefix
    if (block.blockName === 'wp4toastmasters/role') {
        return attrs.role === 'custom' ? attrs.custom_role || 'Custom Role' : attrs.role || 'Role';
    }
    
    const slug = block.blockName.replace(/^[^/]+\//, '').replace('agendanoterich2', 'agenda note');
    const parts = [slug];

    if (attrs.editable) {
        parts.push(attrs.editable);
    }
    if (block.innerHTML) {
        parts.push(makeExcerpt(block.innerHTML, 40));
    }

    return parts.join(': ').replace(': ', ' ');
}

function extractRichTextContent(block) {
    if (!block) {
        return '';
    }

    if (block?.attrs?.content) {
        return block.attrs.content;
    }

    const html = block.innerHTML || '';
    return html
        .replace(/^<p[^>]*>/i, '')
        .replace(/<\/p>\s*$/i, '');
}

function wrapRichText(blockName, content = '') {
    const className = blockName === 'wp4toastmasters/agendanoterich2'
        ? ' class="wp-block-wp4toastmasters-agendanoterich2"'
        : (blockName === 'wp4toastmasters/signupnote' ? ' class="wp-block-wp4toastmasters-signupnote"' : '');

    return `<p${className}>${content}</p>`;
}

function placeholderSummary(block) {
    const name = block?.blockName || 'core/block';
    const attrs = block?.attrs || {};
    const excerpt = attrs.content || block?.innerHTML || attrs.caption || '';

    if (name === 'core/paragraph') {
        return `Paragraph: ${makeExcerpt(excerpt, 60) || 'Empty paragraph'}`;
    }
    if (name === 'core/heading') {
        return `Heading: ${makeExcerpt(excerpt, 60) || 'Heading'}`;
    }
    if (name === 'core/image') {
        const url = attrs.url || '';
        const filename = url ? url.split('/').pop() : 'image';
        return `Image: ${filename}`;
    }

    const cleanedName = name.replace(/^[^/]+\//, '');
    return `${cleanedName}: ${makeExcerpt(excerpt, 60) || 'Placeholder'}`;
}

function roleSummary(block) {
    const count = block?.attrs?.count || 1;
    const time = block?.attrs?.time_allowed || 0;
    const slots = `${count} slot${count > 1 ? 's' : ''}`;
    const timeStr = time > 0 ? ` • ${time} min` : '';
    return `${slots}${timeStr}`;
}

function editableNoteSummary(block) {
    const headline = block?.attrs?.editable || '';
    return headline || 'Note';
}

function agendaNoteSummary(block) {
    const content = extractRichTextContent(block);
    const excerpt = stripHtml(content);
    const shortExcerpt = excerpt.length > 40 ? `${excerpt.substring(0, 40).trim()}...` : excerpt;
    return shortExcerpt || 'Agenda Note';
}

function signupNoteSummary(block) {
    const content = extractRichTextContent(block);
    const excerpt = stripHtml(content);
    const shortExcerpt = excerpt.length > 40 ? `${excerpt.substring(0, 40).trim()}...` : excerpt;
    return shortExcerpt || 'Signup Note';
}

function helpSummary() {
    return 'Help';
}

function abstractSummary(block) {
    const content = extractRichTextContent(block);
    if (content) {
        return makeExcerpt(content, 40);
    }
    return placeholderSummary(block);
}

function isAgendaBlock(block) {
    return !!block?.blockName?.startsWith('wp4toastmasters/');
}

function matchesFilter(block, showDetails) {
    if (!block?.blockName) {
        return false;
    }

    if (showDetails === 'speakers-evaluators') {
        return block.blockName === 'wp4toastmasters/role' && ['Speaker', 'Evaluator'].includes(block?.attrs?.role);
    }

    if (showDetails === 'timed') {
        return !!block?.attrs?.time_allowed;
    }

    return true;
}

function RoleWidgetPreview({ block, data, makeNotification }) {
    return (
        <div className="reorganize-widget-preview reorganize-role-preview">
            {block?.assignments && Array.isArray(block.assignments) && block.assignments.length > 0 && (
                <div className="reorganize-role-assignments">
                    <div className="reorganize-role-assignments-label">Assigned:</div>
                    {block.assignments.map((assignment, index) => (
                        <div key={`${assignment?.ID || assignment?.name || 'assignment'}-${index}`}>{assignment?.name}</div>
                    ))}
                </div>
            )}
            <div className="reorganize-role-metadata">
                <span>{(block?.attrs?.count) ? `${block.attrs.count} slot${block.attrs.count > 1 ? 's' : ''}` : '1 slot'}</span>
                <span>{(block?.attrs?.time_allowed || 0)} min</span>
                {!!block?.attrs?.padding_time && <span>{block.attrs.padding_time} min padding</span>}
            </div>
            <SpeakerTimeCount block={block} makeNotification={makeNotification} data={data} />
            {!!block?.attrs?.agenda_note && <p className="reorganize-inline-note">{block.attrs.agenda_note}</p>}
        </div>
    );
}

function PlaceholderPreview({ block }) {
    return (
        <div className="reorganize-widget-preview reorganize-placeholder-preview">
            <div className="reorganize-widget-heading">Placeholder</div>
            <p>{placeholderSummary(block)}</p>
        </div>
    );
}

function renderWidgetBlock(block, blockindex, onSetAttributes, data, makeNotification, selected) {
    if (!block?.blockName) {
        return null;
    }

    if (block.blockName === 'wp4toastmasters/role') {
        return <RoleWidgetPreview block={block} data={data} makeNotification={makeNotification} />;
    }

    const EditComponent = WIDGET_EDITORS[block.blockName];
    if (EditComponent) {
        const attributes = {
            ...(block.attrs || {}),
            ...(NOTE_BLOCKS.includes(block.blockName) ? { content: extractRichTextContent(block) } : {}),
        };

        return (
            <div className="reorganize-widget-preview reorganize-editor-widget">
                <EditComponent
                    attributes={attributes}
                    setAttributes={(attrsPatch) => onSetAttributes(blockindex, attrsPatch)}
                    isSelected={selected}
                    className="reorganize-editor-widget__body"
                    clientId={`reorganize-${blockindex}`}
                />
            </div>
        );
    }

    if (isAgendaBlock(block)) {
        return (
            <div className="reorganize-widget-preview reorganize-plugin-preview">
                <div className="reorganize-widget-heading">Agenda Block</div>
                <p>{placeholderSummary(block)}</p>
            </div>
        );
    }

    return <PlaceholderPreview block={block} />;
}

export default function Reorganize(props) {

    const { data, mode, post_id, makeNotification, ModeControl, showDetails, setMode, setScrollTo, setEvaluate, setPostId } = props;

    const [sync, setSync] = useState(true);
    const [editThis, setEditThis] = useState(-1);
    const [selectedBlockIndex, setSelectedBlockIndex] = useState(-1);
    const [insertAfter, setInsertAfter] = useState(null);
    const [draggedBlockIndex, setDraggedBlockIndex] = useState(null);
    const [dropBlockIndex, setDropBlockIndex] = useState(null);
    const [isNarrowLayout, setIsNarrowLayout] = useState(false);
    const [expandedBlockIndex, setExpandedBlockIndex] = useState(null);
    const [showInsert, setShowInsert] = useState(false);
    const autoScrollIntervalRef = useRef(null);
    const autoScrollDirectionRef = useRef(null);
    const draggedBlockRef = useRef(null);

    const { mutate: agendaMutate } = updateAgenda(post_id, makeNotification, Inserter);

    function commitAgenda(blocksdata, extra = {}) {
        agendaMutate({ ...data, ...extra, blocksdata });
    }

    function replaceAgendaBlock(targetBlockIndex, nextBlock) {
        if (!Array.isArray(data.blocksdata)) {
            return;
        }

        const nextBlocks = data.blocksdata.map((block, idx) => (idx === targetBlockIndex ? nextBlock : block));
        commitAgenda(nextBlocks);
    }

    function updateBlockAttrs(targetBlockIndex, attrsPatch) {
        if (!Array.isArray(data.blocksdata)) {
            return;
        }

        const currentBlock = data.blocksdata[targetBlockIndex];
        if (!currentBlock) {
            return;
        }

        const nextBlock = {
            ...currentBlock,
            attrs: {
                ...(currentBlock.attrs || {}),
                ...attrsPatch,
            },
        };

        if (Object.prototype.hasOwnProperty.call(attrsPatch, 'content') && NOTE_BLOCKS.includes(currentBlock.blockName)) {
            nextBlock.innerHTML = wrapRichText(currentBlock.blockName, attrsPatch.content);
        }

        replaceAgendaBlock(targetBlockIndex, nextBlock);
    }

    if ('reorganize' !== mode) {
        return null;
    }

    function calcTimeAllowed(attrs = {}) {
        let time_allowed = 0;
        const count = attrs.count ? attrs.count : 1;

        if ('Speaker' === attrs.role) {
            time_allowed = count * 7;
        }

        if ('Evaluator' === attrs.role) {
            time_allowed = count * 3;
        }

        return time_allowed;
    }

    function reorderBlocks(sourceIndex, afterIndex) {
        const nextBlocks = Array.isArray(data.blocksdata) ? [...data.blocksdata] : [];
        if (sourceIndex < 0 || sourceIndex >= nextBlocks.length) {
            return;
        }

        const [moved] = nextBlocks.splice(sourceIndex, 1);
        let insertAt = afterIndex + 1;

        if (sourceIndex < insertAt) {
            insertAt -= 1;
        }

        if (insertAt < 0) {
            insertAt = 0;
        }

        if (insertAt > nextBlocks.length) {
            insertAt = nextBlocks.length;
        }

        nextBlocks.splice(insertAt, 0, moved);
        commitAgenda(nextBlocks, { changed: 'blocks' });
        setSelectedBlockIndex(insertAt);
    }

    function moveBlock(blockindex, direction = 'up') {
        if (direction === 'delete') {
            const nextBlocks = Array.isArray(data.blocksdata) ? [...data.blocksdata] : [];
            nextBlocks.splice(blockindex, 1);
            commitAgenda(nextBlocks, { changed: 'blocks' });
            setSelectedBlockIndex(Math.max(0, blockindex - 1));
            return;
        }

        if (direction === 'up') {
            reorderBlocks(blockindex, blockindex - 2);
            return;
        }

        if (direction === 'down') {
            reorderBlocks(blockindex, blockindex + 1);
            return;
        }

        const numericDestination = direction === 'top' ? -1 : parseInt(direction, 10);
        reorderBlocks(blockindex, numericDestination);
    }

    function insertBlock(blockindex, attributes = {}, blockname = 'wp4toastmasters/role', innerHTML = '', edithtml = '') {
        const nextBlocks = Array.isArray(data.blocksdata) ? [...data.blocksdata] : [];
        const insertAt = Math.max(0, Math.min(nextBlocks.length, blockindex + 1));
        nextBlocks.splice(insertAt, 0, {
            blockName: blockname,
            assignments: [],
            attrs: attributes,
            innerHTML,
            edithtml,
        });
        commitAgenda(nextBlocks);
        setInsertAfter(null);
        setSelectedBlockIndex(insertAt);
    }

    function replaceBlock(blockindex, newblock) {
        replaceAgendaBlock(blockindex, newblock);
    }

    function syncToEvaluator(blocksdata, count) {
        if (!sync) {
            return blocksdata;
        }

        return blocksdata.map((block) => {
            if (block?.attrs?.role !== 'Evaluator') {
                return block;
            }
            return {
                ...block,
                attrs: {
                    ...block.attrs,
                    count,
                    time_allowed: count * 3,
                },
            };
        });
    }

    const baseDate = new Date(data.datetime);
    const dateoptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const localedate = baseDate.toLocaleDateString('en-US', dateoptions);

    let endtime = '';
    let timeCursor = new Date(data.datetime);
    const blocksWithDateStrings = (data.blocksdata && Array.isArray(data.blocksdata))
        ? data.blocksdata.map((block) => {
            let datestring = timeCursor.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            if (block?.attrs?.time_allowed) {
                timeCursor.setMilliseconds(timeCursor.getMilliseconds() + (parseInt(block.attrs.time_allowed, 10) * 60000));

                if (block.attrs.padding_time) {
                    timeCursor.setMilliseconds(timeCursor.getMilliseconds() + (parseInt(block.attrs.padding_time, 10) * 60000));
                }

                endtime = timeCursor.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                datestring = `${datestring} to ${endtime}`;
            }
            return { ...block, datestring };
        })
        : [];

    const visibleBlocks = useMemo(
        () => blocksWithDateStrings
            .map((block, blockindex) => ({ block, blockindex }))
            .filter(({ block }) => matchesFilter(block, showDetails)),
        [blocksWithDateStrings, showDetails]
    );

    useEffect(() => {
        if (!visibleBlocks.length) {
            if (selectedBlockIndex !== -1) {
                setSelectedBlockIndex(-1);
            }
            return;
        }

        const stillVisible = visibleBlocks.some(({ blockindex }) => blockindex === selectedBlockIndex);
        if (!stillVisible) {
            setSelectedBlockIndex(visibleBlocks[0].blockindex);
        }
    }, [selectedBlockIndex, visibleBlocks]);

    useEffect(() => {
        function updateLayoutMode() {
            setIsNarrowLayout(window.innerWidth < 1280);
        }

        updateLayoutMode();
        window.addEventListener('resize', updateLayoutMode);
        return () => window.removeEventListener('resize', updateLayoutMode);
    }, []);

    function stopAutoScroll() {
        if (autoScrollIntervalRef.current) {
            clearInterval(autoScrollIntervalRef.current);
            autoScrollIntervalRef.current = null;
        }
        autoScrollDirectionRef.current = null;
    }

    function startAutoScroll(direction) {
        if (autoScrollDirectionRef.current === direction) {
            return;
        }
        stopAutoScroll();
        autoScrollDirectionRef.current = direction;
        autoScrollIntervalRef.current = setInterval(() => {
            window.scrollBy(0, direction === 'down' ? 12 : -12);
        }, 40);
    }

    function updateAutoScrollFromClientY(clientY) {
        const threshold = 80;
        if (clientY < threshold) {
            startAutoScroll('up');
        } else if (window.innerHeight - clientY < threshold) {
            startAutoScroll('down');
        } else {
            stopAutoScroll();
        }
    }

    useEffect(() => {
        if (draggedBlockIndex === null) {
            stopAutoScroll();
            return;
        }
        function handleWindowDragOver(event) {
            updateAutoScrollFromClientY(event.clientY);
        }
        window.addEventListener('dragover', handleWindowDragOver);
        return () => {
            window.removeEventListener('dragover', handleWindowDragOver);
            stopAutoScroll();
        };
    }, [draggedBlockIndex]);

    const selectedEntry = visibleBlocks.find(({ blockindex }) => blockindex === selectedBlockIndex) || null;
    const selectedBlock = selectedEntry?.block || null;

    function onDropAt(afterIndex) {
        const fromIndex = draggedBlockRef.current;
        if (fromIndex === null || fromIndex === undefined) {
            return;
        }
        draggedBlockRef.current = null;
        setDraggedBlockIndex(null);
        setDropBlockIndex(null);
        reorderBlocks(fromIndex, afterIndex);
    }

    function CopyToTemplateButton() {
        return <button className="tmsmallbutton" onClick={() => { agendaMutate({ ...data, copyToTemplate: true }); }}>Apply to All</button>;
    }

    function renderInsertionZone(afterIndex, key) {
        if (draggedBlockIndex === null) return null;
        const isHovered = dropBlockIndex === afterIndex;
        return (
            <div
                key={key}
                onDragOver={(event) => { event.preventDefault(); setDropBlockIndex(afterIndex); }}
                onDrop={(event) => { event.preventDefault(); onDropAt(afterIndex); setDropBlockIndex(null); }}
                onDragLeave={() => { setDropBlockIndex(null); }}
                style={{
                    margin: '2px 0',
                    padding: '8px',
                    textAlign: 'center',
                    backgroundColor: isHovered ? '#bbb' : '#e0e0e0',
                    border: '2px dashed #999',
                    color: '#666',
                    borderRadius: '4px',
                    fontSize: '0.9em',
                }}
            >Drop here</div>
        );
    }

    function renderSelectedSidebar() {
        if (!selectedBlock) {
            return (
                <div className="reorganize-sidebar-empty">
                    <h3>Select a block</h3>
                    <p>Choose a widget in the agenda canvas to edit its settings, reorder it, or delete it.</p>
                </div>
            );
        }

        const block = selectedBlock;
        const blockindex = selectedBlockIndex;

        return (
            <div className="reorganize-sidebar-panel">
                <div className="reorganize-sidebar-header">
                    <div>
                        <div className="reorganize-sidebar-kicker">Selected Block</div>
                        <h3>{blockLabel(block)}</h3>
                    </div>
                    <div className="reorganize-sidebar-time">{block.datestring}</div>
                </div>

                <div className="reorganize-sidebar-actions">
                    <button className="tmsmallbutton deletebutton" type="button" onClick={() => moveBlock(blockindex, 'delete')}>Delete</button>
                </div>

                {block.blockName === 'wp4toastmasters/help' && <p>See the knowledge base article <a href="https://toastmost.org/knowledge-base/organize-agenda-tool/">Organize Agenda Tool</a> for video and written instructions.</p>}

                {block.blockName === 'wp4toastmasters/speaker-evaluator' && (
                    <div>
                        <p>Displays Speaker-Evaluator matches in a table on the printable and email versions of the agenda.</p>
                        <RadioControl
                            label="Columns"
                            selected={block.attrs?.columns}
                            options={[{ label: '2 columns', value: '2' }, { label: 'Separate columns for Speaker, Path, Project, Title', value: '5' }]}
                            onChange={(value) => updateBlockAttrs(blockindex, { columns: value })}
                        />
                    </div>
                )}

                {block.blockName === 'wp4toastmasters/role' && (
                    <div>
                        <ToggleControl
                            label="Edit"
                            checked={editThis === blockindex}
                            onChange={() => setEditThis(editThis === blockindex ? -1 : blockindex)}
                        />

                        {editThis === blockindex ? (
                            <RoleBlock
                                makeNotification={makeNotification}
                                showDetails={showDetails}
                                agendadata={data}
                                post_id={post_id}
                                blockindex={blockindex}
                                mode="edit"
                                block={block}
                                setMode={setMode}
                                setScrollTo={setScrollTo}
                                setEvaluate={setEvaluate}
                            />
                        ) : (
                            block.assignments && Array.isArray(block.assignments) && block.assignments.map((assignment, index) => (
                                <div key={`${assignment?.ID || assignment?.name || 'assignment'}-${index}`}>{assignment?.name}</div>
                            ))
                        )}

                        <SpeakerTimeCount block={block} makeNotification={makeNotification} data={data} />

                            <div className="reorganize-role-controls">
                                <NumberCtrl
                                    label="Signup Slots"
                                    min="1"
                                    value={block.attrs?.count ? block.attrs.count : 1}
                                    onChange={(value) => {
                                        value = Math.abs(parseInt(value, 10));
                                        const baseBlocks = Array.isArray(data.blocksdata)
                                            ? data.blocksdata.map((agendaBlock, idx) => idx === blockindex
                                                ? {
                                                    ...agendaBlock,
                                                    attrs: {
                                                        ...(agendaBlock.attrs || {}),
                                                        count: value,
                                                        time_allowed: ['Speaker', 'Evaluator'].includes(block.attrs.role)
                                                            ? calcTimeAllowed({ ...block.attrs, count: value })
                                                            : agendaBlock.attrs?.time_allowed,
                                                    },
                                                }
                                                : agendaBlock)
                                            : [];
                                        const syncedBlocks = ['Speaker', 'Evaluator'].includes(block.attrs.role)
                                            ? syncToEvaluator(baseBlocks, value)
                                            : baseBlocks;
                                        commitAgenda(syncedBlocks);
                                    }}
                                />
                                <NumberCtrl
                                    label="Time Allowed"
                                    value={block.attrs?.time_allowed ? block.attrs.time_allowed : calcTimeAllowed(block.attrs)}
                                    onChange={(value) => updateBlockAttrs(blockindex, { time_allowed: value })}
                                />
                                {'Speaker' === block.attrs.role && (
                                    <NumberCtrl
                                        label="Padding Time"
                                        min="0"
                                        value={block.attrs.padding_time}
                                        onChange={(value) => updateBlockAttrs(blockindex, { padding_time: value })}
                                    />
                                )}
                            </div>

                        <TextControl
                            label="Note About Role (optional)"
                            value={block.attrs.agenda_note}
                            onChange={(value) => updateBlockAttrs(blockindex, { agenda_note: value })}
                        />

                        {'Speaker' === block.attrs.role && (
                            <div>
                                <p><em>Padding time is a little extra time for switching between and introducing speakers.</em></p>
                                <ToggleControl
                                    label="Sync Number of Speakers and Evaluators"
                                    help={sync ? 'Number of evaluators updates automatically with speakers' : 'Manage this manually'}
                                    checked={sync}
                                    onChange={() => setSync(!sync)}
                                />
                            </div>
                        )}

                        <ToggleControl
                            label="Backup"
                            help={block.attrs.backup ? 'Editing' : 'Viewing'}
                            checked={block.attrs.backup}
                            onChange={() => updateBlockAttrs(blockindex, { backup: !block.attrs.backup })}
                        />
                    </div>
                )}

                {block.blockName === 'wp4toastmasters/absences' && (
                    <ToggleControl
                        label="Show on Agenda"
                        help={block.attrs.show_on_agenda ? 'Show' : 'Hide'}
                        checked={block.attrs.show_on_agenda}
                        onChange={() => updateBlockAttrs(blockindex, { show_on_agenda: !block.attrs.show_on_agenda })}
                    />
                )}

                {block.blockName === 'wp4toastmasters/agendaedit' && (
                    <div>
                        <ToggleControl
                            label="Edit"
                            checked={editThis === blockindex}
                            onChange={() => setEditThis(editThis === blockindex ? -1 : blockindex)}
                        />
                        {editThis === blockindex ? (
                            <EditableNote makeNotification={makeNotification} mode={mode} block={block} blockindex={blockindex} uid={block.attrs.uid} post_id={post_id} isTemplate={!!data.is_template} />
                        ) : (
                            <SanitizedHTML innerHTML={block.attrs.edithtml || block.edithtml || ''} />
                        )}
                        <div className="tmflexrow">
                            <div className="tmflex30">
                                <NumberCtrl
                                    label="Time Allowed"
                                    value={block.attrs?.time_allowed ? block.attrs.time_allowed : 0}
                                    onChange={(value) => updateBlockAttrs(blockindex, { time_allowed: value })}
                                />
                            </div>
                        </div>
                    </div>
                )}

                {block.blockName === 'wp4toastmasters/agendanoterich2' && (
                    <div>
                        <ToggleControl
                            label="Edit"
                            checked={editThis === blockindex}
                            onChange={() => setEditThis(editThis === blockindex ? -1 : blockindex)}
                        />
                        {editThis === blockindex ? (
                            <EditorAgendaNote makeNotification={makeNotification} blockindex={blockindex} block={block} replaceBlock={replaceBlock} data={data} />
                        ) : (
                            <SanitizedHTML innerHTML={block.innerHTML} />
                        )}
                        <div className="tmflexrow">
                            <div className="tmflex30">
                                <NumberCtrl
                                    label="Time Allowed"
                                    value={block.attrs?.time_allowed ? block.attrs.time_allowed : 0}
                                    onChange={(value) => updateBlockAttrs(blockindex, { time_allowed: value })}
                                />
                            </div>
                        </div>
                    </div>
                )}

                {block.blockName === 'wp4toastmasters/signupnote' && (
                    <div>
                        <SignupNote blockindex={blockindex} block={block} replaceBlock={replaceBlock} />
                    </div>
                )}

                {!isAgendaBlock(block) && (
                    <div>
                        <p>{placeholderSummary(block)}</p>
                        {!!block.innerHTML && <SanitizedHTML innerHTML={block.innerHTML} />}
                    </div>
                )}

                {isAgendaBlock(block) && !['wp4toastmasters/role', 'wp4toastmasters/speaker-evaluator', 'wp4toastmasters/absences', 'wp4toastmasters/agendaedit', 'wp4toastmasters/agendanoterich2', 'wp4toastmasters/signupnote', 'wp4toastmasters/help'].includes(block.blockName) && (
                    <div>
                        <p>{placeholderSummary(block)}</p>
                        {!!block.innerHTML && <SanitizedHTML innerHTML={block.innerHTML} />}
                    </div>
                )}

                <div className="reorganize-sidebar-insert-section">
                    <button type="button" className="tmsmallbutton" style={{marginBottom:'6px'}} onClick={() => setShowInsert(s => !s)}>{showInsert ? 'Hide Insert' : '+ Insert Block After This'}</button>
                    {showInsert && (
                        <div style={{display:'flex',flexDirection:'column',gap:'8px'}}>
                            <Inserter
                                makeNotification={makeNotification}
                                blockindex={selectedBlockIndex}
                                insertBlock={(idx,attrs,name,html,ehtml) => { insertBlock(idx,attrs,name,html,ehtml); setShowInsert(false); }}
                                moveBlock={moveBlock}
                                post_id={post_id}
                            />
                        </div>
                    )}
                </div>
            </div>
        );
    }

    function renderBlockSummary(block, blockindex) {
        if (!block?.blockName) {
            return null;
        }

        let summary = '';
        
        if (block.blockName === 'wp4toastmasters/role') {
            summary = roleSummary(block);
        } else if (block.blockName === 'wp4toastmasters/agendaedit') {
            summary = editableNoteSummary(block);
        } else if (block.blockName === 'wp4toastmasters/agendanoterich2') {
            summary = agendaNoteSummary(block);
        } else if (block.blockName === 'wp4toastmasters/signupnote') {
            summary = signupNoteSummary(block);
        } else if (block.blockName === 'wp4toastmasters/help') {
            summary = helpSummary();
        } else if (block.blockName === 'wp4toastmasters/speaker-evaluator') {
            summary = 'Speaker-Evaluator';
        } else if (block.blockName === 'wp4toastmasters/absences') {
            summary = 'Absences';
        } else {
            summary = placeholderSummary(block);
        }

        return (
            <div className="reorganize-block-summary">
                <p className="reorganize-block-summary__text">{summary}</p>
                <button
                    className="reorganize-block-summary__expand-button"
                    type="button"
                    onClick={(e) => {
                        e.stopPropagation();
                        setExpandedBlockIndex(blockindex);
                    }}
                >
                    See more
                </button>
            </div>
        );
    }

    function renderBlockExpanded(block, blockindex, onSetAttributes, data, makeNotification, selected) {
        return (
            <div className="reorganize-block-expanded">
                {renderWidgetBlock(block, blockindex, onSetAttributes, data, makeNotification, selected)}
            </div>
        );
    }

    return (
        <div className="agendawrapper reorganize-shell" id={`agendawrapper${post_id}`}>
            <>{('rsvpmaker' !== wpt_rest.post_type) && <SelectCtrl label="Choose Event" value={post_id} options={data.upcoming} onChange={(value) => { setPostId(parseInt(value, 10)); makeNotification('Date changed, please wait for the date to change ...'); }} />}</>

            <div className="reorganize-shell__header">
                <div>
                    <h4>{localedate} {data.is_template && <span>(Template)</span>}</h4>
                    {data.has_template && <div><p>By default, changes you make below apply only to this meeting.</p><p><CopyToTemplateButton /><br /><em>Copy these agenda changes to all upcoming meetings based on the same template.</em></p></div>}
                    {data.is_template && <p><a target="_blank" href={`/wp-admin/edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=${data.post_id}`}>Create/Update</a> - copy changes to new and existing events</p>}
                </div>
                <div className="reorganize-shell__mode-control">
                    <ModeControl note={`Based on time allotted, meeting will end at ${endtime}`} makeNotification={makeNotification} isTemplate={(false !== data.is_template)} post_id={data.post_id} />
                </div>
            </div>

            <div className="reorganize-editor-shell">
                <div className="reorganize-editor-canvas">
                    {renderInsertionZone(-1, 'insert-top')}
                    {visibleBlocks.map(({ block, blockindex }) => (
                        <React.Fragment key={`${block.blockName || 'block'}-${blockindex}`}>
                            <div
                                className={`reorganize-block-card ${selectedBlockIndex === blockindex ? 'is-selected' : ''} ${draggedBlockIndex === blockindex ? 'is-dragging' : ''} ${expandedBlockIndex === blockindex ? 'is-expanded' : ''}`}
                                onClick={() => setSelectedBlockIndex(blockindex)}
                                draggable
                                onDragStart={(e) => { e.dataTransfer.setData('text/plain', String(blockindex)); e.dataTransfer.effectAllowed = 'move'; draggedBlockRef.current = blockindex; setTimeout(() => setDraggedBlockIndex(blockindex), 0); }}
                                onDragEnd={() => { draggedBlockRef.current = null; setDraggedBlockIndex(null); setDropBlockIndex(null); stopAutoScroll(); }}
                            >
                                <div className="reorganize-block-toolbar" style={{backgroundColor:'#e0e0e0',padding:'4px 8px',gap:'6px',alignItems:'center'}}>
                                    <div
                                        title="Drag to reorder"
                                        draggable={false}
                                        style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px',cursor:'grab',color:'#444',pointerEvents:'none'}}
                                    >
                                        <Move />
                                    </div>
                                    <button className="blockmove" type="button" onClick={(event) => { event.stopPropagation(); moveBlock(blockindex, 'up'); }} title="Move Up" style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px',padding:'2px',backgroundColor:'#c8c8c8',border:'1px solid #aaa',borderRadius:'3px',cursor:'pointer',color:'#333'}}><Up /></button>
                                    <button className="blockmove" type="button" onClick={(event) => { event.stopPropagation(); moveBlock(blockindex, 'down'); }} title="Move Down" style={{display:'inline-flex',alignItems:'center',justifyContent:'center',width:'24px',height:'24px',padding:'2px',backgroundColor:'#c8c8c8',border:'1px solid #aaa',borderRadius:'3px',cursor:'pointer',color:'#333'}}><Down /></button>
                                    <div style={{flex:1}}>
                                        <div className="reorganize-block-time">{block.datestring}</div>
                                        <h2 style={{margin:0}}>{blockLabel(block)}</h2>
                                    </div>
                                </div>

                                <div className="reorganize-block-surface">
                                    {expandedBlockIndex === blockindex
                                        ? renderBlockExpanded(block, blockindex, updateBlockAttrs, data, makeNotification, selectedBlockIndex === blockindex)
                                        : renderBlockSummary(block, blockindex)
                                    }
                                </div>

                                {expandedBlockIndex === blockindex && (
                                    <button
                                        className="reorganize-block-collapse-button"
                                        type="button"
                                        onClick={(e) => {
                                            e.stopPropagation();
                                            setExpandedBlockIndex(null);
                                        }}
                                    >
                                        See less
                                    </button>
                                )}

                                {isNarrowLayout && selectedBlockIndex === blockindex && expandedBlockIndex !== blockindex && (
                                    <div className="reorganize-inline-inspector">
                                        {renderSelectedSidebar()}
                                    </div>
                                )}
                            </div>
                            {renderInsertionZone(blockindex, `insert-${blockindex}`)}
                        </React.Fragment>
                    ))}
                </div>

                {!isNarrowLayout && (
                    <aside className="reorganize-editor-sidebar">
                        {renderSelectedSidebar()}
                    </aside>
                )}
            </div>
        </div>
    );
}
