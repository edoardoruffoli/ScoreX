<?php
	function showError(){
		echo '<div class="error"><span>Sorry but something went wrong. Please try later!</span></div>';
	} 
	
	function showWarning($message){
		echo '<div class="warning"><span>' . $message . '</span></div>';
	}	

	function showErrorNoFields(){
		echo '<div class="error"><span>ERROR! No fields found :( </span></div>';
	}

	function showErrorNoBookings(){
		echo '<div class="error"><span>ERROR! No bookings found :( </span></div>';
	}

	function showErrorNoReviews(){
		echo '<div class="error"><span>ERROR! No reviews found :( </span></div>';
	}
?>