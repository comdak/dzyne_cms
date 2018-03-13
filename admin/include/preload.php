<?php
	$preloadsql = "SELECT imgfilesel FROM portalnav WHERE imgfilesel != ''";
	$preloadresult = mysql_query($preloadsql);
	$preloadcount = mysql_num_rows($preloadresult);

	if($preloadcount > 0){
?>

<script type="text/javascript" language="javascript">

    if (document.images)
    {
      preload_image_object = new Image();
      // set image url
      image_url = new Array();
      beginurl = "http://<? echo $httphost; ?>/admin/";
	  <?php
	  for($x = 0; $x < $preloadcount; $x++){
			$preload = mysql_result($preloadresult, $x, "imgfilesel");
			echo "image_url[". $x ."] = beginurl + \"". $preload ."\";\n";
	  }
	  
	  ?>

       var i = 0;
       for(i=0; i<=<? echo $preloadcount; ?>; i++) 
         preload_image_object.src = image_url[i];
    }
	
</script>
<?php } ?>