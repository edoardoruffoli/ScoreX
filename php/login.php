<?php
	require_once "./util/ScoreXDbManager.php"; //includes Database Class
    require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
 
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$errorMessage = login($username, $password);
	if($errorMessage === null)
		header('location: ./home.php');
	else
		header('location: ./../index.php?errorMessage=' . $errorMessage );


	function login($username, $password){   
		if ($username != null && $password != null){
			$password = md5($password);	//criptapassword
			echo $password;
			echo '<br>';
			$userRow = authenticate($username, $password);
			echo $userRow['password'];
			$userId = $userRow['userId'];
			$userType = $userRow['userType'];

    		if ($userId > 0){
    			session_start();
    			setSession($username, $userId, $userType);
    			return null;
    		}

    	} else
    		return 'You should insert something';
    	
    	return 'Username and password not valid.';
	}
	
	function authenticate ($username, $password){   
		global $ScoreXDb;
		$username = $ScoreXDb->sqlInjectionFilter($username);
		$password = $ScoreXDb->sqlInjectionFilter($password);

		$queryText = 'SELECT * FROM user WHERE username = \'' . $username . '\' AND password=\'' . $password . '\'';

		$result = $ScoreXDb->performQuery($queryText);
		$numRow = mysqli_num_rows($result);
		if ($numRow != 1)
			return -1;
		
		$ScoreXDb->closeConnection();
		$userRow = $result->fetch_assoc();
		$ScoreXDb->closeConnection();
		return $userRow;
	}

?>