<?php
    require_once __DIR__ . "/../config.php";
    require_once DIR_UTIL . "ScoreXDbManager.php"; //includes Database Class
    
    function getFields(){
        global $ScoreXDb;
        $queryText = ' SELECT * FROM field';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getCityList(){
        global $ScoreXDb;
        $queryText = ' SELECT DISTINCT(citta) FROM field';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }
    
    function getFieldById($fieldId){
		global $ScoreXDb;
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
		$queryText = 'SELECT * FROM field WHERE fieldId = \'' . $fieldId . '\'';
		$result = $ScoreXDb->performQuery($queryText);
		$ScoreXDb->closeConnection();
		return $result; 
    }
    
    function getFieldByCitta($fieldCitta, $offset, $numRecord, $sort){
        global $ScoreXDb;
        $fieldCitta = $ScoreXDb->sqlInjectionFilter($fieldCitta);
        $offset = $ScoreXDb->sqlInjectionFilter($offset);
        $numRecord = $ScoreXDb->sqlInjectionFilter($numRecord);
        $sort = $ScoreXDb->sqlInjectionFilter($sort);
        
        $queryText = 'SELECT *
        FROM review R
            RIGHT OUTER JOIN field F ON R.fieldId = F.fieldId WHERE F.citta = \'' . $fieldCitta  . '\'
            GROUP BY F.fieldId ORDER BY ' . $sort . ' LIMIT '. $offset . ',' . $numRecord;

        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getFieldByPattern($pattern, $fieldCitta, $offset, $numRecord){
        global $ScoreXDb;
        $pattern = $ScoreXDb->sqlInjectionFilter($pattern);
        $fieldCitta = $ScoreXDb->sqlInjectionFilter($fieldCitta);
        $offset = $ScoreXDb->sqlInjectionFilter($offset);
        $numRecord = $ScoreXDb->sqlInjectionFilter($numRecord);

        $queryText = 'SELECT * FROM field WHERE (LOWER(nome) LIKE \'%'. $pattern . '%\' OR UPPER(nome) LIKE \'%'. $pattern . '%\' )AND citta = \'' . $fieldCitta  . '\'' ; 

        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result; 
    }

    function getFieldByUserFavorite($userId, $offset, $numRecord){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        //$offset = $ScoreXDb->sqlInjectionFilter($offset);
        $numRecord = $ScoreXDb->sqlInjectionFilter($numRecord);

        $queryText = 'SELECT * FROM user_field U INNER JOIN field F ON U.fieldId = F.fieldId
                     WHERE U.userId = \'' . $userId  . '\' AND U.favorite = 1 LIMIT '. $offset . ',' . $numRecord ; 

        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result; 
    }

    function count1($table){
        global $ScoreXDb;
        $table = $ScoreXDb->sqlInjectionFilter($table);
        $queryText = 'SELECT COUNT(*) as num FROM ' . $table . '';
        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }

    function totFieldsByCitta($citta){
        global $ScoreXDb;
        $citta = $ScoreXDb->sqlInjectionFilter($citta);
        $queryText = 'SELECT COUNT(*) as num FROM field WHERE citta = \'' . $citta . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }

    function getUserFieldStat($userId, $fieldId){
		global $ScoreXDb;
		$userId = $ScoreXDb->sqlInjectionFilter($userId);
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
 		$queryText = 'SELECT * FROM user_field WHERE userId = \'' . $userId . '\' AND fieldId = \'' . $fieldId . '\'';
 		$result = $ScoreXDb->performQuery($queryText);
		$ScoreXDb->closeConnection();
		return $result; 
    }	

    function getPhoneByUserId($userId){
		global $ScoreXDb;
		$userId = $ScoreXDb->sqlInjectionFilter($userId);

        $queryText = 'SELECT telefono FROM user WHERE userId = \'' . $userId . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        $row = $result->fetch_assoc(); 
		$ScoreXDb->closeConnection();
		return $row['telefono']; 
    }	
    
    function insertFavoriteUserFieldStat($userId, $fieldId, $favoriteFlag){
		global $ScoreXDb;
		$userId = $ScoreXDb->sqlInjectionFilter($userId);
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
 		$favoriteFlag = $ScoreXDb->sqlInjectionFilter($favoriteFlag);
		$queryText = 'INSERT INTO user_field (id, userId, fieldId, favorite) ' 
						. 'VALUES (NULL, \'' . $userId . '\', \'' . $fieldId . '\', ' . $favoriteFlag . ')';
 	
 		$result = $ScoreXDb->performQuery($queryText);
		$ScoreXDb->closeConnection();
		return $result; 
	}
	
	function updateFavoriteUserFieldStat($userId, $fieldId, $favoriteFlag){
		global $ScoreXDb;
		$userId = $ScoreXDb->sqlInjectionFilter($userId);
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
 		$favoriteFlag = $ScoreXDb->sqlInjectionFilter($favoriteFlag);
 		$queryText = 'UPDATE user_field SET favorite = ' . $favoriteFlag . ' WHERE userId=\'' . $userId . '\' AND fieldId = \'' . $fieldId . '\'';
 		
 		$result = $ScoreXDb->performQuery($queryText);
		$ScoreXDb->closeConnection();
		return $result; 
    }

    function userIdFieldIdFavorite($userId, $fieldId){
		global $ScoreXDb;
		$userId = $ScoreXDb->sqlInjectionFilter($userId);
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        
        $queryText = 'SELECT COUNT(*) as num FROM user_field WHERE userId =  \'' . $userId . '\' AND fieldId = \'' . $fieldId . '\' AND favorite = 1';
        $result = $ScoreXDb->performQuery($queryText);
        $favorite = $result->fetch_assoc();
		$ScoreXDb->closeConnection();
        return $favorite['num']; 
    }
    
    function getAverageReviewRating($fieldId){
		global $ScoreXDb;
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT AVG(rating) as Average FROM review WHERE fieldId = ' . $fieldId;        

        $result = $ScoreXDb->performQuery($queryText);
        $avg = $result->fetch_assoc();
        $ScoreXDb->closeConnection();
        return $avg['Average'];
    }
    
    function getTotalReviews($fieldId){
        global $ScoreXDb;
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT COUNT(*) as num FROM review WHERE fieldId = ' . $fieldId;        

        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }

    function getReviewsByRating($fieldId, $rating){
        global $ScoreXDb;
		$fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT COUNT(*) as num FROM review WHERE fieldId = ' . $fieldId .' AND rating = ' . $rating;        
        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }

    function getReviewsByUserId($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT* FROM review R INNER JOIN field F ON F.fieldId = R.fieldId WHERE R.userId = ' . $userId . ' ORDER BY(R.dataR) DESC';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getNReviewsByUserId($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT COUNT(*) as num FROM review R INNER JOIN field F ON F.fieldId = R.fieldId WHERE R.userId = ' . $userId . '';
        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }

    function getReviewsByFieldId($fieldId){
        global $ScoreXDb;
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT* FROM review R INNER JOIN field F ON F.fieldId = R.fieldId INNER JOIN user U ON U.userId = R.userId
                     WHERE R.fieldId = ' . $fieldId . '';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    
    function getReviewsByFieldIdAndRating($fieldId, $rating){
        global $ScoreXDb;
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $rating = $ScoreXDb->sqlInjectionFilter($rating);
        $queryText = 'SELECT* FROM review R INNER JOIN field F ON F.fieldId = R.fieldId INNER JOIN user U ON U.userId = R.userId
                        WHERE R.rating = \'' . $rating . '\' AND R.fieldId =  \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getReviewByIdPrenotazione($idPrenotazione){
        global $ScoreXDb;
        $idPrenotazione = $ScoreXDb->sqlInjectionFilter($idPrenotazione);
        $queryText = 'SELECT* FROM review R WHERE R.IdPrenotazione = \'' . $idPrenotazione . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getReviewByUserIdFieldId($userId, $fieldId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT* FROM review R WHERE R.userId = \'' . $userId . '\' AND R.fieldId = \'' . $fieldId .'\'';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getBookingsByUserId($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT* FROM prenotazione P INNER JOIN field F ON P.fieldId = F.fieldId WHERE P.userId = ' . $userId . ' ORDER BY(P.dataP) DESC';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getNBookingsByUserId($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT COUNT(*) as num FROM prenotazione P INNER JOIN field F ON P.fieldId = F.fieldId WHERE P.userId = ' . $userId . '';
        $result = $ScoreXDb->performQuery($queryText);
        $count = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $count['num'];
    }


    function getNextBookingsByFieldId($fieldId){
        global $ScoreXDb;
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT P.idPrenotazione, P.dataP, P.dalle, P.alle, P.telefono , U.username
                     FROM prenotazione P INNER JOIN field F ON P.fieldId = F.fieldId INNER JOIN user U ON P.userId = U.userId WHERE P.DataP >= current_date() AND P.fieldId = ' . $fieldId . ' ORDER BY P.DataP,P.dalle ASC';
        $result = $ScoreXDb->performQuery($queryText); 
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getMyFieldInfo($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT* FROM  my_field M INNER JOIN field F ON F.fieldId = M.fieldId WHERE M.userId = ' . $userId;
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getNewFieldId(){
        global $ScoreXDb;

        $queryText = 'SELECT MAX(fieldId)as lastFieldId FROM field';
        $result = $ScoreXDb->performQuery($queryText);
        $max = $result->fetch_assoc(); 
        $ScoreXDb->closeConnection();
        return $max['lastFieldId']+1;
    }

    function getHoursByFieldId($fieldId){
        global $ScoreXDb;
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
        $queryText = 'SELECT* FROM  field_schedule WHERE fieldId = ' . $fieldId;
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

    function getUserInfoById($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT* FROM  user WHERE userId = ' . $userId;
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;  

    }

?>