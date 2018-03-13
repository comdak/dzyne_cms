<?php require("include/siteConfig.php"); ?>
<?php require("include/commonFunctions.php"); ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="copyright" content="&copy; 2008-<?php echo date("Y"); ?> Dzyne Web Solutions" />
<meta name="author" content="Dzyne Web Solutions" />

<title>CMS &raquo; Login</title>

<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<?php
if (isset($_POST['submit']) || isset($_COOKIE['userCookie'])){
	if((!$_POST['username'] | !$_POST['password']) && !isset($_COOKIE['userCookie'])) {
		$error = "Please fill in all fields";
	}
	else{
		
		if($_COOKIE['userCookie']){
			$username = $_COOKIE['userCookie'];
			$password = $_COOKIE['passCookie'];
		}
		else{
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		
		$check = mysql_query("SELECT * FROM users WHERE username = '$username'")
		or die(mysql_error());
	
		//Gives error if user dosen't exist
		$total = mysql_num_rows($check);
		if ($total == 0) {
			$error = "Username or Password is incorrect";
		}
		while($info = mysql_fetch_array( $check )){
			if(!isset($_COOKIE['userCookie'])){
				$password = md5(stripslashes($password));
			}		
			$info['password'] = stripslashes($info['password']);
			
			//Gives error if the password is wrong
			if ($password != $info['password']) {
	
				$past = time() - 3600;
				setcookie("userCookie", "0", $past);
				setcookie("passCookie", "0", $past); 
				
				$error = "Username or Password is incorrect";
			}
			else{
				$username = stripslashes($username);
				$hour = time()+3600*2;
				$now = time();
				
				setcookie("userCookie", $username, $hour);
				setcookie("passCookie", $password, $hour);
				
				$ip = $_SERVER['REMOTE_ADDR'];
				
				$sql = "UPDATE users SET lastaccess='$now',ipaddr='$ip' WHERE username='$username'";
				$result = mysql_query($sql);
				
				//then redirect them to the members area
				header("Location: admin.php");
			}
		}
	}
}
?>

<div id="loginHeader"></div>
<div id="loginTop"><h1>Please Login</h1></div>
<div id="loginBody">
	<div id="loginContent">
		<?php if($error){ ?>
		<p class="err"><?php echo $error; ?></p>
		<?php } ?>
		<form action="<? echo $_SERVER['PHP_SELF']?>" method="post">
			<table border="0" style="padding-left:25px;">
			    <tr>
			        <td>Username:</td>
			     </tr>
			     <tr>
			        <td><input type="text" name="username" maxlength="40" value="<?php echo $username; ?>"></td>
			    </tr>
			
			    <tr>
			        <td>Password:</td>
			    </tr>
			    <tr>
			        <td><input type="password" name="password" maxlength="40"></td>
			    </tr>
			    <tr>
			    	<td colspan="2">&nbsp;</td>
			
			     </tr>
			    <tr>
			        <td colspan="2" align="right"><input type="submit" name="submit" value="Login" class="submitBtn"></td>
			    </tr>
			    <tr>
			    	<td colspan="2"><a href="forgot.php">Forgot your password?</a></td>
			    </tr>
			</table>
        </form>
	</div>
</div>
<div id="loginBtm"></div>

</body>
</html>
