<?php
if($action == ""){
	$action = "list";	
}

if($action == "submit" && !isset($del)){
	if($pagetitlenew == "" || $publishpagenew == ""){
			$error = "Please fill in all fields";
			$action = "edit";
	}
}

switch($action){
	case		"submit":
	if(isset($del)){
		$activity = "Deleted a page";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
	
		$sql = "DELETE FROM pages WHERE id='$del'";
		$result = mysql_query($sql);
		unset($del);
		$success = "Page has been removed successfully";
	}
	else{
		if($pgid){
			$activity = "Updated a page";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "UPDATE pages SET pagetitle='$pagetitlenew', inc='$incfilenew', htmlcontent='$htmlcontentnew', publish='$publishpagenew' WHERE id='$pgid'";
			$result = mysql_query($sql);
			$success = "Page has been updated successfully";
		}
		else{
			$activity = "Added a page";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$today = time();
			$sql = "INSERT INTO pages (pagetitle,inc,htmlcontent,publish) VALUES ('$pagetitlenew','$incfilenew','$htmlcontentnew','$publishpagenew')";
			$result = mysql_query($sql);
			$success = "Page has been created successfully";
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
	<div id="controls"><a href="admin.php?page=<?php echo $page; ?>&action=edit" class="button"><span>Add Page</span></a></div>
	<table class="data">
			<tr>
				<th>Page Title</th>
				<th>Published</th>
				<th>Actions</th>
			</tr>
 <?
 	$sql = "SELECT id,pagetitle,publish FROM pages";
	$result = mysql_query($sql);
	$total = mysql_num_rows($result);
	
	for($cnt = 0; $cnt < $total; $cnt++){
		
		$pgid 			= mysql_result($result, $cnt, "id");
		$pgtitle	  	= mysql_result($result, $cnt, "pagetitle");
		$publish		= mysql_result($result, $cnt, "publish");
		
		$zsql = "SELECT pagetitle FROM pages WHERE id='$pgid'";
		$zresult = mysql_query($zsql);
				
		if($publish == 1){
			$publishbg = "#4CC417";
			$publish = "Yes";
		}
		else{
			$publishbg = "#E8A317";
			$publish = "Draft";
		}
 ?>		
		<tr>
			<td><?php echo $pgtitle; ?></td>
			<td align="center" style="background-color:<?php echo $publishbg; ?>;font-weight:bold;color:#fff;"><?php echo $publish; ?></td>
			<td>
				<a href="../index.php?page=<? echo $pgid; ?>" target="_blank"><img src="images/preview.png"></a>
				<a href="admin.php?page=<? echo $page; ?>&action=edit&pgid=<? echo $pgid; ?>"><img src="images/edit.png" /></a>
				<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $pgid; ?>')" ><img src="images/delete.png"></a>
			</td>
<?php
	}
?>
	</table>

<?php	
	break;

	case	"edit":
	if($pgid){
		$sql = "SELECT pagetitle,htmlcontent,inc,publish FROM pages WHERE id='$pgid'";
		$result = mysql_query($sql);
			
			$pagetitlenew				= mysql_result($result, 0, "pagetitle");
			$htmlcontentnew				= mysql_result($result, 0, "htmlcontent");
			$incfilenew					= mysql_result($result, 0, "inc");
			$publishpagenew				= mysql_result($result, 0, "publish");

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
        	<td nowrap="nowrap"><label>PAGE TITLE</label></td>
            <td><input type="text" name="pagetitlenew" maxlength="80" value="<? echo $pagetitlenew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>INCLUDE FILE</label></td>
            <td><input type="text" name="incfilenew" value="<? echo $incfilenew; ?>" class="smallInput"/></td>         
        </tr> 
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	</div>
	<div class="twocol">
    <table border="0">
        <tr>
        	<td nowrap="nowrap"><label>PUBLISH</label></td>
        	<td>
        		<select name="publishpagenew" class="smallInput">
        			<option value="0">Draft</option>
        			<option value="1" <?php if($publishpagenew == 1){ echo " SELECTED"; } ?>>Published</option>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
    </table>
	</div>
	<div style="float:left;">
    <table cellspacing="2" cellpadding="2" border="0" width="850" bgcolor="#e3e3e3">
	    <tr><td>
	    	<textarea cols="30" rows="20" name="htmlcontentnew" style="width:850px;"><? echo $htmlcontentnew; ?></textarea>
	    </td></tr>
    </table>
	</div>
	<div class="twocol">
		<table>
			<tr><td>&nbsp;</td></tr>
		</table>
	</div>
	<div class="twocol">
		<table border="0" width="410">
		<tr><td>&nbsp;</td></tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<?php if($pgid){ ?>
	            	<input type="hidden" name="pgid" value="<?php echo $pgid; ?>" />
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