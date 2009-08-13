<?php

// This is a PLUGIN TEMPLATE.

// Copy this file to a new name like abc_myplugin.php.  Edit the code, then
// run this file at the command line to produce a plugin for distribution:
// $ php abc_myplugin.php > abc_myplugin-0.1.txt

// Plugin name is optional.  If unset, it will be extracted from the current
// file name. Uncomment and edit this line to override:
# $plugin['name'] = 'abc_plugin';

$plugin['version'] = '0.1';
$plugin['author'] = 'Ramanan Sivaranjan';
$plugin['author_uri'] = 'http://funkasohi.com/';
$plugin['description'] = 'Generate ATOM or RSS Feed Auto-discovery links.';

// Plugin types:
// 0 = regular plugin; loaded on the public web side only
// 1 = admin plugin; loaded on both the public and admin side
// 2 = library; loaded only when include_plugin() or require_plugin() is called
$plugin['type'] = 0; 


@include_once('zem_tpl.php');

if (0) {
?>
# --- BEGIN PLUGIN HELP ---

<h2>&lt;txp:rsx_feed_auto_discovery_link /&gt;</h2>
<p>This plugin will produce audo-discovery feed links.  There are two parameters:  </p>
<ul>
	<li><code>smart</code> &#8211; this can equal 1 or 0.  If it is 1, then the feed links will be section and category aware.</li>
	<li><code>flavour</code> &#8211; this can equal &#8216;rss&#8217; or &#8216;atom&#8217;.  This is how you set what sort of feed link to produce.</li>
</ul>
 
# --- END PLUGIN HELP ---
<?php
}

# --- BEGIN PLUGIN CODE ---
function rsx_feed_auto_discovery_link($atts)
{
	global $c, $s, $sitename, $limit;
	extract(lAtts(array('smart' => 0, 'flavour' => 'rss'),$atts));
	
	$title = $sitename;
	$url = '';
	if ($smart)
	{
		$section = '';
		if ( isset($s) && !empty($s) && $s != 'default' )
		{
			$section = $s;
			$title .= ' - '.$s;
		}
		$category = '';
		if ( isset($c) && !empty($c) )
		{
			$category = $c;
			$title .= ' - '.$c;
		}
		$url = pagelinkurl(array('category'=>$category, 'section'=> $section, 'limit'=>$limit, $flavour=>'1'));
	}
	else
	{
		$url = pagelinkurl(array('limit'=>$limit, $flavour=>'1'));
	}

	return '<link rel="alternate" type="application/'.$flavour.'+xml" title="'.$title.' ('.$flavour.' feed)" href="'.$url.'" />';
}

# --- END PLUGIN CODE ---

?>
