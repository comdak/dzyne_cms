<?php 
require("include/siteConfig.php");
require("include/commonFunctions.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="copyright" content="&copy; 2008-<?php echo date("Y"); ?> Dzyne Web Solutions" />
<meta name="author" content="Dzyne Web Solutions" />

<title>CMS &raquo; Administration Panel</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="styles/smoothness/jquery-ui-1.8.17.custom.css" rel="stylesheet" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.0.custom.min.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<?php include("include/preload.php"); ?>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_source_editor_width : 600,
		theme_advanced_resizing : true,
		extended_valid_elements : "iframe[src|width|height|name|align]",
	});
</script>
</head>
<body>
<?php
//checks cookies to make sure they are logged in
if(isset($_COOKIE['passCookie'])){
	$username = $_COOKIE['userCookie'];
	$password = $_COOKIE['passCookie'];
	$check = mysql_query("SELECT * FROM users WHERE username = '$username'");
	
	while($info = mysql_fetch_array($check)){

		//if the cookie has the wrong password, they are taken to the login page
		if($password != $info['password']){
			header("Location: index.php");
		}
		//otherwise they are shown the admin area
		else{
			$page = $_GET['page'];
			if(!isset($page) || $page == ""){
				$page = $mainpage;	
			}
			//$password = setcookie("passCookie", $password, $hour);
			$sql = "SELECT id, parent FROM portalnav WHERE pageid='$page'";
			$result = mysql_query($sql);
			$total = mysql_num_rows($result);
			if($total > 0){
				$nav = mysql_result($result, 0, "parent");
				if($nav == 0){
					$nav = mysql_result($result, 0, "id");
				}
			}
			if(!isset($nav) || $nav == ""){
				$nav = $mainnav;	
			}
			$sql = "SELECT level,id,ipaddr FROM users WHERE username='$username'";	
			$result = mysql_query($sql);
			
			$permlvl 	= mysql_result($result, 0, "level");
			$userid 	= mysql_result($result, 0, "id");
			$ip 		= mysql_result($result, 0, "ipaddr");
?>
			<div id="header">
				<div id="headerCP">
			    	<div id="CPTop"></div>
			    	<div id="CPAvatar"><img src="images/avatar.jpg" width="45" height="45" /></div>
			        <div id="CPUserPanel">
			        	Hi <? echo substr($info['fullname'],0,15); ?> | <a href="logout.php" class="altlink">Logout</a><br />
			            <? $today = date("F j, Y"); echo $today; ?><br />
			            IP: <? echo $ip; ?>
			        </div>
				</div>
			</div>
			<ul id="navContainer">
				<li id="navLeft" class="noPad"></li>
<?php
				$sql = "SELECT navtitle,imgfile,imgfilesel,pageid,id,cssid FROM portalnav WHERE parent='0' AND publish='1' ORDER BY sorting asc";
				$result = mysql_query($sql);
				$total = @mysql_num_rows($result);
				
				for($cnt = 0; $cnt < $total; $cnt++){
					
					$navtitle			= mysql_result($result, $cnt, "navtitle");
					$imgfile			= mysql_result($result, $cnt, "imgfile");
					$imgfilesel			= mysql_result($result, $cnt, "imgfilesel");
					$pageid				= mysql_result($result, $cnt, "pageid");
					$parent				= mysql_result($result, $cnt, "id");
					$cssid				= mysql_result($result, $cnt, "cssid");
					
					$chksql = "SELECT stop_page FROM permissions WHERE stop_page='$pageid' AND level='$permlvl'";
					$chkresult = mysql_query($chksql);
					
					if(mysql_num_rows($chkresult) == 0){
?>
						<li class="noPad"><?php if($pageid == $page || $parent == $nav){ ?><a href="<?php echo "admin.php?page=". $pageid; ?>"><img src="<?php echo $imgfilesel; ?>" alt="<?php echo $navtitle; ?>" id="<?php echo $cssid; ?>" /></a><?php } else{ ?> <a href="<?php echo "admin.php?page=". $pageid; ?>"><img src="<?php echo $imgfile; ?>" onmouseover="javascript:document.<?php echo $cssid; ?>.src='<?php echo $imgfilesel; ?>'" onmouseout="javascript:document.<? echo $cssid; ?>.src='<? echo $imgfile; ?>'" alt="<?php echo $navtitle; ?>" id="<?php echo $cssid; ?>" /></a><?php } ?></li>
<?php
					}
				}

?>
			</ul>
			<ul id="subContainer">
				<li id="subLeft" class="subNoPad"></li>
<?php
			
				$sql = "SELECT navtitle,pageid FROM portalnav WHERE parent='$nav' AND publish='1' ORDER BY sorting asc";
				$result = mysql_query($sql);
				$total = mysql_num_rows($result);
				
				for($cnt = 0; $cnt < $total; $cnt++){
				
					$navtitle			= mysql_result($result, $cnt, "navtitle");
					$pageid				= mysql_result($result, $cnt, "pageid");
					
					$checksql = "SELECT stop_page FROM permissions WHERE stop_page='$pageid' AND level='$permlvl'";
					$checkresult = mysql_query($checksql);
					
					if(mysql_num_rows($checkresult) == 0){

				?>
				        <li class="subNoPad"><?php if($pageid == $page){ ?><a href="<?php echo "admin.php?page=". $pageid; ?>" class="active"><span><?php echo $navtitle; ?></span></a><?php } else{ ?><a href="<?php echo "admin.php?page=". $pageid; ?>" class="inactive"><span><?php echo $navtitle; ?></span></a><?php } ?></li>
	
<?php
					}
				}

?>
			
			</ul>
			<div id="bodyStretch">
				<div id="content">
<?php
					if(isset($page)){
							
						$checksql = "SELECT stop_page FROM permissions WHERE stop_page='$page' AND level='$permlvl'";
						$checkresult = mysql_query($checksql);
						$checktotal = mysql_num_rows($checkresult);
						
						if($checktotal > 0){
							$inc = "content/errorpage.php";	
							$pagetitle = "Page Not Available";
							$inc = "content/errorpage.php";
						}
						else{
							$sql = "SELECT pagetitle, inc FROM portalpages WHERE id='$page' AND publish='1'";
							$result = mysql_query($sql);
							
							$inc 				= mysql_result($result, 0, "inc");
							$pagetitle 			= mysql_result($result, 0, "pagetitle");
							
							if($inc == ""){
								$inc = "content/errorpage.php";
							}
						}		
						echo "<h2>". $pagetitle ."</h2>"; 
						include("$inc");
					}
?>
				</div>
			</div>
			<div id="footer"></div>
			<div id="copyright">Copyright &copy; Dzyne Web Solutions 2008-<?php echo date("Y"); ?></div>








<?php
		}	
	}
}
else{
//if the cookie does not exist, they are taken to the login screen
	header("Location: index.php");
}

?>

</body>
</html>

<?php mysql_close(); ?>