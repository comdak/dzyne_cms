<?php
if($action == ""){
	$action = "list";	
}



if($action == "submit" && !isset($del) && !isset($sortup) && !isset($sortdown)){
	if($navtitlenew == "" || $navpublishnew == ""){
			$error = "Please fill in all fields";
			$action = "edit";
	}
}

switch($action){
	case		"submit":
	if($sortup == '1'){
		$sql = "SELECT sorting,parent FROM nav WHERE id='$nid'";
		$result = mysql_query($sql);
		
		$origpos 	= mysql_result($result, 0, "sorting");
		$navparent	= mysql_result($result, 0, "parent");
		$i			= $origpos - 1;

		if($i == 0){
			$i = 1;	
		}
		
		$sql = "SELECT id FROM nav WHERE sorting='$i' AND parent='$navparent'";
		$result = mysql_query($sql);
		
		$dropnavid = mysql_result($result, 0, "id");
					
		$sql = "UPDATE nav SET sorting='$origpos' WHERE sorting='$i' AND id='$dropnavid'";
		$result = mysql_query($sql);
					
		$sqlsecond = "UPDATE nav SET sorting='$i' WHERE sorting='$origpos' AND id='$nid'";
		$result = mysql_query($sqlsecond);
	}
	elseif($sortdown == '1'){
	
		$sql = "SELECT id FROM nav WHERE parent='$navparent' ORDER BY sorting desc";
		$result = mysql_query($sql);
		$chkid = mysql_result($result, 0, "id");
		
		if($chkid != $nid){
			$sql = "SELECT sorting,parent FROM nav WHERE id='$nid'";
			$result = mysql_query($sql);
			
			$origpos 	= mysql_result($result, 0, "sorting");
			$navparent 	= mysql_result($result, 0, "parent");
			$x				= $origpos + 1;
	
			$sql = "SELECT id FROM nav WHERE sorting = '$x'";
			$result = mysql_query($sql);
			
			$checkd = mysql_result($result, 0, "id");
			
			if($checkd == ""){
				$i = $origpos;
			}
			else{
				$i	 = $origpos + 1;
			}
			
			$sql = "SELECT id FROM nav WHERE sorting = '$i' AND parent='$navparent'";
			$result = mysql_query($sql);
			
			$dropnavid = mysql_result($result, 0, "id");
						
			$sql = "UPDATE nav SET sorting='$origpos' WHERE sorting='$i' AND id='$dropnavid'";
			$result = mysql_query($sql);
						
			$sqlsecond = "UPDATE nav SET sorting='$i' WHERE sorting='$origpos' AND id='$nid'";
			$result = mysql_query($sqlsecond);
		}
	}	
	elseif(isset($del)){
		$activity = "Deleted a navigation item";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
		$sql = "DELETE FROM nav WHERE parent='$del'";
		$result = mysql_query($sql);
	
		$sql = "DELETE FROM nav WHERE id='$del'";
		$result = mysql_query($sql);
		unset($del);
		$success = "Navigation item has been removed successfully";
	}
	else{
		if($nid){
			$activity = "Updated a navigation item";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
		
			$sql = "UPDATE nav SET navtitle='$navtitlenew',imgfile='$imgfilenew',imgfilesel='$imgfileselnew',pageid='$navpagenew',parent='$navparentnew',publish='$navpublishnew',cssid='$cssidnew',extlink='$extlinknew' WHERE id='$nid'";
			$result = mysql_query($sql);
			$success = "Navigation item has been updated successfully";
		}
		else{
			$activity = "Added a navigation item";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
			
			$sql = "INSERT INTO nav (navtitle,imgfile,imgfilesel,pageid,parent,publish,cssid,extlink) VALUES ('$navtitlenew','$imgfilenew','$imgfileselnew','$navpagenew','$navparentnew','$navpublishnew','$cssidnew','$extlinknew')";
			$result = mysql_query($sql);
			$success = "Navigation item has been created successfully";
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
	<div id="controls"><a href="admin.php?page=<?php echo $page; ?>&action=edit" class="button"><span>Add Navigation Link</span></a></div>
	<table class="data">
			<tr>
				<th>Navigation Title</th>
				<th>Linked Page/URL</th>
				<th>Published</th>
				<th>Actions</th>
			</tr>
 <?
 	$sql = "SELECT id,navtitle,pageid,publish,extlink FROM nav WHERE parent='0' ORDER BY sorting ASC";
	$result = mysql_query($sql);
	$total = mysql_num_rows($result);
	
	for($cnt = 0; $cnt < $total; $cnt++){
		
		$nid 			= mysql_result($result, $cnt, "id");
		$navtitle	  	= mysql_result($result, $cnt, "navtitle");
		$npid			= mysql_result($result, $cnt, "pageid");
		$publish		= mysql_result($result, $cnt, "publish");
		$extlinknew		= mysql_result($result, $cnt, "extlink");
		
		$zsql = "SELECT pagetitle FROM pages WHERE id='$npid'";
		$zresult = mysql_query($zsql);
		
		if(strlen($extlinknew) > 0){
			$npagename = substr($extlinknew, 0, 50);
		}
		else{
			$npagename = mysql_result($zresult, 0, "pagetitle");
		}
		
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
			<td><?php echo $navtitle; ?></td>
			<td><?php echo $npagename; ?></td>
			<td align="center" style="background-color:<?php echo $publishbg; ?>;font-weight:bold;color:#fff;"><?php echo $publish; ?></td>
			<td>
				<a href="admin.php?page=<? echo $page; ?>&action=submit&sortup=1&nid=<? echo $nid; ?>"><img src="images/arrow_up.png"></a>
				<a href="admin.php?page=<? echo $page; ?>&action=submit&sortdown=1&nid=<? echo $nid; ?>"><img src="images/arrow_down.png"></a>
				<a href="admin.php?page=<? echo $page; ?>&action=edit&nid=<? echo $nid; ?>"><img src="images/edit.png" /></a>
				<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $nid; ?>')" ><img src="images/delete.png"></a>
			</td>
		</tr>
		<?php
		$subsql = "SELECT id,navtitle,pageid,publish,extlink FROM nav WHERE parent='$nid' ORDER BY sorting";
        $subresult = mysql_query($subsql);
        $subtotal = mysql_num_rows($subresult);
        
        for($subcnt = 0; $subcnt < $subtotal; $subcnt++){
            
            $subnid 			= mysql_result($subresult, $subcnt, "id");
            $subnavtitle	  	= mysql_result($subresult, $subcnt, "navtitle");
			$subnpid			= mysql_result($subresult, $subcnt, "pageid");		 
            $subpublish			= mysql_result($subresult, $subcnt, "publish");
            $subextlink			= mysql_result($subresult, $subcnt, "extlink");
			
			$subzsql = "SELECT pagetitle FROM pages WHERE id='$subnpid'";
			$subzresult = mysql_query($subzsql);
			
			if(strlen($subextlink) > 0){
				$subnpagename = substr($subextlink, 0, 50);
			}
			else{
				$subnpagename = mysql_result($subzresult, 0, "pagetitle");
			}
			
			if($subpublish == 1){
				$subpublishbg = "#4CC417";
				$subpublish = "Yes";
			}
			else{
				$subpublishbg = "#E8A317";
				$subpublish = "Draft";
			}
			
    ?>
			<tr>
				<td style="font-style:italic;"> &raquo; <? echo $subnavtitle; ?></td>
				<td><?php echo $subnpagename; ?></td>
				<td align="center" style="background-color:<?php echo $subpublishbg; ?>;font-weight:bold;color:#fff;"><?php echo $subpublish; ?></td>
				<td>
					<a href="admin.php?page=<? echo $page; ?>&action=submit&sortup=1&nid=<? echo $subnid; ?>"><img src="images/arrow_up.png"></a>
					<a href="admin.php?page=<? echo $page; ?>&action=submit&sortdown=1&nid=<? echo $subnid; ?>"><img src="images/arrow_down.png"></a>
					<a href="admin.php?page=<? echo $page; ?>&action=edit&nid=<? echo $subnid; ?>"><img src="images/edit.png" /></a>
					<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $subnid; ?>')" ><img src="images/delete.png"></a>
				</td>
			 </tr>
    <? } ?>

<?php
	}
?>
	</table>

<?php	
	break;

	case	"edit":
	if($nid){
		$sql = "SELECT navtitle,imgfile,imgfilesel,pageid,parent,publish,cssid,extlink FROM nav WHERE id='$nid'";
		$result = mysql_query($sql);
			
			$navtitlenew		= mysql_result($result, 0, "navtitle");
			$imgfilenew			= mysql_result($result, 0, "imgfile");
			$imgfileselnew		= mysql_result($result, 0, "imgfilesel");
			$navpagenew			= mysql_result($result, 0, "pageid");
			$navparentnew		= mysql_result($result, 0, "parent");
			$navpublishnew		= mysql_result($result, 0, "publish");
			$cssidnew			= mysql_result($result, 0, "cssid");
			$extlinknew			= mysql_result($result, 0, "extlink");

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
        	<td nowrap="nowrap"><label>NAVIGATION TITLE</label></td>
            <td><input type="text" name="navtitlenew" maxlength="80" value="<? echo $navtitlenew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>PARENT</label></td>
	        <td>
                <select name="navparentnew" class="smallInput">
                <option value="">None</option>
					<?
						$sql = "SELECT navtitle,id FROM nav WHERE publish='1' AND parent='0'";
						$result = mysql_query($sql);
						$total = mysql_num_rows($result);
						
						for($cnt = 0; $cnt < $total; $cnt++){
							
							$id = mysql_result($result, $cnt, "id");
							$navtitle = mysql_result($result, $cnt, "navtitle");
					?>
							<option value="<? echo $id; ?>" <? if($id == $navparentnew){ echo " SELECTED"; } ?>><? echo $navtitle; ?></option>
					<?
						}
					?>
                </select>    
	        </td>
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>LINKED PAGE</label></td>
            <td>
				<select name="navpagenew" class="smallInput">
				<?
					$sql = "SELECT pagetitle,id FROM pages WHERE publish='1'";
					$result = mysql_query($sql);
					$total = mysql_num_rows($result);
					
					for($cnt = 0; $cnt < $total; $cnt++){
						
						$id = mysql_result($result, $cnt, "id");
						$pagetitlenew = mysql_result($result, $cnt, "pagetitle");
				?>
						<option value="<? echo $id; ?>" <? if($id == $navpagenew){ echo " SELECTED"; } ?>><? echo $pagetitlenew; ?></option>
				<?
					}
				?>
            	</select>    
			</td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>EXTERNAL URL</label></td>
            <td><input type="text" name="extlinknew" value="<? echo $extlinknew; ?>" class="smallInput"/></td>         
        </tr>
    </table>
	</div>
	<div class="twocol">
    <table border="0">
		<tr>
        	<td nowrap="nowrap"><label>IMAGE FILE</label></td>
            <td><input type="text" name="imgfilenew" value="<? echo $imgfilenew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>ALT IMAGE FILE</label></td>
            <td><input type="text" name="imgfileselnew" value="<? echo $imgfileselnew; ?>" class="smallInput"/></td>         
        </tr>
        <tr style="display:table-row;">
        	<td nowrap="nowrap"><label>CSS ID TAG</label></td>
            <td><input type="text" name="cssidnew" value="<? echo $cssidnew; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>PUBLISH</label></td>
        	<td>
        		<select name="navpublishnew" class="smallInput">
        			<option value="0">Draft</option>
        			<option value="1" <?php if($navpublishnew == 1){ echo " SELECTED"; } ?>>Published</option>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<?php if($nid){ ?>
	            	<input type="hidden" name="nid" value="<?php echo $nid; ?>" />
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