<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once __DIR__ . "./../util/fieldsManagerDb.php";
	require_once DIR_AJAX_UTIL . "ajaxResponse.php";
	//require_once DIR_AJAX_UTIL . "functionsResponse.php";
	
	$response = new AjaxResponse();
	
	if (!isset ($_GET['type']) || !isset($_GET['fieldToLoad']) || !isset($_GET['offset'])){
		echo json_encode($response);
		return;
	}		
	
	$type = $_GET['type'];
	$fieldToLoad = $_GET['fieldToLoad'];
	$offset = $_GET['offset'];

	switch ($type){
		case 0:
			if(!isset ($_GET['citta']) || !isset ($_GET['sort']))
				return;
			$citta = $_GET['citta'];
			switch($_GET['sort']){
				case "RatingDESC":
					$sort = "AVG(R.rating) DESC";
					break;
				case "RatingASC":
					$sort = "AVG(R.rating) ASC";
					break;
				default:
					$sort = "F.fieldId";
					break;
			}
			$result = getFieldByCitta($citta, $offset, $fieldToLoad, $sort);
			break;
		case 1:
			if(!isset ($_GET['citta']) || !isset ($_GET['pattern']))
				return;
			$citta = $_GET['citta'];
			$pattern = $_GET['pattern'];
			$result = getFieldByPattern($pattern, $citta, $offset, $fieldToLoad);
			break;
		case 2:
			if(!isset ($_GET['userId']))
				return;
			$userId = $_GET['userId'];
			$result = getFieldByUserFavorite($userId, $offset, $fieldToLoad);
			break;
		default:
			$result = null;
			break;
	}
	
	if (checkEmptyResult($result)){
		$response = setEmptyResponse();
		echo json_encode($response);
		return;
	}
	
	$message = "OK";	
	$response = setResponse($result, $message);
	echo json_encode($response);
	return;

	function checkEmptyResult($result){
		if ($result === null || !$result)
			return true;
		return ($result->num_rows <= 0);
	}
	
	function setEmptyResponse(){
		$message = "No more fields to load";
		return new AjaxResponse("-1", $message);
	}
	
	function setResponse($result, $message){
		$response = new AjaxResponse("0", $message);
			
		$index = 0;
		while ($row = $result->fetch_assoc()){
			// Set UserStat class
			$userStat = new UserStat();
			
			$userFieldResult = getUserFieldStat($_SESSION['userId'], $row['fieldId']);
			if ($userFieldRow = $userFieldResult->fetch_assoc()){
				$userStat->favorite = $userFieldRow['favorite'];		
			}

			//creo Field class
			$field = new Field();
			$field->fieldId = $row['fieldId'];
			$field->posterUrl = $row['poster'];
			$field->nome = $row['nome'];
			$field->indirizzo = $row['indirizzo'];

			//rating
			$rating = getAveragereviewRating($row['fieldId']);
			$rating = number_format((float)$rating, 1, '.', ''); //arrotondo alla seconda cifra dec
			$starRating = ($rating - floor($rating) >= 0.5)?floor($rating)+1:floor($rating); //parte frazionaria 
			$field->starRating = $starRating;

			//creo fieldUserStat class 		
			$fieldUserStat = new FieldUserStat($field, $userStat);
		
			$response->data[$index] = $fieldUserStat;//$fieldUserStat;
			$index++;
		}
		return $response;
	}

?>
