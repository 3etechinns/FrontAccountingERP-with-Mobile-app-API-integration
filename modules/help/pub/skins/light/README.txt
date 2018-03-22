CIS-Dept. Light Skin for PmWiki 2
=================================
README.txt

About the skin
--------------
This is another clean, minimalist skin for PmWiki 2 that was created with
usability in mind.  It's similar to Lean Skin for PmWiki 2, but this one
has the SideBar on the right, the title in the main content area, and a
few other changes.

There are advantages to having the SideBar on the right.  When content
is too wide, the SideBar gets pushed off of the screen rather than the
content, so there's less scrolling. Text-based browsers will display the
content above the SideBar menu (tested with Lynx and Eudora Web for
PalmOS).

The Title at the top of the content area is an <h1> header. It's intended
to encourage WikiUsers to create wiki pages that are well-structured web
documents.

Design objectives
-----------------
* Be understated without being stripped bare.  Emphasize the content.
* Treat screen pixels as valuable and scrolling as inconvenient.
* Avoid displaying nonessential duplicate links.
* Avoid linking from a page to itself (self-referencing links).
* Give navigation links conspicuous placement in the layout.
* Be easy to use for both inexperienced and seasoned veteran wiki users.
* Allow wiki links and last-modified output to be obscure or invisible.
* Provide an adequate text area for easy editing.
* Keep the main content area a reasonable width for easier reading.
* Produce pages that render similarly in various browsers.
* Encourage wiki users to create well-structured web documents.
* Be easily customizable to suit personal preference.

The skin produces valid XHTML 1.0 and CSS output according to w3c.org's
validation services at http://validator.w3.org/ and
http://jigsaw.w3.org/css-validator/ respectively.

Installing the skin
-------------------
See INSTALL.txt

Revision History
----------------
Ver. 0.01
* The initial release.

Ver. 0.01.1
* Improved some of the CSS a bit.
* Added an upper Save button to the edit page for logged-in users. 

Ver. 0.02
* Added some "rel='nofollow'" attributes to tags.
* Now enabling GUI buttons in the light.php file.
* Added a crude HTTP-Auth (.htaccess) logout capability. 

Ver. 0.03
* Reworked and refined the .tmpl, .css, and .php files.

Ver. 0.04
* Now there's an upper Save button on the Edit page if $Author is set.
* Added a table button to the Edit Page button bar.
* Adjusted CSS so wiki style markup can more readily override the stylesheet.

Ver. 0.04.1
* Fixed an IE compatibility issue introduced in v0.04.

Ver. 0.05
* The upload link was always in "clean URL" format.  Now it changes according
  to $EnablePathInfo.
* The upload link has been renamed from "Upload" to "Attachments".
* The attachments link opens a new window (only) from the edit page.
* The Minor-edit checkbox now appears above the edit page text box if
  HTTP-authenticated.
* Rearranged Reset buttons on the edit page. (Suggested by Radu.)

Ver. 0.05.1
* Removed spurious edit page author box introduced in v0.05.

Ver. 0.05.2
* Improved enforced-author-tracking behavior.

Ver. 0.06
* Adapted the skin so it works on fresh installations of PmWiki 2.0.beta44
  or newer, which use the Site group rather than the Main group for site-
  related pages.

Ver. 0.07
* Further adapted the skin to work with 2.0.beta44 or newer.  Now there's
  a custom Edit Form and a Preferences page.

Ver. 0.08
* Added H5 "divider" styling to the sidebar for compatibility with
  PmWiki 2.0beta55 and newer.
* Added the possibility to not use headings in the sidebar by replacing
  heading markup (!, !!!!!, or !!!!!!) with a wikistyle markup (%p divider%)
  markup.  This is to encourage creating well-structured web documents that
  have the structure intended by the author.
* Added custom styling for a sidebar (:searchbox:).
* Added a searchbox to the page header.
* Added an option to insert the page's title as a hidden <h1> heading in the
  wikipage title area.

Ver. 0.09
* Added switchable appearance from a "wiki look" to a "web site look" via
  a link.

Ver. 0.09.1
* Fixed bug in new header (:searchbox:).

Ver. 0.10
* Lots of changes.  (Entries forthcoming...)

Ver. 0.11
* Improved Site.LightXLPage preferences / translation page.
* Mostly refinements.  (Entries forthcoming...)

Ver. 0.12
* Now the search form adapts according to the PmWiki version.

Ver. 0.12.1
* Improved auto-adapting search form.

Ver. 0.12.2
* Improved auto-adapting search form.
* Added expermental "Admin Bar" with admin-related links.

Ver. 0.12.3
* Added CSS for compatibility with v2.0.0 SideBar wikistyle.

Ver. 0.13.0
* Now bundling a custom Search page and a customized Upload Quick Reference.
* Added a login capability.  There are three login levels: Editor, Editor with
  Upload capability, and Administrator.
* Added miscellaneous CMS-Oriented features.
* Lots of other changes.  (Entries forthcoming...)

Ver. 0.13.1
* Brought Site.LightXLPage preferences / translation page up-to-date.

Ver. 0.13.2
* Added dlcol wikistyle, as seen on the pmwiki.org Cookbook page.
* Disabled some CMS-related settings by default.

Ver. 0.14.0
* Now cookie names use $CookiePrefix.
* Now inserting Atom and RSS 2.0 feed links to enable autodiscovery of feeds.
* Now displaying a few more GUI Edit buttons on the Edit Page.
* Now removing rel='nofollow' attribute from external links when in CMS Mode.
* Improved stylesheet loading order (light2.css is now via $HTMLStylesFmt .)
* Now turning Backlinks link on/off with PHP instead of CSS.
* Now turning Print link on/off with PHP instead of CSS.  It's off by default.

Ver. 0.15.0
* Improved CMS-oriented behavior generally.
* Added some more settings that can be used in config.php.
* Now "site" view is used only if CMS Mode is enabled.
* Improved CMS-Mode page restrictions for web feeds.
* Moved more links from the template to the php script.
* Added a login/logout prompt to the sidebar bottom.
* Eliminated the XHTML validator link.  (A wiki page works.)
* Added a "Manage Users" Admin link to $SiteGroup.AuthUser.

Ver. 0.16.0
* Expanded and improved the configuration settings section, now commented.
* It's now possible to do an (:if enabled LightSkin:) conditional test.
* Now {$SkinVersion} markup returns the skin version.
* Shortened light.php by moving the code for demo views to a separate file.
* The Author Required message now is highlighted so it's easier to notice.
* The SideBar bottom content is now in wiki pages.
* Moved the [[#anchor]] in the Edit Page up one row.
* Removed the Logout link from the Site.AboutThisSite page.

Ver. 0.16.1
* Fixed code that was making it difficult to get a logo to appear.

Ver. 0.16.2
* Added a save-as-draft button to the edit form.
* Removed the margin in sidebar headings for improved vspace compatibility. 

Ver. 0.16.3
* $Actions_allowed now uses SDV() so it can be set in a configuration file.
* Added 'comment', 'approveurls', and 'approvesites' as default allowable actions.
* Adapted new title to use the new $ActionTitle variable.
* Added {curlies} to page variables in the template file.

Author
------
Hagan Fox - http://Qdig.SourceForge.net

