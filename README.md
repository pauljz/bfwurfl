Purpose:

	Implement mobile detection using WURFL (http://wurfl.sourceforge.net/)


Configuration:
	
	Mostly works out of the box. Make sure to regenerate your autoloads after installing this extension.

	bfwurfl.ini can be used to pull additional capabilities.

	See http://wurfl.sourceforge.net/help_doc.php for a list of capabilities available from the WURFL database.

	bfwurfl uses (/var/www/ez)/var/wurfl/ for cache files. You may need to create this directory if your permissions are incorrect.


Usage:

	bfwurfl implements a template operator, bfwurfl_get(), which returns a hash of the capabilities specified in bfwurfl.ini.

	The "is_mobile_device" capabilities is calculated automatically, and is always returned.


Example:

	{if is_unset($capabilities)}
		{def $capabilities = bfwurfl_get()}
	{/if}
	{if $capabilities.is_mobile_device}
		{* mobile only code *}
	{else}
		{* desktop only code *}
	{/if}


Performance:
	
	bfwurfl adds timing points and an accumulator so that you can monitor its performance.

	Look for the "BFWURFL" group in the Accumulator section, and "Querying WURFL" in the Timing Points section.