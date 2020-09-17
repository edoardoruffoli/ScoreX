function FieldLoader(){}	//MODULE

FieldLoader.DEFAUL_METHOD = "GET";
FieldLoader.URL_REQUEST = "./ajax/fieldLoader.php";
FieldLoader.EXPLORE_REQUEST = "./ajax/exploreLoader.php";
FieldLoader.FAVORITE_REQUEST = "./ajax/favoriteLoader.php";
FieldLoader.ASYNC_TYPE = true;

FieldLoader.FIELD_TO_LOAD = 3;
FieldLoader.CHUNK_LOADED = 1;

FieldLoader.FIELD_BY_CITY = 0;
FieldLoader.FIELD_BY_CITY_PATTERN = 1;
FieldLoader.FIELD_BY_USER_FAVORITE = 2;

FieldLoader.SUCCESS_RESPONSE = "0";
FieldLoader.NO_MORE_DATA = "-1";

//PRENOTA
FieldLoader.loadDataByCitta =
	function(citta){
		if(citta === null){
			return;
		}
		FieldLoader.CHUNK_LOADED = 1;	//Re-inizializzo: nel caso di inserimento e successiva cancellazione di un pattern di ricerca
		var sortByElem = document.getElementById("sortBy");
		var sortBy = sortByElem.options[sortByElem.selectedIndex].value;

		var queryString = "?type=" + FieldLoader.FIELD_BY_CITY + "&sort=" + sortBy + "&citta=" + citta + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD 
							+ "&offset=" + (FieldLoader.CHUNK_LOADED-1)*FieldLoader.FIELD_TO_LOAD;
		var url = FieldLoader.URL_REQUEST + queryString;
		var responseFunction = FieldLoader.onAjaxResponse;	

		AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);
	}

FieldLoader.loadMoreByCitta = 
	function(citta){
		if(citta === null){
			return;
		}
		/* DEBUG
		document.write(document.documentElement.scrollTop);
		document.write("       " + document.height+ "     " + window.innerHeight);
		*/

		/* Scroll con JQuery
		var body = document.body,
    		html = document.documentElement;

			var height = Math.max( body.scrollHeight, body.offsetHeight, 
								html.clientHeight, html.scrollHeight, html.offsetHeight );
		*/

		var pattern = document.getElementById("searchByPattern").value;//per evitare che aggiorni durante la ricerca by pattern
		var sortByElem = document.getElementById("sortBy");
		var sortBy = sortByElem.options[sortByElem.selectedIndex].value;

		if  ((document.documentElement.scrollTop >= window.innerHeight - 500) && (pattern === null || pattern.length === 0) ){		//FACENDO PROVE
			var queryString = "?type=" + FieldLoader.FIELD_BY_CITY + "&sort=" + sortBy + "&citta=" + citta + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + 
					"&offset=" + (FieldLoader.CHUNK_LOADED)*FieldLoader.FIELD_TO_LOAD; 
			
			FieldLoader.CHUNK_LOADED++;		
			var url = FieldLoader.URL_REQUEST + queryString;
			var responseFunction = FieldLoader.onAjaxResponse;
		
			AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);	
		}
	}

FieldLoader.loadDataByCittaAndPattern =
	function(pattern, citta){
		if (pattern === null || pattern.length === 0){		
			FieldLoader.loadDataByCitta(citta);				//lascia invariata la lista dei campi
			return;	
		}
		var queryString = "?type=" + FieldLoader.FIELD_BY_CITY_PATTERN + "&pattern=" + pattern + "&citta=" + citta + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + "&offset=" + (FieldLoader.CHUNK_LOADED-1)*FieldLoader.FIELD_TO_LOAD; 
		
		var url = FieldLoader.URL_REQUEST + queryString;
		var responseFunction = FieldLoader.onSearchByPatternAjaxResponse;
	
		AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);
	}

//PREFERITI
FieldLoader.loadDataByUserFavorite = 
	function(userId){
		if(userId === null){
			return;
		}
		var queryString = "?type=" + FieldLoader.FIELD_BY_USER_FAVORITE +"&userId=" + userId + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + "&offset=" + (FieldLoader.CHUNK_LOADED-1)*FieldLoader.FIELD_TO_LOAD; 
		
		var url = FieldLoader.URL_REQUEST + queryString;
		var responseFunction = FieldLoader.onUserFavoriteAjaxResponse;
	
		AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);
	}

FieldLoader.loadMoreByUserFavorite = 
	function(userId){
		if(userId === null){
			return;
		}
		/* PER DEBUG
		document.write(document.documentElement.scrollTop);
		document.write("       " + window.innerHeight);
*/
		if  (document.documentElement.scrollTop >=  window.innerHeight - 500){		//FACENDO PROVE

			var queryString = "?type=" + FieldLoader.FIELD_BY_USER_FAVORITE +"&userId=" + userId + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + 
					"&offset=" + (FieldLoader.CHUNK_LOADED)*FieldLoader.FIELD_TO_LOAD; 
			
			FieldLoader.CHUNK_LOADED++;		
			var url = FieldLoader.URL_REQUEST + queryString;
			var responseFunction = FieldLoader.onUserFavoriteAjaxResponse;
		
			AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);	
		}
	}

//CRONOLOGIA
FieldLoader.loadDataByUserBookings = 
	function(userId){
		if(userId === null){
			return;
		}
		var queryString = "?userId=" + userId + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + "&offset=" + (FieldLoader.CHUNK_LOADED-1)*FieldLoader.FIELD_TO_LOAD; 
		
		var url = FieldLoader.URL_REQUEST + queryString;
		var responseFunction = FieldLoader.onUserFavoriteAjaxResponse;
	
		AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);
	}

FieldLoader.loadMoreByUserBookings = 
	function(userId){
		if(userId === null){
			return;
		}
		/* DEBUG
		document.write(document.documentElement.scrollTop);
		document.write("       " + window.innerHeight);
*/
		if  (document.documentElement.scrollTop >=  window.innerHeight - 500){		//FACENDO PROVE

			var queryString = "?userId=" + userId + "&fieldToLoad=" + FieldLoader.FIELD_TO_LOAD + 
					"&offset=" + (FieldLoader.CHUNK_LOADED)*FieldLoader.FIELD_TO_LOAD; 
			
			FieldLoader.CHUNK_LOADED++;		
			var url = FieldLoader.URL_REQUEST + queryString;
			var responseFunction = FieldLoader.onUserFavoriteAjaxResponse;
		
			AjaxManager.performAjaxRequest(FieldLoader.DEFAUL_METHOD, url, FieldLoader.ASYNC_TYPE, null, responseFunction);	
		}
	}

//RESPONSE
FieldLoader.onAjaxResponse = 
	function(response){
		if (response.responseCode === FieldLoader.NO_MORE_DATA && FieldLoader.CHUNK_LOADED === 1 ){
			FieldDashboard.removeContent();
			return;
		}
		
		if (response.responseCode === FieldLoader.SUCCESS_RESPONSE && FieldLoader.CHUNK_LOADED === 1 ){
			FieldDashboard.refreshData(response.data);
			return;
		}
		if (response.responseCode === FieldLoader.SUCCESS_RESPONSE){
			FieldDashboard.addMoreData(response.data);	//fieldDashboard
		}
	}

FieldLoader.onSearchByPatternAjaxResponse = 
	function(response){
		if(response.responseCode === FieldLoader.NO_MORE_DATA){
			FieldDashboard.setEmptyDashboard();
			FieldDashboard.noSearch();
			return;
		}
		if (response.responseCode === FieldLoader.SUCCESS_RESPONSE){
			FieldDashboard.refreshData(response.data);	//fieldDashboard
		}
	}

FieldLoader.onUserFavoriteAjaxResponse = 
	function(response){
		if(response.responseCode === FieldLoader.NO_MORE_DATA && FieldLoader.CHUNK_LOADED === 1){
				FieldDashboard.noFavorite();
				return;
			}
		
		if (response.responseCode === FieldLoader.SUCCESS_RESPONSE)
			FieldDashboard.addMoreData(response.data);	//fieldDashboard

	}
