=== WP Popups - WordPress Popup builder ===
Contributors: timersys
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4T6L69EV9G2Q
Tags:  wp popups,popups,wp popup,popup builder,popup maker,twitter,google+,facebook,Popups,twitter follow,facebook like,mailchimp,Activecampaign,Mailpoet,Postmatic,Infusionsoft,mailerlite,constant contact,aweber,google plus,social boost,social splash,postmatic,mailpoet,facebook popup,scroll popups,popups,wordpress popup,wp popups,cf7,gf,gravity forms,contact form 7,ifs,infusion soft,subscribe,login popup,ajax login popups,popupmaker
Requires at least: 3.6
Tested up to: 5.5
Stable tag: 2.0.3.6
Requires PHP: 5.4
Text Domain: wp-popups-lite
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Popups is the best popup maker for WordPress. Easy but powerful plugin with display filters, scroll triggered popups, compatible with social networks, Gravity Forms, Ninja Forms, Contact form 7, Mailpoet, Mailchimp for WP, Postmatic, etc

== Description ==

WP Popups is the best popup maker for WordPress. With the easy and intuitive template builder you will be able to create and customize your popup with just a few clicks. No coding skills needed!

Is the perfect solution to show important messages such as EU Cookie notice, increase your social followers, add call to actions, increase your mailing lists by adding a form like mailchimp or to display any other important message in a simple popup.

https://www.youtube.com/embed/_yJ-xHVOQYw

It's compatible with the major form plugins like :
* Wp Forms ( recommended )
* Gravity Forms
* Ninja Forms
* Contact form 7
* USP Forms
* Infusion Soft
* Jetpack
* Mailpoet
* Mailchimp for WP
* Postmatic
* Any generic form

There are multiple display filters that can be combined:

* Show popup on specific pages, templates, posts, etc
* Filter user from search engines
* Filter users that never commented
* Filter users that arrived via another page on your site
* Filter users via roles
* Show popup depending on referrer
* Show popup to logged / non logged users
* Show or not to mobile, desktop and tablet users
* Show or not to bots / crawlers like Google
* Show or not depending on query strings EG: utm_source=email
* Show depending on post type, post template, post name, post format, post status and post taxonomy
* Show depending on page template, if page is parent, page name, page type

= Available Settings =

* Choose from 5 different popup locations
* Trigger popup after X seconds , after scrolling % of page, after scrolling X pixels
* Auto hide the popup if the user scroll up
* Change font color, background, borders, etc
* You can also configure background opacity.
* Days until popup shows again
* Shortcodes for social networks available

> <strong>Premium Version</strong><br>
>
> Check the **new premium version** available in ([https://wppopups.com](https://wppopups.com?utm_source=readme%20file&utm_medium=readme%20links&utm_campaign=Popups%20Premium))
>
> * Beautiful optin forms for popular mail providers
> * Exit Intent technology
> * AJAX login popups
> * Popup scheduler
> * Popups Geolocation
> * Currently supporting MailChimp, Aweber, Postmatic, Mailpoet, Constant Contact, Newsletter plugin, Activecampaign, InfusionSoft, etc
> * New popup positions: top/bottoms bars , fullscreen mode, after post content
> * A/B testing. Explore which popup perform better for you
> * More Display Rules: Show after N(numbers) of pages viewed
> * More Display Rules: Show popup at certain time / day or date
> * More Display Rules: Show/hide if another popup already converted
> * Track impressions and Conversions of social networks and forms like CF7 or Gravity forms
> * Track impressions and Conversions in Google Analytics ande define custom events
> * Data sampling for heavy traffic sites
> * Background images
> * 40 New animations effects
> * More trigger methods
> * Timer for auto closing
> * Ability to disable close button
> * Ability to disable Advanced close methods like esc or clicking outside of the popup
> * Premium support
>

WP Popups template builder it's based on the famous [WPForms plugin](https://wordpress.org/plugins/wpforms-lite/), the best form plugin for WordPress!

== Installation ==

1. Unzip and Upload the directory 'wp-popups-lite' to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to Popups menu and add as many popups as needed

== Screenshots ==

1. Popups Front end with default settings
2. Popups Back end - visual editor
3. Popups Back end - display rules and options
4. Popups Back end - appearance

== Frequently Asked Questions ==

= How to open a popup by pressing a link or button ? =
You can use the popup trigger class to open popups by clicking on any element. Check this [tutorial](https://wppopups.com/docs/how-to-open-a-popup-with-a-button-or-any-html-element/)

= How can I change other styles of the popup like padding, rounded corners, etc ? =
Sure thing, change our [styling guide](https://wppopups.com/docs/how-to-change-popup-appearance/)

= If I have multiple Gravity forms on my page, form is not working =
On certain occasions multiple GF instances can cause problems. There is a plugin that fixes that https://wordpress.org/plugins/gravity-forms-multiple-form-instances/


= Can I attach my custom js events to popups plugin? =
Yes you can attach to any of this events . id = Popup id
`jQuery(document).on('wppopups.popup_opened',function(e,id){ ... });
 jQuery(document).on('wppopups.popup_closed',function(e,id){ ... });
 jQuery(document).on('wppopups.popup_converted',function(e,id){ ... });`
 jQuery(document).on('wppopups.form_submitted',function(e,id){ ... });`

== Changelog ==
= 2.0.3.6 = Aug 27, 2020
* Fix for popup not closing when overlay is clicked (not included on previous)
* Fix for clicked popup triggering error

= 2.0.3.5 = Aug 24, 2020
* Fix for popup not closing when overlay is clicked

= 2.0.3.4 = Aug 21, 2020
* Triggered by class/click popups NOT LONGER IGNORE COOKIES, now they need to be set to 0
* Fixed close button moving page to top

= 2.0.3.3 = July 30, 2020
* Fix on manually trigger popups when class is on parent element
* Added Buddypress Rules
* Fix error with close button on certain themes
* Cookies set to 0 days by default
* Fix issue with browser match rule

= 2.0.3.2 = Jul 7, 2020
* Fixed Conversion with external url forms
* Added yikes mailchimp form support
* Added BP template tags

= 2.0.3 = April 20, 2020
* Core update for extensions
* Update FR language files

= 2.0.2.1 = April 20, 2020
* Builder works better in mobile devices
* Added font family and size to content editor
* Removed Welcome email in Mailchimp as was deprecated by provider

= 2.0.2 = April 8, 2020
* Now addons can be purchased for free version
* Added responsive image attributes
* Fixed gravity forms conversion with redirections

= 2.0.1.4 = March 2, 2020
* Added missing crawlerdetect library to lite
* Added IE 11 compatibility

= 2.0.1.3 = Feb 19, 2020
* Hotfix for bug introduced in previous version

= 2.0.1.2 = Feb 19, 2020
* Performance: Increased overall performance, all popups are not loaded into DOM anymore more and increased speed of ajax

= 2.0.1.1 = Feb 7, 2020
* Fix: compatibility issue with WP less than 5
* Fix: Gravity forms conversion with redirects

= 2.0.1 = Jan 28, 2020
* Feature: new blurry background
* Fix: Move styles blocks to head
* Fix: Error on certain pages where using != post type rules
* Dev: Added more filters for devs

= 2.0.0.9 =
* Fixed issue with popup preview
* Fixed alignment in rules

= 2.0.0.8 =
* Fixed issue with centering and slide animation
* Added option to remove overlay
* Fixed issue with width in mobile

= 2.0.0.7 =
* Fixed issue with centered popups

= 2.0.0.6 =
* Added auto hide for scroll popups
* Multiple popups at the same time
* WPML and Polylang support

= 2.0.0.5 =
* Fixed importer giving errors with mb_encoding_string function
* Fixed popup height on safari iphone with url bar
* Fixed custom css not displaying some rules

= 2.0.0.4 =
* Compatibility with WordPress 4.x

= 2.0.0.3 =
* Fixed test mode
* Fixed top/bottom bars style issues
* Added SE_sv language
* Fixed importer error with utf8 strings

= 2.0.0.2 =
* Added publish / save buttons
* Fixed issue with HTML dissapearing from popup
* Optin success message replace original content now instead of being appended

= 2.0.0.1 =
* Fixed some issues with importer
* Fixed some events not firing for close

= 2.0.0 =
* Popups changed into WP Popups, totally new version released