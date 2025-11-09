=== RSVPMaker for Toastmasters ===
Contributors: davidfcarr
Donate link: https://wp4toastmasters.com/support/
Tags: toastmasters
Requires PHP: 5.6
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 6.5.5
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking.
== Description ==
This plugin adds Toastmasters-specific functions to your WordPress website. Once you activate RSVPMaker for Toastmasters, a series of prompts guide you through the process of installing and activating the other required and recommended software and setting up your home page and meetings schedule. See this video for a preview.
This demo of the hosted version at [Toastmost.org](https://toastmost.org), an excerpt from a [video course for Toastmasters leaders](https://www.wp4toastmasters.com/video-course/) covers the key features. 
https://www.youtube.com/watch?v=Ok_BfVnO_Lk
As an alternative to other club web software options that include a custom content management system, this WordPress-based solution allows website operators to take advantage of the same technology that powers major publishing websites (newyorker.com and time.com, for example) and countless blogs, small business websites, and online marketing campaigns. That makes it a more powerful tool for recruiting new members and showcasing what makes your club special.
Part of a broader WordPress for Toastmasters solution, this plugin lets members sign up for roles on the website. Meeting organizers can also assign members to roles. In addition, club leaders can track member participation and performance through the administrator's dashboard.
Dues collection and dues tracking are enabled through integration with the Stripe and PayPal online payment services. When enrolling new members, you can have them fill out a web-based version of the application form and pay dues as part of that process.
The related [Toastmasters-branded WordPress themes](https://www.wp4toastmasters.com/2023/12/10/new-more-flexible-wordpress-for-toastmasters-design-tools-for-2024/), available on Toastmost or to [download](https://www.wp4toastmasters.com/2023/12/10/new-more-flexible-wordpress-for-toastmasters-design-tools-for-2024/) and use on other web hosting, make it easy to meet Toastmasters International branding guidelines, adding the logo and the required legal disclaimers and integrating official brand colors into the WordPress editor.
For documentation and tips on more effective Toastmasters web and social media marketing, see [WP4Toastmasters.com](https://wp4toastmasters.com/ "WordPress for Toastmasters"). Managed hosting for the WordPress for Toastmasters solution is available at [Toastmost.org](https://toastmost.org). Join the [Toastmost and WordPress for Toastmasters Users group on Facebook](https://www.facebook.com/groups/wp4toastmasters/).
RSVPMaker for Toastmasters is an extension of [RSVPMaker](https://wordpress.org/plugins/rsvpmaker/), a general purpose event scheduling and RSVP tracking plugin. This means you can also use your website to manage other types of events, beyond club meetings, such as open house or training events. RSVPMaker can be configured to allow you to accept online payments via PayPal or Stripe. [Documentation at RSVPMaker.com](https://rsvpmaker.com)
Developers who would like to contribute to this project can find the code on GitHub
[RSVPMaker](https://github.com/davidfcarr/rsvpmaker)
[RSVPMaker for WordPress](https://github.com/davidfcarr/rsvpmaker-for-toastmasters)
== Installation ==
1. Upload the RSVPMaker for Toastmasters plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Follow the on-screen prompts to also add the [RSVPMaker](https://wordpress.org/plugins/rsvpmaker/) plugin (required) and other recommended software, such as the [Lectern theme](https://wordpress.org/themes/lectern/) for Toastmasters branding. You will also be prompted to set up your meeting schedule and create event posts for your website's calendar.
== Frequently Asked Questions ==
= Why is RSVPMaker required? =
RSVPMaker provides the basic functionality for creating, editing, and displaying event posts. By default, it collects a yes/no response to an event (and, optionally, a PayPal payment). This Toastmasters extension allows the software to collect signups for specific roles.
RSVPMaker includes many features you will not use in the course of a regular Toastmasters meeting, but you may have open house events or seminars you might want to advertise as events on your website. 
= How is the version hosted at toastmost.org different? =
Toastmasters clubs can get websites hosted as subdomains of [toastmost.org](https://toastmost.org/), a service of project project sponsor [Carr Communications Inc.](https://www.carrcommunications.com/toastmasters-club-website-hosting/) based on the free, open source software from the [WordPress for Toastmasters](https://wp4toastmasters.com) project. Toastmost.org uses the WordPress Multisite version of WordPress, meaning that all sites hosted in this fashion run on the same instance of the software, with the network administrator controlling what plugins and themes are available. This is similar to the way WordPress.com, the service provided by the company behind WordPress, functions.
The software will run on any WordPress web hosting service.
When you install this software on your own website, you have greater freedom to install other plugins or themes, including those of your own design. However, you must also take more responsibility for providing your own technical support and solving problems such as spam filters blocking email notifications.
The toastmost.org service is supported by subscriptions from member clubs.
== Screenshots ==
1. Role signup on the online agenda.
2. Data collected through the plugin feeds performance reports, such as this one showing progress toward Competent Communicator.
== Changelog ==
= 6.4.3 =
* More efficient database queries for "last did" and agenda metadata via api
= 6.4.2 =
* Shortcode for displaying QR code to enable app on the front end [[toastmost_mobile_qr_shortcode]]
= 6.4.1 =
* Clearer button labels on voting screens. Fixed notifications at bottom of screen. 
* Altered API to check for multiple members signing up for same role.
= 6.4 =
* Translations on dynamic agenda
= 6.3.9 =
* Updated mobile app features. Fix to vote counter's tool.
= 6.3.8 =
* Updated POT file for translations
= 6.3.7 =
* Mobile app promo, additional app features
= 6.3.6 =
* Simplified Assign screen layout
= 6.3.4 =
* More improvements to Toastmost mobile app API
= 6.3.3 =
* Updates to support integration with the Toastmost mobile app.
* Voting tool fix to prevent caching of identifier
= 6.3 =
* Most Organize mode options now available from main Agenda screen.
= 6.2.9 =
* Signup form shows edit options for role on mouseover (if user has permissions)
= 6.2.6 =
* ReorgWidget for easier manipulation of the agenda
* Fix for persistence of security options
= 6.2.5 =
* Timer image file upload security improvement
= 6.2.4 =
* Coding changes to address reports of errors on PHP 8. Functions moved into include files. Inline the_content filter functions.
= 6.1.5 =
* Show / hide for agenda view controls (Signup vs Edit vs Suggest etc.)
= 6.1.3 =
* Fix for agenda notes, compatability with WP editor changes
= 6.1.2 =
* Updates to contest tool, including option for judge to submit vote by email as a backup.
= 6.1.1 =
* Fixes to suggestions function and payment for member application
= 6.0.6 =
* Misc bugfixes, including one with officer forwarding addresses not being updated
= 6.0.5 =
* Copy-paste evaluation form URLs on signup page
= 6.0.1 =
* Sort option for Member Signups and Suggestions screen
= 6.0 =
* Member signups and suggestions screen shows upcoming roles the member has signed up for, suggested roles if the member has not taken a role, plus contact info. Includes one-click signup links for the open roles. 
