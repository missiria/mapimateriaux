<?php

	require_once"../../inc/settings.php";
	require_once"../../inc/functions.php";
	
	if(isset($_POST['user'])) {
		
		$user = $_POST['user'];
		$password = sha1($_POST['password']);
		
		$q = "SELECT * FROM users WHERE user = :user";
		
		$query = $odb->prepare($q);
		$query->execute(array(
			":user" => $user		
		));
		$results = $query->fetchAll();
		
		//var_dump($results);exit();
		
		if($results != FALSE && $query-> rowCount() > 0) {
			if($results[0]['password'] == $password) {
				$_SESSION['user'] = $user;
				
				// header("location: index.php");
				// It's reload into the iframe !!
				// that's wrong !!!
				
				echo iframeRedirect();			
				
			} else {
				echo "Votre mot de pass est incorrect  !!<br />";
			}
		} else {
			echo "Saisie votre login et mot de passe !!<br />";
		}
			
	}

?>