<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once __DIR__ . "./../util/fieldsManagerDb.php";
	require_once DIR_AJAX_UTIL . "ajaxResponse.php";
	//require_once DIR_AJAX_UTIL . "functionsResponse.php";
    
    if (!isset ($_GET['fieldId']) || !isset($_GET['rating'])){
		echo json_encode($response);
		return;
	}		
	
	$response = new AjaxResponse();
    
    $fieldId = $_GET['fieldId'];
    $rating = $_GET['rating'];

    if($rating != 0) {
        $result = getReviewsByFieldIdAndRating($fieldId, $rating);
    }
    else {
        $result = getReviewsByFieldId($fieldId);
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
		$message = "No more reviews to load";
		return new AjaxResponse("-1", $message);
	}
	
	function setResponse($result, $message){
		$response = new AjaxResponse("0", $message);
			
		$index = 0;
		while ($row = $result->fetch_assoc()){

			// Set Review class
            $review = new Review();
            $review->idReview = $row['idReview'];
			$review->userId = $row['userId'];
			$review->username = $row['username'];
			$review->fieldId = $row['fieldId'];
			$review->IdPrenotazione = $row['IdPrenotazione'];
			$review->rating = $row['rating'];
            $review->reviewTitle = $row['reviewTitle'];
			$review->review = $row['review'];
			$review->dataR = $row['dataR'];

			$response->data[$index] = $review;
			$index++;
		}
		return $response;
	}
?>
