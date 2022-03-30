=== GDPR Cookie Compliance ===
Contributors: MooveAgency
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LCYMMR4EQ2YVW
Stable tag: trunk
Tags: gdpr, compliance, cookie, consent, notice
Requires at least: 4.5
Tested up to: 5.1
Requires PHP: 5.6 or higher
License: GPLv2

== Description ==

GDPR Cookie Compliance plugin has settings that can assist you with cookie compliance and consent notice requirements on your website.

### Key features

* Give your users full control over cookies stored on their computer, including the ability for users to revoke their consent
* Simple, beautiful & intuitive user interface
* Choose from two unique layouts
* Fully customisable - upload your own logo, colours, fonts
* Fully editable - you can change all text
* Set the position of the Cookie Banner: at the top or bottom of your pages 
* Flexible - decide which scripts will be loaded by default or only when the user gives consent
* SEO friendly
* WPML, qTranslate, WP Multilang and Polylang compatible, .pot file for translations included
* Includes link to Privacy Policy page
* CDN Base URL supported
* Sleek animations to enhance user experience
* Easy to use JavaScript interface


### Premium features available

* **Full-screen layout** - If it's enabled, the Cookie Banner will be display in full screen mode, and force the user to either accept the cookies, or to change / overview the settings.
* **Export & import settings**
* **WordPress Multisite extension** - You can manage GDPR settings globally, and clone them from one site to another
* **Accept on Scroll** - Allow users to accept cookies by scrolling down the page
* **Analytics** - Stats and charts showing you how many users accepted your cookies (all anonymous)
* **Geo-location** - If enabled, Cookie Banner will be displayed for EU visitors only 
* **Shortcodes** that can be added to your ‘Privacy & Cookie Policy’ and allow users to manage their consent with ease
* **Hide Cookie Banner** allows you to hide the Cookie Notice Banner on selected pages
* **iFrame Blocker** that allows you to block users from viewing 3rd party resources (such as video) until they accept cookies

[Buy GDPR Premium Add-on here](https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/)


### Demo Video

You can view a demo of the plugin here: 

[vimeo https://vimeo.com/255655268]


### Live Examples

* You can choose to setup our GDPR plugin in any way that you like. 
* We have created the plugin with as much flexibility as possible as organisations interpret the Cookie Consent Policy differently.
* A few examples of how you can setup our plugin in various ways are below:

**OPTION A** 
No cookies are stored on users' computers (not even the Cookie that is required to power our own plugin = we call it Strictly Necessary Cookies) until the user accepts Cookies. 
[Example 1](https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/)

**OPTION B**  
You can setup our plugin so that Cookies are accepted by default but the user has the option to turn them off. 
[Example 2](https://www.teneo.net/uk/)
[Example 3](https://www.nacro.org.uk/)

**OPTION C**  
You can display the Cookie Consent Banner at the top of the page.
You can also setup the plugin so that cookies are accepted once user scrolls down the page.
[Example 4](https://www.mrisoftware.com/uk/)

There are many other variations organisations choose to set the plugin up, our plugin is very flexible.

### Custom Layout

* You can also create your own custom front-end layout of the Cookie Settings Screen.
* Simply copy the "gdpr-modules" folder from the plugin directory to your theme directory. 
* If you do this, your changes will be retained even if you update the plugin in future. 
* Any customisation should be implemented by experienced developers only.


### Personalised installation & setup 
* Contact us if you'd like a personalised advice, installation or support for bespoke customisations on plugins@mooveagency.com (please note that this is a paid service).
* For general support, please use the [Support Forum](https://wordpress.org/support/plugin/gdpr-cookie-compliance/).

#### Disclaimer

* THIS PLUGIN DOES NOT MAKE YOUR WEBSITE COMPLIANT. YOU ARE RESPONSIBLE FOR ENSURING THAT ALL GDPR REQUIREMENTS ARE MET ON YOUR WEBSITE.


== Frequently Asked Questions ==

= What is GDPR? = 
General Data Protection Regulation (GDPR) is a European regulation to strengthen and unify the data protection of EU citizens. ([https://www.eugdpr.org/](https://www.eugdpr.org/))

= How do I setup your plugin? =
* You can setup the plugin in the WordPress CMS main menu (on the left-hand side) -> GDPR Cookie Compliance. 

= How can I link to the Cookie Settings Screen? =
You can use the following link to display the Cookie Settings Screen window:

[Relative Path - RECOMMENDED]
/#gdpr_cookie_modal

[Absolute Path]
https://www.example.com/#gdpr_cookie_modal
https://www.example.com/your-internal-page/#gdpr_cookie_modal


= Pasted code is not visible when view-source page is viewed. =
* Our plugin loads the script with Javascript, and that’s why you can’t find it in the view-source page. 
* You can use the developer console in Chrome browser (Inspect Element feature) and find the scripts.

= Can I use custom code or hooks with your plugin? =
* Yes. We have implemented hooks that allow you to implement custom scripts. 
* You can also find list of all pre-defined hooks here: https://wordpress.org/support/topic/conditional-php-script/

= Does the plugin support subdomains? =
* Unfortunately not, subdomains are treated as separate domains by browsers and the plugin is unable to alter cookies stored by another domain. 
* If your multisite setup uses subdomain version, each subsite will be recognised as a separate domain by browsers and will create separate cookies for each subdomain.

= Does this plugin block all cookies? =
No. This plugin only restricts cookies for scripts that you have setup in the Settings. If you want to block all cookies, you have to add all scripts that use cookies into the Settings of this plugin. 

= Once I add scripts to this plugin, should I delete them from the website’s code? =
Yes. Once you setup the plugin, you should delete the scripts you uploaded to the plugin from your website’s code to ensure that your scripts are not loaded twice.

= Does this plugin stop all cookies from being stored? =
This plugin is just a template and needs to be setup by a developer in order to work properly. Once setup fully, it will prevent scripts that store cookies from being loaded on users computers until consent is given.
 
= Does this plugin guarantee that I will comply with GDPR law?=
This plugin is just a template and needs to be setup by a developer in order to work properly. 
THIS PLUGIN DOES NOT MAKE YOUR WEBSITE COMPLIANT. YOU ARE RESPONSIBLE FOR ENSURING THAT ALL GDPR REQUIREMENTS ARE MET ON YOUR WEBSITE.

== Installation ==

1. Upload the plugin files to the plugins directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin on the \'Plugins\' screen in WordPress.
3. You can adjust all settings in the "GDPR Cookie Compliance" main menu link.
4. You can link directly to the Cookie Settings Screen on your website using the following: /#gdpr_cookie_modal
5. WPML, WP Multilang is supported: once you switch the language in your CMS, you can translate all text
6. You can find list of all pre-defined hooks here: https://wordpress.org/support/topic/conditional-php-script/
7. You can buy the [Premium Add-on with additional features here](https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/)


== Screenshots ==

1. GDPR Cookie Compliance - Front-end - Privacy Overview
2. GDPR Cookie Compliance - Front-end - Strictly Necessary Cookies
3. GDPR Cookie Compliance - Front-end - 3rd Party Cookies
4. GDPR Cookie Compliance - Front-end - Additional Cookies
5. GDPR Cookie Compliance - Front-end - Cookie Policy
6. GDPR Cookie Compliance - Front-end - One Page Layout
7. GDPR Cookie Compliance - Front-end - Cookie Banner
8. GDPR Cookie Compliance - Front-end - Full-Screen Mode [Premium]
9. GDPR Cookie Compliance - Admin - Branding
10. GDPR Cookie Compliance - Admin - Banner Settings
11. GDPR Cookie Compliance - Admin - Floating Button
12. GDPR Cookie Compliance - Admin - General Settings
13. GDPR Cookie Compliance - Admin - Privacy Overview
14. GDPR Cookie Compliance - Admin - Strictly Necessary Cookies
15. GDPR Cookie Compliance - Admin - 3rd Party Cookies
16. GDPR Cookie Compliance - Admin - Additional Cookies
17. GDPR Cookie Compliance - Admin - Cookie Policy
18. GDPR Cookie Compliance - Admin - Help - FAQ
19. GDPR Cookie Compliance - Admin - Help - Hooks & Filters
20. GDPR Cookie Compliance - Admin - Help - Premium Hooks [Premium] 
21. GDPR Cookie Compliance - Admin - Help - Premium Shortcodes [Premium]
22. GDPR Cookie Compliance - Admin - Export/Import Settings [Premium]
23. GDPR Cookie Compliance - Admin - Multisite Settings [Premium] 
24. GDPR Cookie Compliance - Admin - Accept Cookies on Scroll [Premium] 
25. GDPR Cookie Compliance - Admin - Full-Screen Mode Settings [Premium]
26. GDPR Cookie Compliance - Admin - Analytics [Premium]
27. GDPR Cookie Compliance - Admin - Analytics with Stats [Premium]
28. GDPR Cookie Compliance - Admin - Geo Location [Premium]
29. GDPR Cookie Compliance - Admin - Hide Cookie Banner on Selected Posts / Pages [Premium]
30. GDPR Cookie Compliance - Admin - Iframe Blocker / Pages [Premium]

== Changelog ==
= 2.0.7 =
* Accessibility issues fixed

= 2.0.6 =
* JavaScript functions improved
* Bugfixes

= 2.0.5 =
* GDPR settings position updated

= 2.0.4 =
* Extended plugin listing with stars
* Bugfixes

= 2.0.3 =
* Color picker conflict fixed

= 2.0.2 =
* Fixed PHP notices

= 2.0.1 =
* Added support to WP Multilang plugin

= 2.0.0 =
* Significant improvements to the plugin settings and content upload workflow
* Added CodeMirror library for easier Javascript editing
* Added Help section to the settings that lists useful shortcodes and hooks

= 1.4.1 =
* Fixed show cookie banner function

= 1.4.0 =
* Added CDN Base URL support to load Lity from CDN
* Support added to use the Privacy page from Options 
* Removed save cookie function from popup close action

= 1.3.4 =
* Bugfixes
* Updated plugin premium box

= 1.3.3 =
* Updated plugin premium box

= 1.3.2 =
* Fixed text domain loading

= 1.3.1 =
* Updated plugin premium box

= 1.3.0 =
* PHP Cookie checker implemented
* PHP function to check Strictly Necessary Cookies: "gdpr_cookie_is_accepted( 'strict' )"
* PHP function to check 3rd Party Cookies: "gdpr_cookie_is_accepted( 'thirdparty' )"
* PHP function to check Advanced Cookies: "gdpr_cookie_is_accepted( 'advanced' )"
* Force reload hook added "add_action( 'gdpr_force_reload', '__return_true' )"
* Fixed layout issues in old Safari

= 1.2.6 =
* Added hook to force reload page on accept

= 1.2.5 =
* Javascript code improvements
* Bugfixes

= 1.2.4 =
* Javascript console warning removed


= 1.2.3 =
* Bugfixes

= 1.2.2 =
* IE11 floating issue fixed

= 1.2.1 =
* Improved admin-ajax.php loading by transient
* Fixed checkbox labels by WCAG 2.0
* Added 'gdpr-infobar-visible' class to the body if the Cookie Banner is visible

= 1.2.0 =
* Fixed modules view

= 1.1.9. =
* Fixed default logo 404 issue
* Fixed floating button positioning
* Modal close & floating button conflict resolved
* Duplicate script injection fixed
* Child theme support added to modules view

= 1.1.8. =
* Improved admin screen with premium, donate, support boxes.
* Fixed missing logo issue
* Undefined variable issue fixed
* Bugfixes

= 1.1.7. =
* Fixed "Third party tab" turn off option

= 1.1.6. =
* Fixed closing comment issue
* Fixed missing stylesheet bug

= 1.1.5. =
* Created 'gdpr-modules' folder, including html sections (this could be added to the main theme folder and is customisable)
* Removed !important tags
* Removed font loaded by css if a custom font is selected
* Translations added: Romanian, German, French
* Translation slug updated, allowing users to upload translations to WordPress.org repository

= 1.1.4. =
* Fixed floating button conflict
* Force reload removed on cookie acceptance
* Console warnings fixed

= 1.1.3. =
* Significant improvement to the plugin settings and content upload workflow
* Cookie bar features were extended
* Improved cookie removal function
* Bugfixes


= 1.1.2. =
* Fixed php EOL errors
* Fixed visual glitches
* Scripts injected to the first page if the checkboxes are always turned on
* Improved cookie removal function
* Added alt tag to logo
* Setting field created to replace font
* One page layout improvements
* Added option to enable cookies by default
* Ability to display change the position of the Cookie Banner (bottom or top)
* Added donation box

= 1.1.1. =
* Fixed missing ttf font files
* Fixed checkbox visibility
* Added forceGet to location.reload
* Accessibility improvements
* Popup open / close improvements

= 1.1.0. =
* Lightbox loaded from local server
* Google fonts loaded from local, @import removed
* Improved functions to remove cookies
* Bugfixes

= 1.0.9. =
* Added One Page layout
* Extended strictly necessary cookies functionality
* the_content conflicts resolved
* Bugfixes

= 1.0.8. =
* Admin colour picker fixed

= 1.0.7. =
* Third party script jump fixed
* Added new warning message if the strictly necessary cookies are not enabled but the user tried to enable other cookies
* Updated admin colour picker
* Qtranslate X support
* Bugfixes

= 1.0.6. =
* Fixed Lity conflict
* Added "postscribe" library

= 1.0.5. =
* Fixed php method declarations and access
* Bugfixes

= 1.0.4. =
* Moved modal content to wp_footer

= 1.0.3. =
* Extended scripts sections with fields to add "<head>" and to "<body>"
* Editable label for "Powered by" text
* Added radio buttons to change the logo position (left, centre, right)
* Colour pickers added to customise the floating button
* Fixed Cookie Banner WYSIWYG editor, links are allowed

= 1.0.2. =
* Fixed .pot file.
* Added WPML support.
* Fixed Strictly Necessary tab content.
* Fixed conflicts inside the WYSIWYG editor.

= 1.0.1. =
* Fixed button conflicts.
* Fixed validation for the scripts in tabs.

= 1.0.0. =
* Initial release of the plugin.
