function ReviewLoader(){}

ReviewLoader.DEFAUL_METHOD = "GET";
ReviewLoader.URL_REQUEST = "./ajax/reviewLoader.php";
ReviewLoader.ASYNC_TYPE = true;
ReviewLoader.SUCCESS_RESPONSE = "0";
ReviewLoader.NO_MORE_DATA = "-1";

//PRENOTA
ReviewLoader.loadReviewByRating =
	function(fieldId, rating){
		if(rating === null || fieldId === null){
			return;
		}
		var queryString = "?fieldId=" + fieldId + "&rating=" + rating;
		var url = ReviewLoader.URL_REQUEST + queryString;
		var responseFunction = ReviewLoader.onAjaxResponse;	
	
		AjaxManager.performAjaxRequest(ReviewLoader.DEFAUL_METHOD, url, ReviewLoader.ASYNC_TYPE, null, responseFunction);
	}

//RESPONSE
ReviewLoader.onAjaxResponse = 
	function(response){
		if (response.responseCode === ReviewLoader.NO_MORE_DATA ){
			ReviewDashboard.removeContent();
			return;
		}
		
		if (response.responseCode === ReviewLoader.SUCCESS_RESPONSE){
			ReviewDashboard.refreshData(response.data);
			return;
		}
	}
