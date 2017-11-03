<?php
add_action("admin_init","update_evaluation_forms");
	
function update_evaluation_forms() {
	$last = (int) get_option("evalforms_updated");
	if(($last > strtotime("-1 week")) && !isset($_GET['update_evaluation_forms']))
		return;
	update_option('evalintro:COMPETENT COMMUNICATION 1','Executive Summary:
For your first speech project, you will introduce yourself to your fellow club members and give them some information about your background, interests and ambitions. Practice giving your speech to friends or family members, and strive to make eye contact with some of your audience. You may use notes during your speech if you wish. Read the entire project before preparing your talk.

Objectives:
To begin speaking before an audience.
To discover speaking skills you already have and skills that need some attention.
Time: Four to six minutes.
Note To The Evaluator:
In this speech the new member is to introduce himself/herself to the club and begin speaking before an audience. The speech should have a clear beginning, body and ending. The speaker has been advised to use notes if necessary and not to be concerned with body language. Be encouraging and point out the speaker&apos;s strong points while gently and kindly mentioning areas that could be improved. Strive to have the speaker look forward to giving another speech. Your evaluation should help the speaker feel glad about joining Toastmasters and presenting this speech. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 1','What strong points does the speaker already have?
How well did the audience get to know the speaker?
Did the speech reflect adequate preparation?
Did the speaker talk clearly and audibly?
Did the speech have a definite opening, body and conclusion?
Please comment on the speaker&apos;s use of notes.
What could the speaker have done differently that would have improved the speech
What did you like about the presentation?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 2','Executive Summary:
Good speech organization is essential if your audience is to follow and understand your presentation. You must take the time to put your ideas together in an orderly manner. You can organize your speech in several different ways; choose the outline that best suits your topic. The opening should catch the audience&apos;s attention, the body must support the idea you want to convey, and the conclusion should reinforce your ideas and be memorable. Transitions between thoughts should be smooth.

Objectives:
* Select and appropriate outline which allows listeners to easily follow and understand your speech.
* Make your message clear, with supporting material directly contributing to that message.
* Use appropriate transitions when moving from one idea to another.
* Create a strong opening and conclusion.
* Time: Five to seven minutes.

Note To The Evaluator:
The speaker is to present a talk that is organized in a manner that leads the audience to a clearly defined goal. The speech includes a beginning, a body and a conclusion; major facts or ideas; and appropriate support material, with smooth transitions between the facts and ideas. In addition to your verbal evaluation, please complete this evaluation form by rating the speech in each category and offering comments or specific recommended action where warranted.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 2','Speech Value Interesting, meaningful to audience|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Preparation Research, rehearsal|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Organization Logical, clear|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Opening Attention getting, led into topic|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Body Flowed smoothly, appropriate support material|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Conclusion Effective|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
Transitions Appropriate, helpful|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
What could the speaker have done differently to make the speech more effective?
What did you like about the presentation?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 3','Executive Summary:
Every speech must have a general and a specific purpose. A general purpose is to inform, to persuade, to entertain or to inspire. A specific purpose is what you want the audience to do after listening to your speech. Once you have established your general and specific purposes, you&apos;ll find it easy to organize your speech. You&apos;ll also have more confidence, which makes you more convincing, enthusiastic and sincere. Of course, the better organized the speech is, the more likely it is to achieve your purpose.
Objectives:
* Select a speech topic and determine its general and specific purposes.
* Organize the speech in a manner that best achieves those purposes.
* Ensure the beginning; body and conclusion reinforce the purposes.
* Project sincerity and conviction and control any nervousness you may feel.
* Strive not to use notes.
* Time: Five to seven minutes.
Note To The Evaluator:
The speaker is to prepare a speech that has a clear general purpose (to inform, persuade, entertain or inspire) and a specific purpose. The speech is to be organized in a manner that best achieves these purposes. The beginning, body and conclusion should all tie into and reinforce the purposes. The speaker is to project sincerity and conviction and strive not to use notes. Any nervousness displayed should be minimal. In addition to your verbal evaluation, please complete the evaluation form below by rating the speech in each category.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 3','The general purpose of the speech was clear|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The specific purpose of the speech was clear|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The speech organization supported the speech s specific purpose.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The main points and supporting material contributed to the speech s specific purpose.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The beginning, body and conclusion reinforced the specific purpose.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The speaker achieved the specific purpose.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The speaker appeared confident and sincere, with minimal nervousness.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
The speaker did not rely on notes throughout the speech.|5 Excellent|4 Above average for the speaker&apos;s experience level|3 Satisfactory|2 Could improve|1 Needs attention
What could the speaker have done differently to make the speech more effective?
What did you like about the presentation?

',false);

update_option('evalintro:COMPETENT COMMUNICATION 4','Executive Summary:
Words are powerful. They convey your message and influence the audience and its perception of you. Word choice and arrangement need just as much attention as speech organization and purpose. Select clear, accurate, descriptive and short words that best communicate your ideas and arrange them effectively and correctly. Every word should add value, meaning and punch to the speech.
Objectives:
* Select the right words and sentence structure to communicate your ideas clearly, accurately and vividly.
* Use rhetorical devices to enhance and emphasize ideas.
* Eliminate jargon and unnecessary words. Use correct grammar.
* Time: Five to seven minutes.
Note To The Evaluator:
The speaker is to use words and arrangements of words that effectively communicate his or her message to the audience. The speaker should select clear, accurate, descriptive and short words and choose verbs that convey action. Sentence and paragraph construction should be simple and short. The speaker needs to include rhetorical devices, avoid jargon and unnecessary words and use correct grammar. The speech must have a clear purpose and be appropriately organized. Please complete the evaluation form below by checking the appropriate column for each item.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 4','Was the speech topic appropriate for this particular assignment?|Excellent|Satisfactory|Could Improve
Did the speaker use simple, short and clear words?|Excellent|Satisfactory|Could Improve
Did the speaker use vivid, descriptive words that created mental images?|Excellent|Satisfactory|Could Improve
Did the speaker use words that had more than one meaning or were inaccurate?|Excellent|Satisfactory|Could Improve
Were the speaker&apos;s sentences short, simple and understandable?|Excellent|Satisfactory|Could Improve
Did the speaker use rhetorical devices to enhance his or her ideas?|Excellent|Satisfactory|Could Improve
Did the speaker avoid jargon and unnecessary words?|Excellent|Satisfactory|Could Improve
Did the speaker use proper grammar and pronunciation?|Excellent|Satisfactory|Could Improve
Was the speech purpose clear?|Excellent|Satisfactory|Could Improve
Was the speech effectively organized?|Excellent|Satisfactory|Could Improve
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 5','Executive Summary:
Body language is an important part of speaking because it enhances your message and gives you more credibility. It also helps release any nervousness you may feel. Stance, movement, gestures, facial expressions and eye contact help communicate your message and achieve your speech\&apos;s purpose. Body language should be smooth, natural and convey the same message that your listeners hear. Read Gestures: Your Body Speaks (Catalog No. 201), which you received in Your New Member Kit.

Objectives:
* Use stance, movement, gestures, facial expressions and eye contact to express your message and achieve your speech\&apos;s purpose.
* Make your body language smooth and natural.
* Time: Five to seven minutes.

Note To The Evaluator:
The speaker is to use stance, body movement, gestures, facial expressions and eye contact that illustrate and enhance his or her verbal message. Movement, gestures, facial expressions and eye contact should be smooth and natural. Body language should enhance and clarify the speaker&apos;s words and help the audience visualize the speaker&apos;s point and overall message. The message you see should be the same one you hear. The speech must have a clear purpose and appropriate organization. Also, the speaker must use words and arrangements of words that effectively communicate his or her message to the audience. In addition to your verbal evaluation, please complete this evaluation form by checking the appropriate space for each item. Add your comments for those items deserving praise or specific suggestions for improvement.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 5','Topic Selection|Facilitated body language|Satisfactory|Could improve
Preparation|Excellent|Satisfactory|Could improve
Manner|Confident, enthusiastic|Satisfactory|Nervous, tense
Posture|Poised, balanced|Satisfactory|Could improve
Gestures|Natural, evocative|Satisfactory|Could improve
Body movement|Purposeful, smooth|Satisfactory|Awkward, distracting
Eye contact|Established visual bonds|Satisfactory|Could improve
Facial expression|Animated, friendly, genuine|Satisfactory|Could improve
Speech Purpose|Clear|Satisfactory|Could improve
Speech organization|Logical, clear|Satisfactory|Could improve
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 6','Executive Summary:
Your voice has a major effect on your audience. A lively, exciting voice attracts and keeps listeners&apos; attention. A speaking voice should be pleasant, natural, forceful, expressive and easily heard. Use volume, pitch, rate and quality as well as appropriate pauses to reflect and add meaning and interest to your message. Your voice should reflect the thoughts you are presenting. Review Your Speaking Voice (Catalog No. 199), which you received in your New Member Kit.

Objectives:
* Use voice volume, pitch, rate and quality to reflect and add meaning and interest to your message.
* Use pauses to enhance your message.
* Use vocal variety smoothly and naturally.
* Time: Five to seven minutes.

Note To The Evaluator:
The speaker is to use a voice that is pleasing to listen to, with proper balance of volume, pitch and rate, and use pauses to enhance his or her message. The speaker&apos;s voice should reflect and add meaning to the thoughts he or she is presenting. The speaker is to incorporate lessons learned in previous projects about purpose, organization, word usage and body language. In addition to your verbal evaluation, please complete this evaluation form by checking the appropriate space for each category. Add comments where praise is warranted or where you can offer specific suggestions for improvement.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 6','Topic Selection|Facilitated vocal variety|Satisfactory|Could Improve
Volume|Excellent|Satisfactory|Too loud or soft
Rate|Excellent, varied|Satisfactory|Too fast or too slow
Pitch|Varied, conversational|Satisfactory|Monotonous, artificial
Quality|Pleasant, friendly|Satisfactory|Harsh, monotonous
Pauses|Appropriate, effective|Satisfactory|Could improve
Expressiveness|Conveyed emotion, meaning|Satisfactory|Could improve
Vocal variety|Enhanced speech|Satisfactory|Could improve
Organization|Logical flow of ideas|Satisfactory|Should improve
Word Usage|Vivid, descriptive, accurate|Satisfactory|Could improve
Body language|Natural, expressive|Satisfactory|Unnatural, distracting
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 7','Executive Summary:
Your speech will be more effective if you can support your main points with statistics, testimony, stories, anecdotes, examples, visual aids and facts. You can find this material on the Internet, at a library and in other places. Use information collected from numerous sources and carefully support points with specific facts, examples and illustrations, rather than with just your own opinions.
Objectives:
* Collect information about your topic from numerous sources.
* Carefully support your points and opinions with specific facts, examples and illustrations gathered through research.
* Time: Five to seven minutes.
Note To The Evaluator:
The speaker is to select a subject of importance to the audience that requires a large amount of research. The speaker is to collect information from numerous sources and carefully support points with specific facts, examples, and illustrations, rather than with just the speaker&apos;s own opinions. The speaker is to incorporate what he or she has learned in previous projects about purpose, organization, word usage, body language and vocal variety, as well as use appropriate suggestions from the evaluations received. In addition to your verbal evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 7','* How well did the speaker s topic apply to the audience?
* Was the topic well researched?
* How well did the speaker support his or her main points?
* Was the support material appropriate for the point made?
* Did the speaker vary the types of support material?
* How clear was the speaker&apos;s purpose?
* Was the speech effectively organized?
* Did the speaker take advantage of body language and vocal variety?
* What could the speaker have done differently to improve the speech?
* What did you like about the speech?

',false);

update_option('evalintro:COMPETENT COMMUNICATION 8','Executive Summary:
Visual aids help an audience understand and remember what they hear; they are a valuable tool for speakers. The most popular visual aids are computer-based visuals, overhead transparencies, flip charts, whiteboards and props. The type of visual aid you choose depends on several factors, including the information you wish to display and the size of the audience. Visuals must be appropriate for your message and the audience, and be displayed correctly with ease and confidence.
Objectives:
* Select visual aids that are appropriate for your message and the audience.
* Use visual aids correctly with ease and confidence.
* Time: Five to seven minutes.
Note To The Evaluator:
The speaker is to present a speech that uses two or more visual aids. The visual aids selected must be appropriate for the message and audience, and be displayed correctly with ease and confidence. The speaker is to incorporate what he or she has learned in previous projects about purpose, organization, word usage, body language and vocal variety. The speaker also is to use appropriate suggestions from the evaluations received and thoroughly research the subject. Please complete this evaluation form by checking the appropriate column for each item. Add comments for items where special praise is warranted or where you can offer specific suggestions for improvement.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 8','Were the visual aids appropriate for the speech and message?|Excellent|Satisfactory|Could Improve
Did each visual aid help you to understand and remember the speaker&apos;s point?|Excellent|Satisfactory|Could Improve
Was each visual aid clearly visible?|Excellent|Satisfactory|Could Improve
If the speaker used computer-based visuals or overhead transparencies, was each visual easy to read and well-designed?|Excellent|Satisfactory|Could Improve
Did the speaker use the visual aids smoothly and with confidence?|Excellent|Satisfactory|Could Improve
How clear was the speaker&apos;s purpose?|Excellent|Satisfactory|Could Improve
Did the speaker use body language to reinforce the message?|Excellent|Satisfactory|Could Improve
Was the speaker&apos;s word choice effective and appropriate?|Excellent|Satisfactory|Could Improve
Was the speech well-researched?|Excellent|Satisfactory|Could Improve
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?

',false);

update_option('evalintro:COMPETENT COMMUNICATION 9','Executive Summary:
The ability to persuade people â€“ getting them to understand, accept and act upon your ideas â€“ is a valuable skill. Your listeners will more likely be persuaded if they perceive you as credible, if you use logic and emotion in your appeal, if you carefully structure your speech and if you appeal to their interests. Avoid using notes because they may cause listeners to doubt your sincerity, knowledge and conviction.
Objectives:
* Persuade listeners to adopt your viewpoint or ideas or to take some action.
* Appeal to the audience&apos;s interests.
* Use logic and emotion to support your position.
* Avoid using notes.
* Time: Five to seven minutes.
Note To The Evaluator:
The speaker is to present a persuasive speech that combines logical support for his/her viewpoint with a strong emotional appeal. The speech should focus on the self-interest of the audience. The speaker also has been asked to avoid using notes, if possible. In addition to your oral evaluation, please complete this evaluation form by checking the appropriate column for each item. Add your comments only for those items where special praise is warranted, or where you can offer specific suggestions for improvement.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 9','Did the speaker project sincerity and conviction?|Excellent|Satisfactory|Could Improve
Was the speaker a credible source of information about this topic?|Excellent|Satisfactory|Could Improve
Did the speaker phrase his/her appeal in terms of the audience&apos;s self-interest?|Excellent|Satisfactory|Could Improve
Did the speech opening capture the audience&apos;s interest?|Excellent|Satisfactory|Could Improve
Did the speaker use facts and logical reasoning to support his or her views?|Excellent|Satisfactory|Could Improve
Did the speaker properly use emotion to persuade the audience to support his or her views?|Excellent|Satisfactory|Could Improve
Was the speech organization effective?|Excellent|Satisfactory|Could Improve
Did the speaker&apos;s body language and vocal variety contribute to the message?|Excellent|Satisfactory|Could Improve
Were you persuaded to accept the speaker&apos;s views?|Excellent|Satisfactory|Could Improve
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?
',false);

update_option('evalintro:COMPETENT COMMUNICATION 10','Executive Summary:
An inspirational speech motivates an audience to improve personally, emotionally professionally or spiritually and relies heavily on emotional appeal. It brings the audience together in a mood of fellowship and shared desire, builds the audience&apos;s enthusiasm, then proposes a change or plan and appeals to the audience to adopt this change or plan. This speech will last longer than your previous talks, so make arrangements in advance with your Vice President Education for extra time.
Objectives:
* To inspire the audience by appealing to noble motives and challenging the audience to achieve a higher level of beliefs or achievement.
* Appeal to the audience&apos;s needs and emotions, using stories, anecdotes and quotes to add drama.
* Avoid using notes.
* Time: Eight to 10 minutes.
Note To The Evaluator:
The speaker is to inspire the audience to improve personally, emotionally, professionally or spiritually, relying heavily on emotional appeal. The speech should appeal to noble motives and challenge the audience to achieve a higher level of beliefs or achievement. The speaker is to use the skills learned in previous projects and not use notes. In additional to your verbal evaluation, please complete this evaluation form by checking the appropriate column for each item. Add comments for those items where special praise is warranted, or where you can offer specific suggestions for improvement.
',false);
update_option('evalprompts:COMPETENT COMMUNICATION 10','Was the speech topic relevant to the occasion selected?|Excellent|Satisfactory|Could Improve
Did the speaker understand and express the feelings and needs of the audience?|Excellent|Satisfactory|Could Improve
Was the speaker forceful, confident and positive?|Excellent|Satisfactory|Could Improve
Did the speaker effectively use stories, anecdotes and/ or quotes to help convey his or her message?|Excellent|Satisfactory|Could Improve
Did the speaker&apos;s words convey strong, vivid mental images?|Excellent|Satisfactory|Could Improve
Did the speaker&apos;s use of body language enhance his or her message?|Excellent|Satisfactory|Could Improve
Did the speech uplift the audience and motivate them as the speaker intended?|Excellent|Satisfactory|Could Improve
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?
',false);

update_option('evalintro:ADVANCED MANUAL TBD 1','',false);
update_option('evalprompts:ADVANCED MANUAL TBD 1','',false);

update_option('evalintro:COMMUNICATING ON VIDEO 1','Objectives
* To effectively present an opinion or viewpoint in a short time.
* To simulate giving a presentation as part of a television broadcast.
* TIME: 3 minutes, plus or minus 30 seconds.

Note to the Evaluator:
For this project, the speaker was asked to prepare and present an editorial designed for an &quot;on camera&quot; television presentation. The editorial should clearly
present the news event or current issue that it addresses, and present a reaction or stand to the event or issue. Although the presentation may be videotaped, your evaluation will be based on the live presentation. However, it is suggested you review the videotape later with the speaker and discuss how effective the presentation would have been had it actually been broadcast. It is suggested you read the entire project and the appendix before you hear the presentation.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 1','What was the news event or current issue on which the editorial was based?
What reaction did the speaker have toward the news event or issue? Was it clearly presented?
Did the speaker show sound logic and reasoning in explaining his / her viewpoint?
Were the words carefully chosen, short and clearly pronounced?
Did the speaker relate convincingly to the television camera?
Was the speaker&apos;s appearance appropriate? How did his or her appearance affect the editorial
How effective do you feel the editorial would have been had it actually been broadcast?
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 2','Objectives
* To understand the dynamics of a television Interview or "talk" show.
* To prepare for the questions that may be asked of you during a television
interview program.
* To present a positive image on the television camera.
* To appear as a guest on a simulated television talk show.
* TIME: 10 minutes, plus or minus 30 seconds.

Note to the Evaluator
The speaker was asked to appear as a guest on a simulated television "talk" show, with another club member serving as the talk show host or interviewer, and the rest of the club acting as the studio audience. The speaker was to answer questions asked by the interviewer. Questions were to be based on the expertise of the speaker in a predetermined subject. Although the presentation may be videotape, your evaluation will be based on the live presentation. However, it is suggested that you review the videotape later with the speaker and discuss how effective the presentation would have been had it actually been broadcast. It is suggested you read the entire project and the appendix before you hear the presentation. Remember, you will be evaluating only the "guest," not the "host."
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 2','How prepared was the speaker? What indicated this?
How effectively did the speaker answer the questions? Did the speaker show enthusiasm?
How did the speaker use a story or anecdote to illustrate or emphasize a point?
Did the speaker appear relaxed, confident and poised? Were the speaker&apos;s gestures / body movements appropriate for the special requirements on television? Did the speaker relate appropriately to the studio audience?
How did the speaker&apos;s appearance (clothing, makeup, etc.) enhance or detract from the presentation?
How effective do you feel the speaker would have been on a "real" talk show?
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 3','Objectives
* To conduct a successful television interview.
* To understand the dynamics of a successful television interview or &quot;talk&quot;
show.
* To prepare questions to ask during the interview program.
* To present a positive, confident image on the television camera
* TIME: 10 minutes, plus or minus 30 seconds.
Note to the Evaluator
The speaker was asked to appear as a host on a simulated television "talk" show, with another member serving as the guest. The speaker was to conduct an interview, asking questions of the guest and maintaining a smooth flow of conversation. Questions were to be based on the expertise of the speaker on a predetermined subject.

Although the presentation may be videotaped, your evaluation will be based on the live presentation. However, it is suggested that you review the videotape later with the speaker and discuss how effective the presentation would have been had it actually been broadcast. It is suggested you read the entire project and the appendix before you hear the presentation.

Remember, you will be evaluating only the "host," not the "guest."
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 3','How well-prepared was the speaker?
How effectively did the speaker lead the interview? Were questions clear? Were they in logical sequence?
What was the guest&apos;s field of expertise? Did the speaker make this clear in the guest&apos;s introduction?
Did the speaker appear relaxed, confident and poised? Were gestures/body movements appropriate for the special requirements of television?
How well did the speaker relate to the television camera and the studio audience? Was eye contact with the camera made at the appropriate times?
How did the speaker&apos;s appearance (clothing, makeup, etc.) affect your impression of the presentation?
How effective do you feel the speaker would have been had it been a "real" talk show?
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 4','Objectives
* To understand the nature of a television press conference.
* To prepare for an adversary confrontation on a controversial or sensitive issue.
* To employ appropriate preparation methods and strategies for communicating your organization&apos;s viewpoint.
* To present and maintain a positive image on television.
* TIME: 4 to 6 minutes for presentation, 8 to 10 minutes for question period.

Note to the Evaluator
The purpose of this talk is to make a presentation on a controversial issue or situation concerning the speaker&apos;s company or other organization he/she represents.  The speaker then will conduct a question-and-answer-period.  Throughout the speech and question period, the speaker is to build and maintain a positive image for himself/herself and the company or organization.   Although the presentation may be videotaped, your evaluation will be based on the live presentation.  However, it is suggested that you review the videotape later with the speaker and discuss how effective the presentation would have been had it actually been broadcast. It is suggested you read the entire project and the appendix before you hear the presentation.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 4','How effectively did the speaker present his or her massage?
Was the speaker able to maintain control of the conference during the question-and-answer period?
How convincing was the speaker in explaining the company or organization&apos;s position on the issue or situation? Was he or she prepared?
How effective was the speaker in building or maintaining a positive image for himself or herself and the company or organization?
Comment on the speaker&apos;s appearance, gestures and body movements. Were they appropriate for television?
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 5','Objectives
* To learn how to develop and present an effective training program on television.
* To receive personal feedback through the videotaping of your presentation.
* TIME: 5 to 7 minutes for the presentation, plus 5 to 7 minutes for playback of the videotape.

Note to the Evaluator:
In this project, the speaker is to present a training program on how to prepare and present a speech.  The presentation will be videotaped and played back during the meeting.  You and a panel of three other evaluators, under the direction of the General Evaluator, will evaluate only the videotaped playback of the presentation.  You will evaluate the effectiveness of the training program and the speaker&apos;s performance on videotape. It is suggested you read the entire project and the appendix before you view the presentation.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 5','What were the objectives of the training program? How effectively did the speaker fulfill the objectives?
How was the training program directed toward the needs of the audience?
Was the training program organized clearly and logically? Was the audience given the information necessary to accomplish what the speaker wanted done?
Comment on the speaker&apos;s voice, gestures and facial expressions. Were they used with moderation or did they overpower the television viewer? Was the voice modulated in pitch and volume?
Did the speaker appear relaxed, confident and poised? How well did the speaker relate to the television camera? What, if any, distracting mannerisms did the speaker display?
',false);

update_option('evalintro:FACILITATING DISCUSSION 1','OBJECTIVES
* Select a topic for a panel discussion
* Identify different viewpoints to be addressed by panelists
* Organize and moderate a panel discussion
* Recommended Time:  28 to 30 minutes
* Optional Time:  22 to 26 minutes

',false);
update_option('evalprompts:FACILITATING DISCUSSION 1','Was the topic selected appropriate for a pane discussion?
In opening the panel discussion, how well did the moderator explain the topic and its purpose?
How well did the moderator introduce each panelist and their presentation topics?
How effectively did the moderator control the panel s time?
How effectively did the moderator manage the question and answer session?
How could the moderator have been more effective?
What did the moderator do well?

',false);

update_option('evalintro:FACILITATING DISCUSSION 2','OBJECTIVES
* Select a problem for a brainstorming session for which you serve as facilitator
* Conduct a brainstorming session
* Have participants reduce the list of ideas to the three best
* Recommended Time:  31-33 minutes
* Optional Time:  20 to 22 minutes

',false);
update_option('evalprompts:FACILITATING DISCUSSION 2','Was the topic narrow enough and appropriately worded that the group could accomplish its objectives within the allotted time?
How well did the facilitator encourage participants to contribute ideas?
What could the facilitator have done differently to help the group generate ideas?
How effectively did the facilitator guide the group in reducing the list of ideas to the three best or most practical ones?
In what way s could the facilitator have been more helpful to the group in making their decisions?
How well did the facilitator remain neutral during the discussion?
What did the facilitator do well?

',false);

update_option('evalintro:FACILITATING DISCUSSION 3','OBJECTIVES
* Discuss the three ideas generated in Project 2
* Determine which one best resolves the problem
* Recommended Time:  26 to 31 minutes
* Optional Time:  19 to 23 minutes

',false);
update_option('evalprompts:FACILITATING DISCUSSION 3','Was the topic narrow enough and worded appropriately that the group could reach a decision within the allotted time?
How well did the facilitator use different types of questions to encourage participants to contribute ideas, opinions, and suggestions?
Was the facilitator able to remain neutral during the discussion?
In what way s could the facilitator have been more helpful to the group as it tried to reach a decision?
How did the facilitator control the flow of the discussion so everyone had the opportunity to be heard?
What did the facilitator do well?

',false);

update_option('evalintro:FACILITATING DISCUSSION 4','OBJECTIVES
* Select a problem and ask club members to discuss and resolve it by either majority vote or by compromise
* Serve as facilitator for the discussion
* Effectively handle any member&apos;s behavioral problems that may interfere with the discussion
* Recommended Time:  22 to 32 minutes
* Optional Time:  12 to 21 minutes

',false);
update_option('evalprompts:FACILITATING DISCUSSION 4','Was the topic narrow enough and worded appropriately that the group could reach a decision within the allotted time?
How well did the facilitator encourage participants to contribute ideas, opinions, and suggestions?
How well did the facilitator remain neutral during the discussion?
How effectively did the facilitator handle those people with behavioral problems?
What could the facilitator do differently that may be more effective in handling the behavioral problems?
What did the facilitator do well?
In what way s could the facilitator be more helpful to the group as it tried to reach a decision?

',false);

update_option('evalintro:FACILITATING DISCUSSION 5','OBJECTIVES
* To select a problem for the group to discuss and resolve
* As facilitator, help the group reach a consensus
* Recommended Time:  31 to 37 minutes
* Optional Time:  20 to 26 minutes

',false);
update_option('evalprompts:FACILITATING DISCUSSION 5','Was the topic narrow enough and worded appropriately that the group could reach a consensus within the allotted time?
How well did the facilitator encourage participants to contribute ideas, opinions, and suggestions?
Did the facilitator help the group identify areas of agreement and disagreement?
How effectively did the facilitator help the group explore alternatives?
How well did the facilitator remain neutral during the discussion?
In what way s could the facilitator have been more helpful to the group as it tried to reach a consensus?
What did the facilitator do well?

',false);

update_option('evalintro:HUMOROUSLY SPEAKING 1','OBJECTIVES
* Prepare a speech that opens with a humorous story
* Personalize the story
* Deliver the story smoothly and effectively
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:HUMOROUSLY SPEAKING 1','How well did the opening story relate to the speech topic?
Was the story appropriate for the audience?
Was the story amusing to you?
Did the story attract and keep your attention?
How did the speaker s delivery of the story help or hinder the story s impact on you?
How could the speaker improve the story s delivery? Comment on the setup, delivery, and pause.
How comfortable and confident did the speaker appear to be while telling the story?
Was the speech body organized clearly and logically?
What could the speaker do to improve the speech?

',false);

update_option('evalintro:HUMOROUSLY SPEAKING 2','OBJECTIVES
* Prepare a serious speech that opens and closes with humorous stories
* Prepare a closing story that reemphasizes the speech&apos;s main point
* Deliver the stories smoothly and effectively
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:HUMOROUSLY SPEAKING 2','How well did the opening story relate to the speech topic?
How well did the closing story reemphasize the speech s main point?
How appropriate were both stories for the audience?
How amusing were the stories to you?
How effectively did the closing story end the speech?
How comfortable and confident did the speaker appear while telling both stories?
How well did the speaker deliver the set ups, pauses before the punch lines, punch lines, punch words, and the ending pauses for both stories?

',false);

update_option('evalintro:HUMOROUSLY SPEAKING 3','OBJECTIVES
* Prepare a speech that opens and closes with humorous stories
* Include jokes in the speech body to illustrate points or maintain audience interest
* Deliver the jokes and stories smoothly and effectively
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:HUMOROUSLY SPEAKING 3','How well did the opening story relate to the speech topic?
How well did the closing story reemphasize the speech s main point?
How well did the jokes illustrate or emphasize the speaker s points?
If the speech had any tedious or complex parts, were jokes used to break them up? If so, how effective were the jokes at doing so?
How smooth were the transitions between the jokes and the speech body?
How comfortable and confident did the speaker appear while telling the stories and jokes?
How well did the speaker deliver the set ups, pauses before the punch lines, punch lines, punch words, and the ending pauses for the stories and jokes?
Were the stories and jokes appropriate? Were they amusing to you?

',false);

update_option('evalintro:HUMOROUSLY SPEAKING 4','OBJECTIVES
* Prepare a speech that opens with a self-deprecating joke
* String together two or three related jokes in the speech body
* Close the speech with a humorous story
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:HUMOROUSLY SPEAKING 4','How effective was the opening joke in breaking the ice with the audience?
How well did the jokes illustrate or emphasize the speaker s points?
How well was each set of jokes in the speech body tied together?
If any parts of the speech were tedious or complex, were jokes used to break them up? If so, did the jokes succeed in doing so?
How smooth were the transitions between the jokes and the speech body?
How well did the closing story reemphasize the speech s main point?
How comfortable or confident did the speaker appear while telling the jokes and story?
Were the story and jokes amusing to you? If not, why?

',false);

update_option('evalintro:HUMOROUSLY SPEAKING 5','OBJECTIVES
* Use exaggeration to tell a humorous story
* Entertain the audience
* Effectively use body language and voice to enhance the story
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:HUMOROUSLY SPEAKING 5','What indicated to you that the audience was entertained?
What made the speech humorous?
How well did the jokes stories fit the theme of the speech?
Did any of the stories jokes seem awkward to you? Which ones? Why?
How did the speaker s body language and vocal variety add impact to the speech?
How well did the speaker tie stories jokes together? Were transitions smooth?
What could the speaker have done to improve the presentation?

',false);

update_option('evalintro:INTERPERSONAL COMMUNICATIONS 1','OBJECTIVES
* Identify techniques to use in conversing with strangers
* Recognize different levels of conversation
* Initiate a conversation with a stranger
* Use open-ended questions to solicit information for further conversation
* Time:  10 to 14 minutes

',false);
update_option('evalprompts:INTERPERSONAL COMMUNICATIONS 1','How well did the speaker explain the value of conversational skills and different conversational techniques?
How effectively did the speaker initiate the conversation?
How did the speaker establish common interest with the other person?
How effectively did the speaker use open ended questions to carry on the conversation?
How did the speaker advance from one level to another? The levels are small talk, fact disclosure, viewpoints and opinions, personal feelings.
How comfortable did the speaker appear to be in the conversation?
What could the speaker have said differently that may have been more effective?

',false);

update_option('evalintro:INTERPERSONAL COMMUNICATIONS 2','OBJECTIVES
* Employ win/win negotiating strategies to achieve your goals
* Enjoy the benefits of win/win negotiating
* Time:  10 to 14 minutes

',false);
update_option('evalprompts:INTERPERSONAL COMMUNICATIONS 2','How clearly did the speaker explain the negotiation process?
How did the speaker break the ice and establish a good relationship with the other party?
How effectively did the speaker address the needs and wants of the other party?
Did the speaker clearly indicate his or her wants and needs and the reasons for them?
Did the speaker achieve his or her goal?
What could the speaker have said or done differently to be more effective?

',false);

update_option('evalintro:INTERPERSONAL COMMUNICATIONS 3','OBJECTIVES
* Respond non-defensively to verbal criticism
* Employ a five-step method to identify the problem, diffuse the attack, and arrive at a solution
* Time:  10 to 14 minutes

',false);
update_option('evalprompts:INTERPERSONAL COMMUNICATIONS 3','How effectively did the speaker explain how to handle verbal criticism?
Did the speaker respond non-defensively to the criticism?
How did the speaker indicate he or she was listening to the criticism with an open mind?
How did the speaker determine the reason(s) for the criticism?
Was the speaker able to discuss a solution with the criticizer?
What could the speaker have said or done differently that would have been more effective?

',false);

update_option('evalintro:INTERPERSONAL COMMUNICATIONS 4','OBJECTIVES
* Determine reasons for someone&apos;s substandard performance
* Coach the person to improved performance
* Time:  10 to 14 minutes


',false);
update_option('evalprompts:INTERPERSONAL COMMUNICATIONS 4','How clearly did the speaker explain the coaching process?
What was preventing the person from performing satisfactorily?  How did the speaker determine this reason?
How effectively did the speaker begin the coaching session?
How did the speaker work with the person to arrive at a solution?
Did the speaker focus on describing behavior rather than evaluating or judging it?
How did the speaker avoid putting the person on the defensive?
How effective was the coaching session?  If you were the person being coached, would you be motivated to improve?

',false);

update_option('evalintro:INTERPERSONAL COMMUNICATIONS 5','OBJECTIVES
* Enjoy the physical and mental benefits of being assertive
* Employ the four-step method for addressing a problem and asking for help
* Overcome resistance to your requests
* Time:  10 to 14 minutes

',false);
update_option('evalprompts:INTERPERSONAL COMMUNICATIONS 5','How well did the speaker explain how to express dissatisfaction effectively?
How effectively did the speaker follow the four-step method when addressing the problem?
Did the speaker clearly state the problem and the remedy?
If you were the other person, would you want to fulfill the speaker&apos;s request?
How did the speaker overcome resistance?

',false);

update_option('evalintro:INTERPRETIVE READING 1','OBJECTIVES
* To understand the elements of interpretive reading
* To learn how to analyze a narrative and plan for effective interpretation
* To learn and apply vocal techniques that will aid in the effectiveness of the reading
* Time:  8 to 10 minutes

',false);
update_option('evalprompts:INTERPRETIVE READING 1','Was the theme understandable and the storyline clear?
To what degree did the speaker achieve the author s purpose in projecting the meaning and the emotions of the message?
How did the speaker emphasize the words which were important in revealing the narrative s meaning and emotions?
How did the speaker build the story s climax?
Did the introduction and transitions if any help you better understand the narrative?
Was the speaker able to establish and maintain eye contact with the audience?
Did the speaker appear to be spontaneous during the presentation?
What could the speaker have done differently to improve the presentation?
What did you like about the presentation?

',false);

update_option('evalintro:INTERPRETIVE READING 2','OBJECTIVES
* To understand the differences between poetry and prose
* To recognize how poets use imagery, rhythm, meter, cadence, and rhyme to convey the meanings and emotions of their poetry
* To apply vocal techniques that will aid the effectiveness of the reading
* Time:  6 to 8 minutes

',false);
update_option('evalprompts:INTERPRETIVE READING 2','How was the speaker able to express the thoughts and emotions of the poem?
Did the speaker understand the poem? Was the speaker able to envision the pictures painted by the poet?
Did the speaker make effective use of pauses, rhythm, and cadence?
Did the speaker avoid a sing song rhythm?
What kind of eye contact did the speaker have with the audience? Was it appropriate for the type of presentation?
Was the speaker well prepared and familiar with the material?
What could the speaker have done differently to improve the presentation?
What did you like about the presentation?

',false);

update_option('evalintro:INTERPRETIVE READING 3','OBJECTIVES
* To understand the concept and nature of the monodrama
* To assume the identity of a character and to portray the physical and emotional aspects of this character to an audience
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:INTERPRETIVE READING 3','Was the character clearly defined by the speaker?
Did the speaker effectively express the conflict in which the character was involved?
How effectively did the speaker use voice and gestures body movements?
Did the speaker successfully avoid eye contact with the audience?
With what parts of the monodrama did the speaker appear most comfortable?
Did the speaker display any distracting mannerisms?
What could the speaker have done differently to improve the presentation?
What did you like about the presentation?

',false);

update_option('evalintro:INTERPRETIVE READING 4','OBJECTIVES
* To adapt a play for interpretive reading
* To portray several characters in one reading, identifying them to the audience through voice changes and movement
* Time:  12 to 15 minutes

',false);
update_option('evalprompts:INTERPRETIVE READING 4','Were the characters vocally, physically, and emotionally distinct? Were character changes smooth and quick?
Did the pitch or tempo of any character distract you?
Was the plot of the play clear? Was the play properly cut so it flowed smoothly? Were transitions clear?
How did the speaker build to the climax of the play?
Did the speaker have eye contact with the audience? Was eye contact appropriate for this presentation?
What could the speaker have done differently to improve the presentation?
What did you like about the presentation?

',false);

update_option('evalintro:INTERPRETIVE READING 5','OBJECTIVES
* To understand the structure of an effective speech
* To interpret and present a famous speech
* Time:  8 to 10 minutes

',false);
update_option('evalprompts:INTERPRETIVE READING 5','Did the speaker reveal the original speaker intelligently, significantly, and with adequate feeling?
Was the speaker comfortable with the speech?
How did the speaker establish rapport with the audience? Did the speaker address the audience, not the book?
Did the speaker inspire the audience?
What could the speaker have done differently to improve the presentation?
What did you like about the presentation?

',false);

update_option('evalintro:Other Manual or Non Manual Speech 1','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 1','',false);

update_option('evalintro:Other Manual or Non Manual Speech 2','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 2','',false);

update_option('evalintro:Other Manual or Non Manual Speech 3','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 3','',false);

update_option('evalintro:Other Manual or Non Manual Speech 4','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 4','',false);

update_option('evalintro:Other Manual or Non Manual Speech 5','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 5','',false);

update_option('evalintro:Other Manual or Non Manual Speech 6','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 6','',false);

update_option('evalintro:Other Manual or Non Manual Speech 7','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 7','',false);

update_option('evalintro:Other Manual or Non Manual Speech 8','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 8','',false);

update_option('evalintro:Other Manual or Non Manual Speech 9','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 9','',false);

update_option('evalintro:Other Manual or Non Manual Speech 10','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 10','',false);

update_option('evalintro:Other Manual or Non Manual Speech 11','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 11','',false);

update_option('evalintro:Other Manual or Non Manual Speech 12','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 12','',false);

update_option('evalintro:Other Manual or Non Manual Speech 13','',false);
update_option('evalprompts:Other Manual or Non Manual Speech 13','',false);

update_option('evalintro:PERSUASIVE SPEAKING 1','OBJECTIVES
* Learn a technique for selling an inexpensive product in a retail store
* Recognize a buyer&apos;s though processes in making a purchase
* Elicit information from a prospective buyer through questions
* Match the buyer&apos;s situation with the most appropriate product
* Time:  8 to 12 minutes

',false);
update_option('evalprompts:PERSUASIVE SPEAKING 1','How well did the speaker explain the persuasive process used in retail sales of inexpensive items?
Was the speaker able to build rapport with the buyer?
How effective were the questions the speaker asked? How did the speaker use follow up questions to elicit more information?
What did the speaker do to show attentiveness to and concern for the buyer?
How knowledgeable did the speaker appear to be about the product s he or she was selling?
Was the speaker friendly, courteous, and polite?
How effective were the speaker s efforts to obtain commitment from the buyer?
What could the speaker have said to be more effective?
What did the speaker do especially well in the sales process?

',false);

update_option('evalintro:PERSUASIVE SPEAKING 2','OBJECTIVES
* Learn a technique for &quot;cold call&quot; selling of expensive products or services
* Recognize the risks buyers assume in purchasing
* Use questions to help the buyer discover problems with his or her current situation
* Successfully handle buyer&apos;s objections and concerns
* Time:  10 to 14 minutes

',false);
update_option('evalprompts:PERSUASIVE SPEAKING 2','How well did the speaker explain the persuasive process used in cold call sales of expensive items?
How effective were the questions in eliciting information from the buyer?
How effective were the questions in helping the buyer discover a problem exists?
Did the speaker avoid talking about his product until the buyer asked about it?
How well did the speaker handle any objections or concerns the buyer raised?
What could the speaker have said that would have been more effective?
What did the speaker do well?

',false);

update_option('evalintro:PERSUASIVE SPEAKING 3','OBJECTIVES
* Prepare a proposal advocating an idea or course of action
* Organize the proposal using the six-step method provided
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:PERSUASIVE SPEAKING 3','How clear was the proposal s objective?
How well was the proposal directed to the intended audience?
Did the speaker address the negative and positive aspects of the proposal?
Was the proposal well organized and logical?
How effective was the speaker s delivery?
What could the speaker have said to make the proposal more effective?

',false);

update_option('evalintro:PERSUASIVE SPEAKING 4','OBJECTIVES
* Prepare a talk on a controversial subject that persuades an audience to accept or at least consider your viewpoint
* Construct a speech to appeal to the audience&apos;s logic and emotions
* Time:  7 to 9 minutes for the speech, plus 2 to 3 minutes for the question and answer period

',false);
update_option('evalprompts:PERSUASIVE SPEAKING 4','How convincing was the speaker s presentation on his or her viewpoint?
How effectively did the speaker appeal to the listeners logic and emotions?
How well did the speaker use stories, anecdotes, and humor to add impact to the presentation?
Did the speaker appear sincere, friendly, and concerned for the audience?
How did the speaker s voice and use of eye contact contribute to the presentation s effectiveness?
How persuasive did you find the speech? Why?
What could the speaker have said to be more effective?
What did the speaker say that was especially effective?
How prepared did the speaker appear to be for the questions that were asked?
How effective was the speaker in responding in a positive manner to the questions that were asked?

',false);

update_option('evalintro:PERSUASIVE SPEAKING 5','OBJECTIVES
* Communicate your vision and mission to an audience
* Convince your audience to work toward achieving your vision and mission
* Time:  6 to 8 minutes

',false);
update_option('evalprompts:PERSUASIVE SPEAKING 5','How effectively did the speaker convey the vision and mission?
How did the speaker connect the vision and mission to the needs, wants, and hopes of the audience?
Did the speaker use stories and anecdotes to enhance the persuasive message?
What other devices gestures, body language, vocal variety, etc. did the speaker use to make the presentation more persuasive?
Did the speaker convince and motivate the audience to act?
What could the speaker have said to be more effective?
What did the speaker do well?

',false);

update_option('evalintro:PUBLIC RELATIONS 1','OBJECTIVES
* Prepare a talk that will build goodwill for your organization by supplying useful information of interest to the audience
* Favorably influence the audience by skillful and friendly delivery of your talk
* Time:  5 to 7 minutes
',false);
update_option('evalprompts:PUBLIC RELATIONS 1','How did the audience react to the speaker?
How was Toastmasters mentioned in the speech?  Was it brought in smoothly and naturally, or did it seem &quot;forced&quot; like an advertisement?
Comment on the information presented.  Did the speaker perform a service for the audience?
Assuming you knew nothing about this organization beforehand, would you be favorably impressed after this presentation?  Why?
What else might the speaker have said to promote Toastmasters?

',false);

update_option('evalintro:PUBLIC RELATIONS 2','OBJECTIVES
* Present a positive image of you and your company or organization on a simulated radio talk show
* Prepare a talk designed to build goodwill toward an organization by presenting factual information
* Understand the dynamics of a successful radio talk show
* Prepare for the questions that may be asked of you during the radio interview
* Time:  3 to 5 minutes for the presentation, plus 2 to 3 minutes for questions and answers
',false);
update_option('evalprompts:PUBLIC RELATIONS 2','Was the guest&apos;s expertise clearly established in the host&apos;s introduction?
How relevant was the speech to the audience and its interests and goals?
How thorough was the speaker&apos;s research?
How well did the speaker use vocal variety in conveying his or her message?  Did it detract from or enhance the message?
How effectively did the speaker answer the questions asked?
Assuming you had no previous knowledge of the speaker&apos;s organization, were you favorably impressed with the organization after listening to the presentation and the questions and answers?  Why?
How effective did you think the speaker would have been on a "real" talk show?
',false);

update_option('evalintro:PUBLIC RELATIONS 3','OBJECTIVES
* Direct a persuasive appeal to the audience&apos;s self-interests using a combination of fact and emotion in a speech delivered in such a manner that it appears extemporaneous
* Persuade the audience to adopt your viewpoint by the use of standard persuasive techniques
* Use at least one visual aid to enhance the audience&apos;s understanding
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:PUBLIC RELATIONS 3','How convincing was the speaker&apos;s argument on his or her viewpoint?
How effective was the speaker&apos;s emotional appeal?
How closely did the presentation relate to the audience&apos;s interests?
Comment on the smoothness and effectiveness of the talk.
How did the visual aid(s) contribute to the speaker&apos;s persuasive effort?
How persuasive was the speech?
Did the speaker change your opinion?  How?
What else might the speaker have done to convince you?

',false);

update_option('evalintro:PUBLIC RELATIONS 4','* Prepare a talk to persuade a hostile audience at least to consider your position on a controversial issue.
* Conduct a question-and-answer period on the speech subject.
* TIME : 6 to 8 minutes for speech - 8 to 10 minutes for question period.

Note to the Evaluator
The purpose of this talk is to present a 6-8 minutes speech to an audience assumed to be hostile to a position on a controversial issue.   The speaker should attempt to lessen the opposition and persuade the audience at least to accept that the position has some merit.  Following the speech, the speaker will conduct an 8 to 10 minutes question-and-answer period on the speech subject. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:PUBLIC RELATIONS 4','How effective was the speech&apos;s organization?
How did the speaker use logic and facts in support of his or her viewpoint?
How effectively did the speaker use emotion and appeals to the audience s self interest in support of his or her viewpoint?
How well did the speaker use eye contact to demonstrate sincerity?
How did the speaker use his or her voice to influence the audience?
If the speaker used visual aids, how did they contribute to the presentation?
How effectively did the speaker answer the questions?
Assuming you were initially opposed to the speaker &apos;s position, how would you feel after the presentation
',false);

update_option('evalintro:PUBLIC RELATIONS 5','OBJECTIVES
* Learn strategies for communicating to the media about a company crisis
* Prepare a speech for the media about a company crisis that builds and maintains a positive image for the company
* Answer questions from the media in a manner that reflects positively on the company
* Time:  4 to 6 minutes for the presentation, plus 3 to 5 minutes for questions and answers

',false);
update_option('evalprompts:PUBLIC RELATIONS 5','How effectively did the speaker present his or her message?
How convincing was the speaker in explaining the company s position on the situation?
How effectively did the speaker create and maintain a positive image of the company?
How skillfully did the speaker handle the questions?
What, if anything, could the speaker have said to better handle the situation?

',false);

update_option('evalintro:SPEAKING TO INFORM 1','THE SPEECH TO INFORM
Objectives
* Select new and useful information for presentation to the audience
* Organize the information for easy understandability and retention
* Present the information in a way that will help motivate the audience to learn
* TIME : 5 to 7 minutes
Note to the Evaluator
The purpose of this talk is for the speaker to present an informative speech of five to
seven minutes. The information should be presented in an interesting manner with
clear organization. The speaker should support the facts or points with statistics,
quotes, or experts&apos; opinions. In addition to your oral evaluation, please write answers
to the questions below.
',false);
update_option('evalprompts:SPEAKING TO INFORM 1','What made the speech interesting?
How effectively did the speech opening capture and hold your attention?
How comfortable and familiar did the speaker appear to be with his / her material?
How confident and in control did the speaker appear to be?
What was the organizational structure of the speech?
How did the speaker encourage the audience to learn?
How effectively did the speaker relate new information to the common experiences and knowledge of the audience?
What could the speaker have done to make the talk more effective?
What would you say is the speaker&apos;s strongest asset in informative speaking?
',false);

update_option('evalintro:SPEAKING TO INFORM 2','Objectives
* Analyze your audience regarding your chosen subject
* Focus your presentation at the audience&apos;s level of knowledge
* Build a supporting case for each major point using information gathered through
research
* Effectively use at least one visual aid to enhance the audience&apos;s understanding
* TIME : 5 to 7 minutes

Note to the Evaluator
The purpose of this talk is for the speaker to inform the audience on a subject of
interest in five to seven minutes. The talk should be directed to the interests of the
audience, with each major point strongly supported by research. The speaker is
required to use at least one visual aid to enhance the audience&apos;s understanding.
Please give written answers to the questions below in addition to your oral
evaluation.
',false);
update_option('evalprompts:SPEAKING TO INFORM 2','How well was the speech directed to the interests and background of the audience?
What methods did the speaker use to support his / her major points? How effective were these methods?
How did the visual aid(s) enhance audience understanding?
How knowledgeable did the speaker appear to be about the subject?
Did the speech appear to be well-researched?
',false);

update_option('evalintro:SPEAKING TO INFORM 3','Objectives
* Prepare a demonstration speech to clearly explain a process, product, or activity
* Conduct the demonstration as part of a speech delivered without notes
* TIME: 5 to 7 minutes
Note to the Evaluator
The purpose of this talk is for the speaker to present a demonstration talk of five to
seven minutes on a process, product, or activity. The speaker may use body
language, an actual object, or a model for the demonstration. The speech, delivered
without notes, should keep the audience interested, and each segment in the
demonstration should be explained clearly and specifically. In addition to your oral
evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEAKING TO INFORM 3','How did the speaker make the talk relevant to the audience&apos;s interest?
Describe the demonstration&apos;s impact on you.
How appropriate was the choice of demonstration method?
Was each part of the demonstration clearly explained?
What could the speaker have done to make the demonstration more effective?
What was the most effective part of the demonstration?
',false);

update_option('evalintro:SPEAKING TO INFORM 4','Objectives
* Prepare a report on a situation, even, or problem of interest to the audience
* Deliver sufficient factual information in your report so the audience can make valid conclusions or a sound decision
* Answer questions from the audience
* TIME: 5 to 7 minutes for the speech, and 2 to 3 minutes for the question-and-answer period

Note to the Evaluator
The purpose of this talk is for the speaker to deliver a fact-finding report of five to seven minutes on a situation, event, or problem. The information should be comprehensive and well-organized, as well as presented in an interesting manner. The talk should include an overview of the report, an explanation of how the data was gathered, and a thorough presentation of the relevant facts. The speaker is then to field questions from the audience. Please write answers to the questions below in addition to your oral evaluation.
',false);
update_option('evalprompts:SPEAKING TO INFORM 4','How well did the speaker explain the purpose of the report to the audience?
Was the report organized clearly and logically?
If the speaker used visual aids, did they help the audience to understand the information more easily and quickly?
Was enough information given on which the audience could base a sound decision or draw valid conclusions?
How prepared did the speaker appear to be for the questions that were asked?
How effective was the speaker in responding in a positive manner to the questions that were asked?
How well did the speaker conclude the question and answer period?
',false);

update_option('evalintro:SPEAKING TO INFORM 5','Objectives
* Research and analyze an abstract concept, theory, historical force, or social / political issue
* Present the ideas in a clear, interesting manner
* TIME: 6 to 8 minutes

Note to the Evaluator
The purpose of this talk is for the speaker to present a six to eight minutes analysis of a concept, idea, theory, historical force, or social / political issue. The talk should
be clear and interesting to the audience. The speaker&apos;s purpose is to clearly explain the meaning of the subject to the audience and use definitions, examples,
anecdotes, illustrations, quotes from experts, and visual aids to explain concepts. In addition to your oral evaluation, please answer the questions below in writing.
',false);
update_option('evalprompts:SPEAKING TO INFORM 5','How did the speaker define the scope of the speech subject?
Was the topic narrow enough to explain sufficiently in the time allotted?
How effectively did the speaker draw on experts&apos; opinions while discussing the subject?
How did the speaker make the talk interesting to the audience? How could the speaker have built greater interest?
',false);

update_option('evalintro:SPECIAL OCCASION SPEECHES 1','OBJECTIVES
* Recognize the characteristics of a toast
* Present a toast honoring an occasion or a person
* Time:  2 to 3 minutes
',false);
update_option('evalprompts:SPECIAL OCCASION SPEECHES 1','How well did the speaker indicate the occasion or person being honored?
Describe how effectively the speaker personalized the toast.
Were stories, anecdotes, or quotes used?
How effectively did the speaker use vocal variety and eye contact in presenting the toast?
Was the toast appropriate for the occasion or person being honored?
What could the speaker have done differently to make the toast more effective?
What did you like about the toast?
',false);

update_option('evalintro:SPECIAL OCCASION SPEECHES 2','OBJECTIVES
* Prepare a speech praising or honoring someone, either living or dead
* Address five areas concerning the individual and his/her accomplishments
* Include anecdotes illustrating points within the speech
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:SPECIAL OCCASION SPEECHES 2','How well did the speech suit the occasion?
What parts of the speech were most effective?
How effectively did the speaker identify and illustrate the individual&apos;s qualities, accomplishments, power and inspiration sources, and his/her impact on society and history?
How did the speaker use this individual&apos;s qualities and accomplishments to inspire the audience?
How well did the speaker use stories and anecdotes concerning the individual to illustrate points?
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?

',false);

update_option('evalintro:SPECIAL OCCASION SPEECHES 3','OBJECTIVES
* Poke fun at a particular individual in a good-natured way
* Adapt and personalize humorous material from other sources
* Deliver jokes and humorous stories effectively
* Time:  3 to 5 minutes

',false);
update_option('evalprompts:SPECIAL OCCASION SPEECHES 3','How well were the jokes and anecdotes adapted to the occasion and to the individual being roasted?
How did the speaker&apos;s delivery contribute to or hinder the effectiveness of the humorous material?
How effective were the jokes and anecdotes?
How did the speaker&apos;s body language and vocal variety add to the impact of the roast?
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?

',false);

update_option('evalintro:SPECIAL OCCASION SPEECHES 4','OBJECTIVES
* Present an award with dignity and grace
* Acknowledge the contributions of the recipient
* Time:  3 to 4 minutes

',false);
update_option('evalprompts:SPECIAL OCCASION SPEECHES 4','Did the speaker clearly explain the purpose of the award?
How effectively did the speaker convey the reasons the recipient deserved the award?
How sincere was the speaker in his/her praise?
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?

',false);

update_option('evalintro:SPECIAL OCCASION SPEECHES 5','OBJECTIVES
* Accept an award with dignity, grace, and sincerity
* Acknowledge the presenting organization
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:SPECIAL OCCASION SPEECHES 5','How effectively did the speaker express gratitude to the organization presenting the award?
How did the speaker recognize the organization presenting the award?
How sincere was the speaker in his/her thanks and gratitude?
Did the speaker appear comfortable and gracious while accepting the award?
What could the speaker have done differently to make the speech more effective?
What did you like about the speech?

',false);

update_option('evalintro:SPECIALTY SPEECHES 1','OBJECTIVES
* Develop an awareness of situations in which you might be called upon to deliver an impromptu speech
* Understand how to prepare for impromptu speaking
* Develop skill as a speaker in the impromptu situation by using one or more patterns to approach a topic under discussion; for example, comparing a past, present, and future situation or before and after
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:SPECIALTY SPEECHES 1','How effectively did the speaker organize his or her ideas?
What pattern or patterns were used?
Did he or she present a clear and definite message?
How well did the speaker draw upon his or her background of special knowledge?
Did the speaker let the audience know that he or she was knowledgeable in that particular subject area?
Did the speaker convey confidence in his or her authority to discuss the topic?
Did the speaker base his or her statements on fact or opinion?
What was the audience reaction?

',false);

update_option('evalintro:SPECIALTY SPEECHES 2','OBJECTIVES
* Identify and understand the basic differences and similarities between inspirational speeches and other kinds of speeches
* Learn how to evaluate audience feeling and establish emotional rapport
* Develop a speech style and delivery that effectively expresses inspirational content by moving the audience to adopt your views
* Time:  8 to 10 minutes

',false);
update_option('evalprompts:SPECIALTY SPEECHES 2','How did the audience respond to the speaker? Were they respectful? Tuned in to what was said? Were the emotionally moved? Did they believe in his or her views?
Comment on the information presented Was it well thought out and easily understood? Did you detect any element of confusion, doubt, or uncertainty?
Comment on the speaker s style and delivery, voice and gestures Were they of a superior quality of expression and did they fit the occasion?
Did the speech satisfy the expectations of the audience? Did it uplift the spirit of the audience? Ask them.

',false);

update_option('evalintro:SPECIALTY SPEECHES 3','OBJECTIVES
* Understand the relationship of sales techniques to persuasion
* Skillfully use the four steps in a sales presentation: attention, interest, desire, action
* Identify and promote a unique selling proposition in a sales presentation
* Be able to handle objections and close a prospective buyer
* Time:  10 to 12 minutes

',false);
update_option('evalprompts:SPECIALTY SPEECHES 3','Did the speaker get and hold the audience s attention?
Did the speaker generate interest and desire by focusing on the benefits of the product or service to the customer?
Did the speaker offer a unique selling position USP ?
Did the speaker build value into his or her speech through the use of positive word choice, personal enthusiasm, and effective use of displays and audiovisuals?
If any objections were voiced, did the speaker handle them effectively?
Did the speaker make the close action smoothly and at the appropriate time?
Did the speaker sell? If not, why not?

',false);

update_option('evalintro:SPECIALTY SPEECHES 4','OBJECTIVES
* Arrive at an understanding of the elements that comprise oral interpretation and how it differs from preparing and giving a speech
* Learn the preparation or planning techniques of effective interpretation
* Learn the principles of presentation and develop skill in interpretive reading with regard to voice and body as instruments of communication
* Time:  12 to 15 minutes

',false);
update_option('evalprompts:SPECIALTY SPEECHES 4','Was the theme clearly understandable and the narrative or story line clear?
Did the reader make effective use of vocal variation, tone, mood, inflection, rhythm, and body movements to create an auditory and visual experience for the audience?
Did the reader convey a sense of the author s style? If not, suggest technical areas the reader might work on.
Did the reader present the work leading to a crisis or major climax?
Were the introduction and transitions informative and effective?
Did the reader create an illusion of spontaneity during the presentation?

',false);

update_option('evalintro:SPECIALTY SPEECHES 5','OBJECTIVES
* Focus on the special occasion talk from the standpoint of the introducer (function chairman, toastmaster, master of ceremonies)
* Become knowledgeable and skilled in the functions associated with master of ceremonies
* Handle the introduction of other speakers at a club meeting
* Time:  The duration of a club meeting

',false);
update_option('evalprompts:SPECIALTY SPEECHES 5','Did the toastmaster make reference to the program to warm up the audience?
Did the toastmaster refer to the other speakers and their topics?
Did the toastmaster stimulate the interest of the audience and start the applause?
Did the toastmaster make reference to the qualifications of the other speakers?
Did the toastmaster highlight the other speaker s backgrounds directly related to the subjects of the talks?
Did the toastmaster convey too much information about the other speakers topics?
Did the toastmaster wait for the other speaker to arrive the lectern before sitting down?

',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 1','Objectives
* Apply the key steps in the preparation of a briefing and the organization of material.
* Give a briefing according to a specific objective so the audience will have an understanding of the information.
* Effectively handle a question-and-answer session following the briefing.
* TIME : 8 to 10 minutes for speech, 5 minutes for question period.

Note to the Evaluator

The purpose of this presentation was for the speaker, as a manager, to deliver an 8 to 10 minutes briefing to employees or associates to explain, instruct, persuade, or report.  The goal of the briefing was the effective communication of procedures, concepts, ideas, and data to accomplish specific objectives. The speaker may use visual aids to amplify the information.  A five minute question-and-answer session should follow the presentation. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 1','Did the speaker state the purpose of the briefing and put the audience in a receptive frame of mind?
During the introduction, did the speaker supply necessary background information? Was the objective clear? State the objective.
In the body of the speech, what methods did the speaker use to explain sources, methods, and criteria to convey main ideas?
In the conclusion, did the speaker capsulate what the audience should remember?
Were the main ideas summarized? When during the briefing were they summarized? How many times were they mentioned?
Did the speaker review the purpose of the briefing and call for action?
How effectively did the speaker make use of visual aids? If they were not effective, explain why and suggest how they could have been. (It is not required that the speaker use visual aids.)
Did the speaker effectively handle the question-and-answer period?
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 2','* Convert a technical paper or technical material and information into a technical speech.
* Organize a technical speech according to the inverted-pyramid approach.
* Write a technical speech as &quot;spoken language,&quot; not as an article.
* Give the speech by effectively reading out loud.
* TIME : 8 to 10 minutes

Note to the Evaluator
The purpose of this presentation was for the speaker, as a manager, to deliver an 8 to 10 minutes technical speech to be read out loud.  The speech should have the sound and manner of a spoken, not a written presentation.  The speaker should maintain eye contact with the audience, and use vocal variety and gestures. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 2','Did the speaker use the inverted-pyramid approach, following conclusions and recommendations with analysis, then details?
Did the speech sound like it was written to be heard or listened to? If not, what elements made it sound like written rather than spoken language?
Did the speaker avoid reading the speech as if it were an essay?
Did the speaker effectively handle the problem of reading the script and maintaining eye contact while reading the script?
How did the speaker work gestures into his or her talk? Were they appropriate? Did they arise spontaneously from the content of the speech?
Was the presentation interesting, skillfully handled, effective and made with enthusiasm?
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 3','* Understand the concept and nature of motivational method in management.
* Apply a four step motivational method with the objectives to persuade and inspire.
* Deliver a motivational speech to persuade an audience to agree with your management proposal.
* TIME : 10 to12 minutes

Note to the Evaluator
The purpose of this presentation was for the speaker, as a manager to deliver a 10 to 12 minutes motivational speech designed to persuade and inspire by making the audience understand that personal goals can be realized through the achievement of organizational goals.  The delivery should have an abundance of vivid word pictures and dynamic gestures.  The content of the speech may include broad issues, long-range objectives, sales goals, responsibilities, and the value of individual contribution. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 3','Did the speaker make his or her proposal understood?
Did the speaker establish mutual understanding? Did he or she appeal to the beliefs and values of the listeners?
Was the speaker positive? Did he or she show enthusiasm?
Did the speaker show the advantages of the proposal?
How and when did the speaker make use of gestures? Were they dynamic? Were they effective?
Did the speaker build an incentive into the talk? What was the incentive?
Did the speaker inspire the audience? Describe briefly what techniques were used. Were they effective? How could they be improved?
Did the speaker persuade and inspire the audience to act? Ask the audience to comment on whether or not the speaker caused them to feel an emotional commitment.
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 4','* Organize and prepare a status report involving the overall condition of a plan or program, or performance of a department or company in relation to goals.
* Construct the report according to a four step pattern.
* Give an effective presentation of the report
* TIME : 10 to 12 minutes

Note to the Evaluator
The purpose for this presentation was for the speaker, as a manager, to deliver a 10 to 12 minutes status report including facts, marketing information, and organizational problems.  He or she was to use a four-step pattern for the report : object, scope, findings, recommendations.  The speaker was to use visual aids to amplify the information. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 4','Did the speaker construct the report according to the OSFR pattern?
What was the object of the report?
Did the speaker effectively present the findings and conclusions? If not, offer suggestions for improvement.
Did the speaker adequately explain the nature and scope of the study?
Did the speaker give his or her recommendations? What were they?
Did the speaker build interest into his or her presentation? List the techniques.
How well did the speaker make use of visual aids? If they were not effective, explain why and suggest how they could have been improved.
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 5','* Understand the definition and nature of the adversary relationship.
* Prepare for an adversary confrontation on a controversial management issue.
* Employing appropriate preparation methods, strategy, and techniques, for communicating with an adversary group as the representative of your company or corporation.
* TIME : 5 minutes for speech â€“ 10 minutes for question period.

Note to the Evaluator
The purpose of this presentation was for the speaker, as a manager representing his or her company or organization, to confront an adversary group concerning a controversial issue related to that company or organization. This situation involves a five-minutes presentation designed to establish the company philosophy and point of view and to persuade the audience as nearly as possible of the validity of that point of view. A ten-minute question-and-answer session will follow with the speaker under fire. In addition to your oral evaluation, please write answers to the questions below.
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 5','What was the controversy?
Did the speaker&apos;s five-minute presentation provide an open disclosure of the issue? What kinds of information were given?
How effectively did the speaker handle the ten-minute question-and-answer session? Did he or she make a skillful transition from the opening presentation to the Q&A period?
Describe how the speaker related to the audience? Was he or she effective? If not, why not? Suggest how the speaker could improve.
Did the speaker keep things moving? Describe how?
Did the speaker quit while he or she was ahead?
Did the speaker offer appropriate closing remarks?
What kind of impression did the speaker leave on the audience? Did he or she accomplish his objective? Ask members of the audience to comment.
Did the speaker persuade the audience that his or her side has merit? Ask the audience to comment.
',false);

update_option('evalintro:STORYTELLING 1','OBJECTIVES
* To tell a folk tale that is entertaining and enjoyable for a specific age group
* To use vivid imagery and voice to enhance a tale
* Time:  7 to 9 minutes

',false);
update_option('evalprompts:STORYTELLING 1','How did the speaker attract your interest to the story? Were you entertained?
What techniques tempo, rhythm, inflection, pause, volume did the speaker use that were especially effective?
Comment on the speaker s use of vocal variety in telling the story.
What parts of the story were most exciting? What parts if any slowed the story? What delivery technique s created or distracted from the effectiveness of the story?
What was the idea or mood the speaker was trying to convey? How was the idea or mood conveyed? Was the speaker successful?
Were you able to visualize the story in your mind? What parts of the story were most impressive?

',false);

update_option('evalintro:STORYTELLING 2','OBJECTIVES
* To learn the elements of a good story
* To create and tell an original story based on a personal experience
* Time:  6 to 8 minutes

',false);
update_option('evalprompts:STORYTELLING 2','How was the plot or point of the story developed?
How did the story build to a climax?
Were the characters well developed? How did you learn about them?
How did the speaker use description and dialogue to add color to the story?
Were you able to picture the characters and action as the speaker told the story? What, if anything, could the speaker have done to help you better visualize the characters and action?

',false);

update_option('evalintro:STORYTELLING 3','OBJECTIVES
* To understand the a story can be entertaining yet display moral values
* To create a new story that offers a lesson or moral
* To tell the story, using the skills developed in the previous two projects
* Time:  4 to 6 minutes

',false);
update_option('evalprompts:STORYTELLING 3','Was the story presented simply and clearly?
How did the speaker capture and hold your interest?
Were all the elements of a good story included plot, setting, characters, action, etc. ? If not, which ones were missing and how did this affect the story?
How did the speaker use vocal variety to add to the story?
What was the twist to the story? Was it successful? Why or why not?

',false);

update_option('evalintro:STORYTELLING 4','OBJECTIVES
* To understand the techniques available to arouse emotion
* To become skilled in arousing emotions while telling a story
* Time:  6 to 8 minutes

',false);
update_option('evalprompts:STORYTELLING 4','What emotions did you experience as the speaker told the story? How did the speaker use descriptive words and phrases to evoke emotion?
How did the speaker use dialogue to evoke emotion?
Did the story contain the basic elements of setting, characters, plot, conflict, and action? If not, which were missing? How did this affect the story?
Were the characters well developed? How did the speaker use description and dialogue to give them life?
How was the story developed? Was the plot or point clear?
How did the speaker build to a powerful climax?

',false);

update_option('evalintro:STORYTELLING 5','OBJECTIVES
* To understand the purpose of stories about historical events or people
* To use the storytelling skills developed in the preceding projects to tell a story about a historical event or person
* Time:  7 to 9 minutes

',false);
update_option('evalprompts:STORYTELLING 5','Was the plot of the story clear?
To what degree did the speaker succeed in building the story to a climax?
How did the speaker develop the characters?
Did the speaker make effective use of description and dialogue in telling the story?
Did you gain greater insight into the historical event or person the speaker was telling about?
How effectively did the speaker use vocal variety while telling the story? Did the speaker display distracting gestures or mannerisms?

',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 1','Objectives
* Using a systematic approach, organize technical material into a concise presentation.
* Tailor the presentation to the audience&apos;s needs, interests and knowledge levels.
* TIME : 8 to10 minutes

Note to the Evaluator:
In this presentation, the speaker is asked to deliver an informative briefing containing technical material.  This material should be tailored to the needs, interests and knowledge levels of the audience, and should be presented clearly and logically.  All aspects of the speech should support a single main message.  It is suggested you read the entire project before the speech.

In addition to your oral evaluation, please complete this evaluation form by assigning a rating in each category, then making comments in the space on the right. Comment only where special praise or specific recommendations for improvement are appropriate.
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 1','In your opinion, was this speech interesting?|Excellent|Satisfactory|Should improve
Was the technical material suitable for the interests and knowledge levels of the audience?|Excellent|Satisfactory|Should improve
Did the speaker state his/ her main message at the onset of the briefing?|Excellent|Satisfactory|Should improve
Did the points and support data contribute to understanding and acceptance of the main message?|Excellent|Satisfactory|Should improve
Was the technical material presented in a concise, logical manner?|Excellent|Satisfactory|Should improve
Did the speaker&apos;s delivery enhance the overall presentation effectiveness?|Excellent|Satisfactory|Should improve

',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 2','* To prepare a technical presentation advocating a product, service, idea or
course of action.
* To present your viewpoint logically and convincingly, using an invertedpyramid
approach.
* To effectively use a flipchart to illustrate your message.
* To effectively handle a question-and-answer period.
* TIME : 8 to 10 minutes for speech; 3 to 5 minutes for question period.
Note to the Evaluator
This project calls for a technical presentation that advocates a product, idea or
course of action. The speaker has been asked to use an &quot;inverted-pyramid&quot;
approach, putting his/her viewpoint at the beginning, then supporting it logically
and convincingly. The speaker was also expected to conduct a question-andanswer
period at the conclusion of the proposal. Visual aids (of the speaker&apos;s
choice) are recommended. It is suggested you read the entire project before
hearing the speech
In addition to your oral evaluation, please complete this evaluation form by
assigning a rating in each category, then making comments in the space on the
right. Don&apos;t comment on each category â€“ only those where special praise or
specific recommendations for improvement are appropriate.
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 2','Was the speaker&apos;s main message clearly stated in terms of audience benefits?|Excellent|Satisfactory|Could Improve
Did the speaker clearly and logically support his/her main message?|Excellent|Satisfactory|Could Improve
Was the proposal appropriate in intent for the audience?|Excellent|Satisfactory|Could Improve
Was the proposal organized according to the &quot;inverted pyramid&quot; method?|Excellent|Satisfactory|Could Improve
Did the speaker effectively deal with audience questions?|Excellent|Satisfactory|Could Improve
During Q an A, did the speaker respond in a way that supported the main message?|Excellent|Satisfactory|Could Improve
How effective were the visual aids?|Excellent|Satisfactory|Could Improve
Was the speaker&apos;s delivery as effective and convincing as his/ her content?|Excellent|Satisfactory|Could Improve

',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 3','Objectives
* Understand the principles of communicating complex information to nontechnical
listeners.
* Build and deliver an interesting talk based on these principles.
* Answer audience questions that arise during the presentation.
* Use overhead transparencies to illustrate your message.
* TIME : 10 to12 minutes
Note to the Evaluator
For this project the speaker is asked to deliver an interesting speech, in which
complex information is conveyed to a non-technical audience. The speaker
should entertain audience questions as they arise during the presentation, and
use overhead transparencies as visual aids. It is suggested you read the entire
project before hearing the speech.
In addition to your oral evaluation, please complete this evaluation form by rating
the speaker in each category, using this guide: 1 = excellent; 2 = very good; 3 =
satisfactory; 4 = should improve; 5 = must improve. Also, use the space on the
right for comments. Comment only in those categories where special praise or
specific recommendations for improvement are appropriate.
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 3','Topic selection (interesting, relevant)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Absence of complexity (easy to understand)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Opening (attention-getting)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Organization (clear, logical)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Support material (examples, comparisons that clarify and simplify)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Transitions (smooth, easy to follow)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Language (simple, without technical jargon)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Responses to audience (questions answered simply and directly)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Visual aids (bold, simple, visible, smoothly handled)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve
Delivery (vocal, variety, body language, etc.)|1 = excellent|2 = very good|3 =satisfactory|4 = should improve|5 = must improve

',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 4','Objectives
* Deliver an interesting speech based on a technical paper or article.
* Effectively use a flipchart, overhead projector or slides to illustrate your
message.
* TIME : 10 to12 minutes
Note to the Evaluator
For this project, the speaker was asked to present a technical paper or article.
The opening should contain a clear description of the problem or process being
discussed. Only a few major points should be included. The conclusion should
contain a summary of the paper&apos;s conclusions, and any recommendations that
arise. The speaker should use a conversational speaking style, and has been
asked to illustrate his/her message with a flipchart, overhead projector or 35mm
slides. It is suggested you read this entire project before hearing the speech.
In addition to your oral evaluation, please write answers to the questions below.
Where appropriate, offer specific suggestions for improvement.
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 4','* Did the speaker discuss only the technical paper or article&apos;s highlights during the oral presentation?
* Was the presentation tailored for the audience&apos;s interests and knowledge levels?
* How did the speaker make the presentation interesting?
* What evidence indicated that the speaker prepare diligently for this project?
* How effective were the speaker&apos;s visual aids and the way they were used?
* What presentation strengths does this speaker have, as displayed during this speech?
* In your opinion, how could the speaker improve his or her delivery in his/ her next speech?

',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 5','Objectives
* Understand the nature and process of a team technical presentation.
* Conceptualize a briefing or proposal involving three or more speakers,
including yourself.
* Assemble a team of club members capable of getting the job done.
* Orchestrate the planning, preparation and delivery of a team technical
presentation
* TIME : 20 to 30 minutes*
* Arrangements for this presentation should be made with your club&apos;s Vice
President Education well in advance. Also, you should arrange for an
evaluator for each speaker.
Note to the Evaluator
In this project, the coordinator&apos;s task was to develop a team presentation
concept, assemble a team of speakers, and orchestrate the presentation. The
actual presentation could be either a briefing or a proposal with a main message
supported by all participating speakers. It should be smoothly planned and
executed. All speakers should use the same type of style of visual aids. It is
suggested you read the entire project before the presentation.
In addition to your oral evaluation, please complete this evaluation form by
assigning a rating in each category, then making comments in the space on the
right. Don&apos;t comment on each category â€“ only those where special praise or
specific recommendations for improvement are appropriate.
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 5','Was the presentation topic appropriate for the audience?|Excellent|Satisfactory|Could Improve
Were all speakers well-prepared?|Excellent|Satisfactory|Could Improve
Did the presentation appear to be well coordinated?|Excellent|Satisfactory|Could Improve
Did all aspects of the team presentation support a main message?|Excellent|Satisfactory|Could Improve
Did the individual parts avoid overlap and include all pertinent material?|Excellent|Satisfactory|Could Improve
Did the coordinator effectively deliver his/her part of the presentation?|Excellent|Satisfactory|Could Improve
Were the visual aids well-designed and well-presented?|Excellent|Satisfactory|Could Improve
Please rate the overall effectiveness of the team presentation.|Excellent|Satisfactory|Could Improve

',false);

update_option('evalintro:THE DISCUSSION LEADER 1','',false);
update_option('evalprompts:THE DISCUSSION LEADER 1','',false);

update_option('evalintro:THE DISCUSSION LEADER 2','',false);
update_option('evalprompts:THE DISCUSSION LEADER 2','',false);

update_option('evalintro:THE DISCUSSION LEADER 3','',false);
update_option('evalprompts:THE DISCUSSION LEADER 3','',false);

update_option('evalintro:THE DISCUSSION LEADER 4','',false);
update_option('evalprompts:THE DISCUSSION LEADER 4','',false);

update_option('evalintro:THE DISCUSSION LEADER 5','',false);
update_option('evalprompts:THE DISCUSSION LEADER 5','',false);

update_option('evalintro:THE ENTERTAINING SPEAKER 1','OBJECTIVES
* Entertain the audience by relating a personal experience
* Organize an entertaining speech for maximum impact
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:THE ENTERTAINING SPEAKER 1','What indicated to you that the audience was entertained?
Briefly describe the talk s organization as you perceived it.
How effectively did the speaker use vivid descriptions and anecdotes or stories?
How did the conclusion relate to the rest of the talk?
How could the speaker improve the talk?
What would you say is the speaker s strongest asset in entertaining speaking?

',false);

update_option('evalintro:THE ENTERTAINING SPEAKER 2','* Draw entertaining material from sources other than your own personal experience
* Adapt your material to suit your topic, your own personality, and the audience
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:THE ENTERTAINING SPEAKER 2','What indicated to you that the audience was entertained?
What was the theme or message of the speech? How effectively was it supported by stories, anecdotes, or quotations?
How comfortable did the speaker appear when telling the stories, anecdotes, or quotations? Was the material presented in the speaker s own words and suitable to his her personality?
What parts of the speech were most effective? Which, if any, did not work well? Why?
How did the speaker s body language and vocal variety add impact to the talk?
What could the speaker have done differently to be more effective?
What did the speaker do well?

',false);

update_option('evalintro:THE ENTERTAINING SPEAKER 3','OBJECTIVES
* Prepare a humorous speech drawn from your own experience
* Strengthen the speech by adopting and personalizing humorous material from outside sources
* Deliver the speech in a way that makes the humor effective
* Time:  5 to 7 minutes
',false);
update_option('evalprompts:THE ENTERTAINING SPEAKER 3','What indicated to you that the audience was entertained?
What made the speech humorous?
How well did the jokes and stories fit the theme of the talk?
How well did the speaker deliver the jokes or stories?
How comfortable and confident did the speaker appear to be while telling the jokes or stories?
How did the speaker s body language and vocal variety add impact to the talk?
What could the speaker have done differently to be more effective?
What did the speaker do well?

',false);

update_option('evalintro:THE ENTERTAINING SPEAKER 4','* Develop an entertaining dramatic talk about an experience or incident
* Include vivid imagery, characters, and dialogue
* Deliver the talk in an entertaining manner
* Time:  5 to 7 minutes

',false);
update_option('evalprompts:THE ENTERTAINING SPEAKER 4','What indicated to you that the audience was entertained?
Describe the dramatic impact of the talk upon you.
How well did the speaker build in your mind vivid images of the situation being described?
How did the speaker s use of vocal variety, body language, and facial expressions add to the speech?
What parts if any of the speech did not work well? How could the speaker improve them? What parts of the speech seemed most effective?
How well did the speaker build to a powerful climax?

',false);

update_option('evalintro:THE ENTERTAINING SPEAKER 5','OBJECTIVES
* Prepare an entertaining after-dinner talk on a specific theme
* Deliver the talk using the skills developed in the preceding projects
* Time:  8 to 10 minutes

',false);
update_option('evalprompts:THE ENTERTAINING SPEAKER 5','What indicated to you that the audience was entertained?
How effectively did the speaker capture the audience s attention and hold it?
What was the theme of the talk? How easy was it for you to follow?
How effectively did the speaker deliver the jokes, stories, and or anecdotes? Did they fit the talk s theme?
What is your overall impression of the speaker s approach to entertaining the audience?

',false);

update_option('evalintro:THE PROFESSIONAL SALESPERSON 1','',false);
update_option('evalprompts:THE PROFESSIONAL SALESPERSON 1','',false);

update_option('evalintro:THE PROFESSIONAL SALESPERSON 2','',false);
update_option('evalprompts:THE PROFESSIONAL SALESPERSON 2','',false);

update_option('evalintro:THE PROFESSIONAL SALESPERSON 3','',false);
update_option('evalprompts:THE PROFESSIONAL SALESPERSON 3','',false);

update_option('evalintro:THE PROFESSIONAL SALESPERSON 4','',false);
update_option('evalprompts:THE PROFESSIONAL SALESPERSON 4','',false);

update_option('evalintro:THE PROFESSIONAL SALESPERSON 5','',false);
update_option('evalprompts:THE PROFESSIONAL SALESPERSON 5','',false);

update_option('evalintro:THE PROFESSIONAL SPEAKER 1','OBJECTIVES
* Identify the basic differences between keynote speeches and other kinds of speeches
* Learn how to evaluate audience feeling and establish emotional rapport
* Learn and use the professional techniques necessary for a successful keynote presentation
* Develop a speech style and delivery that effectively inspires and moves the audience to adopt your views as a collective reaffirmation of its own
* Time:  15 to 20 minutes, longer if club program allows

',false);
update_option('evalprompts:THE PROFESSIONAL SPEAKER 1','What did the speaker say and do to arouse audience interest following the introduction?
Did the speaker communicate to the listeners that he or she was united with them by bonds of sympathy, common experience, and understanding?
How did the speaker project confidence and authority voice, language, platform presence ?
Was the speaker s language and style inspirational? Describe how.
Did the inspirational tone interpret or reinterpret existing feelings in the audience? Ask the audience. Did the speaker express audience emotion?
Did the speaker use appropriate humor to create a lightness of spirit in meeting audience expectations?
Did the speaker use interesting transitions to move from one point to the next?
Did the speaker use word pictures and dynamic examples?
Did the speaker give the audience a final thought to take away after the speech? What was it? What manner of closing was used to convey it?
What positive suggestions can you offer to assist the speaker in improving his or her performance?

',false);

update_option('evalintro:THE PROFESSIONAL SPEAKER 2','OBJECTIVES
* Entertain the audience through the use of humor drawn from personal experience and from other material that you have personalized
* Deliver the speech in a way that makes the humor effective
* Establish personal rapport with your audience for maximum impact
* Time:  15 to 20 minutes, longer if club program allows

',false);
update_option('evalprompts:THE PROFESSIONAL SPEAKER 2','How was the opening handled? Was it effective? If not, why not?
Briefly describe the organization basic outline of the speech as you perceived it.
What indicated to you that the audience was entertained?
What techniques did the speaker use that were especially effective? Were there any that did not work? Why not?
What techniques did the speaker use in the body of the speech to establish and maintain humorous tone and rhythm?
How was the closing handled? Was it effective? If not, why not?
What would you say is the speaker s strongest asset in entertaining an audience?
What positive suggestions can you offer to assist the speaker in improving his or her performance?

',false);

update_option('evalintro:THE PROFESSIONAL SPEAKER 3','OBJECTIVES
* Tell a sales audience how to sell a product by using a planned presentation
* Inform a sales training audience about the human experience of the buyer-seller relationship
* Use entertaining stories and dynamic examples of sales situations
* Inspire salespeople to want to succeed in selling
* Time:  15 to 20 minutes, longer if club program allows

',false);
update_option('evalprompts:THE PROFESSIONAL SPEAKER 3','What was unique about the speaker s use of showmanship? How could it be improved?
Was the speaker s opening effective? Why? If not, why not?
Did the speaker give the audience a system for selling? What was it called?
How did the speaker involve the audience? What techniques were used?
In what way did the speaker illustrate the buyer seller relationship?
In what way did the speaker indicate how to handle buyers objections?
Was the speaker s close effective? If not, why not?
Did the listeners feel they benefited from hearing the speaker? Ask them.
Did the speaker inspire the audience to go out and succeed in selling? Ask them.
What positive suggestions can you offer for improvements of the speaker s presentation?

',false);

update_option('evalintro:THE PROFESSIONAL SPEAKER 4','OBJECTIVES
* Plan and present a seminar with specific learning objectives
* Relate to the audience by using a seminar presentation style
* Use seminar presentation techniques to promote group participation, learning, and personal growth
* Time:  20 to 40 minutes

',false);
update_option('evalprompts:THE PROFESSIONAL SPEAKER 4','In opening the presentation, how did the speaker establish immediate rapport and hold audience attention?
Did the speaker orient the audience to specific learning objectives? What were they?
How did the speaker serve as a role model for the audience?
How effectively did the speaker relate to the audience excellent, good, fair, poor ?
What behaviors or characteristics did the speaker project, e.g., enthusiasm, preparedness, humor, clarity and directness, encouraging feedback? Suggest areas for improvement.
Did the speaker both teach and entertain? Was the seminar interesting and important to the audience? Ask members to respond. Will it help them grow and personally benefit?

',false);

update_option('evalintro:THE PROFESSIONAL SPEAKER 5','OBJECTIVES
* Understand the concept and nature of motivational speaking
* Apply a four-step motivational method with the purpose of persuading and inspiring
* Deliver a motivational speech to persuade an audience to emotionally commit to an action â€¢ Time:  15 to 20 minutes, longer if club program allows

',false);
update_option('evalprompts:THE PROFESSIONAL SPEAKER 5','Did the speaker make his or her proposal understood?
Did the speaker establish mutual understanding? Did he or she appeal to the beliefs and values of the listeners?
Was the speaker positive? Did he or she show enthusiasm?
How and when did the speaker make use of gestures? Were they dynamic? Were they effective?
Did the speaker build an incentive into the talk? What was the incentive?
Did the speaker inspire the audience? Describe briefly what techniques were used. Were they effective? How could they be improved?
Did the speaker persuade and inspire the audience to act? Ask the audience to comment if the speaker caused them to feel an emotional commitment.

',false);

update_option('evalintro:BETTER SPEAKER SERIES 0','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 0','',false);

update_option('evalintro:BETTER SPEAKER SERIES 1','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 1','',false);

update_option('evalintro:BETTER SPEAKER SERIES 2','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 2','',false);

update_option('evalintro:BETTER SPEAKER SERIES 3','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 3','',false);

update_option('evalintro:BETTER SPEAKER SERIES 4','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 4','',false);

update_option('evalintro:BETTER SPEAKER SERIES 5','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 5','',false);

update_option('evalintro:BETTER SPEAKER SERIES 6','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 6','',false);

update_option('evalintro:BETTER SPEAKER SERIES 7','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 7','',false);

update_option('evalintro:BETTER SPEAKER SERIES 8','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 8','',false);

update_option('evalintro:BETTER SPEAKER SERIES 9','',false);
update_option('evalprompts:BETTER SPEAKER SERIES 9','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 0','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 0','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 1','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 1','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 2','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 2','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 3','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 3','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 4','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 4','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 5','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 5','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 6','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 6','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 7','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 7','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 8','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 8','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 9','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 9','',false);

update_option('evalintro:SUCCESSFUL CLUB SERIES 10','',false);
update_option('evalprompts:SUCCESSFUL CLUB SERIES 10','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 0','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 0','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 1','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 1','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 2','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 2','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 3','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 3','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 4','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 4','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 5','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 5','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 6','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 6','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 7','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 7','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 8','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 8','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 9','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 9','',false);

update_option('evalintro:LEADERSHIP EXCELLENCE SERIES 10','',false);
update_option('evalprompts:LEADERSHIP EXCELLENCE SERIES 10','',false);

update_option('evalintro:Dynamic Leadership Level 1 Mastering Fundamentals 0','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 1 Mastering Fundamentals 0','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 1 Mastering Fundamentals 5','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 1 Mastering Fundamentals 5','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 1 Mastering Fundamentals 11','',false);
update_option('evalprompts:Dynamic Leadership Level 1 Mastering Fundamentals 11','',false);

update_option('evalintro:Dynamic Leadership Level 2 Learning Your Style 20','',false);
update_option('evalprompts:Dynamic Leadership Level 2 Learning Your Style 20','',false);

update_option('evalintro:Dynamic Leadership Level 2 Learning Your Style 25','',false);
update_option('evalprompts:Dynamic Leadership Level 2 Learning Your Style 25','',false);

update_option('evalintro:Dynamic Leadership Level 2 Learning Your Style 31','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 2 Learning Your Style 31','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 40','',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 40','',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 45','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 45','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 51','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 51','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 57','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 57','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 63','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 63','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 69','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 69','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 75','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 75','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 81','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 81','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 87','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 87','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 93','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 93','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 99','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 99','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 105','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 105','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 111','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 111','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 117','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 117','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 126','The purpose of this project is for the member to practice developing a change management plan. The purpose of this speech is for the member to share some aspect of a change management plan. 

Notes for the Evaluator
 During the completion of this project, the member developed a change management plan about any real or hypothetical change in his or her past or a current change that affects a group that he or she is part of (including the Toastmasters club). 

About this speech:
The member will give specific information about the plan. The speech may be any type, including humorous. It should not be a report on the content of the &quot;Manage Change&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8406E_EvaluationResource_ManageChange.pdf" target="_blank">8406E_EvaluationResource_ManageChange.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 126','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of plan for change|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Focus: Identifies a change in personal or professional life that can benefit from planning|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 131','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 131','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 137','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 137','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 143','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 143','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 149','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 149','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 155','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 155','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 161','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 161','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 167','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 167','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 173','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 173','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 182','',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 182','',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 187','',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 187','',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 193','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 193','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 199','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 199','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 205','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 205','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 211','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 211','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 218','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 218','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 224','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 224','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 1 Mastering Fundamentals 233','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 1 Mastering Fundamentals 233','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 1 Mastering Fundamentals 240','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 1 Mastering Fundamentals 240','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 1 Mastering Fundamentals 246','',false);
update_option('evalprompts:Effective Coaching Level 1 Mastering Fundamentals 246','',false);

update_option('evalintro:Effective Coaching Level 2 Learning Your Style 256','',false);
update_option('evalprompts:Effective Coaching Level 2 Learning Your Style 256','',false);

update_option('evalintro:Effective Coaching Level 2 Learning Your Style 263','',false);
update_option('evalprompts:Effective Coaching Level 2 Learning Your Style 263','',false);

update_option('evalintro:Effective Coaching Level 2 Learning Your Style 269','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 2 Learning Your Style 269','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 278','',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 278','',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 285','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 285','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 291','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 291','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 297','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 297','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 303','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 303','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 309','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 309','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 315','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 315','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 321','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 321','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 327','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 327','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 333','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 333','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 339','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 339','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 345','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 345','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 351','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 351','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 357','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 357','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 366','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 366','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 8','
Understand the concept of motivation
Use the described strategies to align the audience&apos;s goals with your objective
Deliver a motivational speech and influence your audience to a specific action
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 8','
Did the speaker make his or her proposal understood?
Did the speaker establish mutual understanding? Did he or she appeal to the beliefs and values of the listeners?
Was the speaker positive? How did he or she show enthusiasm?
How did the speaker show the advantages of the proposal?
How and when did the speaker make use of gestures? Were they dynamic? Were they effective?
Did the speaker describe how his or her proposal would support the audience&apos;s intrinsic motivators? How did he or she describe it?
Did the speaker inspire the audience? Describe briefly what techniques were used. Were they effective? How could they be improved?
Did the speaker persuade and inspire the audience to act?
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 373','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 373','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 385','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 385','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 391','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 391','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 397','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 397','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 403','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 403','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 409','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 409','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 415','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 415','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 424','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 424','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 431','',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 431','',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 437','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 437','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 443','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 443','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 449','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 449','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 455','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 455','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 461','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 461','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 1 Mastering Fundamentals 470','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 1 Mastering Fundamentals 470','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 1 Mastering Fundamentals 477','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 1 Mastering Fundamentals 477','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 1 Mastering Fundamentals 483','',false);
update_option('evalprompts:Innovative Planning Level 1 Mastering Fundamentals 483','',false);

update_option('evalintro:Innovative Planning Level 2 Learning Your Style 492','',false);
update_option('evalprompts:Innovative Planning Level 2 Learning Your Style 492','',false);

update_option('evalintro:Innovative Planning Level 2 Learning Your Style 499','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 2 Learning Your Style 499','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 2 Learning Your Style 505','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 2 Learning Your Style 505','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 514','',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 514','',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 521','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 521','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 527','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 527','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 533','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 533','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:TECHNICAL PRESENTATIONS 11','
Understand the nature and process of a technical presentation supported with professionallevel visual aids
Arrange pre-meeting communications via email
Find or create a post-meeting website for further dissemination of information supporting or enhancing your verbal presentation. You may create a web page and add it to your club&apos;s website, making use of podcasting, webcasting, or a basic internet template
Use a desktop computer, Microsoft Word, a web browser, a simple graphics program for photos and other images, Microsoft PowerPoint as well as the venerable flipchart to support your presentation
',false);
update_option('evalprompts:TECHNICAL PRESENTATIONS 11','
Were extra materials on hand for those who needed them?
Did the presentation&apos;s subject matter appear to be well coordinated with the pre- and postcommunications?
Did the recommended websites adequately support and/or enhance the speaker&apos;s main message?
Did the electronic communications include enough pertinent material? What could have been added?
Did the electronic communications avoid unnecessary overlap? What could have been deleted?
Did the speaker effectively deliver the in-person portion of the presentation?
Did the speaker discuss the pre- or post-talk communications in a smooth and prepared manner?
Were the visual aids well designed and well presented to coordinate with the pre- and post-communications?
Please rate the overall effectiveness of the presentation.
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 539','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 539','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 545','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 545','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 551','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 551','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 557','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 557','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 563','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 563','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 569','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 569','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 575','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 575','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 581','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 581','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 3 Increasing Knowledge 587','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 3 Increasing Knowledge 587','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 596','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 596','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 603','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 603','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 609','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 609','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 615','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 615','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 621','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 621','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 627','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 627','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 633','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 633','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 639','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 639','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 648','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 648','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 655','',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 655','',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 661','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 661','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 667','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 667','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 673','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 673','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 679','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 679','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 685','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 685','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 1 Mastering Fundamentals 694','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 1 Mastering Fundamentals 694','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 1 Mastering Fundamentals 701','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 1 Mastering Fundamentals 701','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 1 Mastering Fundamentals 707','',false);
update_option('evalprompts:Leadership Development Level 1 Mastering Fundamentals 707','',false);

update_option('evalintro:Leadership Development Level 2 Learning Your Style 716','',false);
update_option('evalprompts:Leadership Development Level 2 Learning Your Style 716','',false);

update_option('evalintro:Leadership Development Level 2 Learning Your Style 723','',false);
update_option('evalprompts:Leadership Development Level 2 Learning Your Style 723','',false);

update_option('evalintro:Leadership Development Level 2 Learning Your Style 729','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 2 Learning Your Style 729','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 738','',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 738','',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 745','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 745','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 751','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 751','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 757','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 757','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 763','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 763','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 769','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 769','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 775','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 775','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 781','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 781','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 787','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 787','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 793','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 793','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 799','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 799','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 805','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 805','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 811','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 811','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 3 Increasing Knowledge 817','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 3 Increasing Knowledge 817','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 826','The purpose of this project is for the member to lead a small team to the completion of a project. The purpose of this speech is for the member to share some aspect of his or her experience leading a team. 

Notes for the Evaluator
 During the completion of this project, the member:
Built a team Selected a project to complete and completed that project

About this speech:
Your evaluation is based on the speech the member presents to the club. Listen for how the member applied what was learned in the project, the impact of the leadership experience, and the results of the completed project. The speech may be humorous, informational, or any other type of speech that the member selects. The speech should not be a report on the content of the &quot;Leading Your Team&quot; project, but should cover some aspect of the member&apos;s experience leading a team. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8405E_EvaluationResource_LeadingYourTeam.pdf" target="_blank">8405E_EvaluationResource_LeadingYourTeam.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 826','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares all or part of personal experience leading a team|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 833','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 833','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 839','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 839','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 845','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 845','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 851','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 851','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 857','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 857','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 863','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 863','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 869','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 869','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 875','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 875','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 884','',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 884','',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 891','',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 891','',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 897','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 897','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 903','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 903','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 909','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 909','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 915','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 915','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 921','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 921','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 927','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 927','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 1 Mastering Fundamentals 937','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 1 Mastering Fundamentals 937','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 1 Mastering Fundamentals 944','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 1 Mastering Fundamentals 944','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 1 Mastering Fundamentals 950','',false);
update_option('evalprompts:Motivational Strategies Level 1 Mastering Fundamentals 950','',false);

update_option('evalintro:Motivational Strategies Level 2 Learning Your Style 959','',false);
update_option('evalprompts:Motivational Strategies Level 2 Learning Your Style 959','',false);

update_option('evalintro:Motivational Strategies Level 2 Learning Your Style 966','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Motivational Strategies Level 2 Learning Your Style 966','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 2 Learning Your Style 972','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 2 Learning Your Style 972','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 981','',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 981','',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 988','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 988','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 994','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 994','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1000','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1000','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1006','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1006','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1012','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1012','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1018','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1018','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1024','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1024','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1030','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1030','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1036','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1036','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1042','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1042','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1048','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1048','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 3 Increasing Knowledge 1054','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 3 Increasing Knowledge 1054','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1063','The purpose of this project is for the member to practice the skills needed to motivate team members through the completion of a project. The purpose of this speech is for the member to share some aspect of his or her experience motivating team members through the completion of a project. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time developing a project, building a team, and working with that team to bring the project to fruition May have asked team members and at least one club officer to evaluate his or her leadership through the completion of 360Â° evaluation 

About this speech:
The member will deliver a high-quality and engaging speech that addresses his or her experience using motivational techniques while leading a team. The speech may be humorous, informational, or any type the member chooses. The speech should not be a report on the content of the &quot;Motivate Others&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8411E_EvaluationResource_MotivateOthers.pdf" target="_blank">8411E_EvaluationResource_MotivateOthers.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1063','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of leadership experience related to motivating others|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1070','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1070','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1076','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1076','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1082','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1082','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1088','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1088','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1094','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1094','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1100','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1100','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1106','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1106','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1112','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1112','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1121','',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1121','',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1128','',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1128','',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1134','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1134','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1140','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1140','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1146','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1146','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1152','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1152','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1158','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1158','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1164','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1164','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 1 Mastering Fundamentals 1173','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 1 Mastering Fundamentals 1173','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 1 Mastering Fundamentals 1180','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 1 Mastering Fundamentals 1180','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 1 Mastering Fundamentals 1186','',false);
update_option('evalprompts:Persuasive Influence Level 1 Mastering Fundamentals 1186','',false);

update_option('evalintro:Persuasive Influence Level 2 Learning Your Style 1195','',false);
update_option('evalprompts:Persuasive Influence Level 2 Learning Your Style 1195','',false);

update_option('evalintro:Persuasive Influence Level 2 Learning Your Style 1202','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Persuasive Influence Level 2 Learning Your Style 1202','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 2 Learning Your Style 1208','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 2 Learning Your Style 1208','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1217','',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1217','',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1224','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1224','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1230','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1230','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1236','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1236','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1242','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1242','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1248','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1248','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1254','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1254','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1260','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1260','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1266','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1266','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1272','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1272','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1278','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1278','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1284','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1284','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 3 Increasing Knowledge 1290','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 3 Increasing Knowledge 1290','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1299','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1299','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1306','Purpose Statement
 The purpose of this project is for the member to practice strategies for adjusting to unexpected changes to a finalized plan. 

Notes for the Evaluator
 The member completing this project has spent time developing a project plan for an event or set of goals. 

About this speech:
* The first part of the member&apos;s speech will be a presentation of his or her plan.
Your club members will then be invited to suggest disruptions to the plan. 
* The member will need to address methods for managing the challenges presented by club members. 
* There should be a minimum of three disruptions suggested and a maximum of five.
The member may respond to each disruption separately. 
* Evaluate the member on the first, prepared speech about their plan as well as the second, impromptu portion of the speech. 
* As you evaluate consider the member&apos;s poise and presentation, as well as the viability and/or creativity of responses to the challenges.',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1306','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares an organized plan|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates responses to challenges in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Challenges: Presents a viable solution for each challenge|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1312','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1312','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1318','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1318','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1324','Purpose Statement

 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1324','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1330','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1330','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1336','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1336','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1342','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1342','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1348','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1348','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1357','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1357','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1364','',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1364','',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1370','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1370','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1376','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1376','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1382','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1382','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1388','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1388','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1394','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1394','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 1 Mastering Fundamentals 1404','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 1 Mastering Fundamentals 1404','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 1 Mastering Fundamentals 1411','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 1 Mastering Fundamentals 1411','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 1 Mastering Fundamentals 1417','',false);
update_option('evalprompts:Presentation Mastery Level 1 Mastering Fundamentals 1417','',false);

update_option('evalintro:Presentation Mastery Level 2 Learning Your Style 1426','',false);
update_option('evalprompts:Presentation Mastery Level 2 Learning Your Style 1426','',false);

update_option('evalintro:Presentation Mastery Level 2 Learning Your Style 1433','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Presentation Mastery Level 2 Learning Your Style 1433','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 2 Learning Your Style 1439','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 2 Learning Your Style 1439','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 13','
To understand the dynamics of a video interview or "talk" show.
To prepare for the questions that may be asked of you during a video interview program.
To present a positive image on the video camera.
To appear as a guest on a simulated video talk show.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 13','
How prepared was the speaker? What indicated this?
How effectively did the speaker answer the questions? Did the speaker show enthusiasm?
How did the speaker use a story or anecdote to illustrate or emphasize a point?
Did the speaker appear relaxed, confident, and poised? Were the speaker&apos;s gestures/body movements appropriate for the special requirements on video? Did the speaker relate appropriately to the studio audience?
How did the speaker&apos;s appearance (clothing, makeup, etc.) enhance or detract from the presentation?
How effective do you feel the speaker would have been on a "real" talk show?
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1448','',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1448','',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1455','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1455','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1461','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1461','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1467','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1467','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1473','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1473','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1479','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1479','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1485','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1485','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1491','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1491','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1497','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1497','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1503','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1503','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1509','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1509','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1515','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1515','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 3 Increasing Knowledge 1521','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 3 Increasing Knowledge 1521','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1530','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1530','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1537','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1537','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1543','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1543','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1549','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1549','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1555','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1555','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1561','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1561','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1567','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1567','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1573','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1573','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1582','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1582','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1589','',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1589','',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1595','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1595','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1601','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1601','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1607','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1607','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1613','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1613','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1619','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1619','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 1 Mastering Fundamentals 1628','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 1 Mastering Fundamentals 1628','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 1 Mastering Fundamentals 1635','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 1 Mastering Fundamentals 1635','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 1 Mastering Fundamentals 1641','',false);
update_option('evalprompts:Strategic Relationships Level 1 Mastering Fundamentals 1641','',false);

update_option('evalintro:Strategic Relationships Level 2 Learning Your Style 1650','',false);
update_option('evalprompts:Strategic Relationships Level 2 Learning Your Style 1650','',false);

update_option('evalintro:Strategic Relationships Level 2 Learning Your Style 1657','',false);
update_option('evalprompts:Strategic Relationships Level 2 Learning Your Style 1657','',false);

update_option('evalintro:Strategic Relationships Level 2 Learning Your Style 1663','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 2 Learning Your Style 1663','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1672','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1672','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1679','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1679','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1685','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1685','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1691','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1691','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1697','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1697','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1703','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1703','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1709','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1709','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1715','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1715','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 10','
Deliver bad news with tact and sensitivity
Organize your speech appropriately for your audience
Conclude with a pleasant note and maintain the audience&apos;s goodwill
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 10','
Did the speaker use the direct or indirect method for delivering bad news? How did the speaker use this method effectively?
How could the speaker improve his or her use of inclusive language?
What did you notice about the speaker&apos;s tone of voice? How could the speaker improve?
Suggest ways the speaker could have organized his or her facts more effectively?
How would you have felt if the speaker used the demonstrated techniques to deliver bad news to you? What could the speaker do to make you more receptive to the news?
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1721','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1721','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1727','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1727','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1733','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1733','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1739','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1739','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 3 Increasing Knowledge 1745','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 3 Increasing Knowledge 1745','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1754','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1754','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1761','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1761','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1767','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1767','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1773','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1773','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1779','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1779','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1785','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1785','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 14','
To conduct a successful video interview.
To understand the dynamics of a successful video interview or "talk" show.
To prepare questions to ask during the interview program.
To present a positive, confident image on the video camera.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 14','
How well prepared was the speaker?
How effectively did the speaker lead the interview? Were questions clear? Were they in logical sequence?
What was the guest&apos;s field of expertise? Did the speaker make this clear in the guest&apos;s introduction?
Did the speaker appear relaxed, confident, and poised? Were gestures/body movements appropriate for the special requirements of video?
How well did the speaker relate to the camera and the studio audience? Was eye contact with the camera made at the appropriate times?
How did the speaker&apos;s appearance (clothing, makeup, etc.) affect your impression of the presentation?
How effective do you feel the speaker would have been on a"real" talk show?
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1791','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1791','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:PUBLIC RELATIONS 6','
Direct a persuasive appeal to the audience&apos;s self-interests using a combination of fact and emotion in a speech delivered in such a manner that it appears extemporaneous
Persuade the audience to adopt your viewpoint by the use of standard persuasive techniques
Use at least one visual aid to enhance the audience&apos;s understanding
',false);
update_option('evalprompts:PUBLIC RELATIONS 6','
How convincing was the speaker&apos;s argument on his or her viewpoint?
How effective was the speaker&apos;s emotional appeal?
How closely did the presentation relate to the audience&apos;s interests?
Comment on the smoothness and effectiveness of the talk.
How did the visual aid(s) contribute to the speaker&apos;s persuasive effort?
How persuasive was the speech?
Did the speaker change your opinion? How?
What else might the speaker have done to convince you?
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1797','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1797','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1806','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1806','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1813','',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1813','',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1819','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1819','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1825','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1825','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1831','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1831','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1837','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1837','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1843','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1843','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 1 Mastering Fundamentals 1852','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 1 Mastering Fundamentals 1852','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 1 Mastering Fundamentals 1859','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 1 Mastering Fundamentals 1859','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 1 Mastering Fundamentals 1865','',false);
update_option('evalprompts:Team Collaboration Level 1 Mastering Fundamentals 1865','',false);

update_option('evalintro:Team Collaboration Level 2 Learning Your Style 1874','',false);
update_option('evalprompts:Team Collaboration Level 2 Learning Your Style 1874','',false);

update_option('evalintro:Team Collaboration Level 2 Learning Your Style 1881','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.
As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Team Collaboration Level 2 Learning Your Style 1881','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 2 Learning Your Style 1887','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 2 Learning Your Style 1887','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1896','The purpose of this project is for the member to be introduced to or review strategies for working in a collaborative group. The purpose of this speech is for the member to share some aspect of his or her experience practicing collaboration with a small team. 

Notes for the Evaluator
 The member completing this assignment has spent time practicing collaboration within a team or other small group. 

About this speech:
The member will deliver a well-organized speech about his or her collaborative experience. The speech may be humorous, informational, or any type the member chooses. The speech should not be a report on the content of the &quot;Successful Collaboration&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8314E_EvaluationResource_SuccessfulCollaboration.pdf" target="_blank">8314E_EvaluationResource_SuccessfulCollaboration.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1896','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience collaborating with a group|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1903','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1903','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1909','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1909','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1915','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1915','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1921','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1921','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1927','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1927','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1933','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1933','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1939','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1939','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 9','
Introduce a new idea or change to established operations or methods
Show the audience how the change will benefit them
Overcome any resistance to the new idea and gain the audience&apos;s support
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 9','
Did the speaker adequately explain the nature and scope of the change? How could the speaker improve?
How well did the speaker follow the four steps to develop their message?
Describe how the speaker overcame any audience resistance.
How did the speaker showcase the benefits to the audience?
Were you convinced that the chance proposed by the speaker would benefit you? Why or why not?
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1945','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1945','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1951','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1951','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1957','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1957','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1963','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1963','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:PERSUASIVE SPEAKING 12','
Learn a technique for"cold call" selling of expensive products or services
Recognize the risks buyers assume in purchasing
Use questions to help the buyer discover problems with his or her current situation
Successfully handle buyer&apos;s objections and concerns
',false);
update_option('evalprompts:PERSUASIVE SPEAKING 12','
How well did the speaker explain the persuasive process used in"cold call" sales of expensive items?
How effective were the questions in eliciting information from the buyer?
How effective were the questions in helping the buyer discover a problem exists?
Did the speaker avoid talking about his product until the buyer asked about it?
How well did the speaker handle any objections or concerns the buyer raised?
What could the speaker have said that would have been more effective?
What did the speaker do well?
',false);

update_option('evalintro:Team Collaboration Level 3 Increasing Knowledge 1969','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 3 Increasing Knowledge 1969','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 1978','The purpose of this project is for the member to practice the skills needed to motivate team members through the completion of a project. The purpose of this speech is for the member to share some aspect of his or her experience motivating team members through the completion of a project. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time developing a project, building a team, and working with that team to bring the project to fruition May have asked team members and at least one club officer to evaluate his or her leadership through the completion of 360Â° evaluation 

About this speech:
The member will deliver a high-quality and engaging speech that addresses his or her experience using motivational techniques while leading a team. The speech may be humorous, informational, or any type the member chooses. The speech should not be a report on the content of the &quot;Motivate Others&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8411E_EvaluationResource_MotivateOthers.pdf" target="_blank">8411E_EvaluationResource_MotivateOthers.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 1978','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of leadership experience related to motivating others|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 1985','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 1985','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 1991','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 1991','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 1997','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 1997','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2003','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2003','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2009','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2009','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2015','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2015','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2021','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2021','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2027','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2027','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2036','',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2036','',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2043','',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2043','',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2049','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2049','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2055','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2055','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2061','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2061','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2067','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2067','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2073','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2073','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2079','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2079','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 1 Mastering Fundamentals 2088','Purpose Statement
 The purpose of this project is for the member to introduce himself or herself to the club and learn the basic structure of a public speech. 

Notes for the Evaluator
 This member is completing his or her first speech in Toastmasters.
The goal of the evaluation is to give the member an effective evaluation of his or her speech and delivery style.
Because the &quot;Ice Breaker&quot; is the first project a member completes, you may choose to use only the notes section and not the numerical score. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8101E_EvaluationResource_IceBreaker.pdf" target="_blank">8101E_EvaluationResource_IceBreaker.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 1 Mastering Fundamentals 2088','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 1 Mastering Fundamentals 2095','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to present a speech and receive feedback from the evaluator. 

Notes for the Evaluator
 The member has spent time writing a speech to present at a club meeting. 

About this speech:
The member will deliver a well-organized speech on any topic. Focus on the member&apos;s speaking style. Be sure to recommend improvements that the member can apply to the next speech. The speech may be humorous, informational, or any style the member chooses. The member will ask you to evaluate his or her second speech at a future meeting. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E1_EvaluationResource_EvaluationandFeedback1.pdf" target="_blank">8100E1_EvaluationResource_EvaluationandFeedback1.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 1 Mastering Fundamentals 2095','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 1 Mastering Fundamentals 2101','',false);
update_option('evalprompts:Visionary Communication Level 1 Mastering Fundamentals 2101','',false);

update_option('evalintro:Visionary Communication Level 2 Learning Your Style 2110','',false);
update_option('evalprompts:Visionary Communication Level 2 Learning Your Style 2110','',false);

update_option('evalintro:Visionary Communication Level 2 Learning Your Style 2117','',false);
update_option('evalprompts:Visionary Communication Level 2 Learning Your Style 2117','',false);

update_option('evalintro:Visionary Communication Level 2 Learning Your Style 2123','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8410E_EvaluationResource_Mentoring.pdf" target="_blank">8410E_EvaluationResource_Mentoring.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 2 Learning Your Style 2123','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Describes some aspect of experience mentoring during the completion of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2132','',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2132','',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2139','Purpose Statement
 The purpose of this project is for the member to demonstrate his or her ability to listen to what others say. 

Notes for the Evaluator
 The member completing this project is practicing active listening.
At your club meeting today, he or she is leading Table TopicsÂ®. 

Listen for:
A well-run Table TopicsÂ® session.

As Topicsmaster, the member should make short, affirming statements after each speaker completes an impromptu speech, indicating he or she heard and understood each speaker.
For example, the member may say, &quot;Thank you, Toastmaster Smith, for your comments on visiting the beach.
It sounds like you really appreciate how much your dog loves to play in the water.&quot; The goal is for the member to clearly show that he or she listened and can use some of the active listening skills discussed tin the project.
The member completing the project is the ONLY person who needs to show active listening.
The member should not try to teach or have others demonstrate active listening skills.
The member should follow all established protocols for a Table TopicsÂ® session.',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2139','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable in the role of Topicsmaster|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Active Listening: Responds to specific content after each Table TopicsÂ® speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Shows interest when others are speaking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2145','Purpose Statement
 The purpose of this project is for the member to practice using a story within a speech or giving a speech that is a story. 

Notes for the Evaluator
 The member completing this project is focusing on using stories in a speech or creating a speech that is a story. The member may use any type of story:
personal, well-known fiction, or one of his or her own creation. Listen for a well-organized speech that is a story or includes a story <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8300E_EvaluationResource_ConnectwithStorytelling.pdf" target="_blank">8300E_EvaluationResource_ConnectwithStorytelling.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2145','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impact: Story has the intended impact on the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Synthesis: Pacing enhances the delivery of both the story and the rest of the speech. (Evaluate this competency only if the member includes a story as part of a larger speech.)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2151','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to connect with an unfamiliar audience. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to connect with an unfamiliar audience.
To do this, the member presents a topic that is new or unfamiliar to your club members. 

Listen for:
A topic that is unusual or unexpected in your club.
Take note of the member&apos;s ability to present the unusual topic in a way that keeps the audience engaged.
This speech is not a report on the content of the &quot;Connect with Your Audience&quot; project. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8201E_EvaluationResource_ConnectwithYourAudience. pdf" target="_blank">8201E_EvaluationResource_ConnectwithYourAudience. pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2151','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is new or unusual for audience members and challenges speaker to adapt while presenting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2157','Purpose Statement
 The purpose of this project is for the member to practice selecting and using a variety of visual aids during a speech. 

Notes for the Evaluator
 The member completing this project is practicing the skills needed to use visual aids effectively during a speech. The member may choose any type of visual aid(s).
He or she may use a minimum of one but no more than three visual aids. 

Listen for:
A well-organized speech that lends well to the visual aid(s) the member selected. Watch for:
The effective use of any and all visual aids.
The use of the aid should be seamless and enhance the content of the speech.
This speech should not be a report on the content of the &quot;Creating Effective Visual Aids&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf" target="_blank">8301E_EvaluationResource_CreatingEffectiveVisualAids.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2157','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aid: Visual aid effectively supports the topic and speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic is well-selected for making the most of visual aids|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2163','Purpose Statement
  The purpose of this project is for the member to practice delivering social speeches in front of club members.    

Notes for the Evaluator
  The member completing this project has spent time preparing a social speech.  

Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.  You may be evaluating one of the following types of social speeches:
* A toast    
* An acceptance speech    
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy)    
* A speech to honor an organization',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2163','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2169','Purpose Statement
 The purpose of this project is for the member to deliver a speech with awareness of intentional and unintentional body language, as well as to learn, practice, and refine how he or she uses nonverbal communication when delivering a speech. 

Notes for the Evaluator
 During the completion of this project, the member has spent time learning about and practicing his or her body language, including gestures and other nonverbal communication. 

About this speech:
* The member will present a well-organized speech on any topic. 
* Watch for the member&apos;s awareness of his or her intentional and unintentional movement and body language. Note distracting movements as well as movements that enhance the speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The speech is not a report on the content of the &quot;Effective Body Language&quot; project.',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2169','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Unintentional Movement: Unintentional movement is limited and rarely noticeable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Purposeful Movement: Speech is strengthened by purposeful choices of movement|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2175','The purpose of this project is for the member to practice being aware of his or her thoughts and feelings, as well as the impact of his or her responses on others. The purpose of this speech is for the member to share his or her experience completing the project. 

Notes for the Evaluator
 During the completion of this project, the member recorded negative responses in a personal journal and worked to reframe them in a positive way. 

About this speech:
Listen for ways the member grew or did not grow from the experience. The member is not required to share the intimacies of his or her journal. The speech should not be a report on the content of the &quot;Focus on the Positive&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8304E_EvaluationResource_FocusonthePositive.pdf" target="_blank">8304E_EvaluationResource_FocusonthePositive.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2175','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience completing the assignment|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2181','The purpose of this project is for the member to practice writing and delivering a speech that inspires others. The purpose of the speech is for the member to inspire the audience. 

Notes for the Evaluator
 The member needs to present a speech that inspires the audience. The speech content should be engaging and the speaker entertaining or moving. The speaker should be aware of audience response and adapt the speech as needed. If the member appears to be talking &quot;at&quot; the audience instead of interacting with them, he or she is not fulfilling the goal of the speech. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8305E_EvaluationResource_InspireYourAudience.pdf" target="_blank">8305E_EvaluationResource_InspireYourAudience.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2181','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engagement: Connects well with audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Uses topic well to inspire audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2187','Purpose Statement
 
* The purpose of this project is for the member to develop and practice a personal strategy for building connections through networking. 
* The purpose of this speech is for the member to share some aspect of his or her experience networking. 

Notes for the Evaluator
 During the completion of this project, the member attended a networking event. 

About this speech:
* The member will deliver a well-organized speech that includes a story or stories about the networking experience, the value of networking, or some other aspect of his or her experience networking. 
* This speech should not be a report on the content of the &quot;Make Connections Through Networking&quot; project.',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2187','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience networking|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2193','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to present himself or herself well in an interview. 

Notes for the Evaluator
 The member completing this project has spent time organizing his or her skills and identifying how those skills can be applied to complete this role-play interview. 

About this speech:
* The member designed interview questions for the interviewer that are specific to their skills, abilities, and any other content he or she wants to practice. 
* Though the member designed questions, he or she does not know exactly which questions will be asked. 
* Look for poise, concise answers to questions, and the ability to recover from ineffective answers. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8310E_EvaluationResource_PrepareforanInterview.pdf" target="_blank">8310E_EvaluationResource_PrepareforanInterview.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2193','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the interviewer|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Poise: Shows poise when responding to questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Impromptu Speaking: Formulates answers to questions in a timely manner and is well-spoken|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2199','Purpose Statement
 
* The purpose of this project is for the member to practice using vocal variety to enhance a speech. 

Notes for the Evaluator
 During the completion of this project, the member spent time developing or improving his or her vocal variety. 

About this speech:
* The member will present a well-organized speech on any topic.  
* Listen for how the member uses his or her voice to communicate and enhance the speech.  
* The speech may be humorous, informational, or any style the member chooses.  
* The speech is not a report on the content of the &quot;Understanding Vocal Variety&quot; project.  
* Use the Speech Profile resource to complete your evaluation.',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2199','Use the PDF form <a href="http://kleinosky.com/nt/pw/EvaluationResources/8317E_EvaluationResource_UnderstandingVocalVariety.pdf">8317E_EvaluationResource_UnderstandingVocalVariety.pdf</a>|',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2205','Purpose Statement
 The purpose of this project is for the member to practice writing a speech with an emphasis on adding language to increase interest and impact. 

Notes for the Evaluator
 Listen for descriptive words and literary elements, such as plot and setting.
Think about the story the speaker is telling, even in an informational speech.
Are you engaged?
Interested?
<p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8318E_EvaluationResource_UsingDescriptiveLanguage.pdf" target="_blank">8318E_EvaluationResource_UsingDescriptiveLanguage.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2205','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Descriptive Language: Delivers a speech with a variety of descriptive language|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Literary Elements: Uses at least one literary element (plot, setting, simile, or metaphor) to enhance speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 3 Increasing Knowledge 2211','The purpose of this project is for the member to introduce or review basic presentation software strategies for creating and using slides to support or enhance a speech. The purpose of this speech is for the member to demonstrate his or her understanding of how to use presentation software, including the creation of slides and incorporating the technology into a speech. 

Notes for the Evaluator
 During the completion of this project, the member reviewed or learned about presentation software and the most effective methods for developing clear, comprehensive, and enhancing slides. 

About this speech:
The member will deliver a well-organized speech on any topic. The topic should lend itself well to using presentation software. Watch for clear, legible, and effective slides that enhance the speech and the topic. The speech may be humorous, informational, or any style of the member&apos;s choosing. The speech should not be a report on the content of the &quot;Using Presentation Software&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8319E_EvaluationResource_UsingPresentationSoftware.pdf" target="_blank">8319E_EvaluationResource_UsingPresentationSoftware.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 3 Increasing Knowledge 2211','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Design: Slides are engaging, easy to see, and/or readable|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Presentation Slide Effectiveness: Slides enhance member&apos;s speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Topic lends itself well to using presentation software|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2220','',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2220','',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2227','The purpose of this project is for the member to apply his or her understanding of social media to enhance an established or new social media presence. The purpose of this speech is for the member to share some aspect of his or her experience establishing or enhancing a social media presence. 

Notes for the Evaluator
 During the completion of this project, the member:
Spent time building a new or enhancing an existing social media presence Generated posts to a social media platform of his or her choosing. It may have been for a personal or professional purpose. 

About this speech:
The member will deliver a well-organized speech about his or her experience. The member may choose to speak about the experience as a whole or focus on one or two aspects. The speech should not be a report on the content of the &quot;Building a Social Media Presence&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf" target="_blank">8400E_EvaluationResource_BuildingaSocialMediaPresence.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2227','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares the impact of initiating or increasing a social media presence|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2233','The purpose of this project is for the member to be introduced to the skills needed to organize and present a podcast. The purpose of this speech is for the member to introduce his or her podcast and to present a segment of the podcast. 

Notes for the Evaluator
 During the completion of this project, the member learned about and created a podcast. 

About this speech:
You will evaluate the member as a presenter on the podcast. The member will present well-organized podcast content. The podcast may be an interview, a group discussion, or the member speaking about a topic. The member should demonstrate excellent speaking skills. Regardless of the topic or style, the podcast should be engaging to the audience. This speech should not be a report on the content of the &quot;Create a Podcast&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8402E_EvaluationResource_CreateaPodcastE.pdf" target="_blank">8402E_EvaluationResource_CreateaPodcastE.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2233','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs*|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the live audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Podcast: Content and delivery of podcast are engaging|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
*Use these criteria to evaluate the 2- to 3-minute podcast introduction speech presented in person to the club.|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2239','Purpose Statement
 The purpose of this project is for the member to practice facilitating an online meeting or leading a webinar. 

Notes for the Evaluator
 During the completion of this project, the member spent a great deal of time organizing and preparing to facilitate an online meeting or webinar. 

About this online meeting or webinar:
* In order to complete this evaluation, you must attend the webinar or online meeting. 
* The member will deliver a well-organized meeting or webinar.
Depending on the type, the member may facilitate a discussion between others or disseminate information to attendees at the session. 
* The member should use excellent facilitation and public speaking skills. <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8407E_EvaluationResource_ManageOnlineMeetings. pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2239','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Technology Management: Conducts a well-run meeting or webinar with limited technical issues caused by the member|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Organization: Meeting or webinar is well-organized|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2245','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the first speech is for the member to give a short overview of the plan for his or her project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to building a team and developing a project plan. This is a 2- to 3-minute report on the member&apos;s plan. 

Listen for:
* An explanation of what the member intends to accomplish  
* Information about the team the member has built to help him or her accomplish the plan  
* A well-organized informational speech',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2245','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her plan, team, or project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2251','Purpose Statement
 The purpose of this project is for the member to practice the skills needed to address audience challenges when he or she presents outside of the Toastmasters club. 

Notes for the Evaluator
 During the completion of this project, the member spent time learning how to manage difficult audience members during a presentation. 

About this speech:
* The member will deliver a 5- to 7-minute speech on any topic and practice responding to four audience member disruptions.
The speech may be new or previously presented.
You do not evaluate the speech or speech content. 
* Your evaluation is based on the member&apos;s ability to address and defuse challenges presented by the audience. Audience members were assigned roles by the Toastmaster and/or vice president education prior to the meeting. 
* Watch for professional behavior, respectful interactions with audience members, and the use of strategies to refocus the audience on the member&apos;s speech. 
* The member has 10 to 15 minutes to deliver his or her 5- to 7-minute speech and respond to disrupters.',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2251','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Effective Management: Demonstrates skill at engaging difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Professionalism: Remains professional regardless of difficult audience members|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2257','The purpose of this project is for the member to practice the skills needed to effectively use public relations strategies for any group or situation. The purpose of this speech is for the member to share some aspect of his or her public relations strategy. 

Notes for the Evaluator
 During the completion of this project, the member created a public relations plan. 

About this speech:
The member will deliver a well-organized speech about a real or hypothetical public relations strategy. The speech should be informational, but may include humor and visual aids. The speech should be engaging. The speech should not be a report on the content of the &quot;Public Relations Strategies&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8412E_EvaluationResource_PublicRelationsStrategies.pdf" target="_blank">8412E_EvaluationResource_PublicRelationsStrategies.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2257','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of his or her public relations strategy|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Visual Aids: Uses visual aids effectively (use of visual aids is optional)|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2263','The purpose of this project is for the member to learn about and practice facilitating a question-and-answer session. The purpose of this speech is for the member to practice delivering an informative speech and running a well-organized question-and-answer session. The member is responsible for managing time so there is adequate opportunity for both. 

Notes for the Evaluator
 Evaluate the member&apos;s speech and his or her facilitation of a question-and-answer session. 

Listen for:
A well-organized informational speech about any topic, followed by a well-facilitated question-and-answer session. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8413E_EvaluationResource_Question-and-AnswerSession.pdf" target="_blank">8413E_EvaluationResource_Question-and-AnswerSession.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2263','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Response: Responds effectively to all questions|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Facilitation: Question-and-answer session is managed well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Time Management: Manages time effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2269','The purpose of this project is for the member to review or introduce the skills needed to write and maintain a blog. The purpose of this speech is for the member to share some aspect of his or her experience maintaining a blog. 

Notes for the Evaluator
 The member completing this project has spent time writing blog posts and posting them to a new or established blog. The blog may have been personal or for a specific organization. 

About this speech:
The member will deliver a well-organized speech about some aspect of his or her experience writing, building, or posting to a blog. The speech may be humorous, informational, or any style the member chooses. The speech should not be a report on the content of the &quot;Write a Compelling Blog&quot; project. The member may also ask you and other club members to evaluate his or her blog. If the member wants feedback on his or her blog, complete the Blog Evaluation Form. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8414E_EvaluationResource_WriteaCompellingBlog.pdf" target="_blank">8414E_EvaluationResource_WriteaCompellingBlog.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2269','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of experience creating, writing, or posting to his or her blog|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2278','',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2278','',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2285','',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2285','',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2291','Purpose Statement
 The purpose of this project is for the member to develop a clear understanding of his or her ethical framework and create an opportunity for others to hear about and discuss ethics in the member&apos;s organization or community. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time developing a personal ethical framework 
* Organized this panel discussion, invited the speakers, and defined the topic 

About this speech:
* The topic of the discussion should be ethics, either in an organization or within a community. 
* There should be a minimum of three panel members and at least one of them should be from outside Toastmasters. 

Listen for:
A well-organized panel discussion and excellent moderating from the member completing the project. Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion.',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2291','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates the panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Panel discussion stays focused primarily on some aspect of ethics|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Question-and-answer Session: Question-and-answer session is well-managed|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2297','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the first speech is for the member to introduce his or her plan and vision. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, and meeting with a guidance committee. The member has not yet implemented his or her plan. 

About this speech:
* The member will deliver a well-thought-out plan and an organized, engaging speech. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan and goals.',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2297','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2303','Purpose Statements
 
* The purpose of this project is for the member to apply the skills needed to successfully lead in a volunteer organization. 
* The purpose of this speech is for the member to share some aspect of his or her experience serving as a leader in a volunteer organization. 

Notes for the Evaluator
 During the completion of this project, the member:
* Served in a leadership role in a volunteer organization for a minimum of six months 
* Received feedback on his or her leadership skills from members of the organization in the form of a 360Â° evaluation 
* Developed a succession plan to aid in the transition of his or her leadership role 

About this speech:
* The member will present a well-organized speech about his or her experience serving as a volunteer leader. 
* The speech may be humorous, informational, or any style the member chooses.
The style should support the content. 
* This speech is not a report on the content of the &quot;Leading in Your Volunteer Organization&quot; project.',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2303','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience leading in a volunteer organization|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2309','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2309','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2315','Purpose Statement
 The purpose of this project is for the member to apply his or her skills as a public speaker and leader to facilitate a panel discussion. 

Notes for the Evaluator
 During the completion of this project, the member:
* Spent time planning a panel discussion on a topic 
* Organized the panel discussion and invited at least three panelists 

About this panel discussion:
* The panel discussion should be well-organized and well-moderated by the member completing the project. 
* Consider how the member sets the tone, keeps panelists on topic, fields questions from attendees, and generally runs the panel discussion. 
* This panel discussion should not be a report on the content of the &quot;Moderate a Panel Discussion&quot; project <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8508E_EvaluationResource_ModerateaPanelDiscussion.pdf" target="_blank">8508E_EvaluationResource_ModerateaPanelDiscussion.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2315','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Moderating: Moderates panel discussion well|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Panel Selection: Selected panel members well for their expertise on the topic|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2321','Purpose Statement
 The purpose of this project is for the member to practice developing and presenting a longer speech. 

Notes for the Evaluator
 The member completing this project has been working to build the skills necessary to engage an audience for an extended period of time. 

About this speech:
* The member will deliver an engaging, keynote-style speech. 
* The speech may be humorous, informational, or any style the member chooses. 
* The member should demonstrate excellent presentation skills and deliver compelling content. 
* The speech is not a report on the content of the &quot;Prepare to Speak Professionally&quot; project.',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2321','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Speech Content: Content is compelling enough to hold audience attention throughout the extended speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 1 Mastering Fundamentals 6','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 1 Mastering Fundamentals 6','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 1 Mastering Fundamentals 7','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 1 Mastering Fundamentals 7','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 3 Increasing Knowledge 70','Purpose Statement
 The purpose of this project is for the member to practice delivering social speeches in front of club members. 

Notes for the Evaluator
 The member completing this project has spent time preparing a social speech.


Listen for:
A well-organized, well-delivered speech with appropriate content for the type of social speech.
You may be evaluating one of the following types of social speeches:
* A toast 
* An acceptance speech 
* A speech to honor an individual (the presentation of an award, other type of recognition, or a eulogy) 
* A speech to honor an organization <p>See <a href="http:
//kleinosky. com/nt/pw/EvaluationResources/8302E_EvaluationResource_DeliverSocialSpeeches. pdf" target="_blank">http:
//kleinosky. com/nt/pw/EvaluationResources/8302E_EvaluationResource_DeliverSocialSpeeches. pdf</a></p>',false);
update_option('evalprompts:Dynamic Leadership Level 3 Increasing Knowledge 70','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement
 and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)',false);

update_option('evalintro:Dynamic Leadership Level 4 Building Skills 156','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Dynamic Leadership Level 4 Building Skills 156','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 422','The purpose of this project is for the member to develop and apply skills for coaching a fellow member or a person outside of Toastmasters who can benefit from his or her expertise. The purpose of this speech is for the member to share some aspect of his or her experience coaching. 

Notes for the Evaluator
 The member completing this project has spent time coaching a Toastmaster or other person who benefitted from his or her expertise. 

Listen for:
A well-organized speech about the member&apos;s experience as a coach. The speech may be humorous, informational, or any style of the member&apos;s choosing. The style of the speech should support the content of the speech. This speech is NOT a report on the content of the &quot;Improvement Through Positive Coaching&quot; project, but a reflection on the impact of the experience. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8403E_EvaluationResource_ImprovementThroughPositiveCoaching.pdf" target="_blank">8403E_EvaluationResource_ImprovementThroughPositiveCoaching.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 422','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shares some aspect of personal experience as a coach|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 1 Mastering Fundamentals 241','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 1 Mastering Fundamentals 241','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 1 Mastering Fundamentals 478','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 1 Mastering Fundamentals 478','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 1 Mastering Fundamentals 702','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 1 Mastering Fundamentals 702','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 1 Mastering Fundamentals 945','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 1 Mastering Fundamentals 945','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 1 Mastering Fundamentals 1181','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 1 Mastering Fundamentals 1181','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 1 Mastering Fundamentals 1412','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 1 Mastering Fundamentals 1412','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 1 Mastering Fundamentals 1636','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 1 Mastering Fundamentals 1636','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 1 Mastering Fundamentals 1860','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 1 Mastering Fundamentals 1860','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 1 Mastering Fundamentals 2096','The purpose of this project is for the member to present a speech on any topic, receive feedback, and apply the feedback to a second speech. The purpose of this speech is for the member to demonstrate that he or she has applied the feedback receivedfrom his or her first speech. 

Notes for the Evaluator
 During the completion of this project, the member:
Received feedback about his or her speech Worked to apply the feedback to a second speech 

About this speech:
The member will deliver a well-organized speech on any topic and incorporate feedback from his or her previous speech evaluation. The member may choose to present the same speech or a new speech. The speech may be humorous, informational, or any style the member chooses. Be sure the member gives you notes or that you speak with the member before the meeting to discuss the feedback he or she plans to apply in this speech. Pay close attention to these parts of the member&apos;s presentation while also providing a comprehensive evaluation of the speech as a whole. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E2_EvaluationResource_EvaluationandFeedback2.pdf" target="_blank">8100E2_EvaluationResource_EvaluationandFeedback2.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 1 Mastering Fundamentals 2096','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Applied Feedback: F eedback from first speech is applied to second speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 1 Mastering Fundamentals 242','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 1 Mastering Fundamentals 242','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 1 Mastering Fundamentals 479','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 1 Mastering Fundamentals 479','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 1 Mastering Fundamentals 703','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Leadership Development Level 1 Mastering Fundamentals 703','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 1 Mastering Fundamentals 946','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Motivational Strategies Level 1 Mastering Fundamentals 946','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 1 Mastering Fundamentals 1182','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Persuasive Influence Level 1 Mastering Fundamentals 1182','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 1 Mastering Fundamentals 1413','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Presentation Mastery Level 1 Mastering Fundamentals 1413','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 1 Mastering Fundamentals 1637','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Strategic Relationships Level 1 Mastering Fundamentals 1637','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 1 Mastering Fundamentals 1861','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Team Collaboration Level 1 Mastering Fundamentals 1861','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 1 Mastering Fundamentals 2097','The purpose of this project is for the member to develop skills for delivering and receiving feedback. The purpose of this speech is for the member to deliver constructive feedback on another member&apos;s presentation. 

Notes for the Evaluator
 It is recommended that the member evaluating this portion of the project be a proven, exemplary evaluator. During the completion of this project, the member:
Presented a speech on a topic, received feedback from an evaluator, and incorporated that feedback into a second speech 

About this speech:
The last portion of this assignment is for the member to serve as an evaluator at a club meeting. The member will deliver an engaging and constructive evaluation of another member&apos;s speech. He or she will also demonstrate proper meeting etiquette by being fully engaged during all speeches. The member may choose to take notes during the speech he or she is evaluating. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8100E3_EvaluationResource_EvaluationandFeedback3.pdf" target="_blank">8100E3_EvaluationResource_EvaluationandFeedback3.pdf</a></p>',false);
update_option('evalprompts:Visionary Communication Level 1 Mastering Fundamentals 2097','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Delivery: D elivers tactful, constructive feedback|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Engaged: Engages while others ar e speaking during the Toastmasters meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 4 Building Skills 392','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Effective Coaching Level 4 Building Skills 392','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 4 Building Skills 852','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Leadership Development Level 4 Building Skills 852','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 4 Building Skills 1089','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Motivational Strategies Level 4 Building Skills 1089','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 4 Building Skills 1325','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Persuasive Influence Level 4 Building Skills 1325','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 4 Building Skills 1556','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Presentation Mastery Level 4 Building Skills 1556','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 4 Building Skills 1780','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Strategic Relationships Level 4 Building Skills 1780','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 4 Building Skills 2004','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Team Collaboration Level 4 Building Skills 2004','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 4 Building Skills 2246','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Visionary Communication Level 4 Building Skills 2246','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 3 Increasing Knowledge 310','The purpose of this project is for the member to apply his or her mentoring skills to a short-term mentoring assignment. The purpose of this speech is for the member to share some aspect of his or her first experience as a Toastmasters mentor. 

Notes for the Evaluator
 The member completing this project has spent time mentoring a fellow Toastmaster. 

About this speech:
The member will deliver a well-organized speech about his or her experience as a Toastmasters mentor during the completion of this project. The member may speak about the entire experience or an aspect of it. The speech may be humorous, informational, or any type the member chooses. The style should be appropriate for the content of the speech. The speech should not be a report on the content of the &quot;Mentoring&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8302E_EvaluationResource_DeliverSocialSpeeches.pdf" target="_blank">8302E_EvaluationResource_DeliverSocialSpeeches.pdf</a></p>',false);
update_option('evalprompts:Effective Coaching Level 3 Increasing Knowledge 310','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses tone, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: Effectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with interesting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Content fits the topic and the type of social speech|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 6 7','The purpose of this project is for the member to learn about and apply the skills needed to run a lessons learned meeting during a project or after its completion. The purpose of this speech is for the member to share some aspect of his or her leadership experience and the impact of a lessons learned meeting. 

Notes for the Evaluator
 During the completion of this project, the member:
Worked with a team to complete a project Met with his or her team on many occasions, most recently to facilitate lessons learned meeting. This meeting may occur during the course of the project or at its culmination. 

About this speech:
The member will deliver a well-organized speech. The member may choose to speak about an aspect of the lessons learned meeting, his or her experience as a leader, the impact of leading a team, or any other topic that he or she feels is appropriate. The speech must relate in some way to the member&apos;s experience as a leader. The speech may be humorous, informational, or any other style the member chooses. The topic should support the style the member has selected. The speech should not be a report on the content of the &quot;Lessons Learned&quot; project. <p>See <a href="http:
//kleinosky.com/nt/pw/EvaluationResources/8506E_EvaluationResource_LessonsLearned.pdf" target="_blank">8506E_EvaluationResource_LessonsLearned.pdf</a></p>',false);
update_option('evalprompts:Innovative Planning Level 6 7','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spoken language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses physical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: Demonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comfortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience as a leader and the impact of the lessons learned meeting|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 4 Building Skills 598','Purpose Statement
 
* The purpose of this project is for the member to practice developing a plan, building a team, and fulfilling the plan with the help of his or her team.  
* The purpose of the second speech is for the member to share some aspect of his or her experience managing a project.  

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a project plan, building a team, and fulfilling the plan. This is a 5- to 7-minute speech about the member&apos;s experience managing a project. This speech can be humorous, informational, or any type the member feels is appropriate. 

Listen for:
* Information about what the member learned from planning, building a team, and leading that team through the completion of their project  
* The speech should NOT be a report on the content of the &quot;Manage Projects Successfully&quot; project.',false);
update_option('evalprompts:Innovative Planning Level 4 Building Skills 598','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Learning: Speech includes information about some aspect of what the member learned or gained from completing the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Dynamic Leadership Level 5 Demonstrating Expertise 200','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Dynamic Leadership Level 5 Demonstrating Expertise 200','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Effective Coaching Level 5 Demonstrating Expertise 425','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Effective Coaching Level 5 Demonstrating Expertise 425','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Innovative Planning Level 5 Demonstrating Expertise 649','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Innovative Planning Level 5 Demonstrating Expertise 649','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Leadership Development Level 5 Demonstrating Expertise 904','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Leadership Development Level 5 Demonstrating Expertise 904','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Motivational Strategies Level 5 Demonstrating Expertise 1141','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Motivational Strategies Level 5 Demonstrating Expertise 1141','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Persuasive Influence Level 5 Demonstrating Expertise 1358','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Persuasive Influence Level 5 Demonstrating Expertise 1358','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Presentation Mastery Level 5 Demonstrating Expertise 1602','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Presentation Mastery Level 5 Demonstrating Expertise 1602','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Strategic Relationships Level 5 Demonstrating Expertise 1826','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Strategic Relationships Level 5 Demonstrating Expertise 1826','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Team Collaboration Level 5 Demonstrating Expertise 2056','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Team Collaboration Level 5 Demonstrating Expertise 2056','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:Visionary Communication Level 5 Demonstrating Expertise 2298','Purpose Statement
 
* The purpose of this project is for the member to apply his or her leadership and planning knowledge to develop a project plan, organize a guidance committee, and implement the plan with the help of a team. 
* The purpose of the second speech is for the member to share some aspect of his or her experience completing the project. 

Notes for the Evaluator
 The member completing this project has committed a great deal of time to developing a plan, forming a team, meeting with a guidance committee, and completing his or her envisioned project. 

About this speech:
* The member will deliver an engaging speech about the project he or she completed. 
* The speech may be humorous, informational, or presented in any style the member chooses. The style should be appropriate for the content of the speech. 
* The speech should not be a report on the content of the &quot;High Performance Leadership&quot; project, but a presentation about the member&apos;s plan, goals, and experience completing a project of his or her choosing',false);
update_option('evalprompts:Visionary Communication Level 5 Demonstrating Expertise 2298','You excelled at:
You may want to work on:
To challenge yourself:
Clarity: Spok en language is clear and is easily understood|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Vocal Variety: Uses t one, speed, and volume as tools|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Eye Contact: E ffectively uses eye contact to engage audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Gestures: Uses ph ysical gestures effectively|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Audience Awareness: D emonstrates awareness of audience engagement and needs|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Comfort Level: Appears comf ortable with the audience|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Interest: Engages audience with int eresting, well-constructed content|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
Topic: Shar es some aspect of experience completing the components of the project|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
',false);

update_option('evalintro:COMMUNICATING ON VIDEO 15','
To learn how to develop and present an effective training program on video.
To receive personal feedback through the videotaping of your presentation.
',false);
update_option('evalprompts:COMMUNICATING ON VIDEO 15','
How was the training program directed toward the needs of the audience?
Was the training program organized clearly and logically? Was the audience given the information necessary to accomplish what the speaker wanted done?
Comment on the speaker&apos;s voice, gestures, and facial expressions. Were they used with moderation or did they overpower the television viewer? Was the voice modulated in pitch and volume?
Did the speaker appear relaxed, confident, and poised? How well did the speaker relate to the television camera? What, if any, distracting mannerisms did the speaker display?
',false);

update_option('evalintro:SPEECHES BY MANAGEMENT 7','
Give a speech demonstrating the importance of how you personally use feedback techniques in your daily life.
Use constructive evaluation to help someone improve their performance.
Offer support to empower them to change
',false);
update_option('evalprompts:SPEECHES BY MANAGEMENT 7','
How did the speaker&apos;s presentation about the feedback process improve your understanding of that process?
Did the speaker use negative words in the evaluation? If so, suggest alternate words or phrases.
Were the evaluation techniques the speaker used effective in helping his or her partner to set new goals? If they were not effective, why weren&apos;t they?
Did the evaluation include information that was not essential to the purpose? If so, give examples.
If the speaker used the techniques he or she demonstrated to influence you, would they be effective? Why? Why not?
',false);

update_option('evalforms_updated',time());

}
?>