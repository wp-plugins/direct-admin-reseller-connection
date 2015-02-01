=== Plugin Name ===
Contributors: vlijmen
Tags: directadmin, reseller, webhosting, widget, settings, dutch, english, dashboard, stats, email, forwarders, mailbox, pop, user
Requires at least: 3.5.0
Tested up to: 4.1.0
Stable tag: 0.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Direct Admin Reseller Connection let's your users manage their Direct Admin account with their Wordpress website profile and login.

== Description ==

Direct Admin Reseller Connection let's your users manage their Direct Admin account with their Wordpress website profile and login. At this moment you can show them their stats in a widget (if logged in and DA account in their profile) and/or your own reseller stats in a Dashboard Widget. Users can also manage all their email address settings and domainpointers from a desired page by adding a shortcode. Updates coming soon!

I'm doing my best to make it safe, but using it is at your own risk ofcourse!

* Widget with user statics
* Dashboard widget for Reseller stats
* Settings page
* Users field for DA connection
* English and Dutch
* Let users manage their forwarders and mailboxes. [darc-nh-page-mail]
* Let users manage their domainpointers. [darc-nh-page-domain]
* Show available webhosting packages. [darc-nh-page-packages]

Coming soon:

* Extended package shortcode settings

== Installation ==

1. Upload the files `direct-admin-reseller-connection` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the settings page, fill in the details
4. Place the widget in a sidebar
5. Added [darc-nh-page-mail] to the desired page where users can manage all their email address settings.
6. Added [darc-nh-page-domain] to the desired page where users can manage their domainpointers.
6. Added [darc-nh-page-packages] to the desired page where users can see the webhosting you're offering.

== Frequently Asked Questions ==

- Questions? Let me know!
- Made a translation? Send it to me!
- Shortcode settings [darc-nh-page-packages pack=Small-Medium price=1,00-2,50]

== Screenshots ==

1. Widget in action (only for logged in users with DA field not empty)
2. User field (only for admin users)
3. Dashboard Reseller widget
4. Settings page
5. Mail settings page for users
6. Error messages when checking changes

== Changelog ==

= 0.2.1 =
* Bug fix with calculating 'unlimited' value
* Translation updated for package page

= 0.2.0 =
* Added available webhosting shortcode with first setting options.
* Updated shortcode integration for better posts/pages placement.
* Updated conversion, 1000Mb = 1Gb like most of the time used by webhosts.

= 0.1.2 =
* Bug fix on mailaccount management page
* Use "localhost" instead of "http://localhost" message!
* Disabled mail to notify me on install (privacy update)

= 0.1.1 =
* Added user page for managing their domainpointers.
* Show loginform to users that are not logged in and try to visit a manage page.

= 0.1.0 =
* Added user page for managing their email addresses, mailboxes and forwarders.

= 0.0.2 =
* Added widgets for users and dashboard
* Dutch translation

= 0.0.1 =
* First version only connection and settings
