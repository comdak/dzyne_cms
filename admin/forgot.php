<?php require("include/siteConfig.php"); ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="copyright" content="&copy; 2008-<?php echo date("Y"); ?> Dzyne Web Solutions" />
<meta name="author" content="Dzyne Web Solutions" />

<title>CMS &raquo; Account Recovery</title>

<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<?php

if (isset($_POST['submit'])) {
	if(!$_POST['email'] ) {
		$error = "Please fill in all fields";
	}
	else{
		$check = mysql_query("SELECT * FROM users WHERE emailaddr = '".$_POST['email']."'")
		or die(mysql_error());
	
		//Gives error if user dosen't exist
		$total = mysql_num_rows($check);
		if ($total == 0){
			$error = "That email is not connected to any account";
		}
		else{
			$_POST['email'] = stripslashes($_POST['email']);
			
			$userid   = mysql_result($check, 0, "id");		
			$username = mysql_result($check, 0, "username");
			$fullname = mysql_result($check, 0, "fullname");
			$newpass = stripslashes(generatePassword());
			$newhash = md5($newpass);
			
			$sql = "UPDATE users SET password='$newhash' WHERE id='$userid'";
			$result = mysql_query($sql);
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Account Recovery <contact@dzyne.ca>' . "\r\n";		
			$to = $_POST['email'];
			$subject = "Dzyne Web Solutions - Password Recovery";
			
			$body = 		"Hello $fullname,<br /><br />\n
							We received a request to retrieve your password for the Dzyne CMS. For security reasons, we have generated a new unique password for you.<br /><br />\n
							Please use the following account credentials to sign in to your account:<br />\n
							Username: $username <br />\n
							Password: $newpass <br />\n
							<br />\n
							If you are still having trouble, please contact your Administrator or email Dzyne at <a href=\"mailto:contact@dzyne.ca\">contact@dzyne.ca</a>\n";
								
						
			mail($to, $subject, $body, $headers);
			
			$confirm = "An email has been sent with your account information";
		}
	}
}
?>

<div id="loginHeader"></div>
<div id="loginTop"><h1>Account Recovery</h1></div>
<div id="loginBody">
	<div id="loginContent">
		<?php if($error){ ?>
		<p class="err"><?php echo $error; ?></p>
		<?php } ?>
		<form action="<? echo $_SERVER['PHP_SELF']?>" method="post">
			<table border="0" style="padding-left:25px;">
			    <tr>
			    	<td colspan="2"><a href="index.php">&laquo; Return to login</a></td>
			    </tr>
			    <tr>
			    	<td colspan="2">&nbsp;</td>
			     </tr>
				<?php if($confirm){ ?>
				<tr>
					<td colspan="2"><p class="success"><?php echo $confirm; ?></p></td>
				</tr>
				<?php } ?>
			    <tr>
			        <td>Email Address:</td>
			     </tr>
			     <tr>
			        <td><input type="text" name="email" maxlength="40"></td>
			    </tr>
			
			    <tr>
			    	<td colspan="2">&nbsp;</td>
			     </tr>
			    <tr>
			        <td colspan="2" align="right"><input type="submit" name="submit" value="Login" class="submitBtn"></td>
			    </tr>
			</table>
        </form>
	</div>
</div>
<div id="loginBtm"></div>

</body>
</html>
