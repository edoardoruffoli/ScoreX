function UserFieldEventHandler(){}

UserFieldEventHandler.DEFAUL_METHOD = "GET";
UserFieldEventHandler.URL_REQUEST = "./ajax/userFieldInteraction.php";
UserFieldEventHandler.ASYNC_TYPE = true;

UserFieldEventHandler.SUCCESS_RESPONSE = "0";

UserFieldEventHandler.onFavoriteEvent = 
	function(fieldId){
		var flag =  getComplementaryFlag(document.getElementById("favorite_field_item_" + fieldId))
		var queryString = "?fieldId=" + fieldId + "&favorite=" + flag;
		var url = UserFieldEventHandler.URL_REQUEST + queryString;
		var responseFunction = UserFieldEventHandler.onAjaxResponse;
	
		AjaxManager.performAjaxRequest(UserFieldEventHandler.DEFAUL_METHOD, 
										url, UserFieldEventHandler.ASYNC_TYPE, 
										null, responseFunction)
	}	

UserFieldEventHandler.onAjaxResponse = 
	function(response){
		if (response.responseCode === UserFieldEventHandler.SUCCESS_RESPONSE)
			FieldDashboard.updateFavoriteFieldElement(response.data);
		
	}

function getComplementaryFlag(item){
	var classAttribute = item.getAttribute("class");
	var currentFlag = parseInt(classAttribute.charAt(classAttribute.length-1)); // parseInt(classAttribute.slice(-1));
	return (currentFlag+1)%2;
}
