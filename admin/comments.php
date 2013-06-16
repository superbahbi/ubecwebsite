<?php

/**
 *  Comments page
 *
 * @package FusionNews
 * @copyright (c) 2006 - 2009, FusionNews.net
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL 3.0 License
 * @version $Id: comments.php 285 2009-09-19 17:07:23Z xycaleth $
 */

if ( !defined ('FNEWS_ROOT_PATH') )
{
	/**@ignore*/
	define ('FNEWS_ROOT_PATH', str_replace ('\\', '/', dirname (__FILE__)) . '/');
	include_once FNEWS_ROOT_PATH . 'common.php';
}

$id = ( isset ($VARS['fn_id']) ) ? (int)$VARS['fn_id'] : 0;
$action = ( isset ($VARS['fn_action']) ) ? $VARS['fn_action'] : '';

if ( !function_exists ('parse_comments') )
{
	/**
	 * Parses the comments for display with the template
	 * @param string &$comment_text Comment message text
	 * @param string &$comment_author Name of the comment's author
	 * @param string $comment_email Email address of the author
	 */
	function parse_comments ( &$comment_text, &$comment_author, $comment_email )
	{
		global $cbwordwrap, $wwwidth, $bbc, $htc, $wfcom, $comallowbr, $smilcom;
        
        $comment_text = str_replace ('&br;', ($comallowbr ? '<br />': ''), $comment_text);
        $comment_text = format_message ($comment_text, $htc, $bbc, $smilcom, $wfcom);

		if ( !empty ($comment_email) )
		{
			$comment_author = '<a href="mailto:' . $comment_email . '">' . $comment_author . '</a>';
		}
	}
}

if ( !headers_sent() )
{
	header ('Last-Modified: ' . gmdate ('D, d M Y H:i:s') . ' GMT');
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
}

if ( $action == 'confirm' )
{
	$fus_sid = ( isset ($VARS['fn_sid']) ) ? $VARS['fn_sid'] : '';
	if ( empty ($fus_sid) )
	{
		exit;
	}

	header ('Content-Type: image/png');
	header ('Cache-control: no-cache, no-store');

	$color = array ('black', 'grey', 'white');
	$image = imagecreatetruecolor (175, 80);

	$color['black'] = imagecolorallocate ($image, 0x00, 0x00, 0x00);
	$color['grey']	= imagecolorallocate ($image, 0x4B, 0x4B, 0x4B);
	$color['white'] = imagecolorallocate ($image, 0xFF, 0xFF, 0xFF);

	imagefill ($image, 0, 0, $color['white']);

	$mt = microtime();
	list ($sec, $msec) = explode (' ', $mt);
	mt_srand ($sec * $msec);

	$confirm_code = array();
	for ( $i = 0; $i < 5; $i++ )
	{
		$x = mt_rand (1, 10);
		$confirm_code[] = ( $x % 2 ) ? chr (mt_rand (48, 57)) : chr (mt_rand (65, 90));
	}

	for ( $i = 0; $i < 10; $i++ )
	{
		imageline ($image, mt_rand (5, 80), mt_rand (5, 75), mt_rand (90, 170), mt_rand (5, 75), imagecolorallocate ($image, mt_rand (200, 255), mt_rand(200, 255), mt_rand(200, 255)));
	}

	$i = 10;
	foreach ( $confirm_code as $letter )
	{
		$rand_size = mt_rand (16, 32);
		$rand_angle= mt_rand (-30, 30);

		imagettftext ($image,
				$rand_size,
				$rand_angle,
				$i, 50,
				imagecolorallocate ($image, mt_rand (145, 230), mt_rand(145, 230), mt_rand(145, 230)),
				FNEWS_ROOT_PATH . 'news/fonts/VeraMono.ttf',
				$letter);
		$i += 30;
	}

	for ( $i = 0; $i < 10; $i++ )
	{
		imageline ($image, mt_rand (5, 80), mt_rand (5, 75), mt_rand (90, 170), mt_rand (5, 75), imagecolorallocate ($image, mt_rand (200, 255), mt_rand(200, 255), mt_rand(200, 255)));
	}

	imagepng ($image);
	imagedestroy ($image);

	$confirm_code = implode ('', $confirm_code);

	$file = file (FNEWS_ROOT_PATH . 'sessions.php');
	array_shift ($file);

	$updated = false;
	$current_time = time();
	$user_ip = get_ip();
	$data = '<?php die (\'' . $error1 . '\'); ?>' . "\n";
	foreach ( $file as $value )
	{
		$session = get_line_data ('sessions', $value);

		if ( $session['session_id'] == $fus_sid )
		{
			continue;
		}

		if ( (($session['last_visit'] + 600) >= $current_time) && ($session['ip'] != $user_ip) )
		{
			$data .= $value;
		}
	}

	$data .= $fus_sid . '|<|' . $confirm_code . '|<|' . $id . '|<|' . $user_ip . '|<|' . $current_time . '|<|' . "\n";
	safe_write ('sessions.php', 'wb', $data);

	exit;
}

ob_start();

echo get_template('com_header.php', true);

if ( !$id )
{
	echo $com10;
	echo get_template('com_footer.php', true);
    
    ob_end_flush();
    
	return;
}

if ( is_ip_banned (get_ip()) )
{
	echo $com3;
    echo get_template('com_header.php', true);
    
    ob_end_flush();
    
	return;
}

if ( !file_exists (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php') )
{
    echo $com11;
    echo get_template('com_footer.php', true);
    
    ob_end_flush();
    
    return;
}

if ( !$action )
{
	$session_id = create_security_id();

	$file = file (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php');
	array_shift ($file);
	$news_info = parse_news_to_view ($file[0]);
	array_shift ($file);

	$fn_page = 1;

	$start = 0;
	$end = sizeof ($file);
	$pagination = '';
	$next_page = '';
	$prev_page = '';
	$qs = clean_query_string();

	if ( $comments_pages && $comments_per_page > 0 )
	{
		$fn_page = ( isset ($VARS['fn_page']) ) ? (int)$VARS['fn_page'] : $fn_page;
		$fn_page = ( $fn_page < 1 ) ? 1 : $fn_page;

		if ( $end == 0 )
		{
			// Slight hack to display the pagination even if there are no
			// comments to display.
			$end = 1;
		}

		for ( $i = 0, $j = 1; $i < $end; $i += $comments_per_page, $j++ )
		{
			if ( !empty ($pagination) )
			{
				$pagination .= '&nbsp;';
			}

			if ( $j != $fn_page )
			{
				$pagination .= '<a href="?fn_mode=comments&amp;fn_id=' . $id . '&amp;fn_page=' . $j . $qs . '">' . $j . '</a>';
			}
			else
			{
				$pagination .= '<b>' . $j . '</b>';
			}
		}

		$prev_page = ( ($fn_page - 1) >= 1 ) ? '<a href="?fn_mode=comments&amp;fn_id=' . $id . '&amp;fn_page=' . ($fn_page - 1) . $qs . '">$1</a>' : '$1';
		$next_page = ( ($fn_page + 1) <= ceil ($end / $comments_per_page) ) ? '<a href="?fn_mode=comments&amp;fn_id=' . $id . '&amp;fn_page=' . ($fn_page + 1) . $qs . '">$1</a>' : '$1';

		$start = $comments_per_page * ($fn_page - 1);
		$end = $start + $comments_per_page;
		$end = ( $end > sizeof ($file) ) ? sizeof ($file) : $end;
	}

	//replace user variables
	$temp_short = get_template ('com_fulltemp.php', true);
	$temp_short .= '<script src="' . $furl . '/jsfunc.js" type="text/javascript"></script>' . "\n";
	$temp_short = replace_masks ($temp_short, array (
		'post_id'		=> $news_info['post_id'],
		'subject'		=> $news_info['subject'],
		'description'	=> $news_info['description'],
		'user'		=> $news_info['writer'],
		'date'		=> $news_info['date'],
		'send'		=> $news_info['link_tell_friend'],
		'news'		=> $news_info['news'],
		'fullstory'		=> $news_info['fullnews'],
		'icon'		=> $news_info['icon'],
		'nrc'			=> $news_info['nrc'],
		'com'			=> $news_info['link_comments'],
		'cat_id'		=> $news_info['cat_id'],
		'cat_name'		=> $news_info['cat_name'],
		'cat_icon'		=> $news_info['cat_icon'],
		'pagination'	=> $pagination
	));

	$temp_short = preg_replace ('#{prev_page\|(.+)}#U', $prev_page, $temp_short);
	$temp_short = preg_replace ('#{next_page\|(.+)}#U', $next_page, $temp_short);

	$count = 0;
	$comment_template = get_template ('com_temp.php', true);
	$comments = '';

	$file = array_reverse ($file);
	foreach ( $file as $comment_data )
	{
		$comment = get_line_data ('comments', $comment_data);

		if ( !$comment['validated'] )
		{
			// Can't use this comment at all
			continue;
		}

		if ( $count < $start || $count >= $end )
		{
			// Valid comment, but not to be displayed on this post.
			$count++;
			continue;
		}

		parse_comments ($comment['message'], $comment['author'], $comment['email']);
		$commenthtml = $comment_template;

		$comments .= replace_masks ($commenthtml, array (
			'poster'	=> $comment['author'],
			'comment'	=> $comment['message'],
			'date'	=> date ($datefor, (int)$comment['timestamp']),
			'posterip'	=> $comment['ip']
		));

		$count++;
	}

	if ( empty ($comments) )
	{
		$comments = $com12;
	}

	$extras = show_extras ('comment_form', 'comment', $smilcom, $bbc);
	$box = $extras . '<textarea id="comment" name="comment" rows="$2" cols="$1"></textarea>';
	$temp_short = str_replace('{comments}', $comments, $temp_short);
	$temp_short = str_replace('[form]', '<form action="?fn_mode=comments&amp;fn_action=post&amp;fn_id=' . $id . $qs . '" method="post" id="comment_form">', $temp_short);
	$temp_short = str_replace('[/form]', '</form>', $temp_short);
	$temp_short = str_replace('[buttons]', '<input type="hidden" name="confirm_id" value="' . $session_id . '" /><input type="submit" id="com_Submit" value="' . $com15 . '" />' . "\n" . '<input type="reset" value="' . $com16 . '" />', $temp_short);

	$comlen = '';
	if ( $comlength <= 0 )
	{
		$temp_short = str_replace('[comlen]', '', $temp_short);
	}
	else
	{
		$comment_too_long = sprintf ($com17, $comlength);
		$comlen .= <<< html
<script type="text/javascript">
//<![CDATA[
document.getElementById('comment').onkeyup = Calcul;
document.getElementById('comment').onkeydown = Calcul;
function Calcul ( e )
{
	var maxchars = $comlength;
	var comment = document.getElementById('comment');
	var comment_length = comment.value.length;
	var characters_left = maxchars - comment_length;

	if ( comment_length > maxchars )
	{
		comment.value = comment.value.substring (0, maxchars);
		characters_left = 0;
		alert("$comment_too_long");
	}

	document.getElementById('chars').value = characters_left;
}
//]]>
</script>
html;
		$temp_short = str_replace('[comlen]', '<input id="chars" name="chars" size="5" value="' . $comlength . '" disabled="disabled" />', $temp_short);
	}

	$temp_short = preg_replace ('/\[pwfld,\s*([0-9]+)\]/i', '<input type="password" size="$1" name="pass" />', $temp_short);
	$temp_short = preg_replace ('/\[namefld,\s*([0-9]+)\]/i', '<input type="text" size="$1" name="name" id="name" />', $temp_short);
	$temp_short = preg_replace ('/\[mailfld,\s*([0-9]+)\]/i', '<input type="text" size="$1" name="email" />', $temp_short);
	$temp_short = preg_replace ('/\[comfld,\s*([0-9]+),\s*([0-9]+)]/i', $box, $temp_short);

	// Image verification
	if ( $com_captcha )
	{
		$temp_short = str_replace ('[securityimg]', '<img src="' . $furl . '/comments.php?fn_id=' . $id . '&amp;fn_action=confirm&amp;fn_sid=' . $session_id . '" alt="CAPTCHA" id="captcha" />', $temp_short);
		$temp_short = str_replace ('[securityfld]', '<input type="text" name="code" size="5" maxlength="5" />', $temp_short);
	}
	else
	{
		$temp_short = str_replace ('[securityimg]', '', $temp_short);
		$temp_short = str_replace ('[securityfld]', '', $temp_short);
	}

	$comlen .= "<script type=\"text/javascript\">\n";
	$comlen .= "//<![CDATA[\n";
	$comlen .= "document.getElementById('com_Submit').onclick = Check;\n";
	$comlen .= "function Check(e)\n";
	$comlen .= "{\n";
	$comlen .= "\tvar msg = document.getElementById('comment');\n";
	$comlen .= "\t\tif ((msg.value.length == 0) || (document.getElementById('name').value.length == 0)) {\n";
	$comlen .= "\t\t\talert(\"$com18\");\n";
	$comlen .= "\t\t\treturn false;\n";
	$comlen .= "\t}\n";
	$comlen .= "\telse {\n";
	if ( $comlength > 0)
	{
		$comlen .= 'if (msg.value.length > ' . $comlength . ') document.getElementById(\'comment\').value = msg.value.substring(0, ' . $comlength . ');';
	}
	$comlen .= "\t\treturn true;\n";
	$comlen .= "\t}\n";
	$comlen .= "}\n";
	$comlen .= "//]]>\n";
	$comlen .= "</script>\n";

	$temp_short .= $comlen;
	echo $temp_short;
}
//---------------

//Post Comment
elseif ( $action == 'post' )
{  /*id Post comment*/
	$comment	= ( isset ($VARS['comment']) ) ? trim ($VARS['comment']) : '';
	$name		= ( isset ($VARS['name']) ) ? trim(substr( $VARS["name"], 0, 40)) : '';
	$email	= ( isset ($VARS['email']) ) ? $VARS['email'] : '';
	$pass		= ( isset ($VARS['pass']) ) ? trim (substr ($VARS['pass'], 0, 40)) : '';
	$code		= ( isset ($VARS['code']) ) ? $VARS['code'] : '';
	$confirm_id	= ( isset ($VARS['confirm_id']) ) ? $VARS['confirm_id'] : '';

	if ( $com_captcha && !check_security_code ($code, $confirm_id, $id) )
	{
		echo $com13;
	}
	else if ( !$name || !$comment )
	{
		echo $com1;
	}
	else if ( $comlength > 0 && strlen ($comment) > $comlength )
	{
		printf ($com14, $comlength);
	}
	else if ( !is_valid_email ($email) && $email != '' )
	{
		echo $com2;
	}
	elseif ( is_flooding() )
	{
		echo $com4 . ' ' . $floodtime . ' ' . $com5;
	}
	else
	{
		$news_user = false;
		$passok = false;

		$file = file (FNEWS_ROOT_PATH . 'users.php');
		array_shift ($file);

		$passhash = md5 ($pass);

		foreach ( $file as $value )
		{
			$user = get_line_data ('users', $value);
			if ( $name == $user['username'] || $name == $user['nickname'] )
			{
				$news_user = true;
				if ( $passhash == $user['passwordhash'] )
				{
					$name = $user['nickname'];
					$passok = true;
					if ( !$email )
					{
						$femail = explode ('=', $user['email']);
						if ( $femail[0] )
						{
							$email = $femail[1];
						}
					}
				}

				break;
			}
		}

		if ( $passok == $news_user )
		{
			$ip = get_ip();

			if ( $comallowbr )
			{
				$comment = str_replace ("\n", '&br;', $comment);
			}
			else
			{
				$comment = str_replace ("\n", '&nbsp;', $comment);
			}

			$comment = str_replace("\r", '', $comment);

			$time = time();
			mt_srand ((double)microtime() * 1000000);
			$random = 'com' . mt_rand();

			$file = file (FNEWS_ROOT_PATH . 'news/news.' . $id . '.php');
			$file[count($file)] = $ip . '|<|' . (($com_validation && !$news_user) ? 0 : 1) . '|<|' . $comment . '|<|' . $name . '|<|' . $email . '|<|' . $time . '|<|' . $random . '|<|' . "\n";

			$article = get_line_data ('news', $file[1]);

			if ( !$com_validation || $news_user )
			{
				++$article['numcomments'];
			}

			$file[1] = implode ('|<|', $article) . '|<|' . "\n";
			$data = implode ('', $file);

			safe_write ('news/news.' . $id . '.php', 'wb', $data);
			safe_write ('flood.php', 'ab', $ip . '|<|' . $time . '|<|' . "\n");

			echo <<< html
<script type="text/javascript">
//<![CDATA[
setTimeout ('window.location="{$_SERVER['HTTP_REFERER']}"', 3000);
//]]>
</script>
html;

			if ( $com_validation && !$news_user )
			{
				echo $com6a;
			}
			else
			{
				echo $com6 . ' <a href="' . $_SERVER['HTTP_REFERER'] . '">' . $com7 . '</a>';
			}
		}
		else
		{
			echo $com8;
		}
	}
}

echo get_template('com_footer.php', true);

ob_end_flush();

?>
