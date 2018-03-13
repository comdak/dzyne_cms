<?php
if($action == ""){
	$action = "list";	
}

if($action == "submit" && !isset($del)){
	if($typenew == "" || $levelnew == ""){
			$error = "Please fill in all fields";
			$action = "edit";
	}
}
switch($action){
	case		"submit":
	
	if(isset($del)){
		$activity = "Deleted a user permission role";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
	
		$sql = "SELECT level FROM perm_levels where id='$del'";
		$result = mysql_query($sql);
		$dellevel = mysql_result($result, 0, "level");
		
		$sql = "DELETE FROM perm_levels WHERE id='$del'";		
		$result = mysql_query($sql);
		
		$sql = "DELETE FROM permissions WHERE level='$dellevel'";
		$result = mysql_query($sql);
		
		unset($del);
		$success = "Role has been removed successfully";
	}
	else{
		if($pid){
			$activity = "Updated a user permission role";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "UPDATE perm_levels SET type='$typenew', level='$levelnew' WHERE id='$pid'";
			$result = mysql_query($sql);
			
			$sql = "DELETE FROM permissions WHERE level='$levelnew'";
			$result = mysql_query($sql);
			
			explode($stoppagenew);
			
			foreach($stoppagenew as $stoppage){
				$sql = "INSERT INTO permissions (level, stop_page) VALUES ('$levelnew', '$stoppage')";
				$result = mysql_query($sql);
			}
			$success = "User has been updated successfully";
		}
		else{
			$activity = "Added a user permission role";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "INSERT INTO perm_levels (type,level) VALUES ('$typenew', '$levelnew')";
			$result = mysql_query($sql);
			explode($stoppagenew);
			
			foreach($stoppagenew as $stoppage){
				$sql = "INSERT INTO permissions (level, stop_page) VALUES ('$levelnew', '$stoppage')";
				$result = mysql_query($sql);
			}
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
	<div id="controls"><a href="admin.php?page=<?php echo $page; ?>&action=edit" class="button"><span>Add Level</span></a></div>
	<table class="data">
			<tr>
				<th>Permission Level</th>
				<th>Applicable Users</th>
				<th>Actions</th>
			</tr>
 <?php
	$sql = "SELECT id, type, level FROM perm_levels";
	$result = mysql_query($sql);
	$total = mysql_num_rows($result);
	
	for ($cnt = 0; $cnt < $total; $cnt++){
		
		$pid			= mysql_result($result, $cnt, "id");
		$ptype			= mysql_result($result, $cnt, "type");
		$plevel			= mysql_result($result, $cnt, "level");
		
		$usrresult = mysql_query("SELECT username, fullname, FROM users WHERE level='$plevel'");
		$usrtotal = mysql_num_rows($usrresult);
				
		if($plevel >= $permlvl){
 ?>
	 		<tr>
				<td><?php echo $ptype; ?></td>
				<td>
				<?php 
					for($a = 0; $a < $usrtotal; $a++){
						$puname			= mysql_result($usrresult, $a, "username");
						$pfname			= mysql_result($usrresult, $a, "fullname");
						
						echo $puname ."( ". $pfname ." )<br />";
					}					
				?>
				</td>
				<td>
					<a href="admin.php?page=<?php echo $page; ?>&action=edit&pid=<?php echo $pid; ?>"><img src="images/edit.png"></a> 
					<?php if($plevel != $permlvl){ ?>
					<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $pid; ?>')" ><img src="images/delete.png"></a>
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
	if($pid){
		$sql = "SELECT type,level FROM perm_levels WHERE id='$pid'";
		$result = mysql_query($sql);
		
		$typenew	 		= mysql_result($result, 0, "type");
		$levelnew			= mysql_result($result, 0, "level");
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
        	<td nowrap="nowrap"><label>ROLE NAME</label></td>
            <td><input type="text" name="typenew" maxlength="80" value="<? echo $typenew; ?>" class="smallInput"/></td>         
        </tr>
		<tr>
        	<td nowrap="nowrap"><label>USER LEVEL</label></td>
            <td>
				<select name="levelnew" class="smallInput">
					<?php
					for($x = 1; $x <= 10; $x++){
						$sql = "SELECT level FROM perm_levels WHERE level='$x'";
						$result = mysql_query($sql);
						$levelchk = mysql_result($result, 0, "level");

						unset($total);
						$total = mysql_num_rows($result);
						if(!$total || $levelchk == $levelnew){
					?>
							<option value="<?php echo $x; ?>" <?php if($levelnew == $x){ echo " SELECTED"; }?>><?php echo $x; if($x == 1){ echo " (Administrator)"; } ?></option>
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
        	<td nowrap="nowrap"><label>DISALLOW PAGES</label></td>
			<td>
			<?php
				$sql = "SELECT id,pagetitle FROM portalpages";
				$result = mysql_query($sql);
				$total = mysql_num_rows($result);
			
				for($x = 0; $x < $total; $x++){
					
					$ppid = mysql_result($result, $x, "id");
					$pptitle = mysql_result($result, $x, "pagetitle");
					
					$ysql = "SELECT stop_page FROM permissions WHERE level='$levelnew' AND stop_page='$ppid'";
					$yresult = mysql_query($ysql);
					
					$ypage = mysql_result($yresult, 0, "stop_page");
					if($ppid == $ypage){
						$checked = "CHECKED";
					}
					else{
						$checked = "";
					}
					
					echo "<input type=\"checkbox\" name=\"stoppagenew[]\" value=\"". $ppid ."\" style=\"width:auto;\" ". $checked ."> ". $pptitle ."<br /><br />\n";
				}
			?>
			</td>
		</tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<?php if($pid){ ?>
	            	<input type="hidden" name="pid" value="<?php echo $pid; ?>" />
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