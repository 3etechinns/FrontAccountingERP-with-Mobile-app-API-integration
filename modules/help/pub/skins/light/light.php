<?php if (!defined('PmWiki')) exit();
/**
* This is light.php, the php script portion of the Light Skin for PmWiki 2.
*/

global $EnableCMSMode, $EnableHeadBacklinks, $EnableHeadPrintLink,
  $EnableHeadWikiLinks, $EnableHeadUploadLink, $EnableHeadAboutLink,
  $EnableRigtSideBar, $Realm, $LogoutRedirectFmt, $EnableRssLink,
  $EnableAtomLink, $FeedLinkSourcePath, $FeedLinkTitleGroup,
  $EnablePageLogo, $PageLogoFile,$UserTheme,$FullName;

/*
+------------------------------------------+
|  Settings
|
| You can override these default values in
| a local configuration file.
+------------------------------------------+
*/

## Enable CMS-Oriented features.
SDV($EnableCMSMode, 0);

## Enable/disable some links in the page header.
SDV($EnableHeadBacklinks, 0);
SDV($EnableHeadPrintLink, 0);
SDV($EnableHeadWikiLinks, 1);
SDV($EnableHeadUploadLink, 1);
SDV($EnableHeadAboutLink, 1);

## Place the SideBar on the right (1) or left (0).
SDV($EnableRigtSideBar, 1);

## Allow use of an alternate Edit Form via the XLPage.
SDV($EnableEditFormPrefs, 1);

## Set the realm for HTTP-Auth (.htaccess) logout capability.
SDV($Realm, "Some Realm"); # Match's AuthName in .htaccess file

## Set a page to view after logging out.
SDV($LogoutRedirectFmt, '$FullName');

## Enable web feed links.  This just enables the links, not the feeds.
## To enable RSS and Atom feeds, use the following in local/config.php:
##
##   if ($action == 'rss' || $action == 'atom') {
##     include_once("scripts/feeds.php"); }
##
SDV($EnableSitewideFeed, 1);   # Link to Site/AllRecentChanges,
                               # otherwise feed is group-specific.
SDV($EnableRssLink, 1);
SDV($EnableAtomLink, 1);
SDV($FeedLinkSourcePath, '$[Main/AllRecentChanges]'); ## Override Site/...
SDV($FeedLinkTitleGroup, ''); // TODO: Needs a better name?

//## Use a graphic logo?
//SDV($EnablePageLogo, 0);
//SDV($PageLogoFile, 'lightlogo.gif');

// End of configuration settings

/*
TODO: Adapt AllRecentChanges link based on authorization. Switch to Site
      version if authorized.  Perhaps hide the (diff) link.
TODO: AboutThisSite link.
TODO: Bundle recipes.
*/
$GLOBALS['SkinVersion'] = '0.16.3';

# Use verbose error reporting for development.
if (strpos('*'.$_SERVER['SERVER_NAME'], 'bang.exam')) {
  $orig_err_rept = error_reporting('E_ALL'); }

## Use a special default view for demonstration on pmwiki.org.
if (strpos('*'.$_SERVER['SERVER_NAME'], 'pmwiki.org')) {
  global $View; SDV($View, 'demo3'); }

## Enable (:if enabled LightSkin:) conditional markup.
global $LightSkin; $LightSkin = TRUE;

## Enable {$SkinVersion} markup that returns the skin version.
Markup('{$SkinVersion}', '>{$fmt}', '/{\\$SkinVersion}/e', "\$GLOBALS['SkinVersion']");

## For backward compatibility.  TODO: Discard.
global $SiteGroup; if (!$SiteGroup) { $SiteGroup = 'Main'; }

## For backward compatibility.
global $ActionTitle, $Action; if (!$ActionTitle) { $ActionTitle = $Action; }

## Search form auto-adapts to the version.
global $Version, $SkinFormInput, $SkinSearch;
if (strpos($Version, '2.0.beta')
  && substr(strstr($Version, '2.0.beta'), 8) < 44 )
{
  $SkinSearch = "SearchWiki";
} else { $SkinSearch = "Search"; }
if (strpos($Version, '2.0.beta')
  && substr(strstr($Version, '2.0.beta'), 8) < 53 )
{
  $SkinFormInput = "
       <input type='hidden' name='n' value='{$SiteGroup}/$SkinSearch' />";
} else {
  $SkinFormInput = "
       <input type='hidden' name='n' value='{$FullName}' />
       <input type='hidden' name='action' value='search' />"; }

## Logout action
global $HandleActions, $Realm;
$HandleActions['logout'] = 'HandleLogoutL';
function HandleLogoutL($pagename, $auth = 'read') {
  global $LogoutRedirectFmt, $Realm, $CookiePrefix;
  @session_start();
  $_SESSION = array();
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-43200, '/'); }
  if (isset($_COOKIE[$CookiePrefix.'author'])) {
    setcookie($CookiePrefix.'author', '', time()-43200, '/'); }
  if (isset($_COOKIE[$CookiePrefix.'lightview'])) {
    setcookie($CookiePrefix.'lightview', '', time() - 42000, '/'); }
  session_destroy();
  # For HTTP-Auth sites
  if (isset($_SERVER['REMOTE_USER'])) {
    Header("WWW-Authenticate: Basic realm=\"$Realm\"");
    Header('HTTP/1.0 401 Unauthorized');
    exit; }
  SDV($LogoutRedirectFmt, '$FullName');
  Redirect(FmtPageName($LogoutRedirectFmt, $pagename)); }
## Login actions
global $HandleActions;
// TODO: Discard
// Edit
if (! function_exists('HandleLogin')) {
  SDV($HandleActions['login'], 'HandleLogin');
  function HandleLogin($pagename) {
    RetrieveAuthPage($pagename, 'edit');
    Redirect($pagename);
  }
}
// Upload
SDV($HandleActions['loginupload'], 'HandleLoginUpload');
function HandleLoginUpload($pagename) {
  RetrieveAuthPage($pagename, 'upload');
  Redirect($pagename); }
// Admin
SDV($HandleActions['loginadmin'], 'HandleLoginAdmin');
function HandleLoginAdmin($pagename) {
  RetrieveAuthPage($pagename, 'admin');
  Redirect($pagename); }

## Do some things based on the authorization level.
$page = RetrieveAuthPage($pagename, 'read', false, READPAGE_CURRENT);
## Read
#if (@$page['=auth']['read']) { # visitor has read permission }
## Edit
if (@$page['=auth']['edit']) {
  if ($EnableCMSMode == TRUE) { global $View; SDV($View, 'wiki'); }
  $EnableHeadBacklinks = 0;
} elseif ($EnableCMSMode == TRUE) {
  ##  Allow only essential site-related actions.
  if ($EnableCMSMode == TRUE) { global $View; SDV($View, 'site'); }
  global $action;
  SDV($Actions_allowed, array('browse', 'print', 'search', 'edit', 'login', 'rss',
    'atom', 'loginadmin', 'loginupload', 'comment', 'approveurls', 'approvesites'));
  if (! in_array($action, $Actions_allowed)) { $action='browse'; }
  ## Exclude Certain pages / groups from search results.
  global $SearchPatterns;
  $SearchPatterns['default'][] = '!\\.(All)?Recent(Changes|Uploads)$!';
  $SearchPatterns['default'][] = '!\\.(Group|Print)(Header|Footer)$!';
  $SearchPatterns['default'][] = '!\\.(GroupAttributes|WikiSandbox)$!';
  $SearchPatterns['default'][] = '!^(Test|Site|PmWiki)\\.!';
  ## Deny access to certain pages / groups.
  if ((preg_match('!\\.(All)?Recent(Changes|Uploads)$!', $pagename)
      && ! preg_match('!(Main.All)?RecentChanges$!', $pagename)) // For the RSS feed.
    || $pagename == "$SiteGroup.AllRecentChanges"
    || preg_match('!\\.(GroupHeader|GroupFooter|GroupAttributes|WikiSandbox)$!', $pagename)
    || preg_match('!^(PmWiki|Test)\\.!', $pagename))
  { global $DefaultPage; Redirect($DefaultPage); }
  ## Lose the rel='nofollow' attribute for external links.
  global $UrlLinkFmt; $UrlLinkFmt =
    "<a class='urllink' href='\$LinkUrl'>\$LinkText</a>";
  global $TimeFmt; $TimeFmt = '%B %d, %Y'; }
## Upload
#if (@$page['=auth']['upload']) { # visitor has attr permission }
## Attr
#if (@$page['=auth']['attr']) { # visitor has attr permission }
## Admin
global $SkinLoginFmt;
if (@$page['=auth']['admin']) {
  SetTmplDisplay('PageAdminTopFmt', 0);
  SetTmplDisplay('PageAdminBtmFmt', 1);
  global $EnableDiag;   $EnableDiag = 1;
  $EnableHeadBacklinks = 1;
  global $HTMLStylesFmt;  $HTMLStylesFmt[] = '
  #sitefoot { margin-top:4px; } ';
  if ($EnableCMSMode != TRUE) {$SkinLoginFmt ="<span id='footeditlogin'> |
       <a href='\$PageUrl?action=logout'
        title='$[Logout]' rel='nofollow'>$[Logout]</a></span>"; }
} else {
  SetTmplDisplay('PageAdminTopFmt', 0);
  SetTmplDisplay('PageAdminBtmFmt', 0);
  $SkinLoginFmt ="<span id='footeditlogin'> |
       <a href='\$PageUrl?action=loginadmin'
        title='$[Admin Login]' rel='nofollow'>$[Admin]</a></span>"; }

## Place the sidebar on the right by default.
if ($EnableRigtSideBar == TRUE) {
  SetTmplDisplay('PageLeftFmt', 0);
  SetTmplDisplay('PageRightFmt', 1);
} else {
  SetTmplDisplay('PageLeftFmt', 1);
  SetTmplDisplay('PageRightFmt', 0);
  global $HTMLStylesFmt;  $HTMLStylesFmt[] = '
    #mainsidebar { border-left:1px solid #cccccc; border-right:0px; } '; }

## Load some style settings that can override PmWiki defaults.
global $HTMLHeaderFmt;
$HTMLHeaderFmt['lightcss'] =
  "  <link rel='stylesheet' href='\$SkinDirUrl/light2.css' type='text/css' />";

## Set/get $View and apply CSS styles, etc.
## Limited only by your imagination...  :-)
global $CookiePrefix, $SkinDir, $HTMLStylesFmt, $View;
SDV($View, 'wiki');  // Default view
@include_once("$SkinDir/lightviews.php");

if ($View == 'site') {
  global $WikiTitle;
  if ($WikiTitle == 'PmWiki') $WikiTitle = 'Your Site';
  $EnableHeadUploadLink = 0;
  $EnableHeadWikiLinks = 0;
  $HTMLStylesFmt[] =  '
  #headlogo, #headlogo a, #headlogo a:visited { color:#333333; }
  #location .grouplink, #location .separator { display:none; }
  #footleft, #footmiddle, #footright { display:none; }
  #headright input.searchbox { background-color:#f9f9f9; border-color:#999999; }
  #headright input.searchbutton { background-color:#eeeeee;
    border-color:#999999; } ';
} else { @include_once("$SkinDir/demoviews.php"); }

#if ($View == 'wiki') { ## the default }

if ($View == 'admin' && $page['=auth']['edit']) {
  SetTmplDisplay('PageAdminTopFmt', 0);
  SetTmplDisplay('PageAdminBtmFmt', 1);
  $EnableHeadBacklinks = 1; }

## Use a graphic logo?
// TODO: Can these be with other settings without breaking demo views?
SDV($EnablePageLogo, 0);
SDV($PageLogoFile, 'lightlogo.gif');

## Add a custom page storage location for the
## custom Edit Form and a Preferences page.
global $WikiLibDirs;
$PageStorePath = dirname(__FILE__)."/wikilib.d/\$FullName";
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0,
  array(new PageStore($PageStorePath)));

## Enable the Preferences page.
global $PageEditForm, $XLLangs;
XLPage('light', 'Site.LightXLPage');
array_splice($XLLangs, -1, 0, array_shift($XLLangs));

## Enable the skin's custom EditForm, either
## configurable via a prefs page (XLPage) or not.
global $PageEditForm;
if ($EnableEditFormPrefs == TRUE) {
  SDV($PageEditForm, '$[Site.LightEditForm]');
} else {
  SDV($PageEditForm, 'Site.LightEditForm'); }

## Set the RSS Feed links to enable autodiscovery of the feeds.
## (Based on http://www.pmwiki.org/wiki/Cookbook/FeedLinks .)
if (@$EnableSitewideFeed == TRUE) {
  SDV($FeedLinkSourcePath , '$[Main/AllRecentChanges]');
  SDV($FeedLinkTitleGroup , '');
} else {
  SDV($FeedLinkSourcePath , '$[$Group/RecentChanges]');
  SDV($FeedLinkTitleGroup , ' : $[$Group] -'); }
if ($EnableRssLink) {
  $HTMLHeaderFmt['rsslink'] =
    "<link rel='alternate' title='\$WikiTitle$FeedLinkTitleGroup $[RSS Feed]'
      href='\$ScriptUrl/$FeedLinkSourcePath?action=rss'
      type='application/rss+xml' />\n  "; }
if ($EnableAtomLink) {
  $HTMLHeaderFmt['atomlink'] =
    "<link rel='alternate' title='\$WikiTitle$FeedLinkTitleGroup $[Atom Feed]'
      href='\$ScriptUrl/$FeedLinkSourcePath?action=atom'
      type='application/atom+xml' />\n  "; }

//$HTMLHeaderFmt['sitecss'] =
//    "<link href='\$PageUrl/themes/$Utheme/default.css' rel='stylesheet' type='text/css' /> \n";

## Sometimes hide #location for extra vertical space.
global $action;
if (in_array($action, array('edit', 'diff', 'upload', 'attr'))) {
  $HTMLStylesFmt[] =  "\n  #location { display:none; }";
  SDV($UseTitleAsHeading, FALSE); } // TODO

## Use GUI buttons on edit pages, including add some extra buttons.
global $EnableGUIButtons, $GUIButtons;
$EnableGUIButtons = 1;
$GUIButtons['h3'] = array(402, '\\n!!! ', '\\n', '$[Subheading]',
                     '$GUIButtonDirUrlFmt/h3.gif"$[Subheading]"');
$GUIButtons['indent'] = array(500, '\\n->', '\\n', '$[Indented text]',
                     '$GUIButtonDirUrlFmt/indent.gif"$[Indented text]"');
$GUIButtons['outdent'] = array(510, '\\n-<', '\\n', '$[Hanging indent]',
                     '$GUIButtonDirUrlFmt/outdent.gif"$[Hanging indent]"');
$GUIButtons['ul'] = array(530, '\\n* ', '\\n', '$[Unordered list]',
                     '$GUIButtonDirUrlFmt/ul.gif"$[Unordered (bullet) list]"');
$GUIButtons['ol'] = array(520, '\\n# ', '\\n', '$[Ordered list]',
                     '$GUIButtonDirUrlFmt/ol.gif"$[Ordered (numbered) list]"');
$GUIButtons['stable'] = array(600,
                      '||border=1 width=80%\\n||!Hdr ||!Hdr ||!Hdr ||\\n||     ||     ||     ||\\n||     ||     ||     ||\\n', '', '',
                    '$GUIButtonDirUrlFmt/table.gif"$[Simple Table]"');
$GUIButtons['atable'] = array(610,
                     '(:table border=1 width=80%:)\\n(:cell style=\'padding:5px\;\':)\\n1a\\n(:cell style=\'padding:5px\;\':)\\n1b\\n(:cellnr style=\'padding:5px\;\':)\\n2a\\n(:cell style=\'padding:5px\;\':)\\n2b\\n(:tableend:)\\n', '', '',
                     '$GUIButtonDirUrlFmt/table.gif"$[Advanced Table]"');

if ($action == 'edit') { global $AuthorRequiredFmt, $HTMLStylesFmt;
  $AuthorRequiredFmt = "<h3 class='wikimessage authormessage'>"
  ."$[An author name is required.]</h3>";
  $HTMLStylesFmt['wikimessage'] = "\n  .authormessage { color:black;"
  ." background-color:#ffffcc; padding:3px; }"; }

global $RecentChangesFmt;
if ($EnableCMSMode == TRUE
  && (preg_match('!\\.(GroupHeader|GroupFooter|GroupAttributes|WikiSandbox)$!',
    $pagename) || preg_match('!^(PmWiki|Test|Site)\\.!', $pagename))) {
$RecentChangesFmt['Main.AllRecentChanges'] = '';
} else {
$RecentChangesFmt['Main.AllRecentChanges'] =
 '* [[$Group.$Name]]  ([[($Group.$Name?action=)diff]])'
 .' . . . $CurrentTime $[by] $AuthorLink: [=$ChangeSummary=]'; }
if (! $EnableCMSMode == TRUE) {
global $HTMLStylesFmt;  $HTMLStylesFmt[] = '
  #sidebarbottom { display:none; } '; }

## Uplaod / Attachments link
global $EnableUpload, $SkinUploadLinkFmt;
if ($action == 'edit') {
  $UpNewWin = "target='_blank'";
} else { $UpNewWin = ''; }
##if (@$page['=auth']['upload']) {
if ($EnableUpload == 1 && $EnableHeadUploadLink == 1) {
  $SkinUploadLinkFmt =
      "<span id='headupload'><a href='\$PageUrl?action=upload'
       title='$[Attached Files]' rel='nofollow' $UpNewWin>$[Attachments]</a> |
      </span>"; }

## Reduce confusing links to the page we're already on (self-references).
global $DefaultPage, $ScriptUrl, $SkinHomeLink, $WikiTitle, $SkinGroupFmt,
  $SkinTitleFmt;
$WikiTitle = htmlspecialchars($WikiTitle, ENT_QUOTES);
// Logo  // TODO: Clean up?
if (empty($pagename) || $pagename==$DefaultPage && $action == 'browse') {
  if ($EnablePageLogo == TRUE) {
    $SkinHomeLink = "<img
        src='\$SkinDirUrl/$PageLogoFile' alt='$WikiTitle' border='0' />";
  } else {
    $SkinHomeLink = "$WikiTitle";
    $HTMLStylesFmt[] = "\n  #headlogo { margin-top:4px; } ";
  }
} else {
  if ($EnablePageLogo == TRUE) {
  $SkinHomeLink = "<a href='\$ScriptUrl'><img
        src='\$SkinDirUrl/$PageLogoFile' alt='$WikiTitle' border='0' /></a>";
  } else {
    $SkinHomeLink = "<a href='\$ScriptUrl'>$WikiTitle</a>";
    $HTMLStylesFmt[] = "\n  #headlogo { margin-top:4px; } ";
  }
}
// Group
$thisgroup = FmtPageName('$Group',$pagename);
$thispage = FmtPageName('$Name',$pagename);
if (empty($pagename)
  || $pagename == $DefaultPage 
  || $thisgroup == $thispage
  || $thispage == 'HomePage')
{
  $SkinGroupFmt = "\$Group";
} else {
  $SkinGroupFmt = "<a href='\$ScriptUrl/\$Group'
          title='\$Group \$[Home]'>\$Group</a>"; }
// Title
if (in_array($action, array('edit', 'upload', 'diff'))) {
  $SkinTitleFmt = "<a href='\$PageUrl'>\$Titlespaced</a>";
} else { $SkinTitleFmt = "\$Titlespaced"; }
// Action Links
if (in_array($action, array('browse', 'edit', 'diff', 'upload'))) {
  $HTMLStylesFmt[] = "\n  #head$action { display:none; }"; }

## Insert the page's title as a hidden <h1> heading in the wikipage title
## area to improve the document structure, hence search engine optimization.
SDV($UseTitleAsHeading, TRUE);  // Use TRUE or FALSE
global $SkinTitleHeadingFmt;
if ($UseTitleAsHeading == TRUE) {
  $SkinTitleHeadingFmt =
   "<div style='display:none;'><h1>\$Titlespaced</h1></div>";
} else { $SkinTitleHeadingFmt = ''; }

## Hide sidebar and/or header sometimes TODO: Switch to $HTMLSTylesFmt?
global $SkinHideSide, $SkinWideBody,  $SkinHideLoc;
if (in_array($action, array('edit', 'diff', 'attr'))) {
  $SkinHideSide     = "style='display:none;'";
  $SkinWideBody     = "style='width:744px;'"; }
if ($action == 'edit') { $SkinHideLoc = "style='display:none;'"; }
// RecentChanges pages
if (preg_match('/\\.(All)?Recent(Changes|Uploads)$/', $pagename)) {
  $SkinHideSide     = "style='display:none;'"; }

global $SkinWikiLinksFmt;
if ($EnableHeadWikiLinks == TRUE) {
  $SkinWikiLinksFmt =
    "<span id='headbrowse'><a href='\$PageUrl'
       title='\$[Browse the page]' rel='nofollow' accesskey='\$[ak_view]'>\$[View]</a> |
      </span><span id='headedit'><a href='\$PageUrl?action=edit'
       title='\$[Edit this page]' rel='nofollow'>\$[Edit]</a> |
      </span><span id='headdiff'><a href='\$PageUrl?action=diff'
       title='\$[History of this page]' rel='nofollow'>\$[History]</a> |
      </span>";}

##  Head commands (lower, below searchbox)
global $SkinBackLinksFmt, $SkinPrintLinkFmt, $SkinAboutLinkFmt;
if ($EnableHeadBacklinks == TRUE) {
  $SkinBackLinksFmt =
    "<span id='headbacklinks'><a href='\$PageUrl?action=search&amp;q=link=\{$FullName}'
       title='\$[Pages that link to \$Group.\$Name]' rel='nofollow'>\$[Backlinks]</a> |
      </span>"; }
if ($EnableHeadPrintLink == TRUE) {
  $SkinPrintLinkFmt =
    "<span id='headprint'><a href='\$PageUrl?action=print'
       title='\$[Printable view of this page]' rel='nofollow'>\$[Print]</a> |
      </span>"; }
if ($EnableHeadAboutLink == TRUE) {
  $SkinAboutLinkFmt =  "<span id='headabout'><a"
    ." href='\$ScriptUrl/\$[Main/AboutThisSite]' title='\$[About this site]'"
    ." rel='nofollow'>\$[About $WikiTitle]</a></span>"; }

## Copyright notice
global $SkinCopyright;
/*
$SkinCopyright = "<span id='copyright' title='Copyright notice'>All
          text is available under the terms of the
          <a href='http://www.gnu.org/copyleft/fdl.html'
           title='GNU FDL Home'>GNU Free Documentation License</a></span>";
*/

## Power-by notice
global $PoweredByFmt;
$PoweredByFmt="<span id='sitepoweredby' title='$[Powered by PmWiki]'>$[Powered by]
          <a href='http://www.pmwiki.org/wiki/PmWiki/PmWiki'
           title='\$[PmWiki Home]'>PmWiki</a>
         </span>";

## Reset error reporting ("just in case")
if (@$orig_err_rept) { error_reporting($orig_err_rept); }

