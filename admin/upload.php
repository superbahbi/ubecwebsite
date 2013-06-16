<?php

/**
 * Image uploads dialog page
 *
 * @package FusionNews
 * @copyright (c) 2006 - 2009, FusionNews.net
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL 3.0 License
 * @version $Id: upload.php 287 2009-09-19 20:48:49Z xycaleth $
 */

include './common.php';

$id = ( !isset ($VARS['id']) ) ? '' : $VARS['id'];
$sid = ( isset ($_COOKIE['fus_sid']) ) ? $_COOKIE['fus_sid'] : '';
$uid = ( isset ($_COOKIE['fus_uid']) ) ? $_COOKIE['fus_uid'] : '';

$userdata = array();
$userdata = login_session_update ($uid, $sid);

if ( !has_access (NEWS_REPORTER) )
{
	echo $ind148;
	exit;
}

if ( !$uploads_active )
{
	echo $upld1;
	exit;
}

if ( strtolower (@ini_get ('file_uploads')) == 'off' || @ini_get ('file_uploads') == 0 || @ini_get ('file_uploads') == '' )
{
	echo
<<< html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>$upld3</title>
    
	<style type="text/css">
	<!--
	body { font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 100% }
	-->
	</style>
</head>

<body>$upld2</body>

</html>
html;
	exit;
}

$title = '';
$content = '';

if ( !$id || $id == '' )
{
	$title = $upld3;
	$maximum_filesize = calc_size ($uploads_size);

	$content =
<<< html
<ul>
	<li>$upld11 <b>{$furl}/uploads</b>.</li>
	<li>$upld12 {$uploads_ext}.</li>
	<li>$upld13 {$maximum_filesize}.</li>
</ul>
<form method="post" enctype="multipart/form-data" action="?id=upload">
<fieldset>
	<legend>$upld3</legend>
	<div>
        <input type="hidden" name="MAX_FILE_SIZE" value="$uploads_size" />
    
		<label for="F0">$upld14 1</label><br />
        <input type="file" name="F[]" id="F0" size="50" /><br />
        
		<label for="F1">$upld14 2</label><br />
        <input type="file" name="F[]" id="F1" size="50" /><br />
        
		<label for="F2">$upld14 3</label><br />
        <input type="file" name="F[]" id="F2" size="50" /><br />
        
		<label for="F3">$upld14 4</label><br />
        <input type="file" name="F[]" id="F3" size="50" /><br />
        
		<label for="F4">$upld14 5</label><br />
        <input type="file" name="F[]" id="F4" size="50" /><br /><br />

		<input type="submit" class="mainoption" value="$ind270" />
	</div>
</fieldset>
</form>
html;
}
else if ( $id == 'upload' )
{
	$title = $upld3;

	$files_uploaded_list = '';
	$freq_count = array_count_values ($_FILES['F']['error']);

	if ( isset ($freq_count[UPLOAD_ERR_NO_FILE]) &&
		$freq_count[UPLOAD_ERR_NO_FILE] >= sizeof ($_FILES['F']['error']) )
	{
		$content = $upld10;
	}
	else
	{
		foreach ( $_FILES['F']['name'] as $key => $name )
		{
			if ( $_FILES['F']['error'][$key] == UPLOAD_ERR_NO_FILE )
			{
				continue;
			}
            
            if ( !@getimagesize ($_FILES['F']['tmp_name'][$key]) )
            {
                $files_uploaded_list .= "<li>$name is not a valid image file.</li>";
            }
            else
            {
                $files_uploaded_list .= '<li>' . upload_file ($key, $uploads_ext) . '</li>';
            }
		}

		$content = <<< html
<p>$ind262</p>
<ol>
	$files_uploaded_list
</ol>
<p><a href="?">$upld4</a></p>
html;
	}
}
else if ( $id == 'imagelist' )
{
	$title = $upld4;
	$content = <<< html
<p><a href="?id=imagelist">$upld5</a></p>
<table class="data">
	<tr>
		<th style="width:35%">$upld6</th>
		<th style="width:65%">$ind226</th>
	</tr>
html;

	$dir = @opendir ('./uploads');
	if ( $dir !== false )
	{
		$valid_extensions = str_replace ('&#124;', '|', $uploads_ext);
		$has_images = false;
		while ( ($file = readdir ($dir)) !== false )
		{
			if ( $file == '.' || $file == '..' )
			{
				continue;
			}

			if ( !preg_match ('#^.+\.' . $valid_extensions . '$#i', strtolower ($file)) )
			{
				continue;
			}

			$has_images = true;

			$image_info = getimagesize ('./uploads/' . $file);
			$image_width = 400;
			$image_height = 400;

			if ( $image_info !== false )
			{
				$image_width = $image_info[0] + 50;
				$image_height = $image_info[1] + 50;
			}

			if ( $image_width > 800 )
			{
				$image_width = 800;
			}

			if ( $image_height > 800 )
			{
				$image_height = 800;
			}

			$content .= <<< html
	<tr>
		<td>[<a href="#" onclick="window.opener.document.getElementById('newsposting').news.value += ' [img]{$furl}/uploads/{$file}[/img] ';">$upld7</a>]&nbsp;[<a href="#" onclick="javascript:opener.document.forms['newsposting'].fullnews.value  += ' [img]{$furl}/uploads/{$file}[/img] ';">$upld8</a>]</td>
		<td><a href="#" onclick="javascript:window_pop ('{$furl}/uploads/{$file}', 'image_preview_{$file}', $image_width, $image_height)">$file</a></td>
	</tr>

html;
		}

		closedir ($dir);

		if ( !$has_images )
		{
			$content .= <<< html
	<tr>
		<td colspan="2" style="text-align:center">$ind300</td>
	</tr>
html;
		}
	}
	else
	{
		$content .= <<< html
	<tr>
		<td colspan="2" style="text-align:center">$upld9</td>
	</tr>
html;
	}

	$content .= <<< html
</table>
html;
}

$curve = FNEWS_CURVE;

echo
<<< html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>$upld3</title>	
	<style type="text/css">
	<!--
    * { margin:0px; padding:0px }
    
	body { margin: 5px; font-size: 100% }
	body, td, input { color: #2D617D; font-family: "Trebuchet MS", Helvetica, sans-serif }
	input { background-color: #EFFFEF; border: 1px solid #A5B8C0; padding: 3px }
    input[type="submit"] { font-weight: bold }
    input[type="file"] { width: 100% }
    
	label { cursor:hand }
    
    fieldset { padding: 5px; border: 1px solid #000 }
	fieldset div { margin: 0 auto; width: 75% }

	h1 { font-size: 1.5em }

	a { color: #2D617D }
	a:hover { color: #22495E; text-decoration: none }
    
    ul { margin: 10px 0px }

	#wrapper { margin: 0 auto; text-align: left; width: 95% }

	table.data { border-collapse:collapse; width:100% }
    table.data th { text-align: left }
	table.data td, table.data th { border-bottom: 1px solid #999; padding:2px }
	-->
	</style>

	<script type="text/javascript" src="./jsfunc.js"></script>
</head>

<body>
<div id="wrapper">
<h1>$title</h1>
$content
</div>
</body>

</html>
html;

?>
