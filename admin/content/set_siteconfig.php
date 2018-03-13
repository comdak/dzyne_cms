<?

if($action == ""){
	$action = "input";	
}

switch($action){
	
	case		"submit":
	
		if($homedirnew == "" || $sitenamenew == "" || $metadescnew == "" || $metakeywordsnew == "" || $imgpathnew== "" || $filepathnew == ""){
			$error = "Please fill in all fields";
			$action = "input";
		}
		else{
		
			$activity = "Modified site parameters";
			$now = time();
			$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");

			$sql = "UPDATE siteconfig SET homedir='$homedirnew',sitename='$sitenamenew',metadesc='$metadescnew',metakeywords='$metakeywordsnew',imgpath='$imgpathnew',filepath='$filepathnew',mainpage='$mainpagenew',mainnav='$mainnavnew' WHERE id='1'";
			$result = mysql_query($sql);
			$success = "All fields have been updated successfully";
		}
	
	case		"input":
	
	$sql = "SELECT homedir,sitename,metadesc,metakeywords,imgpath,filepath,mainpage,mainnav FROM siteconfig WHERE id='1'";
	$result = mysql_query($sql);
	
	$homedir 				= mysql_result($result, 0, "homedir");
	$sitename				= mysql_result($result, 0, "sitename");
	$metadesc				= mysql_result($result, 0, "metadesc");
	$metakeywords			= mysql_result($result, 0, "metakeywords");
	$imgpath				= mysql_result($result, 0, "imgpath");
	$filepath				= mysql_result($result, 0, "filepath");
	$mainpage				= mysql_result($result, 0, "mainpage");
	$mainnav				= mysql_result($result, 0, "mainnav");
?>
	

	<form action="<? echo "admin.php?page=". $page; ?>" method="POST">
	<div class="notification">
		<? if($error){ ?>
			<p class="err"><?php echo $error; ?></p></td>
		<? } ?>
		<? if ($success){ ?>
			<p class="success"><?php echo $success; ?></p></td>
		<? } ?>
	</div>
	<div class="twocol">
    <table border="0">
        <tr>
        	<td nowrap="nowrap"><label>SITE NAME</label></td>
            <td><input type="text" name="sitenamenew" maxlength="80" value="<? echo $sitename; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>META DESCRIPTION</label></td>
            <td><input type="text" name="metadescnew" maxlength="255" value="<? echo $metadesc; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>META KEYWORDS</label></td>
            <td><input type="text" name="metakeywordsnew" maxlength="255" value="<? echo $metakeywords; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
    </table>
</div>
<div class="twocol">
    <table border="0">
		<tr>
        	<td nowrap="nowrap"><label>HOME DIRECTORY</label></td>
            <td><input type="text" name="homedirnew" maxlength="40" value="<? echo $homedir; ?>" class="smallInput"/></td>         
        </tr>
        	<td nowrap="nowrap"><label>IMAGE PATH</label></td>
            <td><input type="text" name="imgpathnew" maxlength="255" value="<? echo $imgpath; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>FILE PATH</label></td>
            <td><input type="text" name="filepathnew" maxlength="255" value="<? echo $filepath; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>MAIN PAGE</label></td>
            <td><input type="text" name="mainpagenew" maxlength="5" value="<? echo $mainpage; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>MAIN NAVIGATION</label></td>
            <td><input type="text" name="mainnavnew" maxlength="5" value="<? echo $mainnav; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<input type="submit" name="submit" value="Update" class="submitBtn">
            </td>
    	</tr>
    </table>
</div>
</form>
<?	
	break;
}
?>