=== RSVPMaker for Toastmasters ===
Contributors: davidfcarr
Donate link: https://wp4toastmasters.com/support/
Tags: toastmasters
Requires PHP: 5.6
Requires at least: 5.0
Tested up to: 5.6
Stable tag: 4.2.5
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking.

== Description ==

This plugin adds Toastmasters-specific functions to your WordPress website. Once you activate RSVPMaker for Toastmasters, a series of prompts guide you through the process of installing and activating the other required and recommended software and setting up your home page and meetings schedule. See this video for a preview.

https://www.youtube.com/watch?v=D1E9GMwnImM

As an alternative to other club web software options that include a custom content management system, this WordPress-based solution allows website operators to take advantage of the same technology that powers major publishing websites (newyorker.com and time.com, for example) and countless blogs, small business websites, and online marketing campaigns. That makes it a more powerful tool for recruiting new members and showcasing what makes your club special.

Part of a broader WordPress for Toastmasters solution, this plugin lets members sign up for roles on the website. Meeting organizers can also assign members to roles. In addition, club leaders can track member participation and performance through the administrator's dashboard.

The related [Lectern WordPress theme](https://wordpress.org/themes/lectern/) makes it easy to meet Toastmasters International branding guidelines with your WordPress website, adding the logo and the required legal disclaimers.

For documentation and tips on more effective Toastmasters web and social media marketing, see [WP4Toastmasters.com](https://wp4toastmasters.com/ "WordPress for Toastmasters"). Managed hosting for the WordPress for Toastmasters solution is available at [Toastmost.org](https://toastmost.org). Join the [Toastmost and WordPress for Toastmasters Users group on Facebook](https://www.facebook.com/groups/wp4toastmasters/).

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

Toastmasters clubs can get websites hosted as subdomains of [toastmost.org](https://toastmost.org/), a service of project project sponsor [Carr Communications Inc.](https://www.carrcommunications.com/toastmasters-club-website-hosting/) based on the free, open source software from the [WordPress for Toastmasters](https://wp4toastmasters.com) project. Toastmost.org uses the WordPress Multisite version of WordPress, meaning that all sites hosted in this fashion run on the same instance of the software, with the network administrator controlling what plugins and themes are available. This is similar to the way WordPress.com, the service provided by the company behind WordPress, functions.

The software will run on any WordPress web hosting service.
 
When you install this software on your own website, you have greater freedom to install other plugins or themes, including those of your own design. However, you must also take more responsibility for providing your own technical support and solving problems such as spam filters blocking email notifications.

The toastmost.org service is supported by subscriptions from member clubs.

== Screenshots ==

1. Role signup on the online agenda.
2. Data collected through the plugin feeds performance reports, such as this one showing progress toward Competent Communicator.

== Changelog ==

= 4.2.4 =

* Dues tracker enhancements. Now a more complete solution for tracking online payments, sending reminders.

= 4.2.3 =

* Support for custom timer background images

= 4.2.2 =

* A few more tweaks to timer. Words Green, Yellow, Red appear in main screen, not just popup.
* Checking that Jitsi integration still works.

= 4.2.1 =

* Tweaks for timer javascript and layout

= 4.2 =

* Updates to the contest and timer tools.

= 4.1.8 =

* Multiple contest tool enhancements. Feature for emailing contest links to judges and timer.
* More glitch free implementation of automatic count for multiple role blocks for the same role. On post updated, rather than on post view.

= 4.1.7 =

* Synchronization of judges between related contests
* Practice contest links for judges and timer

= 4.1.6 =

* Enhancements to contest functions. Clearer display of when a tie exists / tiebreaker vote is required.
* Better handling of multiple blocks representing the same role (no longer necessary to manually set the Start From field). Example: Speakers 1-3, then a break or another activity, followed by Speakers 4-6.

= 4.1.5 =

* Enhancements to contest functions. Help links. Sample ballot link.

= 4.1.4 =

* Contest functions: create a second contest associated with a meeting; judges type name to "sign" ballot

= 4.1.3 =

* Enhancements to setup wizard, including option for password reset with strength meter.

= 4.1.2 =

* Setup wizard added to simplify configuration, particularly for those who are new to WordPress.

= 4.1.1 =

* Agenda layout change
* Fix project timing for Deliver Social Speeches

= 4.1.0 =

* Improvements to contest functions

= 4.0.9 =

* Evaluation forms correction: Introduction to Toastmasters Mentoring
* Updated welcome screen for new members

= 4.0.8 =

* Added evaluation forms for speeches from the Toastmasters Mentor program
* Option to upload member roster CSV file from toastmasters.org rather than using copy-and-paste import from Excel

= 4.0.6 =

* Filter on output for WordPress menus adds member login / role signup / edit profile options to menu, replacing any custom menu item with #tmlogin as the URL field.

= 4.0.4 =

* Remote download of evaluation forms now only used if no local copy or if administrator requests an update.

= 4.0.3 =

* Simplification of contest dashboard UI
* Fix to multi-week signup function

= 4.0.1 =

* A few more timer options
* Small change in widget code.

= 4.0 =

* Timer fix

= 3.9.9 =

* Ajax loading of reports
* Fixed issue with edit history screen

= 3.9.8 =

* Role planner tool now allows you to specify speech planner details.
* Inline editing of roles on the signup form (without clicking Edit Signups on the menu) now allows you to specify a guest speaker.

= 3.9.7 =

* Fix to formatting on the YouTube Toastmasters screen.
* Added "Other" category to list of Path / Manual types

= 3.9.5 =

* Speaker selection defaults show Pathways options more prominently
* JavaScript for picking manuals list by path or list of old manuals
* When an editor changes assignments, path and level (or manual) are set based on what member did last
* Better security for JavaScript actions

= 3.9.4 =

* More updates to YouTube tool.

= 3.9.3 =

* Update to YouTube tool - simplifies creating blog posts and emails with embedded speech (or online meeting replay) videos.

= 3.9.2 =

* Another timing bug fix.

= 3.9.1 =

* Fix agenda timing UI bug

= 3.8.9 =

* Timing for segments of the meeting now displayed in the inspector sidebar for roles and agenda notes. Timing summary updates as "time allowed" and "padding time" are changed.

= 3.8.4 =

* Adding Start to the options available in editor for role blocks. Corrects a potential issue with role enumeration.

= 3.8.3 =

* Redisigned online timer displays synchronized timing lights without putting as much strain on the web server or network bandwith. In the view used by a speaker, it checks the server for updates every 15 seconds. If it detects that the Timer has started timing, it calculates the difference between the timestamp shared by the server and the speaker's own computer clock. Green, yellow, and red are then displayed on a syncrhonized schedule.

= 3.8.1 =

* It is now possible to have multiple blocks of roles with the same name -- for example, 2 Speaker blocks separated by Table Topics or a break in the agenda -- without messing up the Speaker counts and data. So the first block might be Speaker 1, 2, and 3 while the second is 4, 5, and 6 (assuming both have the count parameter set to 3).
* Items from the agenda menu now mirrored on the dashboard (more complete access to agenda functions)

= 3.8 =

* Disabled speaker monitoring of timer because of security issues.

= 3.7.9 =

* Correcting issues with timer JavaScript polling server.

= 3.7.7 and 3.7.8 =

* Timer tweaks

= 3.7.4 =

* Making Timer implementation consistent across versions with embedded Jitsi and Zoom

= 3.7.2 =

* Integration with Jitsi online meetings and preliminary support for Zoom.
* Cleanup of WP Cron jobs on plugin deactivate.
* Addressed a potential XSS issue.

= 3.7.1 =

* Updates to the contest voting / vote counting tools.

= 3.7 =

* Fixes to project list. Adding speeches for HPL (Advanced Leadership Silver version) and fixing glitch with display of Engaging Humor projects.
* Minor tweaks to contest tool

= 3.6.9 =

* Updates to reflect the addition of Group Email functions in RSVPMaker as an alternative to Mailman or WP Mailster.

= 3.6.8 =

* Updates to contest tools, based on experience of what can go wrong.
* Contest setup can import settings from another event.

= 3.6.7 =

* Improvements to contest scoring dashboard.

= 3.6.6 =

* Multiple updates to the scoring dashboard for contests (particularly contests conducted online)
* Added the ability to open a separate browser window displaying only the green/yellow/red colors. Can be used in combination with a virtual webcam to show timing colors in a Zoom meeting without sharing other information.

= 3.6.5 =

* Added "To Be Announced" as a placeholder for role assignments, in addition to "Open" and "Not available"
* Editable text blocks no longer display "No set" when no content has been set for them.

= 3.6.4 =

Avoid issues with document save JSON confirmation by checking that wp_is_json_request is false before init of shortcodes / dynamic blocks 

= 3.6.1 =

* Option to have speech introductions appear on the agenda by default. If not set to default, a Show with Introductions item appears on the agenda menu.
* Updated Agenda Layout document to use Gutenberg blocks for layout with or without sidebar.

= 3.5.9 =

* Documentation tips for editing the agenda
* Fix to scheduling functions

= 3.5.8 =

* Tweaks to some timing functions.
* Improvement to Online Timer speech timer tool. Now also tracks Evaluators.

= 3.5.6 =

* Fix to member application form (prevent user editing of club name / number)
* Edit signups for individual roles
* Edit editable fields without switching to edit signups mode

= 3.5.4 =

* Adding a missing project that wasn't showing up on all paths (Deliver Social Speeches - Second Speech)
* Optimizations

= 3.5.3 =

* Added integration with the WP Mailster for email discussion lists (alternative to integration with Mailman)

= 3.5.2 =

* Multi-meeting signup editor now shows list of members without a role
* New API endpoint for determining which members do not have a meeting role - /wp-json/rsvptm/v1/norole/331 where 331 is the post ID

= 3.5.1 =

* Dashboard shows current assignment (or planned absence) for next several dates.
* Bug fixes related to away messages, contest tool

= 3.5 =

* Overhaul of the performance reports screen, with less emphasis on the traditional program vs. Pathways, more on measuring active participation (6-month snapshot report)

= 3.4.9 =

* Added a setting for an editor or administrator to be notified when a Contributor submits a blog post for review.

= 3.4.7 =

* Split the Toastmasters menu on the dashboard in two, with basic functions and reports in the Toastmasters and administrative functions on a separate TM Administration menu.
* Cleaned up the Toastmasters-specific widgets on the main Dashboard screen.
* Refined the functions for adding a default home page (rather than a blog listing on front) and/or adding default pages for calendar, member listing etc.
* Improved the Member Access widget, making it easier to view any of the upcoming events listed with the option of logging in on your way to that page. Previously, the link was always to a login page, which some users found confusing when they were trying to view the event listing without necessarily signing up for a role.

= 3.4.6 =

* Added a web form version of the Toastmasters International application, with workflow for digital signature by applicant and officer, online payment, and creation of website account for new member.

= 3.4.5 =

* Updates to the online evaluation form screen.
* Member listing on dashboard can be sorted to show newest members first.

= 3.4.3 =

* Optional rules for managing the agenda, including a points system for tracking members who sign up to speak but don't regularly fill other supporting roles.

= 3.4.2 =

* Rules tab under Settings allows for setting optional rules. First optional rule makes it possible to set meeting roles that confer the ability to edit agenda signups, in addition to security roles. For example, if you limit the edit signups capability to the Administrator and Manager roles, you can specify that a regular member serving as Toastmaster of the Day should still be able to edit the agenda.

= 3.4.0 =

* Evaluation forms updated to include additional Pathways  project, incliuding Engaging Humor path
* Better system for fetching evaluation forms from a centralized repository.

= 3.3.9 =

* Downloading for branded Toastmasters images such as agenda banners.

= 3.3.8 =

* Most reports consolidated under a Reports Dashboard screen.
* New reports: Pathways Progress, Members without an Assignment

= 3.3.7 =

* Tweaks to automated role reminders. More time options on dropdown, addition of [[officers]] shortcode.

= 3.3.4 =

* Fix to automated reminders

= 3.3.3 =

* Fix for random assignments feature

= 3.3.2 =

* Added Role Report on admin dashboard
* Tested with WordPress 5.0 beta

= 3.3 =

* Import / export tweaks
* Planned absences displayed on signup sheet

= 3.2.9 =

* Import / export tab now includes a utility for transferring data between websites.

= 3.2.8 =

* Making Agenda with Contacts screen work with Gutenberg
* Limiting output of JavaScript on admin screens to avoid conflicts with other plugins

= 3.2.4 =

* Tweak Timing feature added to edit signups mode -- allows you to tweak the time allowed for each role  or agenda note without going into the editor.

= 3.2 =

* Added Look Ahead Editor as a submenu under Signup Sheet - an editable form arranged in a table, with 3-6 weeks worth of assignments showing
* Agenda editor refinements
* Fixed Planning screen so it works with new agenda format

= 3.1.9 =

* [[wpt_embed_agenda]] shortcode can be used to embed the print view of the agenda in any blog post or page. Optional attributes are id and style. By default, the agenda for the next upcoming meeting is displayed in an iframe with a height of 1000px and width of 100%.

= 3.1.8 =

* Agenda Note and Signup Note blocks support rich text
* Fix for spacing on agenda

= 3.1.3 =

* Updated the YouTube video publishing / email distribution tool, which you find under Media -> YouTube Toastmasters

= 3.1.1 =

* More work on the agenda editor and simplifying the conversion of existing agenda templates.

= 3.1.0 =

* Updates to allow the agenda editor to work with the new Gutenberg editor.

= 3.0.7 =

* Fixed / improved functions for reactivating former members.

= 3.0.6 =

* Export Personal Data includes the user archive for members with no active user account.

= 3.0.5 =

* Integration with the new Export Personal Data and Erase Personal Data tools WordPress 4.9.6 added to simplify compliance with privacy regulations such as the EU's General Data Protection Regulation (GDPR)

= 3.0.4 =

* Tweaks to Agenda Timing tool.

= 3.0.3 =

* New JavaScript animation for Take Role 
* As members sign up for roles, they are prompted to also sign up for future meetings.

= 3.0.1 =

* Ajax data post for Take Role function - saves agenda data without reloading page when individual member is signing up for a role.
* Tweaked import / sync process for updating member records based on the spreadsheet downloaded from toastmasters.org. Tried to make the process clearer. Should work better on a multisite instance like toastmost.org.
* Fixed bug in the process for adding speeches or roles on the administrative dashboard (added roles weren't showing up with the specified date)
* In addition to background colors, added green/yellow/red color labels for the online timer tool.

= 3.0 =

* Improvements to the online Toastmasters contest voting / vote counting setup, now integrated with Timer tool.

= 2.9.7 =

* Contest scoring tool

= 2.9.3 =

* Planned absences shortcode, [tm_absence], that can be added to an agenda. Allows members to record when they expect to miss a specific meeting
* Attendance report now allows display of dates attended for a specific member (based on roles served or member recorded as attending)
* RSVP to Guest screen now allows you to record Toastmasters ID#.

= 2.9.2 =

* Suggest Assignments is the new menu label for the agenda editing mode that semi-randomly selects members to fill open roles.

= 2.9.1 =

* Assign mode for - editing the agenda with semi-random suggestions for members to fill open roles - now disabled by default. Must be specifically enabled on the settings screen.
* When enabled, Assign mode now requires and "Are you sure?" confirmation from the member before random assignments will be inserted on the form.
* The link from the agenda to the member role planner tool can now be shown or hidden, depending on your choice on the Toastmasters settings screen. By default, it is displayed.

= 2.9 =

* Clearer notification when email-sending functions are disabled.
* Updates for compatibility with new sponsorship program.

= 2.8.9 =

* Clearer notifications / instructions for editing modes and randomly suggested assignments.
* Added Switch Template as an option on the Agenda Setup menu.

= 2.8.8 =

* Fixing check that RSVPMaker is installed before calling any RSVPMaker functions (better error message for plugin install)

= 2.8.4 =

* Updates to Multi-Meeting Role Planner tool.

= 2.8.3 =

* Added autocomplete on member name to the timing tool.

= 2.8.2 =

* Tweaks to timing tool.

= 2.8.1 =

* New Role Planner for signing up for roles several weeks in advance, with suggestions based on past history.
* Online Timing tool on Agenda menu for displaying timing lights on a computer screen. Pulls time requirements for projects from the agenda. In addition to showing green/yellow/red, it can sound a chime as each milestone is passed. Particularly intended for use by online clubs, in combination with webcam software. See [blog post](https://wp4toastmasters.com/2017/11/29/new-online-timing-lights-tool/)

= 2.8 =

* Improvements to email reminders function, including the ability to preview messages and an option to send a meeting reminder to members without a role (in addition to reminders for members who have taken a role).

= 2.7.9 =

* Added Request Evaluation tab to the Evaluations page.

= 2.7.8 =

* Redesign of online evaluations screen with Evaluations Received and Evaluations Given tabs. Tracking of evaluations given added.

= 2.7.7 =

Changed how assignments and recommendations are logged and displayed to the person editing the agenda.

= 2.7.6 =

* Fixes for data sync function, stoplight timing html/css

= 2.7.4 =

* Dates now displayed on Competent Leader report.

= 2.7.3 =

* More tweaks for recommended roles

= 2.7.2 =

* Fixes for recommended role feature, online evaluation forms

= 2.7.1 =

* Improved the random member selection tool, particularly for use by clubs that tend to assign members to roles more than asking for volunteers. This is enabled when you choose Assign or Recommend from the menu. In the Recommend mode, members must confirm before they are added to the agenda. The software attempts to filter out 1) members who have filled the same role at one of the last few meetings, 2) members who have been absent recently, and 3) junior members who have completed less than 3 speeches in the case of senior roles like evaluator and Toastmaster of the Day.
* Changed the coding for red-yellow-green stoplight indicators. Now works better with download to Word and should print more clearly in black and white.
* A shortcode in the format [signup_sheet limit="3"] is now available for displaying a multi-week view of upcoming roles on your website. This is essentially the same as the paper signup sheet. The limit value must be specified and determines the number of columns for the table.

= 2.7 =

* fix to admin css / js
* tweak to recommend role function

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