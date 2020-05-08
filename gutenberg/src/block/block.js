/**
 * BLOCK: wpt
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText } = wp.editor;
const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.editor;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType( 'wp4toastmasters/agendanoterich2', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Agenda Note' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('Displays "stage directions" for the organization of your meetings.','rsvpmaker'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Rich Text' ),
	],
attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        time_allowed: {
            type: 'string',
            default: '',
        },
		uid: {
			type: 'string',
			default: '',
		},
    },

    edit: function( props ) {	

	const { attributes, attributes: { time_allowed }, className, setAttributes, isSelected } = props;
	var uid = props.attributes.uid;
	if(!uid)
		{
			var date = new Date();
			uid = 'note' + date.getTime();
			setAttributes({uid});
		}
	
	function setTime( event ) {
		const selected = event.target.querySelector( '#time_allowed option:checked' );
		setAttributes( { time_allowed: selected.value } );
		event.preventDefault();
	}		
	
	return (
<Fragment>
<DocInspector />	
<div className={ props.className }>
<form onSubmit={ setTime } ><strong>Toastmasters Agenda Note</strong> <select id="time_allowed"  value={ time_allowed } onChange={ setTime }>
<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">60</option>
<option value="61">61</option>
<option value="62">62</option>
<option value="63">63</option>
<option value="64">64</option>
<option value="65">65</option>
<option value="66">66</option>
<option value="67">67</option>
<option value="68">68</option>
<option value="69">69</option>
<option value="70">70</option>
<option value="71">71</option>
<option value="72">72</option>
<option value="73">73</option>
<option value="74">74</option>
<option value="75">75</option>
<option value="76">76</option>
<option value="77">77</option>
<option value="78">78</option>
<option value="79">79</option>
<option value="80">80</option>
<option value="81">81</option>
<option value="82">82</option>
<option value="83">83</option>
<option value="84">84</option>
<option value="85">85</option>
<option value="86">86</option>
<option value="87">87</option>
<option value="88">88</option>
<option value="89">89</option>
<option value="90">90</option>
<option value="91">91</option>
<option value="92">92</option>
<option value="93">93</option>
<option value="94">94</option>
<option value="95">95</option>
<option value="96">96</option>
<option value="97">97</option>
<option value="98">98</option>
<option value="99">99</option>
<option value="100">100</option>
<option value="101">101</option>
<option value="102">102</option>
<option value="103">103</option>
<option value="104">104</option>
<option value="105">105</option>
<option value="106">106</option>
<option value="107">107</option>
<option value="108">108</option>
<option value="109">109</option>
<option value="110">110</option>
<option value="111">111</option>
<option value="112">112</option>
<option value="113">113</option>
<option value="114">114</option>
<option value="115">115</option>
<option value="116">116</option>
<option value="117">117</option>
<option value="118">118</option>
<option value="119">119</option>
<option value="120">120</option>
<option value="121">121</option>
<option value="122">122</option>
<option value="123">123</option>
<option value="124">124</option>
<option value="125">125</option>
<option value="126">126</option>
<option value="127">127</option>
<option value="128">128</option>
<option value="129">129</option>
<option value="130">130</option>
<option value="131">131</option>
<option value="132">132</option>
<option value="133">133</option>
<option value="134">134</option>
<option value="135">135</option>
<option value="136">136</option>
<option value="137">137</option>
<option value="138">138</option>
<option value="139">139</option>
<option value="140">140</option>
<option value="141">141</option>
<option value="142">142</option>
<option value="143">143</option>
<option value="144">144</option>
<option value="145">145</option>
<option value="146">146</option>
<option value="147">147</option>
<option value="148">148</option>
<option value="149">149</option>
<option value="150">150</option>
<option value="151">151</option>
<option value="152">152</option>
<option value="153">153</option>
<option value="154">154</option>
<option value="155">155</option>
<option value="156">156</option>
<option value="157">157</option>
<option value="158">158</option>
<option value="159">159</option>
<option value="160">160</option>
<option value="161">161</option>
<option value="162">162</option>
<option value="163">163</option>
<option value="164">164</option>
<option value="165">165</option>
<option value="166">166</option>
<option value="167">167</option>
<option value="168">168</option>
<option value="169">169</option>
<option value="170">170</option>
<option value="171">171</option>
<option value="172">172</option>
<option value="173">173</option>
<option value="174">174</option>
<option value="175">175</option>
<option value="176">176</option>
<option value="177">177</option>
<option value="178">178</option>
<option value="179">179</option>
<option value="180">180</option>
<option value="181">181</option>
<option value="182">182</option>
<option value="183">183</option>
<option value="184">184</option>
<option value="185">185</option>
<option value="186">186</option>
<option value="187">187</option>
<option value="188">188</option>
<option value="189">189</option>
<option value="190">190</option>
<option value="191">191</option>
<option value="192">192</option>
<option value="193">193</option>
<option value="194">194</option>
<option value="195">195</option>
<option value="196">196</option>
<option value="197">197</option>
<option value="198">198</option>
<option value="199">199</option>
<option value="200">200</option>
<option value="201">201</option>
<option value="202">202</option>
<option value="203">203</option>
<option value="204">204</option>
<option value="205">205</option>
<option value="206">206</option>
<option value="207">207</option>
<option value="208">208</option>
<option value="209">209</option>
<option value="210">210</option>
<option value="211">211</option>
<option value="212">212</option>
<option value="213">213</option>
<option value="214">214</option>
<option value="215">215</option>
<option value="216">216</option>
<option value="217">217</option>
<option value="218">218</option>
<option value="219">219</option>
<option value="220">220</option>
<option value="221">221</option>
<option value="222">222</option>
<option value="223">223</option>
<option value="224">224</option>
<option value="225">225</option>
<option value="226">226</option>
<option value="227">227</option>
<option value="228">228</option>
<option value="229">229</option>
<option value="230">230</option>
<option value="231">231</option>
<option value="232">232</option>
<option value="233">233</option>
<option value="234">234</option>
<option value="235">235</option>
<option value="236">236</option>
<option value="237">237</option>
<option value="238">238</option>
<option value="239">239</option>
<option value="240">240</option>
</select></form>
<RichText
	tagName="p"
	value={attributes.content}
	multiline=' '
	onChange={(content) => setAttributes({ content })}
/></div>
</Fragment>
);
	
    },
    save: function( { attributes, className } ) {
		//return null;
		return <RichText.Content tagName="p" value={ attributes.content } className={className} />;
    }
});

registerBlockType( 'wp4toastmasters/signupnote', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Signup Form Note' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('A text block that appears only on the signup form, not on the agenda.'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Signup' ),
		__( 'Rich Text' ),
	],
attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
    },

    edit: function( props ) {	
	const { attributes, setAttributes } = props;

	return (<Fragment>
		<DocInspector />	
		<div className={ props.className }>
				<strong>Toastmasters Signup Form Note</strong><RichText
                tagName="p"
                className={props.className}
                value={props.attributes.content}
                onChange={(content) => setAttributes({ content })}
            />
			</div>
			</Fragment>
);
	
    },
    save: function(props) {
	
    return <RichText.Content tagName="p" value={ props.attributes.content } className={props.className} />;
    }

} );

registerBlockType( 'wp4toastmasters/role', {
	// Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Agenda Role' ), // Block title.
	icon: 'groups', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('Defines a meeting role that will appear on the signup form and the agenda.'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Role' ),
	],
attributes: {
        role: {
            type: 'string',
            default: '',
        },
        custom_role: {
            type: 'string',
            default: '',
        },
        count: {
            type: 'int',
            default: 1,
        },
        agenda_note: {
            type: 'string',
            default: '',
        },
        time_allowed: {
            type: 'string',
            default: '',
        },
        padding_time: {
            type: 'string',
            default: '',
        },
        backup: {
            type: 'string',
            default: '',
        },
    },
	edit: function( props ) {

	const { attributes: { role, custom_role, count, agenda_note, time_allowed, padding_time, backup }, setAttributes, isSelected } = props;

	function showHideOptions () {
		const selected = document.querySelector( '#role option:checked' );
		if(selected.value == 'custom')
			customline.style = 'display: block;';
		else
			{
			document.getElementById('custom_role').value = '';
			customline.style = 'display: none;';
			}
		var paddingline = document.getElementById('paddingline');
		
		if(selected.value == 'Speaker')
			paddingline.style = 'display: block;';
		else
			{
			paddingline.style = 'display: none;';
			}
	}

	function setRole() {
		const selected = event.target.querySelector( '#role option:checked' );
		setAttributes( { role: selected.value } );
		var customline = document.getElementById('customline');
		showHideOptions();
		
		event.preventDefault();
		}
	function setTime( event ) {
		const selected = event.target.querySelector( '#time_allowed option:checked' );
		setAttributes( { time_allowed: selected.value } );
		event.preventDefault();
	}	
	function setCustomRole( event ) {
		var roleinput = document.getElementById('custom_role').value;
		setAttributes( { custom_role: roleinput } );
		event.preventDefault();
	}
	function setCount( event ) {
		const selected = event.target.querySelector( '#count option:checked' );
		setAttributes( { count: selected.value } );
		event.preventDefault();
	}	
	function setBackup( event ) {
		const selected = event.target.querySelector( '#backup option:checked' );
		setAttributes( { backup: selected.value } );
		event.preventDefault();
	}
	function setAgendaNote( event ) {
		var note = document.getElementById('agenda_note').value;
		setAttributes( { agenda_note: note } );
		event.preventDefault();
	}	
	function setPaddingTime( event ) {
		const selected = event.target.querySelector( '#padding_time option:checked' );
		setAttributes( { padding_time: selected.value } );
		event.preventDefault();
	}
		
	function showPaddingTime () {
		
		return (
		<div id="paddingline">
			<label>Padding Time:</label> <select id="padding_time"  value={ padding_time } onChange={ setPaddingTime }>
						<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
<br /><em>Typical use: extra time for introductions, beyond the time allowed for speeches</em>
</div>);
	}

		function showForm() {
		if(!isSelected)
			return (<em> Click to show options</em>);
return (<form onSubmit={ setRole, setCustomRole, setCount, setTime, setPaddingTime, setAgendaNote } >
<div><label>Role:</label> 
<select id="role" value={ role } onChange={ setRole }>
<option value=""></option>
<option value="custom">Custom Role</option>
<option value="Ah Counter">Ah Counter</option>
<option value="Body Language Monitor">Body Language Monitor</option>
<option value="Evaluator">Evaluator</option>
<option value="General Evaluator">General Evaluator</option>
<option value="Grammarian">Grammarian</option>
<option value="Humorist">Humorist</option>
<option value="Speaker">Speaker</option>
<option value="Backup Speaker">Backup Speaker</option>
<option value="Topics Master">Topics Master</option>
<option value="Table Topics">Table Topics</option>
<option value="Timer">Timer</option>
<option value="Toastmaster of the Day">Toastmaster of the Day</option>
<option value="Vote Counter">Vote Counter</option>
<option value="Contest Chair">Contest Chair</option>
<option value="Contest Master">Contest Master</option>
<option value="Chief Judge">Chief Judge</option>
<option value="Ballot Counter">Ballot Counter</option>
<option value="Contestant">Contestant</option>
</select>			
</div>
<p id="customline"><label>Custom Role:</label> <input type="text" id="custom_role" onChange={setCustomRole} defaultValue={custom_role} /></p>
<div>			<label>Count:</label> <select id="count"  value={ count } onChange={ setCount }>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
</select>
</div>
			
<div>			<label>Time Allowed:</label> <select id="time_allowed"  value={ time_allowed } onChange={ setTime }>
						<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">60</option>
<option value="61">61</option>
<option value="62">62</option>
<option value="63">63</option>
<option value="64">64</option>
<option value="65">65</option>
<option value="66">66</option>
<option value="67">67</option>
<option value="68">68</option>
<option value="69">69</option>
<option value="70">70</option>
<option value="71">71</option>
<option value="72">72</option>
<option value="73">73</option>
<option value="74">74</option>
<option value="75">75</option>
<option value="76">76</option>
<option value="77">77</option>
<option value="78">78</option>
<option value="79">79</option>
<option value="80">80</option>
<option value="81">81</option>
<option value="82">82</option>
<option value="83">83</option>
<option value="84">84</option>
<option value="85">85</option>
<option value="86">86</option>
<option value="87">87</option>
<option value="88">88</option>
<option value="89">89</option>
<option value="90">90</option>
<option value="91">91</option>
<option value="92">92</option>
<option value="93">93</option>
<option value="94">94</option>
<option value="95">95</option>
<option value="96">96</option>
<option value="97">97</option>
<option value="98">98</option>
<option value="99">99</option>
<option value="100">100</option>
<option value="101">101</option>
<option value="102">102</option>
<option value="103">103</option>
<option value="104">104</option>
<option value="105">105</option>
<option value="106">106</option>
<option value="107">107</option>
<option value="108">108</option>
<option value="109">109</option>
<option value="110">110</option>
<option value="111">111</option>
<option value="112">112</option>
<option value="113">113</option>
<option value="114">114</option>
<option value="115">115</option>
<option value="116">116</option>
<option value="117">117</option>
<option value="118">118</option>
<option value="119">119</option>
<option value="120">120</option>
<option value="121">121</option>
<option value="122">122</option>
<option value="123">123</option>
<option value="124">124</option>
<option value="125">125</option>
<option value="126">126</option>
<option value="127">127</option>
<option value="128">128</option>
<option value="129">129</option>
<option value="130">130</option>
<option value="131">131</option>
<option value="132">132</option>
<option value="133">133</option>
<option value="134">134</option>
<option value="135">135</option>
<option value="136">136</option>
<option value="137">137</option>
<option value="138">138</option>
<option value="139">139</option>
<option value="140">140</option>
<option value="141">141</option>
<option value="142">142</option>
<option value="143">143</option>
<option value="144">144</option>
<option value="145">145</option>
<option value="146">146</option>
<option value="147">147</option>
<option value="148">148</option>
<option value="149">149</option>
<option value="150">150</option>
<option value="151">151</option>
<option value="152">152</option>
<option value="153">153</option>
<option value="154">154</option>
<option value="155">155</option>
<option value="156">156</option>
<option value="157">157</option>
<option value="158">158</option>
<option value="159">159</option>
<option value="160">160</option>
<option value="161">161</option>
<option value="162">162</option>
<option value="163">163</option>
<option value="164">164</option>
<option value="165">165</option>
<option value="166">166</option>
<option value="167">167</option>
<option value="168">168</option>
<option value="169">169</option>
<option value="170">170</option>
<option value="171">171</option>
<option value="172">172</option>
<option value="173">173</option>
<option value="174">174</option>
<option value="175">175</option>
<option value="176">176</option>
<option value="177">177</option>
<option value="178">178</option>
<option value="179">179</option>
<option value="180">180</option>
<option value="181">181</option>
<option value="182">182</option>
<option value="183">183</option>
<option value="184">184</option>
<option value="185">185</option>
<option value="186">186</option>
<option value="187">187</option>
<option value="188">188</option>
<option value="189">189</option>
<option value="190">190</option>
<option value="191">191</option>
<option value="192">192</option>
<option value="193">193</option>
<option value="194">194</option>
<option value="195">195</option>
<option value="196">196</option>
<option value="197">197</option>
<option value="198">198</option>
<option value="199">199</option>
<option value="200">200</option>
<option value="201">201</option>
<option value="202">202</option>
<option value="203">203</option>
<option value="204">204</option>
<option value="205">205</option>
<option value="206">206</option>
<option value="207">207</option>
<option value="208">208</option>
<option value="209">209</option>
<option value="210">210</option>
<option value="211">211</option>
<option value="212">212</option>
<option value="213">213</option>
<option value="214">214</option>
<option value="215">215</option>
<option value="216">216</option>
<option value="217">217</option>
<option value="218">218</option>
<option value="219">219</option>
<option value="220">220</option>
<option value="221">221</option>
<option value="222">222</option>
<option value="223">223</option>
<option value="224">224</option>
<option value="225">225</option>
<option value="226">226</option>
<option value="227">227</option>
<option value="228">228</option>
<option value="229">229</option>
<option value="230">230</option>
<option value="231">231</option>
<option value="232">232</option>
<option value="233">233</option>
<option value="234">234</option>
<option value="235">235</option>
<option value="236">236</option>
<option value="237">237</option>
<option value="238">238</option>
<option value="239">239</option>
<option value="240">240</option>
</select>
<br /><em>Total time allowed. If you have three speakers, you might allow 24 minutes or more to allow for two 7-minute speeches, plus a slightly longer one.</em>
</div>
{showPaddingTime()}
<p><label>Agenda Note:</label> <input type="text" id="agenda_note" onChange={setAgendaNote} defaultValue={agenda_note} /></p>

<div><label>Backup for This Role:</label> <select id="backup" value={ backup } onChange={ setBackup }>
<option value="0">No</option>
<option value="1">Yes</option>
</select>
</div>

</form>
);		
		}
		
		return (
<Fragment>
<DocInspector />				
<div className={ props.className }>
<strong>Toastmasters Role {role} {custom_role}</strong>
{ showForm() }
</div>
</Fragment>
		);
	},
    save: function (props) { return null; },

} );

registerBlockType( 'wp4toastmasters/agendaedit', {

	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Editable Note' ), // Block title.
	icon: 'welcome-write-blog', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Editable' ),
	],
	description: __('A note that can be edited by a meeting organizer'),
	attributes: {
        editable: {
            type: 'string',
            default: '',
        },
		uid: {
			type: 'string',
			default: '',
		},	
    },
	edit: function( props ) {

	const { attributes: { editable }, setAttributes, isSelected } = props;

	var uid = props.attributes.uid;
	if(!uid)
		{
			if(editable)
				uid = editable;
			else
				{
				var date = new Date();
				uid = 'editable' + date.getTime();					
				}
			setAttributes({uid});
		}
		
	function setAgendaEdit( event ) {
		var note = document.getElementById('editable').value;
		setAttributes( { editable: note } );
		event.preventDefault();
	}	
	function showForm() {
	if(!isSelected)
		return (<p><em>Select to set title</em></p>);
return (<form onSubmit={ setAgendaEdit } >
<p><label>Editable Note Title:</label> <input type="text" id="editable" onChange={setAgendaEdit} defaultValue={editable} /></p>
<p>Enter the title for a note that can be changed for each meeting the meeting. <em>Example: Meeting Theme.</em></p></form>);		
		}
		
		return (
			<Fragment>
<DocInspector />	
<div className={ props.className }>
<p class="dashicons-before dashicons-welcome-write-blog"><strong>Toastmasters Editable Note</strong></p>
{ showForm() }
</div>
</Fragment>
		);
	},
    save: function (props) { return null; },

} ); 

registerBlockType( 'wp4toastmasters/absences', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Absences' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Absences' ),
	],
	description: __('A button on the signup form where members can record a planned absence.'),
	attributes: {
       show_on_agenda: {
            type: 'int',
            default: 0,
        },
    },
    edit: function( props ) {	
	const { attributes: { show_on_agenda }, setAttributes, isSelected } = props;

	function setShowOnAgenda() {
		const selected = event.target.querySelector( '#show_on_agenda option:checked' );
		setAttributes( { show_on_agenda: selected.value } );
		event.preventDefault();		
	}
	function showForm() {
return (<form onSubmit={ setShowOnAgenda } >
<label>Show on Agenda?</label> <select id="show_on_agenda" value={ show_on_agenda } onChange={ setShowOnAgenda }>
<option value="0">No</option>
<option value="1">Yes</option>
</select></form>);		
		}

	return (
		<Fragment>
		<DocInspector />
		<div className={ props.className }>
				<strong>Toastmasters Absences</strong> placeholder for widget that tracks planned absences
			{showForm()}
			</div>
		</Fragment>
);
	
    },
    save: function(props) {
    return null;
    }
} ); 

class DocInspector extends Component {

	render() {
		return (
			<InspectorControls><p><a href="https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/" target="_blank">{__('Agenda Setup Documentation','rsvpmaker')}</a></p>
			<p>Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren't visible, start typing "toastmasters" in the search blank as shown below.</p>
			<p><img src="/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png" /></p>
			<p>Most used agenda content blocks:</p>
			<ul>
			<li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/">Agenda Role</a></li><li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/">Agenda Note</a></li><li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/">Editable Note</a></li><li><a target="_blank" href="https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/">Toastmasters Absences</a></li>
			</ul>
			</InspectorControls>
		);
	}
}
