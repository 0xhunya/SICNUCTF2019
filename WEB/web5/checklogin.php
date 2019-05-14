<?php

	if (isset($_COOKIE['token'])) {

		$token = $_COOKIE['token'];

		if ($payload = Jwt::verifyToken($token)) {

			$login = true;

			$username = $payload['username'];
			
			$isvip = $payload['isvip'];
		}else{

			$login = false;

			echo "<script>alert('Token Error!')</script>;location.href=index.php;";

			exit();
		}

	}else{

		$login = false;
	}

?>