<?php if (!defined('PmWiki')) exit();

if ($View == 'hybrid') {
  global $WikiTitle;
  if ($WikiTitle == 'PmWiki') $WikiTitle = "Your Wiki Site";
  $EnableHeadUploadLink = 0;
  $EnableHeadWikiLinks = 0;
  $HTMLStylesFmt[] =  '
  #footedit, #footedit a, #foothist, #foothist a { color:#999999; }
  #footlastmod { padding-right:50px; color:#cccccc; }
  #footchanges, #footchanges a { color:#999999; }
  #footeditsb { display:none }
  #location .grouplink, #location .separator { display:none; } ';
}

/**
* These are just demos for the skin's page on pmwiki.org.  Delete these,
* or experiment with them to help yourself come up with a custom style.
*/
if ($View == 'demo1') {
  // Use a graphic logo.
  SDV($EnablePageLogo, TRUE); // TODO: Rename?
  // CSS style adjustments.
  $HTMLStylesFmt[] =  '
  #sitehead, #sitehead td, #mainsidebar { background-color:#fffffa; }
  #maincontent { background-color:#fdffff; }
  #maincontent a, #maincontent a:visited { font-weight:bold;
    text-decoration:none; } 
  #mainsidebar h1, #mainsidebar h5, #mainsidebar h6, #mainsidebar .divider,
    #mainsidebar .wikisearch, #mainsidebar .newpage, #mainsidebar .sidehead {
    background-color:#fcfcfc; border-bottom:1px solid #dddddd;
    border-top: 2px solid #fcfcfc; } 
  #headcmdsupper, #headcmdslower { padding-bottom:2px; padding-top:2px; }
  #headright input.searchbox { background-color:#fcfcfc; border-color:#b0b0b0; }
  #headright input.searchbutton { background-color:#f0f0f0; border-color:#999999; }
  #footedit, #footedit a, #foothist, #foothist a, #footeditsb, #footeditsb a {
    color:#999999; }
  #footlastmod { color:#cccccc; }
  #footchanges, #footchanges a { color:#999999; } ';
}

if ($View == 'demo2') {
  // Move sidebar to the left.
  SetTmplDisplay('PageRightFmt', 0);
  SetTmplDisplay('PageLeftFmt', 1);
  $HTMLStylesFmt[] = '
  #mainsidebar { border-left:1px solid #cccccc; border-right:0px; } ';
  // Use a graphic logo.
  SDV($EnablePageLogo, TRUE);
  // CSS style adjustments.
  $HTMLStylesFmt[] =  '
  #sitehead, #siteadmintop, #siteadminbtm, #sitemain, #sitefoot {
    width:100%; }
  #sitehead { margin:0px; }
  #sitehead { padding-top:2px; border-top:0px; }
  #maincontent { width:100%; }
  #mainsidebar { width:165px; }
  #wikiedit textarea { width:99%; }
  body { background-color:#fcfaf9; margin:9px; margin-bottom:0px;
    margin-top:0px; }
  #sitehead, #sitehead td, #mainsidebar { background-color:#fcfcfc; }
  #mainsidebar h1, #mainsidebar h5, #mainsidebar h6, #mainsidebar .divider,
    #mainsidebar .wikisearch, #mainsidebar .newpage, #mainsidebar .sidehead {
    background-color:#f6f6f6; border-color:#f3f3f3; } ';
}

if ($View == 'demo3') {
  SDV($EnablePageLogo, TRUE);
  SDV($PageLogoFile, 'lightlogo2.gif');
  $HTMLStylesFmt[] =  '
  #sitehead, #sitemain, #sitefoot { width:100%; border:none; }
  #sitehead { margin:0px; }
  #siteadmintop, #siteadminbtm { width:100%; margin:0px; }
  #maincontent { width:100%; }
  #mainsidebar { width:165px; }
  #wikiedit textarea { width:99%; }
  body { background-color:#fcfaf9; margin-left:12px; margin-right:12px; }
  a { font-weight:bold; color:#996633; text-decoration:none; }
  a:visited { font-weight:bold; color:#663300; text-decoration:none; }
  a:hover { color:#cc9966; text-decoration:underline; }
  a:active { color:#9c0606; }
  #sitehead, #sitehead td, #mainsidebar { background-color:#fcfcfc; }
  #headlogo, #headlogo a, #headlogo a:visited { color:#554433; font-weight:bold; }
  #headcmdsupper, #headcmdslower { padding-bottom:1px; padding-top:2px; }
  #headright input.searchbox { background-color:#fcfcfc; border-color:#b0b0b0; }
  #headright input.searchbutton { background-color:#f0f0f0; border-color:#999999; }
  #mainsidebar h1, #mainsidebar h5, #mainsidebar h6, #mainsidebar .divider,
    #mainsidebar .wikisearch, #mainsidebar .newpage, #mainsidebar .sidehead {
    background-color:#f9f9f9; border-bottom:1px solid #f3f3f3;
    border-top: 2px solid #fcfcfc; }
  #maincontent { background-color:#ffffff; }
  #maincontent a, #maincontent a:visited { font-weight:bold;
  text-decoration:none; } ';
}

