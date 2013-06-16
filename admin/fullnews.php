<?php

/**
 * Full news page
 *
 * @package FusionNews
 * @copyright (c) 2006 - 2009, FusionNews.net
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL 3.0 License
 * @version $Id: fullnews.php 270 2009-04-26 11:34:02Z xycaleth $
 */

if ( !defined ('FNEWS_ROOT_PATH') )
{
	/**@ignore*/
	define ('FNEWS_ROOT_PATH', str_replace ('\\', '/', dirname (__FILE__)) . '/');
	include_once FNEWS_ROOT_PATH . 'common.php';
}

$id = ( isset ($VARS['fn_id']) ) ? (int)$VARS['fn_id'] : 0;

ob_start();

if ( !file_exists (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php') )
{
	echo $flns0;
}
else
{
	$file = file (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php');
	$news_info = parse_news_to_view ($file[1]);

	$temp_full = get_template ('fullnews_temp.php', true);
	echo replace_masks ($temp_full, array (
		'post_id'		=> $news_info['post_id'],
		'subject'		=> $news_info['subject'],
		'description'	=> $news_info['description'],
		'user'		=> $news_info['writer'],
		'date'		=> $news_info['date'],
		'icon'		=> $news_info['icon'],
		'send'		=> $news_info['link_tell_friend'],
		'nrc'			=> $news_info['nrc'],
		'comments'		=> $news_info['link_comments'],
		'cat_icon'		=> $news_info['cat_icon'],
		'cat_id'		=> $news_info['cat_id'],
		'cat_name'		=> $news_info['cat_name'],
		'shortnews'		=> $news_info['news'],
		'fullnews'		=> $news_info['fullnews']
	));
}

ob_end_flush();

?>
