<?php
/**********************************************
Author: Joe Hunt
Name: Test Client Info
Free software under GNU GPL
***********************************************/
$page_security = 2;
$path_to_root="../..";

include($path_to_root . "/includes/session.inc");
page("Test Client Info");

include($path_to_root . "/includes/ui.inc");

class client_info
{
	var $platform;
	var $browser;

	function client_info()
	{
  		$this->platform = "Unknown";
		// Determine the platform they are on
		if (strstr($this->get_user_agent(),'Win')) 
    		$this->platform='Windows';
		else if (strstr($this->get_user_agent(),'Mac'))
    		$this->platform='Macintosh';
		else if (strstr($this->get_user_agent(),'Linux'))
    		$this->platform='Linux';
		else if (strstr($this->get_user_agent(),'Unix'))
    		$this->platform='Unix';
		else
    		$this->platform='Other';
        
    		
		// Next, determine the browser they are using		
		if ( preg_match("/Opera ([0-9].[0-9]{0,2})/i", $this->get_user_agent(), $found) &&
			   strstr($this->get_user_agent(), "MSIE") )
		{
			// This will identify the Opera browser even when it tries to ID itself
			// as MSIE 5.0			
		 	$this->browser = "Opera " . $found[1];
		}
		else if ( preg_match("/Opera ([0-9].[0-9]{0,2})/i", $this->get_user_agent(), $found) &&
				 strstr($this->get_user_agent(), "Mozilla") )
		{
		  	// Finds Opera if ID's itself as Mozilla based browser
		 	$this->browser = "Opera " . $found[1];
		}
		else if ( preg_match("/Opera/([0-9].[0-9]{0,2})/i", $this->get_user_agent(), $found) )
		{
		  // Finds Opera when ID'ing itself as Opera
		  $this->browser = "Opera " . $found[1];
		}
    	else if ( preg_match("/Netscape[0-9]/([0-9]{1,2}.[0-9]{1,2})/i", $this->get_user_agent(), $found) )
    	{
		  	// For Netscape 6.x
    		$this->browser = "Netscape " . $found[1];
    	}
		else if ( preg_match("/Mozilla/([0-9]{1}.[0-9]{1,2}) [en]/i", $this->get_user_agent(),$found) )
    	{
			// For Netscape 4.x
    		$this->browser = "Netscape " . $found[1];
    	}		
    	else if ( preg_match("/MSIE ([0-9]{1,2})/i", $this->get_user_agent(), $found) )
    	{
			// For MSIE
    		$this->browser = $found[0];
    	}    
		else
		  $this->browser = $this->get_user_agent();
	}
  
	// Return the platform detected
  	function get_client_platform()
  	{
  		return ($this->platform);
  	}
  
  	// Return the browser that we detected
  	function get_client_browser()
	{
  		return ($this->browser);
  	}
  
  	// Return the user agent string
  	function get_user_agent()
  	{
  		return $_SERVER['HTTP_USER_AGENT'];
  	}
  
}

start_table($table_style);

$th = array("Function", "Description");
table_header($th);

$k = 0;
$cl = new client_info();

alt_table_row_color($k);

label_cell("Platform");
label_cell($cl->get_client_platform());
end_row();
alt_table_row_color($k);

label_cell("Browser");
label_cell($cl->get_client_browser());
end_row();
alt_table_row_color($k);

label_cell("User Agent");
label_cell($cl->get_user_agent());
end_row();

end_table(1);

end_page();

?>