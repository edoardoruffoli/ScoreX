<?php  
	/*
		AjaxResponse is the class that will be sent back to the client at every Ajax request.
		The class is serialize according the Json format through the json_encode function, that 
		serialize ONLY the public property.
		
		It is possibile to serialize also protected and private property but it is out of the course scope.
	*/
	class AjaxResponse{
		public $responseCode; // 0 all ok - 1 some errors - -1 some warning
		public $message;
		public $data;

		function AjaxResponse($responseCode = 1, 
								$message = "Somenthing went wrong! Please try later.",
								$data = null){
			$this->responseCode = $responseCode;
			$this->message = $message;
			$this->data = null;
		}
	}

	class FieldUserStat {
		public $field;
		public $userFieldStat;
	
		function FieldUserStat($field = null, $userFieldStat = null){
			$this->field = $field;
			$this->userFieldStat = $userFieldStat;
		}
	}

	class Field{
		public $fieldId;
		public $posterUrl;
		public $nome;
		public $indirizzo;
		public $starRating;
	
		function Field($fieldId = null, $posterUrl = null, $nome = null, $indirizzo = null, $starRating = null){
			$this->fieldId = $fieldId;
			$this->posterUrl = $posterUrl;
			$this->nome = $nome;
			$this->indirizzo = $indirizzo;
			$this->starRating = $starRating;
		}
	}
	
	class UserStat{
		public $favorite;
	
		function UserStat($favorite = 0){
			$this->favorite = $favorite;
		}
	}

	class Review{
		public $idReview;
		public $userId;
		public $username;
		public $fieldId;
		public $IdPrenotazione;
		public $rating;
		public $reviewTitle;
		public $review;
		public $dataR;

		function Review($idReview = null, $userId = null, $username = null, $fieldId = null, $IdPrenotazione = null, $rating = null, $reviewTitle = null, $review = null, $dataR = null ){
			$this->idReview = $idReview;
			$this->userId = $userId;
			$this->username = $username;
			$this->fieldId = $fieldId;
			$this->IdPrenotazione = $IdPrenotazione;
			$this->rating = $rating;
			$this->reviewTitle = $reviewTitle;
			$this->review = $review;
			$this->dataR = $dataR;
		}
	}
?>