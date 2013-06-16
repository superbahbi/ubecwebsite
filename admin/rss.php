<?php

/**
 * RSS Feed generator
 *
 * @package FusionNews
 * @copyright (c) 2006 - 2009, FusionNews.net
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL 3.0 License
 * @version $Id: rss.php 283 2009-09-17 18:15:45Z xycaleth $
 */

if ( !defined ('FNEWS_ROOT_PATH') )
{
	/**@ignore*/
	define ('FNEWS_ROOT_PATH', str_replace ('\\', '/', dirname (__FILE__)) . '/');
	include_once FNEWS_ROOT_PATH . 'common.php';
}

if ( !$enable_rss )
{
	exit;
}

$file = get_ordered_toc();

$total_posts = sizeof ($file);
if ( $total_posts <= 0 )
{
	exit;
}

/**
 * Category ID to display posts from
 * @global int $fn_category
 */
$fn_category = ( isset ($VARS['fn_category']) ) ? (int)$VARS['fn_category'] : 0;

$current_date = date ('r');

$rss_url = $furl . '/rss.php';
if ( $fn_category > 0 )
{
	$rss_url .= '?fn_category=' . $fn_category;
}

$category_name = '';
if ( $fn_category > 0 )
{
	$category_file = file (FNEWS_ROOT_PATH . 'categories.php');
	array_shift ($category_file);

	$category_exists = false;
	foreach ( $category_file as $value )
	{
		$category = get_line_data ('categories', $value);
		if ( $category['category_id'] == $fn_category )
		{
			$category_exists = true;
			$category_name = $category['name'];
		}
	}

	if ( !$category_exists )
	{
		// Fall back
		$fn_category = 0;
	}
}

$rss_title = replace_masks ($rss_title, array ('cat_name' => $category_name));
$rss_description = replace_masks ($rss_description, array ('cat_name' => $category_name));

header ('Content-Type: text/rss+xml; charset=' . $rss_encoding);

ob_start();

echo <<< rss
<?xml version="1.0" encoding="$rss_encoding"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">

<channel>
	<title>$rss_title</title>
	<link>$hurl</link>
	<description>$rss_description</description>
	<pubDate>$current_date</pubDate>
	<lastBuildDate>$current_date</lastBuildDate>
	<generator>Fusion News</generator>
	<atom:link href="$rss_url" type="application/rss+xml" rel="self" />

rss;

if ( $category_name != '' )
{
	echo "\t" . '<category>' . $category_name . '</category>' . "\n";
}

$count = 0;
$settings = array ('category' => array ($fn_category));
foreach ( $file as $newsdata )
{	
	$toc = get_line_data ('news_toc', $newsdata);
	$categories = explode (',', $toc['categories']);

	if ( $fn_category !== 0 && !in_array ($fn_category, $categories) )
	{
		continue;
	}

	if ( !file_exists (FNEWS_ROOT_PATH . 'news/news.' . $toc['news_id'] . '.php') )
	{
		continue;
	}
	
	if ( $count > 25 )
    {
        break;  
    }
    
    ++$count;

	$news_file = file (FNEWS_ROOT_PATH . 'news/news.' . $toc['news_id'] . '.php');

	$article = get_line_data ('news', $news_file[1]);
	$news_info = parse_news_to_view ($article, $settings);

	$writer = get_author ($article['author']);
	$news_info['date'] = date ('r', $article['timestamp']);
	$news_info['subject'] = strip_tags ($news_info['subject']);

	$author = ( $news_info['email'] ) ? "\n\t\t" . '<author>' . $news_info['email'] . ' (' . $writer['nick'] . ')</author>' : '';
    
    $description = $news_info['description'];
    if ( $news_info['description'] == '' )
    {
        $lines = explode ("\n", $news_info['news']);
        $description = strip_tags (array_shift ($lines));
    }

	echo <<< rss
	<item>
		<title><![CDATA[{$news_info['subject']}]]></title>
		<link>{$furl}/fullnews.php?fn_id={$article['news_id']}</link>
		<description><![CDATA[$description]]></description>$author
		<pubDate>{$news_info['date']}</pubDate>
		<guid isPermaLink="false">fus_{$article['news_id']}-{$article['timestamp']}</guid>
	</item>

rss;
}

echo <<< rss
</channel>

</rss>
rss;

ob_end_flush();

?>