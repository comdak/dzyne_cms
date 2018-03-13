<?

if($action == ""){
	$action = "input";	
}

switch($action){
	
	case		"submit":
		
		if($contname == "" || $contemail == "" || $contphone == "" || $contmessage == ""){
			$error = "Please fill in all fields before pressing send.";
			$action = "input";
		}
		else{
			
			$contmessage = strip_tags($contmessage);
			
			$sql = "INSERT INTO contactform (companyname,contactname,email,phone,message) VALUES ('$contcompany','$contname','$contemail','$contphone','$contmessage')";
			$result = mysql_query($sql);
			$success = "Message sent! One of our representatives will be in touch soon.";
			
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:'. $contname .'<'.$contemail .'>'.  "\r\n";		
		$to = "contact@dzyne.ca";
		$subject = "New Request for Information";
		
		$body = "<table><tr><td>Company Name:</td><td> $contcompany</td></tr>
						<tr><td>Contact Name:</td><td> $contname</td></tr> 
						<tr><td>E-Mail:</td><td> $contemail</td></tr>
						<tr><td>Phone:</td><td> $contphone</td></tr>
						<tr><td>Comment/Question:</td><td> $contmessage</td</tr></table>";
		 
		$action = "submit";
		$sent = 1;
		
		mail($to, $subject, $body, $headers);
		

			
			
			
		}
	
	case		"input":
	
?>
		<p>We are committed to supporting our new and existing customers. If you have questions or comments about any of our products or services, please feel free to get in touch with us, and we'll do our best to answer your questions.</p>
<br />
<p>Simply fill out this form, and we will get back to you right away.</p>


	<form action="<? echo "index.php?page=". $page; ?>" method="POST">
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
        	<td nowrap="nowrap"><label>COMPANY NAME</label></td>
            <td><input type="text" name="contcompany" maxlength="80" value="<? echo $contcompany; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>YOUR NAME</label></td>
            <td><input type="text" name="contname" maxlength="255" value="<? echo $contname; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
        	<td nowrap="nowrap"><label>EMAIL ADDRESS</label></td>
            <td><input type="text" name="contemail" maxlength="255" value="<? echo $contemail; ?>" class="smallInput"/></td>         
        </tr>
        <tr>
    </table>
</div>
<div class="twocol">
    <table border="0">
		<tr>
        	<td nowrap="nowrap"><label>PHONE NUMBER</label></td>
            <td><input type="text" name="contphone" maxlength="40" value="<? echo $contphone; ?>" class="smallInput"/></td>         
        </tr>
        	<td nowrap="nowrap"><label>YOUR MESSAGE</label></td>
            <td><textarea class="textbox" name="contmessage" value="<? echo $contmessage; ?>" class="smallInput"/></textarea></td>         
        </tr>
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="2" align="right">
            	<input type="hidden" name="action" value="submit" />
            	<input type="submit" name="submit" value="Send" class="submitBtn">
            </td>
    	</tr>
    </table>
</div>
</form>
<?	
	break;
}
?>