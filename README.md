bfwurfl
=======

Implements mobile device capability detection for [eZ Publish](https://github.com/ezsystems/ezpublish) using [WURFL](http://wurfl.sourceforge.net/).


Configuration
-------------
	
Mostly works out of the box. Make sure to regenerate your autoloads after installing this extension.

bfwurfl.ini can be used to pull additional capabilities.

See http://wurfl.sourceforge.net/help_doc.php for a list of capabilities available from the WURFL database.

bfwurfl uses (/var/www/ez)/var/wurfl/ for cache files. You may need to create this directory if your permissions are incorrect.


Usage
-----

bfwurfl implements a template operator, wurfl(), which returns a hash of the capabilities specified in bfwurfl.ini.

The "is_mobile_device" capability is calculated automatically, and is always returned.

	{if is_unset($capabilities)}
		{def $capabilities = wurfl()}
	{/if}
	{if $capabilities.is_mobile_device}
		{* mobile only code *}
	{else}
		{* desktop only code *}
	{/if}


Caching
-------
To make sure mobile-only code is not cached globally in eZ Publish, you may want to include the result
of ```wurfl()``` in the cache keys of your pagelayout.tpl.

	{def $capabilities = wurfl()}
	{cache-block keys=array( $current_node_id, $capabilities.is_mobile_device ) expiry=300}


Performance
-----------
	
bfwurfl adds timing points and an accumulator so that you can monitor its performance.

Look for the "BFWURFL" group in the Accumulator section, and "Querying WURFL" in the Timing Points section.

bfwurfl.ini has several settings which may have an impact on performance.


Keeping up to date
------------------
Make sure to regularly pull a new version of the data/wurfl.xml file from [ScientiaMobile](http://wurfl.sourceforge.net/wurfl_download.php)


Legal
-----

[bfwurfl](https://github.com/pauljz/bfwurfl) is distributed under the [AGPL version 3](http://www.gnu.org/licenses/agpl-3.0.html)

This project is in no way affiliated with ScientiaMoble Inc, WURFL, eZ Systems AS, or eZ Publish

* [WURFL](http://wurfl.sourceforge.net/) is a trademark of [ScientiaMobile, Inc.](http://www.scientiamobile.com/)
* [eZ Publish](http://www.ez.no) is a trademark of eZ Systems AS

Copyright &copy; 2012 [Beaconfire](http://www.beaconfire.com/)