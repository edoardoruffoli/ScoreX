<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "fieldsManagerDb.php";
	require_once DIR_AJAX_UTIL . "ajaxResponse.php";
	
	$response = new AjaxResponse();
	$message = "OK";
	
	$fieldId = null;
	if (!isset($_GET['fieldId']) || !isset($_GET['favorite'])){
		echo json_encode($response);
		return;
	}		
	
	$fieldId = $_GET['fieldId'];
	$currentFlag = $_GET['favorite'];

	if (setFavoriteUserStat($fieldId, $currentFlag))
		$response = setCorrectResponse($fieldId, $message);
				
	echo json_encode($response);
	return;
	
		
	function isUserFieldStatInDb($userId,$fieldId){
		$result = getUserFieldStat($userId, $fieldId);
		$numRows = $result->num_rows;
		return $numRows === 1;
	}
	
	function setFavoriteUserStat($fieldId, $favoriteFlag){
		if(isUserFieldStatInDb($_SESSION['userId'], $fieldId))
			$result = updateFavoriteUserFieldStat($_SESSION['userId'], $fieldId, $favoriteFlag);
		else
			$result = insertFavoriteUserFieldStat($_SESSION['userId'], $fieldId, $favoriteFlag);
		
		return $result;
	}
	
	function setCorrectResponse($fieldId, $message){
		$response = new AjaxResponse("0", $message);
		$result = getUserFieldStat($_SESSION['userId'], $fieldId);
		$userFieldRow = $result->fetch_assoc();
		
		//Set UserStat class
		$userStat = new UserStat();
		$userStat->favorite = $userFieldRow['favorite'];

		// Set Field class
		$Field = new Field();
		$Field->fieldId = $fieldId;
		
		// Set FieldUserStat class
		$fieldUserStat = new FieldUserStat($Field, $userStat);

		$response->data = $fieldUserStat;
		
		return $response;
	}

?>
