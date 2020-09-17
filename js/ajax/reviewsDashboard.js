function ReviewDashboard(){}

ReviewDashboard.DEFAULT_POSTER_URL = "./../css/images/reviews/noposter.png";

ReviewDashboard.removeContent = 
	function(){
		var dashboardElement = document.getElementById("ReviewsDashboard");
		if (dashboardElement === null)
			return;
		
		var firstChild = dashboardElement.firstChild;
		if (firstChild !== null)
			dashboardElement.removeChild(firstChild);	
	}

ReviewDashboard.setEmptyDashboard = 
	function(){
		ReviewDashboard.removeContent();		
	}
	
ReviewDashboard.addMoreData =
	function(data){
		var dashboardElement = document.getElementById("ReviewsDashboard");
		if (dashboardElement === null || data === null || data.length <= 0)
			return;
		
		var reviewListItem = document.getElementById("reviewList");
		if (reviewListItem === null){
			reviewListItem = ReviewDashboard.createReviewListElement();
			dashboardElement.appendChild(reviewListItem);
		}
		
		for (var i = 0; i < data.length; i++){
			var reviewItemElem = ReviewDashboard.createReviewItemElement(data[i]);
			reviewListItem.appendChild(reviewItemElem);
		}		
	}

ReviewDashboard.refreshData =
	function(data){
		ReviewDashboard.removeContent();
		
		var newreviewListElem =	ReviewDashboard.createReviewListElement();
		
		for (var i = 0; i < data.length; i++){
			var reviewItemElem = ReviewDashboard.createReviewItemElement(data[i]);
			newreviewListElem.appendChild(reviewItemElem);
		}		
		document.getElementById("ReviewsDashboard").appendChild(newreviewListElem);	
	}
	
ReviewDashboard.createReviewListElement = 
	function(){
		var reviewListItem = document.createElement("ul");
		reviewListItem.setAttribute("id", "ReviewsList");
		reviewListItem.setAttribute("class", "review_list");
		
		return reviewListItem;
	}

ReviewDashboard.createReviewItemElement = 	
	function(currentData){
		var reviewItemLi = document.createElement("li");
		reviewItemLi.setAttribute("id", "review_item_" + currentData.idReview);
		reviewItemLi.setAttribute("class", "review_item_wrapper");
	
		reviewItemLi.appendChild(ReviewDashboard.createRatingReviewElement(currentData));
		reviewItemLi.appendChild(ReviewDashboard.createDetailReviewElement(currentData));

		return reviewItemLi; 
	}
ReviewDashboard.createRatingReviewElement = 
	function(currentData){

		var ratingReviewDivElem = document.createElement("div");
		ratingReviewDivElem.setAttribute("class", "rating_review_item");

		var rating = currentData.rating;
		var i;
		for(i=0; i<rating; i++){
			var ratingReviewCheckedStarElem = document.createElement("span");
			ratingReviewCheckedStarElem.setAttribute("class", "rating_field_star checked");
			ratingReviewDivElem.appendChild(ratingReviewCheckedStarElem);
		}
		while(i<5){
			var ratingReviewUncheckedStarElem = document.createElement("span");
			ratingReviewUncheckedStarElem.setAttribute("class", "rating_field_star unchecked");
			ratingReviewDivElem.appendChild(ratingReviewUncheckedStarElem);
			i++;
		}

		var ratingDateElem = document.createElement("span");
		ratingDateElem.textContent = " Recensito il " + currentData.dataR;
		ratingReviewDivElem.appendChild(ratingDateElem);

		var ratingUserElem = document.createElement("span");
		ratingUserElem.textContent = currentData.username;
		ratingUserElem.setAttribute("class", "username_rating");
		ratingReviewDivElem.appendChild(ratingUserElem);

		return ratingReviewDivElem;
	}

ReviewDashboard.createDetailReviewElement =
	function(currentData){

		var detailReviewDivElem = document.createElement("div");
		detailReviewDivElem.setAttribute("class", "text_review_item");
		
		var detailReviewTitleElem = document.createElement("h3");
		detailReviewTitleElem.textContent = currentData.reviewTitle;

		var detailReviewTextElem = document.createElement("p");
		detailReviewTextElem.textContent = currentData.review;
		
		detailReviewDivElem.appendChild(detailReviewTitleElem);
		detailReviewDivElem.appendChild(detailReviewTextElem);
		
		return detailReviewDivElem;	
	}
