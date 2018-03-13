<?php require("admin/include/siteConfig.php"); ?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Keywords" content="<? echo $metakeywords; ?>" />
<meta name="Description" content="<? echo $metadesc; ?>" />
<meta name="Author" content="Dzyne Web Solutions" />
<meta name="copyright" content="<?php echo date("Y"); ?> <? echo $sitename; ?>" />
<title><?php echo $sitename; ?></title>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<script type="text/javascript" src="js/fontsize.js"></script>
<script type="text/javascript" src="admin/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="admin/js/jquery-ui-1.9.0.custom.min.js"></script>

<?php include("include/preload.php"); ?>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link href="css/lightbox.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/nav.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="styles/smoothness/jquery-ui-1.9.0.custom.css" rel="Stylesheet" />

<?php
if(!isset($page) || $page == ""){
	$page = $mainpage;
}
$sql = "SELECT id, parent FROM nav WHERE pageid='$page'";
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
?>

</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<div id="header">
	<div id="headerLeft"></div>
	<div id="navContain">
		<ul class="nav">
		    <?php
		    $sql = "SELECT navtitle,imgfile,imgfilesel,pageid,id,cssid FROM nav WHERE parent='0' AND publish='1' ORDER BY sorting asc";
		    $result = mysql_query($sql);
		    $total = mysql_num_rows($result);

			for($cnt = 0; $cnt < $total; $cnt++){
				$navtitle			= mysql_result($result, $cnt, "navtitle");
				$imgfile			= mysql_result($result, $cnt, "imgfile");
				$imgfilesel			= mysql_result($result, $cnt, "imgfilesel");
				$pageid				= mysql_result($result, $cnt, "pageid");
				$parent				= mysql_result($result, $cnt, "id");
				$cssid				= mysql_result($result, $cnt, "cssid");

			?>
				<li>
					<?php if($pageid == $page || $parent == $nav){ ?><a href="<?php echo "index.php?page=". $pageid; ?>"><?php if($imgfilesel != ""){ ?><img src="<?php echo $imgfilesel; ?>" alt="<?php echo $navtitle; ?>" id="<?php echo $cssid; ?>" /><?php }else{ echo $navtitle; }?></a><?php }else{ ?> <a href="<?php echo "index.php?page=". $pageid; ?>"><?php if($imgfile != ""){ ?><img src="<?php echo $imgfile; ?>" onmouseover="javascript:document.<?php echo $cssid; ?>.src='<?php echo $imgfilesel; ?>'" onmouseout="javascript:document.<? echo $cssid; ?>.src='<? echo $imgfile; ?>'" alt="<?php echo $navtitle; ?>" id="<?php echo $cssid; ?>" /><?php }else{ echo $navtitle; }?></a><?php } ?>
					<?php
					$subsql = "SELECT navtitle,pageid FROM nav WHERE parent='$parent' AND publish='1' ORDER BY sorting asc";
					$subresult = mysql_query($subsql);
					$subtotal = mysql_num_rows($subresult);
					if($subtotal > 0){
					?>
						<ul>
						<?php
							for($subcnt = 0; $subcnt < $subtotal; $subcnt++){
								$subnavtitle			= mysql_result($subresult, $cnt, "navtitle");
								$subpageid				= mysql_result($subresult, $cnt, "pageid");
						?>
								 <li><a href="<?php echo "index.php?page=". $subpageid; ?>"><?php echo $subnavtitle; ?></a></li>
						<?php
							}
						?>
						</ul>
					<?php
					}
					?>
				</li>
			<?php
			}
			?>
		<li><img src="images/navRight.jpg"></li>
		</ul>
	</div>
</div>
<?php
if($page == 1){ ?>
	<div id="homeTop">
		<div id="topPad"></div>
		<div id="leftPad"></div>
		<div id="screen"><img src="images/screenshot.jpg"></div>
		<div id="midPad"></div>
		<div id="topContent">
			<h1>Clean design. User friendly. Unique.</h1>
			<br />
			<p>Building Apps is our core business. Apps can extend and enhance your existing software or create brand new functionality from the ground up. Let us help evolve your business with custom Apps to suit the specific needs of your business.</p>
		</div>
		<div id="btnPad"></div>
		<a href="index.php?page=102" id="btn"></a>
	</div>
<?php }elseif($page == 100){ ?>
	<div id="bodyTop"><img src="images/solutionsTop.jpg"></div>
<?php }elseif($page == 101){ ?>
	<div id="bodyTop"><img src="images/clientsTop.jpg"></div>
<?php }elseif($page == 102){ ?>
	<div id="bodyTop"><img src="images/contactTop.jpg"></div>
<?php } ?>
<div id="bodyStretch">
	<div id="contentLeft"></div>
	<div id="content">
		<?
		if(isset($page)){
			$sql = "SELECT pagetitle, inc, htmlcontent FROM pages WHERE id='$page' AND publish='1'";
			$result = mysql_query($sql);

			$inc 				= mysql_result($result, 0, "inc");
			$pagetitle 			= mysql_result($result, 0, "pagetitle");
			$htmlcontent		= mysql_result($result, 0, "htmlcontent");

			if($page != $mainpage){
				echo "<h2>". $pagetitle ."</h2><br />";
			}
			if(!isset($inc) || $inc == ""){
				echo $htmlcontent;
			}
			else{
				include("$inc");
			}
		}
		?>
	</div>
</div>
<div id="footer">
	<div id="footerPad"></div>
	<div id="footerLeft"></div>
	<div style="float:left;width:640px;">
		<div style="float:left;width:580px;">
			<h2>About Us</h2>
			<br />
			<p>Dzyne Web Solutions is a small team of web designers and developers who challenge themselves to create user friendly web systems and Apps. We’re driven to create experiences that combine functionality with creativity.</p>
			<br />
			<p>At Dzyne Web Solutions, our team can assist your company in developing tools to manage and control your business, or we can work together with you and your existing systems to update and add new tools that will enhance your company in your community and globally.</p>
			<br />
			<p>Let our Apps evolve your business.</p>
		</div>
	</div>
	<div style="float:left;width:300px;">
		<div style="float:left;width:290px;height:30px;">
			<h2>Stay Tuned</h2>
			<br />
			<div class="fb-like" data-href="#" data-send="false" data-width="200" data-show-faces="false" data-font="tahoma" data-colorscheme="dark"></div>
			<br /><br />
			<a href="#s" class="twitter-follow-button" data-show-count="false" data-lang="en" data-size="medium">Follow @dzyne</a>
			<br /><br />
			<p>Located in Sudbury, Ontario.</p>
			<br />
			<p>Call us at: 705-555-1212</p>


		</div>
	</div>
	<div id="footerBtm"></div>
	<div id="copyright"><p><a href="index.php">Home</a> | <a href="index.php?page=100">Solutions</a> | <a href="index.php?page=101">Clients</a> | <a href="index.php?page=102">Contact</a></p><p>&copy; Copyright <?php echo date("Y"); ?> Dzyne Web Solutions</p></div>
</div>
</body>
</html>
