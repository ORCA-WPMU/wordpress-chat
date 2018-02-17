=== Chat ===
Contributors: wpmudev, Paul Menard, UmeshSingla
Tags: chat, twitter, facebook, google, shortcode, BuddyPress, widget, chat widget, buddypress group, buddypress friend
Requires at least: 3.7
Stable tag: trunk
Tested up to: 4.7

Allow your readers to chat with you

== Description ==

Add a chat to your blog and allow your readers to chat with you.

== Screenshots ==

1. In post chat
2. Chat widget

== ChangeLog ==

= 2.2.1 =

*Fixed:
    * Compatibility with WordPress 4.8, TinyMCE button not working
    * Typo in settings page

= 2.2 =

*Fixed:
    * Wrong date and time, when server timezone is set other than UTC
    * Specified User login message not displayed for `noauth_login_message`
    * Missing div closing tags
    * Selected Avatar border color not shown on frontend for Moderator and User
    * Fatal Error with WordPress 4.7
    * Conflict with Easy Blogging plugin

= 2.1.3 = Umesh Kumar =
* Fixed:
    * Conflict with Upfront

= 2.1.2 = Umesh Kumar =

* Fixed: Chat login issue for users

= 2.1.1 = Umesh Kumar =

* Fixed: Emoji issue in Safari
* Fixed: Page reload required for Twitter login

= 2.1 = Umesh Kumar =
* Fixed: Chat messages not working with WordPress 4.4
* Fixed: Gravatar doesn't shows up for page chat
* Fixed: Translate date

= 2.0.9.5 = Umesh Kumar =

* Fixed: Compatibility with latest WordPress

= 2.0.9.4 = Umesh Kumar =

* Fixed: Pop Out Window

= 2.0.9.3 = Umesh Kumar =

* Fixed:  Emoticons not appearing in messages

= 2.0.9.2 = Umesh Kumar =

* Fixed (Important - Security Fix ):  Fixed query_arg, xss possibility

= 2.0.9.1 = Umesh Kumar =

* Fixed:  Messages not being sent when Object cache was enabled

= 2.0.9 =

* Fixed:  Private Chat: check invitation status before displaying messages
* Fixed:  Include Facebook script checkbox on settings page
* Fixed:  Multiple private chat window overlapping each other
* Fixed:  TinyMCE insert chat shortcode - title missing in shortcode parameters
* Update: Changed default time for polling to 3s instead of 1s
* Update: Blocked word settings (Settings are now available directly under "Settings Site, Settings Page and Settings Widget")

= 2.0.8.8 =

* Fixed: Chat messages not appearing in Wordpress 4.0

= 2.0.8.7 =

* Fixed: Private chat not working for public login

= 2.0.8.6 =

* Fixed: Private chat not displayed on Single member page
* Fixed: Chat not displayed on gravity new form page
* New: Disable auto scroll in particular chat window

= 2.0.8.5 =
* Corrected reported issue on new Chat Rooms Widget where BuddyPress chat URL were not properly linked to specific group chat. 

= 2.0.8.4 =
* Added new Chat Rooms Widget to show active chat rooms and optionally active users. Currently can show listing of open chat for Page and BuddyPress Groups. Bottom Corner and Widget cats are not shown since those show on all pages. 
* Added more logic to handle responsive screen sizes. New settings with chat for controlling width and height independantly. See new settings options on Box Appearance tab near the height/width settings
* Added new option on Site chat (bottom corner) Box Position tab to allow changing the fixed position bottom corner chat to revert to relative position when the screen size is narrower than the width of the chat box. Also removing box shadow and margins.
* Added CSS to try forcing break on long URLs. 
* Corrected reported issue where chat box jumped on screen. 
* Corrected reported issue where moving the cursor to the middle of the line when hitting return caused the chat message to be split into two lines. Better support for shift+ret.
* Corrected reported issue where plus sign '+' when posted in a chat message was being removed. 

= 2.0.8.3 = 
* Corrected reported issue with latest version of BuddyPress where Chat user status was no longer showing on individual BP profile pages. 


= 2.0.8.2 = 
* Corrected reported issue where some string were not being properly translated because they were included before calling load_plugin_textdomain(). 


= 2.0.8.1 = 
* Corrected small JavaScript issue where after a public user login they are not shown the message input. 


= 2.0.8 = 
* Corrected reported security issue where private chats were continuing even after WP user logged out. 
* Corrected reported issue related to BuddyPress Friends Connection causing fatal error is component was not enabled. This was seen when viewing a specific member's profile.
* Corrected issue when user has set their chat status to unavailable they were still able to receive private chat invites. Now the user must by available. When the user changes their chat status back to available they will see the pending invites.
* Updated chat user statuses. When the user is authenticated the selectable chat statuses are 'Available' or 'Unavailable'. When the user is not authenticated the chat status will be set to Away. This is changed on the Chat toolbar menu, User Profile in Dashboard and BuddyPress Profile Settings options. Thanks @Aurelio for the notification on the confusion. 
* Added option on Chat > Settings Site > Bottom Corner tab to control how/when the private chat popup will auto-reappear.
* Added support for WordPress delete user. See new option on Chat > Settings Common > WPAdmin tab. Allow deletion of chat messages when WordPress user is removed from system. Will also handle reassign message to different user. 

 
= 2.0.7.9 = 
* Corrected reported issue where activation of plugin was causing errors.
* Corrected reported issue related to the user enter/exit notifications within flashing over and over in private chat. 
* Tuned private chat logic to reopen a previously close chat session if a new message is sent. This also works if the user leaves the site and returns the chat session will resume. Thanks Carl for the suggestion. 
* Added logic to support window resizing. This mean the chat width/height will not be larger then the browser window. This also help make chat a little more responsive for mobile users. 
* Added logic for the new send button to only show for mobile users. This is in addition to enabled/disabld for all.

= 2.0.7.8 = 
- Corrected reported issue where bottom corner and primate chat minimize/maximize and settings 'gear' icon clicks were not working. 
- Corrected issue where bottom corner and private chat box when mimimized lost their title text.

= 2.0.7.7 =
- Fixed issue with the send button when enabled on some chat session. Was not properly being captured.
- Fixed issue related to WP 3.9 when using the Plugin AJAX polling method.
- Added a performance option see Chat > Settings Commong > Poll Intervals to enable. This performance information is displayed via the browser console and shows queries, memory, timer. Only shown to admin users for debug purposes.

= 2.0.7.6 =
- Fixes to Chat Log Message inproperly setting query elements to pull in message for selected chat log ID.
- On Chat Log Messages filters add options to show no moderators or no users. 
- Corrected issue where messages per page setting was not being properly handled. 

= 2.0.7.5 =
- Corrected reported issue in JS which effected IE10 beng able to backspace in chat textarea.
- Corrected undefined varable PHP Notice.
- Initial testing for WordPress 3.9 and BuddyPress 2.0 betas

= 2.0.7.4 =
- Added Chat status button shown on BuddyPress user profile header. 
- Added Chat User Enter/Exit status shown on all Chats. Can be controlled on new option on Users List settings tab. 
- Added Send button to chat box as it seems to be requested at least one a week. This will override default return action on message entry.


= 2.0.7.3 =
- Corrected reported issue with a new user chat settings not inheriting chat default settings. 

= 2.0.7.2 =
- Corrected reported issue when using backslash on date/time settings field.
- Corrected reported issue with Archive logs not properly handling bulk actions. 

= 2.0.7.1 = 
- Corrected reported issue where having a blank value in shortcode for moderator_roles or login_options causes PHP warnings.
- Corrected reported issue where non-initialized log_id instances were causing PHP warnings to be output. 
- Corrected reported issue where new nag admin notice was being shown on network admin even though plugin was not network activated. 
- Corrected issue with tinymce logic to not output empty parameters for unused arguments. 
- Corrected issue where showing Name and Avatar for chat messages the moderator and user name colors were not being set properly.
- Remove Network > Dashboard > Authentication tab as this is superfilous in that only Network Admins can access the Network Dashboard. No need to control user access level. 

= 2.0.7 = 
- Corrected reported issue when network activating plugin causing WordPress to report unexpected characters output.
- Corrected color on WP toolbar to inherit WP 3.8 Admin Color Scheme selection per User profile.
- Corrected issue on Message Appearance panel where color options for user and moderator names was not being displayed when loading the screen.
- Corrected issue with BuddyPress Members/Friends online status not properly being reported.
- Testing for BuddyPress 1.9.1
- Added Dashboard Group Chat Widget. Now chat with others directly from the Dashboard. Works on Site and Network Dashboard widget area. Can be hidden by WordPress user role. Users can also hide this from display via their profile. 
- Added Dashboard Chat Status Widget. Lets WordPress users control thier Chat status. Works on Site and Network Dashboard widget area. Can be hidden by WordPress user role. Users can also hide this from display via their profile. 
- Added Dashboard Chat Friends Widget. Lets WordPress users see their friends online status. Works on Site and Network Dashboard widget area. Can be hidden by WordPress user role. Users can also hide this from display via their profile.  Requires WPMUDEV Friends plugin or BuddyPress Friends option enabled. Can initiate private chat with online and available friends via widget.
- Added chat Status Widget for front-end. Lets WordPress users control thier Chat status.
- Added new Friends widget. Shows friends online. Works with either WPMUDEV Friends plugin or BuddyPress Friends option enabled. Can initiate private chat with online and available friends via widget. 
- Added admin notice nag panel to have the admin review the Chat settings specifically the poll intervals. Admin notice nag will be hidden once the chat settings are re-saved.
- Private chats can now be used across sites within the same Multiite system. So userA on site2 can now initiate a private chat with friend userB who is logged into site99. Previously users had to be logged in and viewing the same site. 
- Updated logic for Private chats windows to automatically close private chat windows across all browsers windows connected to site. 
- Rewrote Chat Session Users List display logic to be more efficient. 
- Chat Session Users List now excluding the current user from the display output. Showing only other users participating in chat session. 
- On Private chat added logic to display message when a user enters/exits/declines chat request. 
- Added 'user_type' column to chat messages and users tables. This is for future use where we can filter the chat conversations by different user login methods.

= 2.0.6.4 = 
- Corrected reported issues on Network settings where PHP warnings were being output. 
- Reworked Active users Insert/Update SQL to not update unneeded fields. 

= 2.0.6.3 = 
- Change support for WPMU DEV Dashboard notices
- Update for conflict reported with BuddyPress/BP Profile as Homepage Fork plugin. The plugin calls the redirect earlier than chat. This was causing the chat popout function not to operate correctly. Resolved by calling the popout logic via an earlier action.
- Updated logic when using the 'Plugin AJAX' polling option. Now using a local encoded config file instead of passing path via _POST request. Also added fallback option to using default admin ajax hook.
- Added better output on Chat Sessions logs Users ouput. For session still open, output now showing active moderators/users distinguished from inactive moderators/users. 
- Testing for WP 3.8

= 2.0.6.2 = 
- Changed out split() use to explode() for PHP 5 compatability. 
- Corrected issue where private chat box was loading without needed CSS from server in some cases.
- Added logic to remove CSS from page when private chat is exited.

= 2.0.6.1 =
- Corrected issue where on some new installs the upgrade database process was failing. Thus causing the upgrade database logic to run on every AJAX call. 
- Corrected issue where the plugin function load_configs() was potentially being called more than once. 
- Corrected issue for potential warning during check of wp_roles. 
- Removed DROP column SQL on update plugin logic as this was causing issues for some sites where the WordPress database user does not have authority from DROP columns. 

= 2.0.6 =
- Updated chat moderator action labels. Changed to hide/unhide from delete/undelete on message row.
- Added new menu option within Dashboard for Chat > Session Logs which shows all open and archived chat sessions. Clicking on a log entry will show individual messages. Admin has the ability to hide/unhide/delete entire chat logs or individual messages. When a log or message is hidden it will not show in the front-end log display output. Also, admin can view/participate in an open chat session within the log view section. 
- Updated use of inline CSS to load in the head of the HTML document for W3C compliance. 
- Updated fields to chat_log database table: box_title, deleted, archived for new Session Logs output.
- Reworked chat log logic to start log entry during first message. Previous method create log entry only when the chat session was archived. 
- Reworked Private chat logic. Instead of creating a new session for each request prior session between two users are resumed. 
- Add new log display options on individual chat session setup. Previous option was to show listing of logs below active chat session. Can now show simple link above/below chat session. When clicked will reload page to show chat logs listing. User can then click a log entry to show message or return to active chat session.
- Added logic to stop polling chat box on popup session. In previous version both the main session and the popout session polled the server. More efficient to have only the popup. When popout is closed the main session will update with any new messages. 
- Added logic to BuddyPress Members listing to display status for all user, not just user's Friends, if the viewing user is site admin.
- Added logic to BuddyPress Group Chat to show chat session archive logs. 
- Added neew option under Mesage Input tab to lock the size of the textarea input to prevent user resizing.
- (Beta) Added Network Bottom Corner Chat. When enabled replaces the individual site bottom corner chat session and all messages are global. So as a user moves from siteA to siteB the message are carried across sites. 
- (Beta) Added Network Session Logs to show all global chat sessions and message.
- Fixed bug in BuddyPress Profile > Settings > Chat. Was previously showing setting for logged in user not the user whose profile was being viewed. 
- Fixed issue in BuddyPress when Chat > Settings Common > Blocked URLs > Front URLS to NO was not loading needed JS/CSS on front-end Groups Admin Chat panels. 
 - Fixed issue where some themes are adding a CSS rule to force all image to display block. Setup override CSS for images within chat messages (emoticons) to display inline, no margins or padding and no border. 

= 2.0.5.1 = 
- Corrected issue with Chat Widget where settings being set/unset where not being properly used by the widget code or inherited from the global options. 
- Corrected issue where date/time format setting was not being applied to message output. Was instead using default WP Settings format.
- Changed name on Widget to 'WordPress Chat'.
- Corrected PHP Strict Redefining already defined constructor for class error by moving old-style PHP4 class constructor function below PHP5 __construct() function.


= 2.0.5 =
- Corrected reported issue with font-size not remaining fixed when viewing the pop-out chat. 
- Corrected reported issue when using BuddyPress 1.7.x Groups admin.


= 2.0.4.9 =
- Corrected reported JavaScript issue which were preventing Chrome from loading chat via AJAX
- Corrected reported JavaScript issue which prevented chat from functioning when minifying JS via common cache plugins. Thanks @godrob

= 2.0.4.8 =
- Corrected reported issue where legacy shortcode login option 'current_user' not working.
- Updates No Auth View form element from radio buttons to select for less space. 
- Added new option for No Auth View. New option, No Login. Allows users to view chat messages and users but not login or participate in chat. 
- Removed some debug console.log output shown in wpmudev-chat.js
 
= 2.0.4.7 =
- Correct reported issue on Avatar/Name/None option where was not retaining the none setting
- Corrected reported issue warnings showing on the Chat TinyMCE popup. 

= 2.0.4.6 = 
- Correct typo in form description. 

= 2.0.4.5 =
- Corrected issue where Chat Settings panel not properly displayed for BuddyPress 1.8 group admin within Dashboard
- Corrected issue for IE9 on the public user login form where placeholder text is not supported. 
- Corrected issue for IE9 on using the popout chat feature. Force IE9 Standards mode only.
- Corrected Chat Widget code to not show widget title when widget is hidden from non-authenticated users. 
- Added Polling timers and settings option for Chat Invites and Chat Meta information to prevent excessive queries during each message polling interval.
- Rewrote JS/AJAX message send logic to create send queuing system to ensure eventual message delivery to server. Should help with fast typists.
- Dropped dependency on external jQuery cookie library. 
- Changes login options to allow support for individual WordPress user roles. 
- Added logic to Users list to control height of box. 
- Added display options for Users List for moderator and user list output. Split or combined lists. 
- Added logic to control what level of users can view Chat archive logs show below the session. 
- Added options to clean up the chat archives listing. Ability to hide main chat. Change label. Limit listing entries. Return to normal chat session.
- Added option to show user avatar and name on message output. 
- Added option to hide popout chat on individual chat sessions.
- Added option to hide moderator message options (block IP, Delete, private chat) on individual chat sessions.
- Added count for new messages on minimized bottom corner chat. 
- Added option to stop polling for new messages when minimized bottom corner chat. 

= 2.0.4.4 =
- Fixed reported issue where chat_id was set yo zero or null. 
- Fixed reported issue where pop-out chat on Pages/Widgets was including private chat sessions.
- Added CSS/JS to help control chat avatar to override some themes which set content images too large.
- Added CSS/JS to help control images added on list items to prevent showing within the chat session

= 2.0.4.3 =
- Fixed reported issues with BuddyPress 1.8 Groups and Groups Admin sections
- Fixed reported issues where setting non-auth view was not showing proper display
- Fixed reported issues where Friend/Member private chat buttons were not working correctly in BuddyPress various pages
- Fixed display issue on minimized chat that was showing the chat maximized on initial page load briefly before forcing minimized via JS.

= 2.0.4.2 =
- Fixed issue with position of private chat box when bottom corner chat not enabled. Missing CSS for positioned chat elements
- Fixed issue with Group Chat under BuddyPress 1.8
- Removed footer debug output. 

= 2.0.4.1 =
- Added Chat options to BuddyPress profile settings to control chat status, and visibility.
- Fixed issue where user can hack cookie and promote self to moderator user list. But not actual moderator functionality.
- Fixed issue where user avatar for user list and message were not matched. 
- Fixed issue where deleting single message row forced cleared the chat session instead of hiding row. 
- Fixed issue where selecting NO for Load JS/CSS effected chat admin screens layouts.
- Cleanup some of the INSERT queries which were reporting error on some member sites because the database columns didn't have assigned default values. 



= 2.0.4 =
- Fixed issue with transient keys length causing BuddyPress Group chat not to load properly. 
- Fixed issue in Bottom Corner chat were non-authenticated users were still able to post to a closed session.
- Fixed issue where proper settings tab not being set active when link to with hash.
- Fixed issue where WP toolbar Chat menu was not being hidden on admin URLs when configured not to show.
- Fixed issue where chat session sound is disabled was still producing ping sound on new messages.
- Removed some debug statements from JavaScript.
- Added Settings Widget option to hide on URLs where shortcode is used. 
- Added Settings Widget option to include/exclude widget chats on specified URLs.
- Added Settings Site option to hide on URLs where shortcode is used. 
- Added Settings Site option to include/exclude bottom corner chats on specified URLs.
- Added Settings Global option to prevent load of JS/CSS where chats are not displayed. By default JS/CSS are loaded on ALL URLs.
- Added Settings Global option to using WordPress AJAX instead of plugin AJAX. Calling the plugin AJAX file is prevented in some server configurations. 


= 2.0.3 =
- Updated JS/CSS enqueue logic to only load JS/CSS where essentially needed. 
- Update AJAX processing to handle be more efficient and not send settings data as POST information
- Fixed PHP Notices shown when Chat TinyMCE Post types and/or WP Roles were empty
- Fixed issue where Chat tTinyMCE button was effecting other TinyMCE buttons from functioning like link popup
- Added retry logic to AJAX init and message_update process. For better handling of server errors. 
- Corrected issue with language files not loading correctly on AJAX requests. 
- Corrected issue on non-Multisite where blog_id was being set to zero instead of one.
- Rewrite of message filtering logic to provide better support for cyrillic and other language formats. Also provides better processing for inline code blocks.
- Correct formatting of SQL used for dbDelta which caused PHP Notices related to duplicate keys
- Updates language files. 
- Added WP toolbar color support for MP6 Admin plugin

= 2.0.2 =
- Updated to user Twitter API version 1.1 since 1.0 expired on June 12, 2012
- Fixed issue for allowing local user avatars. 
- Fixed issue on Multisite where promoted super admins were not seeing chat button on post type button bar.
- Fixed issue with database check logic not properly setting current version on activation for Multisite. 
- Fixed issue in Site options exclude URL comparison. 
- Fixed issue where language files were not being loaded properly on the polling loop. 
- Added new Settings Common > WP Admin panel to control not showing chat on certain pages within WP Admin.
- Added new Settings Common > BuddyPress panel to control BP Group page slug and menu label values
- Replace JavaScript Audio library to be more flexible. 
- Added lazy loading of jQuery.cookie and buzz sound in case loaded from other plugins. 

= 2.0.1 =
- Corrected database update/migration errors and warnings.
- Corrected warnings and notices when using WP_DEBUG on
- Re-added filter to allow language input into messages. This was added into 1.3.x but the code was not added to the 2.0 code base.

= 2.0 =
- Rewrite of core messaging function to improve overall performance.
- Added support for Google+ user authentication.
- Added integration for BuddyPress group and friends.
- Added integration with WPMU DEV Friends plugin.
- Redesign of chat UI.
- Added support for user lists for each chat session.
- Better support for Widgets.
- Support for Private one-to-one chats initiated by moderators
- Support for one-to-one chat between WP users.
- More settings to control the look, feel and colors of the chat windows
- Added ability to ban user by email address
- Added ability to block words. 
- Added ability to control position of bottom corner and private chat to top/bottom/left/right
- Added popout/popin ability on all chat windows to break out of the theme frame. Full screen on tablets and smart phones.

= 1.3.0.2 =
- Corrected issue where bottom corner chat was not resuming polling after being closed then opened.
- Removed some debug output from message replies.

= 1.3.0.2 =
- Corrected some undefined variables which throw Notices when full error reporting is enabled.

= 1.3.0.1 =
- Corrected some undefined variables in the widget.

= 1.3.0 =
- Added Advanced option to limit of TinyMCE button to selected post types.
- Added Advanced option to limit of TinyMCE button to selected user roles.
- Rewrote code messaging logic to limit polling. This should clear up many user reports or chat crashing servers. 

= 1.2.0 =

* Corrected logic when using Facebook authentication only for bottom corner chat and not for inline chat. Which was causing endless refresh of page http://premium.wpmudev.org/forums/topic/wordpress-chat-endlessly-refreshes-for-facebook
* Renamed global plugin instance from $chat to $wpmudev_chat. https://app.asana.com/0/589152284006/1796940364279
* Added Chat Widget with some of the options. http://premium.wpmudev.org/forums/topic/chat-box-as-a-widget-instead-of-floating
* Added support for moderator to delete/undelete messages http://premium.wpmudev.org/forums/topic/moderate-chat-ban-users-delete-messages
* Added support to close/open chat session. Similar to WPMU DEV. Thanks Enzo. 
* Corrected emoticons. Had two not properly displaying. 
* Corrected issue where depending on the WordPress setup the trailing slash is removed from the base URL. Causing sound manager to not load. http://premium.wpmudev.org/forums/topic/soundmanager2swf-404-chat-plugin
* Added some color options for Row area background, Row item background, Row item border width, Row item border color. http://premium.wpmudev.org/forums/topic/moderate-chat-ban-users-delete-messages
* Switched plugin to use new WPMU DEV Dashboard plugin updates


= 1.1.0 =

* Recode Facebook authentication for OAuth 2.0 and PHP-SDK

= 1.0.9.1 =

* Twitter instructions updated

= 1.0.9 =

* Fixed: Archive and clear capabilties conflict

= 1.0.8 =

* Fixed: TwentyEleven header image covering chat window
* Fixed: In IE message text box loses focus

= 1.0.7 =

* Fixed: Wrong path for soundmanager2.swf
* Fixed: Scrolling issue
* Stop autoscrolling if the user scrolls to a particular position
* Fixed: Bottom corner chat size changes
* Highlight chat box in a different color when there is a new message
* Fixed: Prevent line breaks when enter key is pressed
* Fixed: Code tags instructions
* Fixed: Chat message encoding issue
* Do not include swf if sound is disabled
* Function split() is deprecated

= 1.0.6 =

* Fixed: Missing styles

= 1.0.5 =

* Improve host compatibility with login with Facebook
* Balance code tags
* Allow multiple links to be in the chat message

= 1.0.4 =

* Remove chat js if no chat is in the page
* Fixed: upgrade race

= 1.0.3 =

* Fixed: Multiple messages posted
* Added Moderators
* Notify user when offline

= 1.0.2 =

* Tested with WordPress 3.1
* Added Auto Update plugin installation check
* Fixed: mod_security issue
* Fixed: FB & Twitter button alignment
* Fixed: Setting height and width of a in post chat
* Fixed: Configure refresh interval

= 1.0.1 =

* Fixed: Parse error: syntax error, unexpected T_STATIC, expecting T_OLD_FUNCTION or T_FUNCTION or T_VAR or '}'
* Fixed: Issue in displaying non ASCII characters (Ü,Ö,Ä,ü,ö,ä,...)
* Fixed: Not sufficient permissions to modify Chat plugin settings
* Fixed: Slashes in message and author name
* Fixed: Sound issues
* Fixed: IE 7 javascript errors
* Fixed: Timezone issue
* Fixed: Unicode characters issue
* Allow users with only edit_posts or edit_pages (not both) to add to posts
* Fixed: IE 8 javascript errors in wp-admin
* Allow admin to control the chat text color

= 1.0.0 =

* Initial release


403900-1511248464-ai