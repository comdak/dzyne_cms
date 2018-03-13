	<div class="notification">
		<? if($error){ ?>
			<p class="err"><?php echo $error; ?></p></td>
		<? } ?>
		<? if ($success){ ?>
			<p class="success"><?php echo $success; ?></p></td>
		<? } ?>
	</div>

<iframe src ="js/tiny_mce/plugins/filemanager/frameset.php?path=/home/<?php echo sitename; ?>/www/uploads&js=mcFileManager.insertFileToTinyMCE" style="background-color:#e3e3e3;width:900px;height:400px;border:1px solid #ddd;">
</iframe>
