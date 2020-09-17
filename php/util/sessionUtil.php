<?php
	
	//setSession: set $_SESSION properly
	function setSession($username, $userId, $userType){
		$_SESSION['userId'] = $userId;
		$_SESSION['username'] = $username;
		$_SESSION['userType'] = $userType;
	}

	//isLogged: check if user has logged in and if true returns the user id
	function isLogged(){		
		if(isset($_SESSION['userId']))
			return $_SESSION['userId'];
		else
			return false;
	}

?>