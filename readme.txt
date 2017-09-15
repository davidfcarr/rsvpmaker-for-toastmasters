=== RSVPMaker for Toastmasters ===
Contributors: davidfcarr
Donate link: https://wp4toastmasters.com/support/
Tags: toastmasters
Requires at least: 3.0
Tested up to: 4.8.1
Stable tag: 2.6.9
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking.

== Description ==

This plugin adds Toastmasters-specific functions to your WordPress website. Once you activate RSVPMaker for Toastmasters, a series of prompts guide you through the process of installing and activating the other required and recommended software and setting up your home page and meetings schedule. See this video for a preview.

https://www.youtube.com/watch?v=D1E9GMwnImM

As an alternative to other club web software options that include a custom content management system, this WordPress-based solution allows website operators to take advantage of all the flexibility available on other WordPress sites. Members can sign up for roles on the website, meeting organizers can also assign members to roles, and club leaders can track member participation and performance.

The related [Lectern WordPress theme](https://wordpress.org/themes/lectern/) makes it easy to meet Toastmasters International branding guidelines with your WordPress website, adding the logo and the required legal disclaimers.

For documentation and tips on more effective Toastmasters web and social media marketing, see [WP4Toastmasters.com](https://wp4toastmasters.com/ "WordPress for Toastmasters"). Managed hosting for the WordPress for Toastmasters solution is available at [Toastmost.org](https://toastmost.org).

RSVPMaker for Toastmasters is an extension of [RSVPMaker](https://wordpress.org/plugins/rsvpmaker/), a general purpose event scheduling and RSVP tracking plugin. This means you can also use your website to manage other types of events, beyond club meetings, such as open house or training events. RSVPMaker can be configured to allow you to accept online payments via PayPal. [Documentation at RSVPMaker.com](https://rsvpmaker.com)

Developers who would like to contribute to this project can find the code on GitHub
[RSVPMaker](https://github.com/davidfcarr/rsvpmaker)
[RSVPMaker for WordPress](https://github.com/davidfcarr/rsvpmaker-for-toastmasters)
[Lectern](https://github.com/davidfcarr/lectern)

== Installation ==

1. Upload the RSVPMaker for Toastmasters plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Follow the on-screen prompts to also add the [RSVPMaker](https://wordpress.org/plugins/rsvpmaker/) plugin (required) and other recommended software, such as the [Lectern theme](https://wordpress.org/themes/lectern/) for Toastmasters branding. You will also be prompted to set up your meeting schedule and create event posts for your website's calendar.

== Frequently Asked Questions ==

= Why is RSVPMaker required? =

RSVPMaker provides the basic functionality for creating, editing, and displaying event posts. By default, it collects a yes/no response to an event (and, optionally, a PayPal payment). This Toastmasters extension allows the software to collect signups for specific roles.

RSVPMaker includes many features you will not use in the course of a regular Toastmasters meeting, but you may have open house events or seminars you might want to advertise as events on your website. 

= How is the version hosted at toastmost.org different? =

Toastmasters clubs can get free websites hosted as subdomains of [toastmost.org](https://toastmost.org/), a free ad-supported service that is part of the broader [WordPress for Toastmasters](https://wp4toastmasters.com) project. Toastmost.org uses the WordPress Multisite version of WordPress, meaning that all sites hosted in this fashion run on the same instance of the software, with the network administrator controlling what plugins and themes are available. This is similar to the way WordPress.com, the service provided by the company behind WordPress, functions.

When you install this software on your own website, you have greater freedom to install other plugins or themes, including those of your own design.

You can purchase hosting through project sponsor [Carr Communications Inc.](https://www.carrcommunications.com/toastmasters-club-website-hosting/), which is a way of supporting the author of this software and getting the most direct technical support.

== Screenshots ==

1. Role signup on the online agenda.
2. Data collected through the plugin feeds performance reports, such as this one showing progress toward Competent Communicator.

== Changelog ==

= 2.6.8 =

* Factored out a dependency on the intdiv function introduced in PHP 7

= 2.6.6 =

Fixing a couple of agenda and agenda timing bugs

= 2.6.5 =

* Overhaul of the agenda HTML and the custom agenda layout option
* Option to display green/yellow/red timing indicators on the agenda

= 2.6.3 =

* Fixes to user/member import and sync routine

= 2.6.1 =

* Improvements to Agenda Timing tool
* Ability to edit the display text for project time

= 2.5.9 =

* Improved agenda time planning tool

= 2.5.8 =

* Added tracking for a guests Mailman email list, in addition to members and officers lists. Activate on the Toastmasters settings screen.
* New admin screen for Mailman makes it possible to add addresses to the list and remove them. You can also manage pending messages that have been held for moderation from this screen, rather than logging into Mailman directly. Located in the submenu under Users, along with the Guests/Former Members screen.
* Guests/Former Members screen also allows you to add addresses to the Mailman guest email list.

= 2.5.7 =

* Fix to the reorder function
* YouTube tool now handles playlists as well as individual video links (can be used to share unlisted playlists in a members-only blog post)

= 2.5.5 =

* Reorder function allows you to change the order in which speakers and evaluators are displayed on the agenda.
* To display the matching of speakers to evaluators on the agenda, you can add text like "Evaluates {Speaker}" in the agenda note field. That shortcode will be replaced with the speaker name (Speaker 1 for Evaluator 1, Speaker 2 for Evaluator 2, etc)

= 2.5.2 =

* Refinements to menus, reports on member data

= 2.5 =

* Renamed Reconcile screen with Update History. Now allows you to add backdated records for arbitrary dates (for example, meetings prior your start using the software), in addition to correcting records from past meetings.
* Added Pathways tab on the Progress Reports screen to track Pathways projects completed.
* Re-enabled background save in edit signups mode. Got rid of "you have not saved this form" warning.
* Added option to sync member progress report data between websites hosted on separate domains that use this software.

= 2.4.9 =

* Updating Pathways projects list

= 2.4.8 =

* Adding online evaluation forms, particularly intended for online clubs.

= 2.4.7 =

* Preliminary support for Pathways speech projects

= 2.4.5 =

* Option to set a second email reminder to meeting participants
* Fix to prevent unwanted text from showing up on the signup sheet
* Hide member profile option to prevent display of user accounts on member listing
* Dues tracker page for tracking dues payment history

= 2.4.4 =

* Updated "Set Away Message" function (formerly called "Status") to clarify intent that this should be used to set a temporary message with an expiration date, like "I will be out of town for the next 2 weeks." The idea is to prevent members who are unavailable from being asked to take roles (and save meeting organizers from wasting time trying to contact members who are unavailable). Now appears on the sidebar widget and member listing.
* Added rich text editor to the function for emailing out agendas.
* Agenda note attribute on roles, often used to offer an explanation of the role, now also appears on the signup form.

= 2.4.3 =

* More formatting options for agenda notes, plus the ability to include a link (useful for online clubs that need to post a meeting url)

= 2.4.2 =

* Fixes an error with enqueueing of javascript and style specific to the signup form

= 2.4.1 =

* Updating date string formatting for consistency with RSVPMaker (better translation)

= 2.4 =

* Background save for the signup form disabled, for now, because it was causing problems. Replaced with a prompt that reminds the user to save the form before navigating away.
* Submenu under users allows you to convert people who registered for an event using the RSVP function (perhaps as guests at an open house) into members (website users).

= 2.3.8 =

* Added field on form for members to add a speech introduction. Intro will be sent to the Toastmaster of the Day by email and can be viewed from Agenda -> Speech Introductions on the meeting menu.
* The tmlayout_intros shortcode, meant to be used in custom agenda layouts, will display the speaker's introduction on the menu.

= 2.3.7 =

* Added "Manager" security role, replacing "Officer." Equivalent to editor but with the ability to add and edit users / members
* Added section on Settings screen for promoting members to Administrator or Manager. A Toastmasters club website needs more than one person who can update the site if the main administrator is not available.

= 2.3.6 =

Fixing background update of role assignment changes (AJAX bug)

= 2.3.3 =

Tweaking code for translation / localization

= 2.3.2 =

Added support for a customizable agenda layout.

= 2.3.1 =

Fix to export function

= 2.3 =

Bug fixes and WordPress 4.7 compatibility

= 2.2 =

* You can now fill meeting roles by randomly assigning members who do not have a role. Person editing the agenda has the opportunity to reality check the assignments before confirming them. Also works with the "Recommend" function.
* Added an option setting for the number of future meetings to be displayed on the signup sheet.

= 2.1 =

* Bug fix - correcting situation where members were unable to remove themselves from a role.

= 2.0.7 =

* Improved tracking of former members and guests
* Display of educational awards after member's name on agenda

= 2.0 =

Added listing of documents shared through the site to the main Dashboard (also shows up under the top level Toastmasters menu item)

= 1.9.9 =

Tweaked email notifications for better compatibility with Sendgrid plugin, SMTP plugins

= 1.9.7 =

* Added Toastmasters YouTube tool, which appears under the Media menu. Can be used to share speech videos uploaded to YouTube as "unlisted" with club members.
* Updated code to be translation-ready.
* Removed code related to compatibility with older versions of RSVPMaker. Make sure you have the current version.

= 1.9.1 =

Refinements to reporting and editing functions.

= 1.8.9 =

* New tabbed interface for member reporting and editing functions.
* Added data export / import screen

= 1.8.8 =

* Bug fix: security roles setup on first activation
* Tweaks to prepare for new RSVPMaker release

= 1.8.7 =

* Code cleanup
* Fixed JavaScript function for editing role assignments (loading of ajaxurl parameter on front end).

= 1.8.6 =

When a club leader is editing roles for a meetings, assignments and manuals now get "background saved" (as soon as you change a role assignment or project choice, that information is relayed to the server via AJAX). This prevents information from being lost if the leader navigates away from the form without clicking the save button at the bottom.

= 1.8.5 =

* More improvements / fixes to reporting system

= 1.8.4 =

Improvements / fixes to reporting system

= 1.8.2 =

BuddyPress integration. If BuddyPress is turned on, activities like signing up for a meeting are reflected on the user's activity feed. BuddyPress profiles also include information from the member's Toastmasters profile, including officer status.

= 1.8.1 =

Bug fix: time display on agenda

= 1.8 =

* New welcome screen, displayed on members's first login to the administrative dashboard
* Reorganized Toastmasters menu
* Starting work on a progress report for advanced manuals

= 1.7 =

* Improved member import / synch from toastmasters.org spreadsheet. Better handling of situation where a member does not have an email address, or two members (for example, husband and wife) share an email address.
* Email notification to members when they are signed up for a role by the administrator. If information such as speech project is missing, the member will be prompted to provide it.
* When no speech project is specified, 7 minutes on the agenda assigned by default.

= 1.6.9 =

Redesigned security options based on WordPress roles and capabilities. See [blog post](http://wp4toastmasters.com/2016/01/23/restricting-access-to-reports-agenda-editing/)

= 1.6.7 =

* Control of time allowed for roles or other items on the agenda. Ability to output calculated times on the agenda.
* Option to add a custom message on the login page.
* Drop-down menu for agenda editing based on http://cssmenumaker.com/menu/cherry-responsive-menu

= 1.6.6 =

The administrator can now restrict options such as viewing the CC and CL reports or editing the signups list for a coming event. Functions can be specified as accessible to any member, only to an officer or site editor, or only to the administrator.

= 1.6.5 =

Important bugfix. Correcting a glitch that was preventing posts, pages, and events from being displayed properly in the editor under some circumstances.

= 1.6.3 =

* Visual represetnation of shortcodes in editor, with popup dialog box for setting roles or content and parameters of agenda notes.
* More consistency between behavior of Agenda Setup screen and using the native WordPress editor.
* Sidebar content can now be updated as part of the edit roles function on the front end, similar to how updating the Theme of the Day/Words of the Day is handled.

= 1.6 =

Improving prompts for site setup, meeting agenda setup, and scheduling of first meetings.

= 1.5.9 =

When used in conjunction with the mailman mailing list manager, members removed from the club (deleted as users in WordPress) will automatically be deleted from the mailing list. I don't yet have this working with multisite installations (where a user removed from a site is not deleted from the user database).

= 1.5.6 =

* Changed Member Access widget HTML to display better in combination with a wider variety of themes.
* Updated widget code to use the newer style of PHP object constructor, replacing code deprecated under WordPress 4.3.

= 1.5.4 =

Bug fix: was interfering with update of user email addresses on admin screen.

= 1.5 =

* Simplification of the Agenda Setup screen
* Bug fix (plugin was interfering with WordPress standard password reset function. Sorry!)

= 1.4.9 =

Bug fixes and tweaks for compatibility with the latest version of RSVPMaker.

= 1.4.7 =

RSVPMaker for Toastmasters is now translation-ready. See the readme file in the translations folder for instructions on how to use the POEdit tool to define equivalent labels for user interface elements in other languages.

= 1.4.6 =

Adds option of new agenda layout with sidebar.

= 1.4.5 =

Tested with WordPress 4.1

= 1.4.4 =

Role data and speech details recorded on a Free Toast Host can now be imported so that it will be reflected in reports run on the website.

= 1.4.3 =

* Added ability to assign a role to a guest of the club who is not on the member list.
* Toastmasters settings screen includes key options such as setting the timezone (important for scheduling) and making the site public (turning off the "discourage search engines from indexing this site" option).

= 1.4.2 =

* Added support for members-only posts. Posts tagged to the Members Only category will only be displayed to logged in members. (Display name of category can vary, but slug must be 'members-only')
* Bug fixes and a removal of a hard-coded mention of a carrcommunications.com email address.

= 1.4 =

Simplified editor for Agenda Setup.

= 1.3.2 =

Correcting initial setup of database and meeting templates. If you installed an earlier version, please deactivate and reactivate the plugin for the correct setup.

= 1.3.1 =

Bug fix: member stats editing

= 1.2/1.3 =

* Fixed recommend function bug
* Default event template created on plugin activation