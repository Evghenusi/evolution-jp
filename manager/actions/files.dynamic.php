<?php
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') exit();
if(!$modx->hasPermission('file_manager')) {
	$e->setError(3);
	$e->dumpError();
}

function getToken()
{
	if(isset($_POST['token']))    $token = $_POST['token'];
	elseif(isset($_GET['token'])) $token = $_GET['token'];
	else                          $token = '';
	return $token;
}
function checkToken($token='')
{
	if(empty($token)) $token = getToken();
	
	if   (!isset($_SESSION['token']))   $rs = false;
	elseif(empty($_SESSION['token']))   $rs = false;
	elseif($_SESSION['token']===$token) $rs = true;
	else                                $rs = false;
	$_SESSION['token'] = '';
	return $rs;
}
function initToken()
{
	$token = uniqid('');
	$_SESSION['token'] = $token;
	return $token;
}
$token_check = checkToken();
$token = initToken();

// settings
$excludes = array('.', '..', '.svn');
$alias_suffix = (!empty($friendly_url_suffix)) ? ','.ltrim($friendly_url_suffix,'.') : '';
$editablefiles       = explode(',', 'txt,php,shtml,html,htm,xml,js,css,pageCache,htaccess'.$alias_suffix);
$inlineviewablefiles = explode(',', 'txt,php,html,htm,xml,js,css,pageCache,htaccess'.$alias_suffix);
$viewablefiles       = explode(',', 'jpg,gif,png,ico');

$editablefiles       = add_dot($editablefiles);
$inlineviewablefiles = add_dot($inlineviewablefiles);
$viewablefiles       = add_dot($viewablefiles);

$proteted_path[] = $modx->config['base_path'] . 'manager';
$proteted_path[] = $modx->config['base_path'] . 'temp/backup';
$proteted_path[] = $modx->config['base_path'] . 'assets/backup';

if(!$modx->hasPermission('save_plugin'))   $proteted_path[] = $modx->config['base_path'] . 'assets/plugins';
if(!$modx->hasPermission('save_snippet'))  $proteted_path[] = $modx->config['base_path'] . 'assets/snippets';
if(!$modx->hasPermission('save_template')) $proteted_path[] = $modx->config['base_path'] . 'assets/templates';
if(!$modx->hasPermission('save_module'))   $proteted_path[] = $modx->config['base_path'] . 'assets/modules';
if(!$modx->hasPermission('empty_cache'))   $proteted_path[] = $modx->config['base_path'] . 'assets/cache';
if(!$modx->hasPermission('import_static')) {
	$proteted_path[] = $modx->config['base_path'] . 'temp/import';
	$proteted_path[] = $modx->config['base_path'] . 'assets/import';
}
if(!$modx->hasPermission('export_static')) {
	$proteted_path[] = $modx->config['base_path'] . 'temp/export';
	$proteted_path[] = $modx->config['base_path'] . 'assets/export';
}

// Mod added by Raymond
$enablefileunzip = true;
$enablefiledownload = true;
$newfolderaccessmode = $new_folder_permissions ? octdec($new_folder_permissions) : 0777;
$new_file_permissions = $new_file_permissions ? octdec($new_file_permissions) : 0666;
// End Mod -  by Raymond
// make arrays from the file upload settings
$upload_files = explode(',',$upload_files);
$upload_images = explode(',',$upload_images);
$upload_media = explode(',',$upload_media);
$upload_flash = explode(',',$upload_flash);
// now merge them
$uploadablefiles = array_merge($upload_files,$upload_images,$upload_media,$upload_flash);
$uploadablefiles = add_dot($uploadablefiles);
function add_dot($array)
{
	$count = count($array);
	for($i=0; $i<$count; $i++) {
		$array[$i] = '.'.strtolower(trim($array[$i])); // add a dot :)
	}
	return $array;
}
// end settings

// get the current work directory
if(isset($_REQUEST['path']) && !empty($_REQUEST['path'])) {
        $_REQUEST['path'] = str_replace('..','',$_REQUEST['path']);
	$startpath = is_dir($_REQUEST['path']) ? $_REQUEST['path'] : removeLastPath($_REQUEST['path']) ;
} else {
	$startpath = $filemanager_path;
}
$startpath = rtrim($startpath,'/');

// Raymond: get web start path for showing pictures
$rf = realpath($filemanager_path);
$rw = realpath('../');
$webstart_path = str_replace('\\','/',str_replace($rw,'',$rf));
if(substr($webstart_path,0,1)=='/') $webstart_path = '..'.$webstart_path;
else $webstart_path = '../'.$webstart_path;

?>
<style type="text/css">
.warning {color:#c00;}
</style>
<h1><?php echo $_lang['manage_files']?></h1>

<div id="actions">
  <ul class="actionButtons">
<?php
if(isset($_GET['mode'])&&$_GET['mode']!=='drill') $href= 'a=31&path=' . urlencode($_REQUEST['path']);
else $href='a=2';
?>
      <li id="Button5"><a href="#" onclick="documentDirty=false;document.location.href='index.php?<?php echo $href;?>';"><img alt="icons_cancel" src="<?php echo $_style["icons_cancel"] ?>" /> <?php echo $_lang['cancel']?></a></li>
  </ul>
</div>

<div class="sectionBody">
<script type="text/javascript">
var current_path = '<?php echo $startpath;?>';

function viewfile(url) {
	document.getElementById('imageviewer').style.border="1px solid #ccc";
	document.getElementById('imageviewer').src=url;
}

function setColor(o,state){
	if (!o) return;
	if(state && o.style) o.style.backgroundColor='#eeeeee';
	else if (o.style) o.style.backgroundColor='transparent';
}

function confirmDelete() {
	return confirm("<?php echo $_lang['confirm_delete_file'] ?>");
}

function confirmDeleteFolder(status) {
	if(status!='file_exists')
		return confirm("<?php echo $_lang['confirm_delete_dir']; ?>");
	else
		return confirm("<?php echo $_lang['confirm_delete_dir_recursive']; ?>");
}

function confirmUnzip() {
	return confirm("<?php echo $_lang['confirm_unzip_file'] ?>");
}

function getFolderName(a){
	var f;
	f=window.prompt('Enter New Folder Name:','')
	if (f) a.href+=escape(f);
	return (f) ? true:false;
}

function getFileName(a){
	var f;
	f=window.prompt('Enter New File Name:','')
	if (f) a.href+=escape(f);
	return (f) ? true:false;
}

function deleteFolder (folder,status) {
    if (confirmDeleteFolder(status))
    {
        window.location.href="index.php?a=31&mode=deletefolder&path="+current_path+"&folderpath="+current_path+'/'+folder+"&token=<?php echo $token;?>";
        return false;
    }
}

function deleteFile(file) {
    if (confirmDelete())
    {
        window.location.href="index.php?a=31&mode=delete&path="+current_path+'/'+file+"&token=<?php echo $token;?>";
        return false;
    }
}
</script>
<?php
if (is_writable($startpath))
{
	$ph = array();
	$ph['style_path'] = $style_path;
	$tpl = '<li><a href="[+href+]" onclick="return getFolderName(this);"><img src="[+style_path+]tree/[+image+]" alt="" /> [+subject+]</a></li>';
	$ph['image']   = 'folder.gif';
	$ph['subject'] = $_lang['add_folder'];
	$ph['href'] = 'index.php?a=31&mode=newfolder&path='.urlencode($startpath).'&name=';
	$_ = $modx->parsePlaceholder($tpl,$ph);
	
	$tpl = '<li><a href="[+href+]" onclick="return getFileName(this);"><img src="[+style_path+]tree/[+image+]" alt="" /> ' . $_lang['files.dynamic.php1'] . '</a></li>';
	$ph['image']   = 'page-html.gif';
	$ph['href'] = 'index.php?a=31&mode=newfile&path='.urlencode($startpath).'&name=';
	$_ .=  $modx->parsePlaceholder($tpl,$ph);
	echo '<ul class="actionButtons">' . $_ . '</ul>';
}


if(!empty($_FILES['userfile']))
{
	if(!empty($_FILES['userfile']['tmp_name']))
	{
		$userfile['tmp_name'] = $_FILES['userfile']['tmp_name'];
		$userfile['error']    = $_FILES['userfile']['error'];
		$name = $_FILES['userfile']['name'];
		if($modx->config['clean_uploaded_filename']==1)
		{
			$nameparts = explode('.', $name);
			$nameparts = array_map(array($modx, 'stripAlias'), $nameparts,'file_manager');
			$name = implode('.', $nameparts);
		}
		$userfile['name'] = $name;
		$userfile['type'] = $_FILES['userfile']['type'];
	}
	
	// this seems to be an upload action.
	printf("<p>".$_lang['files_uploading']."</p>", $userfile['name'], substr($startpath, strlen($filemanager_path), strlen($startpath)));
	if($userfile['error']==0)
	{
		echo "<p>".$_lang['files_file_type'].$userfile['type'].", ".$modx->nicesize($userfile['tmp_name']).'</p>';
	}
	
	$userfilename = $userfile['tmp_name'];
	
	if (is_uploaded_file($userfilename))
	{
		// file is uploaded file, process it!
		if(!in_array(getExtension($userfile['name']), $uploadablefiles))
		{
			echo '<p><span class="warning">'.$_lang['files_filetype_notok'].'</span></p>';
		}
		else
		{
			if(@move_uploaded_file($userfile['tmp_name'], $_POST['path'].'/'.$userfile['name']))
			{
				// Ryan: Repair broken permissions issue with file manager
				if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN')
					@chmod($_POST['path']."/".$userfile['name'], $new_file_permissions);
				// Ryan: End
				echo '<p><span class="success">'.$_lang['files_upload_ok'].'</span></p>';
				
				// invoke OnFileManagerUpload event
				$modx->invokeEvent('OnFileManagerUpload',
				array(
				'filepath'	=> $_POST['path'],
				'filename'	=> $userfile['name']
				));
				// Log the change
				logFileChange('upload', $_POST['path'].'/'.$userfile['name']);
			}
			else
			{
				echo '<p><span class="warning">'.$_lang['files_upload_copyfailed'].'</span> '.$_lang["files_upload_permissions_error"].'</p>';
			}
		}
	}
	else
	{
		echo '<br /><span class="warning"><b>'.$_lang['files_upload_error'].':</b>';
		switch($userfile['error'])
		{
			case 0: //no error; possible file attack!
				echo $_lang['files_upload_error0'];
				break;
			case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
				echo $_lang['files_upload_error1'];
				break;
			case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
				echo $_lang['files_upload_error2'];
				break;
			case 3: //uploaded file was only partially uploaded
				echo $_lang['files_upload_error3'];
				break;
			case 4: //no file was uploaded
				echo $_lang['files_upload_error4'];
				break;
			default: //a default error, just in case!  :)
				echo $_lang['files_upload_error5'];
				break;
		}
		echo '</span><br />';
	}
	echo '<hr/>';
}

if($_POST['mode']=='save')
{
	echo $_lang['editing_file'];
	$filename = $_POST['path'];
	$content  = $_POST['content'];

	// Write $content to our opened file.
	if (file_put_contents($filename, $content) === FALSE)
	{
		echo '<span class="warning"><b>'.$_lang['file_not_saved'].'</b></span><br /><br />';
	}
	else
	{
		echo '<span class="success"><b>'.$_lang['file_saved'].'</b></span><br /><br />';
		$_REQUEST['mode'] = 'edit';
	}
	// Log the change
	logFileChange('modify', $filename);
}


if($_REQUEST['mode']=='delete')
{
	printf($_lang['deleting_file'], str_replace('\\', '/', $_REQUEST['path']));
	$file = $_REQUEST['path'];
	if(!$token_check)
	{
		echo '<span class="warning"><b>'.$_lang['file_not_deleted'].'</b></span><br /><br />';
	}
	elseif(!@unlink($file))
	{
		echo '<span class="warning"><b>'.$_lang['file_not_deleted'].'</b></span><br /><br />';
	}
	else
	{
		echo '<span class="success"><b>'.$_lang['file_deleted'].'</b></span><br /><br />';
	}

	// Log the change
	logFileChange('delete', $file);
}

if(in_array($startpath,$proteted_path))
{
	echo $_lang['files.dynamic.php2'];
	exit;
}

$tpl = '<img src="[+style_path+]tree/[+image+]" align="absmiddle" alt="" />[+subject+] ';
$ph = array();
$ph['style_path'] = $style_path;
// To Top Level with folder icon to the left
if($startpath==$filemanager_path || $startpath.'/' == $filemanager_path)
{
	$ph['image']   = 'deletedfolder.gif';
	$ph['subject'] = '<span style="color:#bbb;cursor:default;">Top</span>';
}
else
{
	$ph['image']   = 'folder.gif';
	$ph['subject'] = '<a href="index.php?a=31&mode=drill&path=' . $filemanager_path . '">Top</b></a> / ';
}
echo $modx->parsePlaceholder($tpl,$ph);

$len = strlen($filemanager_path);
if(substr($startpath, $len, strlen($startpath))=='')
	$topic_path = '/';
else
{
	$topic_path = substr($startpath, $len, strlen($startpath));
	$pieces = explode('/',rtrim($topic_path,'/'));
	$path = '';
	$count = count($pieces);
	foreach($pieces as $i=>$v)
	{
		if(empty($v)) continue;
		$path .=  rtrim($v,'/') . '/';
		if(1<$count)
		{
			$href = 'index.php?a=31&mode=drill&path=' . urlencode($filemanager_path.$path);
			$pieces[$i] = '<a href="' . $href . '">' . trim($v,'/') . '</a>';
		}
		else $pieces[$i] = trim($v,'/');
		$count--;
	}
	$topic_path = join(' / ', $pieces);
}

?> <b><?php echo $topic_path; ?></b>
<?php
// check to see user isn't trying to move below the document_root
if(substr(strtolower(str_replace('//','/',$startpath."/")), 0, $len)!=strtolower(str_replace('//','/',$filemanager_path.'/'))) {
	echo $_lang['files_access_denied']?>
</div>

<?php
	exit;
}

// Unzip .zip files - by Raymond
if ($enablefileunzip && $_REQUEST['mode']=='unzip' && is_writable($startpath))
{
	if(!$err=@unzip(realpath("{$startpath}/".$_REQUEST['file']),realpath($startpath)))
	{
		echo '<span class="warning"><b>'.$_lang['file_unzip_fail'].($err===0? 'Missing zip library (php_zip.dll / zip.so)':'').'</b></span><br /><br />';
	}
	else
	{
		echo '<span class="success"><b>'.$_lang['file_unzip'].'</b></span><br /><br />';
	}
}
// End Unzip - Raymond


// New Folder & Delete Folder option - Raymond
if (is_writable($startpath))
{
	// Delete Folder
	if($_REQUEST['mode']=='deletefolder')
	{
		$folder = $_REQUEST['folderpath'];
		if(!$token_check)
		{
		   echo '<span class="warning"><b>'.$_lang['file_folder_not_deleted'].'</b></span><br /><br />';
		}
		elseif(!@rrmdir($folder))
		{
			echo '<span class="warning"><b>'.$_lang['file_folder_not_deleted'].'</b></span><br /><br />';
		}
		else
		{
			echo '<span class="success"><b>'.$_lang['file_folder_deleted'].'</b></span><br /><br />';
		}
	}

	// Create folder here
	if($_REQUEST['mode']=='newfolder')
	{
		$old_umask = umask(0);
		$foldername = str_replace('..\\','',str_replace('../','',$_REQUEST['name']));
		if(!mkdirs("{$startpath}/{$foldername}",0777))
		{
			echo '<span class="warning"><b>',$_lang['file_folder_not_created'],'</b></span><br /><br />';
		}
		else
		{
			if (!@chmod($startpath.'/'.$foldername,$newfolderaccessmode))
			{
				echo '<span class="warning"><b>'.$_lang['file_folder_chmod_error'].'</b></span><br /><br />';
			}
			else
			{
				echo '<span class="success"><b>'.$_lang['file_folder_created'].'</b></span><br /><br />';
			}
		}
		umask($old_umask);
	}
	// Create file here
	if($_REQUEST['mode']=='newfile')
	{
		$old_umask = umask(0);
		$filename = str_replace('..\\','',str_replace('../','',$_REQUEST['name']));
		$filename = $modx->db->escape($filename);
		
		if(!in_array(getExtension($filename), $uploadablefiles))
		{
			echo '<span class="warning"><b>'.$_lang['files_filetype_notok'].'</b></span><br /><br />';
		}
		elseif(preg_match('@(\\\\|\/|\:|\;|\,|\*|\?|\"|\<|\>|\||\?)@',$filename)!==0)
		{
			echo $_lang['files.dynamic.php3'];
		}
		else
		{
			$rs = file_put_contents("{$startpath}/{$filename}",'');
			if($rs===false)
			{
				echo '<span class="warning"><b>',$_lang['file_folder_not_created'],'</b></span><br /><br />';
			}
			else
			{
				echo $_lang['files.dynamic.php4'];
			}
			umask($old_umask);
		}
	}
}
// End New Folder - Raymond

$filesize = 0;
$files = 0;
$folders = 0;
$dirs_array = array();
$files_array = array();
if(strlen(MODX_BASE_PATH) < strlen($filemanager_path)) $len--;

echo '<br />';
?>
<table>
<tr>
<td style="width:300px;"><b><?php echo $_lang['files_filename']?></b></td>
<td><b><?php echo $_lang['files_modified']?></b></td>
<td><b><?php echo $_lang['files_filesize']?></b></td>
<td><b><?php echo $_lang['files_fileoptions']?></b></td>
</tr>
<?php
ls($startpath);
echo "\n\n\n";
if($folders==0 && $files==0) {
	echo '<tr><td colspan="4"><img src="' . $style_path . 'tree/deletedfolder.gif" /><span style="color:#888;cursor:default;"> This directory is empty.</span></td></tr>';
}
?></table>
<hr />
<?php

echo $_lang['files_directories'],': <b>',$folders,'</b> ';
echo $_lang['files_files'],': <b>',$files,'</b> ';
echo $_lang['files_data'],': <b><span dir="ltr">',$modx->nicesize($filesizes),'</span></b> ';
echo $_lang['files_dirwritable'],' <b>',is_writable($startpath)==1 ? $_lang['yes'].'.' : $_lang['no'].'.'
?></b>
<div>
<img src="<?php echo $_style['tx']; ?>" id="imageviewer" />
</div>

<?php
if (((@ini_get("file_uploads") == true) || get_cfg_var("file_uploads") == 1) && is_writable($startpath)) {
	@ini_set("upload_max_filesize", $upload_maxsize); // modified by raymond
?>

<form name="upload" enctype="multipart/form-data" action="index.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo isset($upload_maxsize)? $upload_maxsize:3145728; ?>">
<input type="hidden" name="a" value="31">
<input type="hidden" name="path" value="<?php echo $startpath?>">

<div id="uploader" class="actionButtons" style="margin-top:10px;">
<input type="file" name="userfile" onchange="document.upload.submit();">
<a href="#" onclick="document.upload.submit()" style="display:inline;float:none;"><?php echo '<img src="' . $_style['icons_add'] . '" /> '; echo $_lang['files_uploadfile'];?></a>
<input type="submit" value="<?php echo $_lang['files_uploadfile']?>" style="display:none;">
</div>
</form>
<?php
} else {
	echo "<p>".$_lang['files_upload_inhibited_msg']."</p>";
}

?>


</div>

<?php

if($_REQUEST['mode']=="edit" || $_REQUEST['mode']=="view") {
?>

<div class="sectionHeader" id="file_editfile"><?php echo $_REQUEST['mode']=="edit" ? $_lang['files_editfile'] : $_lang['files_viewfile']?></div>
<div class="sectionBody">
<?php
$filename=$_REQUEST['path'];
$buffer = file_get_contents($filename);
// Log the change
logFileChange('view', $filename);
if($buffer===false) {
	echo 'Error opening file for reading.';
	exit;
}

?>
<?php

if($_REQUEST['mode']=="edit") {
?>
<ul class="actionButtons">
	<li><a href="#" onclick="document.editFile.submit();"><img src="<?php echo $_style["icons_save"] ?>" /> <?php echo $_lang['save']?></a></li>
	<li><a href="index.php?a=31&path=<?php echo urlencode($_REQUEST['path'])?>"><img src="<?php echo $_style["icons_cancel"] ?>" /> <?php echo $_lang['cancel']?></a></li>
</ul>
<?php } ?>
<form action="index.php" method="post" name="editFile">
<input type="hidden" name="a" value="31" />
<input type="hidden" name="mode" value="save" />
<input type="hidden" name="path" value="<?php echo $_REQUEST['path']?>" />
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><textarea dir="ltr" style="width:100%; height:370px;" name="content" class="phptextarea"><?php echo htmlentities($buffer,ENT_COMPAT,$modx_manager_charset)?></textarea></td>
  </tr>
</table>
</form>
</div>
<?php
}

function ls($curpath)
{
	global $_lang,$style_path,$_style;
	global $excludes, $proteted_path, $editablefiles, $inlineviewablefiles, $viewablefiles, $enablefileunzip, $enablefiledownload, $uploadablefiles, $folders, $files, $filesizes, $len, $dirs_array, $files_array, $webstart_path, $modx;
	$dircounter = 0;
	$filecounter = 0;
	$curpath = str_replace('//','/',$curpath.'/');

	if (!is_dir($curpath))
	{
		echo 'Invalid path "',$curpath,'"<br />';
		return;
	}
	$dir = dir($curpath);

	// first, get info
	while ($file = $dir->read())
	{
		$newpath = $curpath.$file;
		if($file==='..'||$file==='.') continue;
		if(is_dir($newpath))
		{
			$dirs_array[$dircounter]['dir'] = $newpath;
			$dirs_array[$dircounter]['stats'] = lstat($newpath);
			if($file==='..'||$file==='.') continue;
			elseif(!in_array($file, $excludes) && !in_array($newpath,$proteted_path))
			{
				$dirs_array[$dircounter]['text'] = '<img src="' . $style_path.'tree/folder.gif" align="absmiddle" alt="" /> <a href="index.php?a=31&mode=drill&path='.urlencode($newpath).'"><b>'.$file.'</b></a>';
				
				$dfiles = scandir($newpath);
				foreach($dfiles as $i=>$infile)
				{
					switch($infile)
					{
						case '..':
						case '.':
							unset($dfiles[$i]);
							break;
					}
				}
				$file_exists = (0<count($dfiles)) ? 'file_exists' : '';
				
				$dirs_array[$dircounter]['delete'] = is_writable($curpath) ? '<span style="width:20px"><a href="javascript: deleteFolder(\''.urlencode($file).'\',\'' . $file_exists . '\');"><img src="'.$style_path.'icons/delete.gif" alt="'.$_lang['file_delete_folder'].'" title="'.$_lang['file_delete_folder'].'" /></a></span>' : '';
			}
			else
			{
				$dirs_array[$dircounter]['text'] = '<img src="'.$style_path.'tree/deletedfolder.gif" align="absmiddle" alt="" /> <span style="color:#bbb;">'.$file . '</span>';
				$dirs_array[$dircounter]['delete'] = is_writable($curpath) ? '<span style="width:20px" class="disabledImage"><img src="'.$style_path.'icons/delete.gif" alt="'.$_lang['file_delete_folder'].'" title="'.$_lang['file_delete_folder'].'" /></span>' : '';
			}

			// increment the counter
			$dircounter++;
		}
		else
		{
			$type=getExtension($newpath);
			$files_array[$filecounter]['file'] = $newpath;
			$files_array[$filecounter]['stats'] = lstat($newpath);
			$files_array[$filecounter]['text'] = '<img src="'.$style_path.'tree/page-html.gif" align="absmiddle" alt="" />'.$file;
			$files_array[$filecounter]['view'] = (in_array($type, $viewablefiles)) ?
			'<span style="cursor:pointer; width:20px;" onclick="viewfile(\''.$webstart_path.substr($newpath, $len, strlen($newpath)).'\');"><img src="'.$style_path.'icons/context_view.gif" align="absmiddle" alt="'.$_lang['files_viewfile'].'" title="'.$_lang['files_viewfile'].'" /></span> ' : (($enablefiledownload && in_array($type, $uploadablefiles))? '<a href="'.$webstart_path.implode('/', array_map('rawurlencode', explode('/', substr($newpath, $len, strlen($newpath))))).'" style="cursor:pointer; width:20px;"><img src="'.$style_path . 'misc/ed_save.gif" align="absmiddle" alt="'.$_lang['file_download_file'].'" title="'.$_lang['file_download_file'].'" /></a> ':'<span class="disabledImage"><img src="'.$style_path . 'icons/context_view.gif" align="absmiddle" alt="'.$_lang['files_viewfile'].'" title="'.$_lang['files_viewfile'].'" /></span> ');
			$files_array[$filecounter]['view'] = (in_array($type, $inlineviewablefiles)) ? '<span style="width:20px;"><a href="index.php?a=31&mode=view&path='.urlencode($newpath).'"><img src="'.$style_path . 'icons/context_view.gif" align="absmiddle" alt="'.$_lang['files_viewfile'].'" title="'.$_lang['files_viewfile'].'" /></a></span> ' : $files_array[$filecounter]['view'] ;
			$files_array[$filecounter]['unzip'] = ($enablefileunzip && $type=='.zip') ? '<span style="width:20px;"><a href="index.php?a=31&mode=unzip&path='.$curpath.'&file='.urlencode($file).'" onclick="return confirmUnzip();"><img src="'.$style_path . 'icons/unzip.gif" align="absmiddle" alt="'.$_lang['file_download_unzip'].'" title="'.$_lang['file_download_unzip'].'" /></a></span> ' : '' ;
			$files_array[$filecounter]['edit'] = (in_array($type, $editablefiles) && is_writable($curpath) && is_writable($newpath)) ? '<span style="width:20px;"><a href="index.php?a=31&mode=edit&path='.urlencode($newpath).'#file_editfile"><img src="'.$_style['icons_edit_document'] . '" align="absmiddle" alt="'.$_lang['files_editfile'].'" title="'.$_lang['files_editfile'].'" /></a></span> ' : '<span class="disabledImage"><img src="'.$_style['icons_edit_document'] . '" align="absmiddle" alt="'.$_lang['files_editfile'].'" title="'.$_lang['files_editfile'].'" /></span> ';
            $files_array[$filecounter]['delete'] = is_writable($curpath) && is_writable($newpath) ? '<span style="width:20px;"><a href="javascript:deleteFile(\''.urlencode($file).'\');"><img src="'.$style_path . 'icons/delete.gif" align="absmiddle" alt="'.$_lang['file_delete_file'].'" title="'.$_lang['file_delete_file'].'" /></a></span> ' : '<span class="disabledImage"><img src="'.$style_path . 'icons/delete.gif" align="absmiddle" alt="'.$_lang['file_delete_file'].'" title="'.$_lang['file_delete_file'].'" /></span> ';

			// increment the counter
			$filecounter++;
		}
	}
	$dir->close();

	// dump array entries for directories
	$folders = count($dirs_array);
	sort($dirs_array); // sorting the array alphabetically (Thanks pxl8r!)
	for($i=0; $i<$folders; $i++)
	{
		$filesizes += $dirs_array[$i]['stats']['7'];
		echo '<tr style="cursor:default;" onmouseout="setColor(this,0)" onmouseover="setColor(this,1)">';
		echo '<td>',$dirs_array[$i]['text'],'</td>';
		echo '<td>',$modx->toDateFormat($dirs_array[$i]['stats']['9']),'</td>';
		echo '<td dir="ltr">',$modx->nicesize($dirs_array[$i]['stats']['7']),'</td>';
		echo '<td>';
		echo $dirs_array[$i]['delete'];
		echo '</td>';
		echo '</tr>';
	}

	// dump array entries for files
	$files = count($files_array);
	sort($files_array); // sorting the array alphabetically (Thanks pxl8r!)
	for($i=0; $i<$files; $i++)
	{
		$filesizes += $files_array[$i]['stats']['7'];
		echo '<tr onmouseout="setColor(this,0)" onmouseover="setColor(this,1)">';
		echo '<td>',$files_array[$i]['text'],'</td>';
		echo '<td>',$modx->toDateFormat($files_array[$i]['stats']['9']),'</td>';
		echo '<td dir="ltr">',$modx->nicesize($files_array[$i]['stats']['7']),'</td>';
		echo '<td>';
		echo $files_array[$i]['unzip'];
		echo $files_array[$i]['view'];
		echo $files_array[$i]['edit'];
		echo $files_array[$i]['delete'];
		echo '</td>';
		echo '</tr>';
	}
	return;
}

function removeLastPath($string) {
	$pos = strrpos($string, '/');
	if($pos!==false)
	{
	   $path = substr($string,0,$pos);
	}
	else $path = false;
	return $path;
}

function getExtension($string) {
	$pos = strrpos($string, '.');
	if($pos!==false)
	{
	   $ext = substr($string,$pos);
	   $ext = strtolower($ext);
	}
	else $ext = false;
	return $ext;
}

function mkdirs($strPath, $mode){ // recursive mkdir function
	if (is_dir($strPath)) return true;
	$pStrPath = dirname($strPath);
	if (!mkdirs($pStrPath, $mode)) return false;
	return @mkdir($strPath);
}

function logFileChange($type, $filename)
{
	//global $_lang;

	include_once('log.class.inc.php');
	$log = new logHandler();

	switch ($type)
	{
		case 'upload':		$string = 'Uploaded File'; break;
		case 'delete':		$string = 'Deleted File'; break;
		case 'modify':		$string = 'Modified File'; break;
		default:		$string = 'Viewing File'; break;
	}

	$string = sprintf($string, $filename);
	$log->initAndWriteLog($string, '', '', '', $type, $filename);

	// HACK: change the global action to prevent double logging
	// @see manager/index.php @ 915
	global $action; $action = 1;
}

// by patrick_allaert - php user notes
function unzip($file, $path)
{
	global $newfolderaccessmode;
	// added by Raymond
	$r = substr($path,strlen($path)-1,1);
	if ($r!='\\'||$r!='/') $path .='/';
	if (!extension_loaded('zip'))
	{
		return 0;
	}
	// end mod
	$zip = zip_open($file);
	if ($zip)
	{
		$old_umask = umask(0);
		while ($zip_entry = zip_read($zip))
		{
			if (zip_entry_filesize($zip_entry) > 0)
			{
				// str_replace must be used under windows to convert "/" into "\"
				$complete_path = $path.str_replace('/','\\',dirname(zip_entry_name($zip_entry)));
				$complete_name = $path.str_replace ('/','\\',zip_entry_name($zip_entry));
				if(!file_exists($complete_path))
				{
					$tmp = '';
					foreach(explode('\\',$complete_path) AS $k)
					{
						$tmp .= $k.'\\';
						if(!file_exists($tmp))
						{
							@mkdir($tmp, 0777);
						}
					}
				}
				if (zip_entry_open($zip, $zip_entry, 'r'))
				{
					$fd = fopen($complete_name, 'w');
					fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
					fclose($fd);
					zip_entry_close($zip_entry);
				}
			}
		}
		umask($old_umask);
		zip_close($zip);
		return true;
	}
	zip_close($zip);
}

function rrmdir($dir)
{
	foreach(glob($dir . '/*') as $file)
	{
		if(is_dir($file)) rrmdir($file);
		else              unlink($file);
	}
	return rmdir($dir);
}