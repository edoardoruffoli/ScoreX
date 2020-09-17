<?php
	session_start();

	session_destroy();
	if(isset($_POST['noRedirect'])) echo 'Logged out successfully.';
		else
		{
			header("Location: ./../index.php");
			exit;
		}
?>