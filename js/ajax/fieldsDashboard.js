function FieldDashboard(){}

FieldDashboard.DEFAULT_POSTER_URL = "./../css/images/fields/noposter.png";

FieldDashboard.removeContent = 
	function(){
		var dashboardElement = document.getElementById("FieldDashboard");
		if (dashboardElement === null)
			return;
		
		var firstChild = dashboardElement.firstChild;
		if (firstChild !== null)
			dashboardElement.removeChild(firstChild);	
	}

FieldDashboard.setEmptyDashboard = 
	function(){
		FieldDashboard.removeContent();		
	}
	
FieldDashboard.addMoreData =
	function(data){
		var dashboardElement = document.getElementById("FieldDashboard");
		if (dashboardElement === null || data === null || data.length <= 0)
			return;
		
		var fieldListItem = document.getElementById("FieldList");
		if (fieldListItem === null){
			fieldListItem = FieldDashboard.createFieldListElement();
			dashboardElement.appendChild(fieldListItem);
		}
		
		for (var i = 0; i < data.length; i++){
			var fieldItemElem = FieldDashboard.createFieldItemElement(data[i]);
			fieldListItem.appendChild(fieldItemElem);
		}		
	}

FieldDashboard.refreshData =
	function(data){
		FieldDashboard.removeContent();
		
		var newFieldListElem =	FieldDashboard.createFieldListElement();
		
		for (var i = 0; i < data.length; i++){
			var fieldItemElem = FieldDashboard.createFieldItemElement(data[i]);
			newFieldListElem.appendChild(fieldItemElem);
		}		
		document.getElementById("FieldDashboard").appendChild(newFieldListElem);	
	}
	
FieldDashboard.createFieldListElement = 
	function(){
		var fieldListItem = document.createElement("ul");
		fieldListItem.setAttribute("id", "FieldList");
		fieldListItem.setAttribute("class", "field_list");
		
		return fieldListItem;
	}

FieldDashboard.createFieldItemElement = 	
	function(currentData){
		var fieldItemLi = document.createElement("li");
		fieldItemLi.setAttribute("id", "field_item_" + currentData.field.fieldId);
		fieldItemLi.setAttribute("class", "field_item_wrapper");
		
		fieldItemLi.appendChild(FieldDashboard.createPosterElement(currentData));
		fieldItemLi.appendChild(FieldDashboard.createDetailFieldElement(currentData));
		fieldItemLi.appendChild(FieldDashboard.createRatingFieldElement(currentData));
		fieldItemLi.appendChild(FieldDashboard.createFavoriteFieldElement(currentData));

		return fieldItemLi; 
	}

FieldDashboard.createPosterElement =
	function(currentData){

		var posterDivElem = document.createElement("div");
		posterDivElem.setAttribute("class", "poster_field_item");
		
		var posterLinkElem = document.createElement("a");
		posterLinkElem.setAttribute("href", "./detailedfield.php?fieldId=" + currentData.field.fieldId);
		
		var posterImgElem = new Image();
		posterImgElem.alt = "poster";
		posterImgElem.src = currentData.field.posterUrl;
		if (currentData.field.posterUrl === "N/A")
			posterImgElem.src = FieldDashboard.DEFAULT_POSTER_URL;
				
		posterLinkElem.appendChild(posterImgElem);
		posterDivElem.appendChild(posterLinkElem);
		
		return posterDivElem;
	}
			
FieldDashboard.createDetailFieldElement =
	function(currentData){

		var detailFieldDivElem = document.createElement("div");
		detailFieldDivElem.setAttribute("class", "detail_field_item");
		
		var detailFieldLinkElem = document.createElement("a");
		detailFieldLinkElem.setAttribute("href", "./detailedfield.php?fieldId=" + currentData.field.fieldId);
		detailFieldLinkElem.textContent = currentData.field.nome;
		
		var detailFieldAddressPElem = document.createElement("p");
		detailFieldAddressPElem.textContent = currentData.field.indirizzo;
		
		detailFieldDivElem.appendChild(detailFieldLinkElem);
		detailFieldDivElem.appendChild(detailFieldAddressPElem);
		
		return detailFieldDivElem;	
	}

FieldDashboard.createRatingFieldElement = 
	function(currentData){

		var ratingFieldDivElem = document.createElement("div");
		ratingFieldDivElem.setAttribute("class", "rating_field_item");

		var rating = currentData.field.starRating;
		var i;
		for(i=0; i<rating; i++){
			var ratingFieldCheckedStarElem = document.createElement("span");
			ratingFieldCheckedStarElem.setAttribute("class", "rating_field_star checked");
			ratingFieldDivElem.appendChild(ratingFieldCheckedStarElem);
		}
		while(i<5){
			var ratingFieldUncheckedStarElem = document.createElement("span");
			ratingFieldUncheckedStarElem.setAttribute("class", "rating_field_star");
			ratingFieldDivElem.appendChild(ratingFieldUncheckedStarElem);
			i++;
		}

		return ratingFieldDivElem;
	}

FieldDashboard.createFavoriteFieldElement = 
	function(currentData){

		var favoriteFieldDivElem = document.createElement("div");
		var favoriteFieldItemElem = document.createElement("div");
		
		favoriteFieldDivElem.setAttribute("class", "favorite_field_item");
		favoriteFieldItemElem.setAttribute("id", "favorite_field_item_" + currentData.field.fieldId);
		favoriteFieldItemElem.setAttribute("class", "favorite_img_" + currentData.userFieldStat.favorite);
		favoriteFieldItemElem.setAttribute("onClick", "UserFieldEventHandler.onFavoriteEvent(" + currentData.field.fieldId + ")");

		favoriteFieldDivElem.appendChild(favoriteFieldItemElem);

		return favoriteFieldDivElem;
	}

FieldDashboard.updateFavoriteFieldElement = 
	function(currentData){
		if (document.getElementById("favorite_field_item_" + currentData.field.fieldId) === null)
			return;
		var favoriteFieldItemElem;

		favoriteFieldItemElem = document.getElementById("favorite_field_item_" + currentData.field.fieldId);
		favoriteFieldItemElem.setAttribute("class", "favorite_img_" + currentData.userFieldStat.favorite);
	}

FieldDashboard.noSearch = 
	function(){
		if(document.getElementsByClassName("ad").length != 0)
			return;

		var addSearchItem = document.createElement("div");
		addSearchItem.setAttribute("class", "ad");

		var thisPattern = document.getElementById("searchByPattern").value;
		var addSearchItemElemH1 = document.createElement("h1");
		addSearchItemElemH1.textContent = "Nessun campo trovato :( con la keyword '" + thisPattern +"'";

		var addSearchItemElemH2 = document.createElement("h2");
		addSearchItemElemH2.textContent = "Prova con un'altra parola chiave ";

		addSearchItem.appendChild(addSearchItemElemH1);
		addSearchItem.appendChild(addSearchItemElemH2);

		document.getElementById("FieldDashboard").appendChild(addSearchItem);
	}

FieldDashboard.noFavorite = 
	function(){
		if(document.getElementsByClassName("ad").length != 0)
			return;

		var addFavoriteItem = document.createElement("div");
		addFavoriteItem.setAttribute("class", "ad");

		var addFavoriteItemElemH1 = document.createElement("h1");
		addFavoriteItemElemH1.textContent = "Nessuna preferenza trovata :(";

		var addFavoriteItemElemH2 = document.createElement("h2");
		addFavoriteItemElemH2.textContent = "Aggiungi subito un campo ai preferiti cliccando ";

		var addFavoriteItemElemLink = document.createElement("a");
		addFavoriteItemElemLink.setAttribute("href", "./prenota.php");
		addFavoriteItemElemLink.textContent = "QUI";

		addFavoriteItem.appendChild(addFavoriteItemElemH1);
		addFavoriteItem.appendChild(addFavoriteItemElemH2);
		addFavoriteItem.appendChild(addFavoriteItemElemLink);

		document.getElementById("FieldDashboard").appendChild(addFavoriteItem);
	}
