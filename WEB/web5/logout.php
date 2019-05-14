<?php

	setcookie("token","",time()-3600);
	
	header("Refresh:0;url=index.php");

?>