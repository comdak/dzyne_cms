<?php
if($action == ""){
	$action = "list";	
}
switch($action){
	case		"submit":
	if(isset($del)){
		$activity = "Deleted a scratch post";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
	
		$sql = "DELETE FROM scratchpad WHERE id='$del'";
		$result = mysql_query($sql);
		unset($del);
	}
	else{
		$activity = "Added a scratch post";
		$now = time();
		$result = mysql_query("INSERT INTO changelog (uname,action,activitytime) VALUES ('$username','$activity','$now')");
	
		$sql = "INSERT INTO scratchpad (note,uname,posttime) VALUES ('$scratchpad','$username','$now')";
		$result = mysql_query($sql);
	}
	
	case	"list":

?>
	<div class="notification"></div>
	<div class="twocol">	
		<h3>Welcome</h3>
		<br />
		<p>We are proud to offer the latest version of the Dzyne content management system. In version 3.0, we have rebuilt the system from the ground up to provide numerous enhancements made specifically with our client base in mind. A brand new user interface has been designed for ease of use and provide all of the functionality to you, the client, in the best possible way.</p>
		<br />
		<p> If you have any questions, or need any help with the CMS, please contact us <a href="mailto:contact@dzyne.ca" class="altlink">here.</a></p>
	</div>
	<div class="colspace"></div>
	<div class="smallcol">
		<h3>Current Drafts</h3>
		<br />
		<?php
		$sql = "SELECT id,pagetitle,publish FROM pages WHERE publish='0' ORDER BY id";
		$result = mysql_query($sql);
		$total = mysql_num_rows($result);
		
		if($total == 0){ ?>
			<p>There are no drafts at the moment.</p>
			
		<? } else { ?>
		<table class="data">
			<tr>
			<th width="200">Page Title</th>
			<th>Functions</th>
			</tr>
			<?php
			for($cnt = 0; $cnt < $total; $cnt++){
			
				$pagesid 			= mysql_result($result, $cnt, "id");
				$contenttitle		= mysql_result($result, $cnt, "pagetitle");
				?>
				<tr>
				<td nowrap="nowrap"><? echo $contenttitle; ?></td>
				<td>
					<a href="../index.php?page=<? echo $pagesid; ?>" target="_blank"><img src="images/preview.png"></a>
					<a href="admin.php?page=<? echo $page; ?>&action=edit&pgid=<? echo $pagesid; ?>"><img src="images/edit.png" /></a>
					<a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $pagesid; ?>')" ><img src="images/delete.png"></a>
				</td>
				</tr>
		<?php 	
			} 
		?>
			</table>
		<?php
		}
		?>
	</div>
	<div class="notification"></div>
	<div class="twocol">
	<h3>Recent Activity</h3>
	<br />	
	<table class="data">
		<tr>
			<th>Date/Time</th>
			<th>User</th>
			<th>Action</th>
		</tr>
		<?php
			$sql = "SELECT uname,action,activitytime FROM changelog ORDER BY id DESC LIMIT 0, 10";
			$result = mysql_query($sql);
			$total = mysql_num_rows($result);
			
			for($cnt = 0; $cnt < $total; $cnt++){
				$changeuser		= mysql_result($result, $cnt, "uname");
				$changeaction 	= mysql_result($result, $cnt, "action");
				$changetime		= mysql_result($result, $cnt, "activitytime");
				
				$changetime = date("Y-m-d H:i:s", $changetime);
		?>
			<tr>
				<td><?php echo $changetime; ?></td>
				<td><?php echo $changeuser; ?></td>
				<td><?php echo $changeaction; ?></td>
			</tr>
		<?php } ?>
	</table>
	</div>
	<div class="colspace"></div>
	<div class="smallcol">
		<h3>Scratch Pad</h3>
		<br />
		<form action="<? echo "admin.php?page=". $page; ?>" method="POST">
			<table class="data">
			<tr>
				<th colspan="2">
					<input type="text" name="scratchpad" id="scratchPad">
				</th>
			</tr>
			<tr>
				<th colspan="2">
	            	<input type="hidden" name="action" value="submit" />
		            <input type="submit" name="submit" value="Post" class="submitBtn" style="font-weight:normal;">
				</th>
			</tr>
			<?php
				$sql = "SELECT id,note,uname,posttime FROM scratchpad ORDER BY id DESC";
				$result = mysql_query($sql);
				$total = mysql_num_rows($result);
				for($cnt = 0; $cnt < $total; $cnt++){
					$spid		= mysql_result($result, $cnt, "id");
					$spnote		= mysql_result($result, $cnt, "note");
					$spuname	= mysql_result($result, $cnt, "uname");
					$spposttime = mysql_result($result, $cnt, "posttime");
					
					$spposttime = date("Y-m-d H:i:s", $spposttime);
					
			?>		
					<tr>
						<td>
							<?php echo $spnote; ?><br />
							<span class="smallText">Posted by: <?php echo $spuname; ?> @ <?php echo $spposttime; ?></span>
						</td>
						<td align="right"><a href="javascript:confirmDelete('admin.php?page=<?php echo $page; ?>&action=submit&del=<?php echo $spid; ?>')" ><img src="images/delete.png"></a>
						</td>
					</tr>
			<?php
				}
			?>
			</table>
		</form>
	</div>
<?php	
	break;
}
?>