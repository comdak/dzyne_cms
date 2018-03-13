<?php
if($action == ""){
	$action = "list";	
}

if($action == "submit" && !isset($del)){
	if(($usernamenew == "" || $emailnew == "" || $fullnamenew == "" || $permnew == "") || (!isset($uid) && ($passwordnew == "" || $confirmnew == ""))){
			$error = "Please fill in all fields";
			$action = "edit";
	}
	if($passwordnew != $confirmnew){
		$error = "Your passwords do not match, please try again";
		$action = "edit";
	}
}

if($_GET['uid']){
	$uid = $_GET['uid']; 	
}

switch($action){
	case		"submit":
	
	if(isset($del)){
		$activity = "Deleted a user account";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
	
		$sql = "DELETE FROM users WHERE id='$del'";
		$result = mysql_query($sql);
		unset($del);
		$success = "User has been removed successfully";
	}
	else{
		if($passwordnew != ""){
			$passwordnew = md5($passwordnew);			
		}
		else{
			$sql = "SELECT password FROM users WHERE id='$uid'";
			$result = mysql_query($sql);
			$passwordnew = mysql_result($result, 0, "password");
		}
		if($uid){
			$activity = "Updated a user account";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "UPDATE users SET username='$usernamenew', fullname='$fullnamenew', password='$passwordnew', level='$permnew', emailaddr='$emailnew' WHERE id='$uid'";
			$result = mysql_query($sql);
			$success = "User has been updated successfully";
			
		}
		else{
			$activity = "Added a user account";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "INSERT INTO users (username,password,fullname,emailaddr,level,lastaccess) VALUES ( '$usernamenew','$passwordnew','$fullnamenew','$emailnew','$permnew','$today')";
			$result = mysql_query($sql);
			$success = "User has been created successfully";
		}
	}
		
	case	"list":
?>
	<div class="notification">
		<? if($error){ ?>
			<p class="err"><?php echo $error; ?></p></td>
		<? } ?>
		<? if ($success){ ?>
			<p class="success"><?php echo $success; ?></p></td>
		<? } ?>
	
	</div>
	<div id="controls"><a href="admin.php?page=<?php echo $page; ?>&action=edit" class="button"><span>Add User</span></a></div>
	<table class="data">
			<tr>
				<th>Username</th>
				<th>Real Name</th>
				<th>Last Access</th>
				<th>Permissions</th>
				<th>Actions</th>
			</tr>
 <?
 	$sql = "SELECT id, username, fullname, lastaccess, level FROM users ORDER BY id";
	$result = mysql_query($sql);
	$total = mysql_num_rows($result);
	
	for($cnt = 0; $cnt < $total; $cnt++){
		
		$uname			= mysql_result($result, $cnt, "username");
		$uid		  	= mysql_result($result, $cnt, "id");
		$ufullname 		= mysql_result($result, $cnt, "fullname");
		$ulastaccess	= mysql_result($result, $cnt, "lastaccess");
		$ulevel			= mysql_result($result, $cnt, "level");
		
		$ulastaccess = date("F d, Y", $ulastaccess);
		
		$levelresult = mysql_query("SELECT type FROM perm_levels WHERE level='$ulevel'");
		
		$ulname = mysql_result($levelresult, 0, "type");
		
		if($ulevel >= $permlvl){
 ?>
	 		<tr>
				<td><?php echo $uname; ?></td>
				<td><?php echo $ufullname; ?></td>
				<td><?php echo $ulastaccess; ?></td>
				<td><?php echo $ulname; ?></td>
				<td>
					<a href="admin.php?page=<?php echo $page; ?>&action=edit&uid=<?php echo $uid; ?>"><img src="images/edit.png"></a> 
					<?php if($userid != $uid){ ?>
					<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $uid; ?>')" ><img src="images/delete.png"></a>
					<?php } ?>
				</td>
			</tr>
<?php
		}
	}
?>
	</table>

<?php	
	break;

	case	"edit":
	if($uid){
		$sql = "SELECT fullname,username,emailaddr,level FROM users WHERE id='$uid'";
		$result = mysql_query($sql);
		
		$fullnamenew 		= mysql_result($result, 0, "fullname");
		$emailnew			= mysql_result($result, 0, "emailaddr");
		$permnew			= mysql_result($result, 0, "level");
		$usernamenew		= mysql_result($result, 0, "username");
	}
?>	
	<div class="notification">
		<? if($error){ ?>
			<p class="err"><?php echo $error; ?></p></td>
		<? } ?>
		<? if ($success){ ?>
			<p class="success"><?php echo $success; ?></p></td>
		<? } ?>
	</div>
	<form action="<? echo "admin.php?page=". $page; ?>" method="POST">
	
	<div class="twocol">
    <table border="0">
        <tr>
        	<td nowrap="nowrap"><label>FULL NAME</label></td>
            <td><input type="text" name="fullnamenew" maxlength="80" value="<? echo $fullnamenew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>EMAIL ADDRESS</label></td>
            <td><input type="text" name="emailnew" maxlength="255" value="<? echo $emailnew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>USER ROLE</label></td>
            <td>
            	<select name="permnew" class="smallInput">
            		<option value="">Please Select...</option>
<?php
				$sql = "SELECT level, type FROM perm_levels";
				$result = mysql_query($sql);
				$total = mysql_num_rows($result);
				for($x = 0; $x < $total; $x++){
					$level 	= mysql_result($result, $x, "level");
					$type	= mysql_result($result, $x, "type");
					if($level >= $permlvl){
?>
                		<option value="<?php echo $level; ?>" <?php if($level == $permnew){ echo " SELECTED"; } ?>><?php echo $type; ?></option>
<?php
					}
				}
?>
                </select>

            </td>         
        </tr>
    </table>
	</div>
	<div class="twocol">
    <table border="0">
		<tr>
        	<td nowrap="nowrap"><label>USERNAME</label></td>
            <td><input type="text" name="usernamenew" maxlength="40" value="<? echo $usernamenew; ?>" class="smallInput"/></td>         
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><hr><em>If you would like to change the password type a new one (twice). Otherwise leave blank.</em></td>
		</tr>
		<tr>
        	<td nowrap="nowrap"><label>NEW PASSWORD</label></td>
            <td><input type="password" name="passwordnew" maxlength="255" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>CONFIRM PASSWORD</label></td>
            <td><input type="password" name="confirmnew" maxlength="255" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<?php if($uid){ ?>
	            	<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	            	<input type="submit" name="submit" value="Update" class="submitBtn">
            	<?php }else{ ?>
	            	<input type="submit" name="submit" value="Create" class="submitBtn">
            	<?php } ?>
            </td>
    	</tr>
    </table>
	</div>
</form>

<?php	
	break;
}
?>