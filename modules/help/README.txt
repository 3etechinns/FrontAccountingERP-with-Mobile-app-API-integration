Special notes for installing PmWiki for FrontAccounting 2.0.
--------------------------------------------------------
PmWiki for FA is a special designed Wiki for on-line Help/Documentation.

Installing PmWiki for Frontaccounting 2.0:
-----------------------------------------
This module is NOT installed the normal way from inside FrontAccounting, but is done
manuelly.
Create a new folder, wiki, under /modules folder. Unzip the package and upload it to this 
new wiki folder.

In the file, config.php

Uncomment the line 
  //$help_base_url = $path_to_root.'/modules/wiki/index.php?n='._('Help').'.';
and comment the line  
  $help_base_url = null;

Save the config.php file.  
  
The next time you are running FrontAccounting, a new menu item is present, Help, just 
before the Logout menu. Depending on which page you are using, the Help Wiki is 
presenting help for this page. 

For now, there is not much help entered, but you can add this by yourself. The Administrator
as well as the Developers of FrontAccounting will create pages, and as soon these are 
majured, we will upload new releases of the PmWiki Help.

----------------------- End of notes for FrontAccounting 2.0 -----------------

This is the README.txt file for PmWiki, a wiki-based system for
collaborative creation and maintenance of websites.

PmWiki is distributed with the following directories:

  docs/           Brief documentation, sample configuration scripts
  local/          Configuration scripts
  cookbook/       Recipes (add-ons) from the PmWiki Cookbook
  pub/skins/      Layout templates ("skins" for custom look and feel)
  pub/css/        Extra CSS stylesheet files
  pub/guiedit/    Files for the Edit Form's GUIEdit module
  scripts/        Scripts that are part of PmWiki
  wikilib.d/      Bundled wiki pages, including
                    * a default Home Page
                    * PmWiki documentation pages
                    * some Site-oriented pages

After PmWiki is installed the following directories may also exist:

  wiki.d/         Wiki pages
  uploads/        Uploaded files (page attachments)

For quick installation advice, see docs/INSTALL.txt.

For more extensive information about installing PmWiki, visit
  http://pmwiki.org/wiki/PmWiki/Installation

For information about running PmWiki in standalone mode without
requiring a webserver, visit
  http://pmwiki.org/wiki/Cookbook/Standalone

PmWiki is Copyright 2001-2006 Patrick R. Michaud
pmichaud@pobox.com
http://www.pmichaud.com/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

The GNU General Public License is distributed with this program
(see docs/COPYING.txt) and it is also available online at
http://www.fsf.org/licensing/licenses/gpl.txt .
