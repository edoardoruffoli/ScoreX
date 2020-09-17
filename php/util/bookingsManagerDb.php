<?php
    require_once __DIR__ . "/../config.php";
    require_once DIR_UTIL . "ScoreXDbManager.php"; //includes Database Class

    function getBookingsById($userId){
        global $ScoreXDb;
        $userId = $ScoreXDb->sqlInjectionFilter($userId);
        $queryText = 'SELECT* FROM prenotazione P INNER JOIN field F ON P.fieldId = F.fieldId WHERE P.userId = ' . $userId . '';
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return $result;
    }

?>