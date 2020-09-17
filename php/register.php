<?php
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $telefono = $_POST['telefono'];

  $errorMessage = register($username, $email, $telefono, $password);
  if($errorMessage === null)
    header('location: ./home.php');
  else
    header('location: ./../index.php?errorMessage=' .$errorMessage);

  function register($username, $email, $telefono, $password){
    global $ScoreXDb;
    
    $username = $ScoreXDb->sqlInjectionFilter($username);
    $email = $ScoreXDb->sqlInjectionFilter($email);
    $telefono = $ScoreXDb->sqlInjectionFilter($telefono);
    $password = $ScoreXDb->sqlInjectionFilter($password);
  

    // controllo se username o email sono già associati ad un account
    $queryText = 'SELECT * FROM user WHERE username=\'' . $username . '\' OR email=\'' . $email . '\'';
    $result = $ScoreXDb->performQuery($queryText);
    $user = mysqli_fetch_assoc($result);
      
    if ($user) {
      if ($user['username'] === $username) {
        return 'Username già esistente';
      }

      if ($user['email'] === $email) {
        return 'Email già associata ad un username';
      }
    } 

    // Registrazione effettiva del nuovo utente
    $newUserId = newUserId();  //serve per settare la sessione
    $cryptpassword = md5($password);//encrypt the password before saving in the database COPIATO

  	$query = 'INSERT INTO user VALUES(NULL, "cliente", \'' . $username . '\', \'' . $email . '\', \'' . $telefono . '\', \'' . $cryptpassword . '\')';
  	$ScoreXDb->performQuery($query);
    session_start();
    setSession($username, $newUserId);  
    return null;
 }

  function newUserId(){
    global $ScoreXDb;

    $queryText = ' SELECT MAX(userId)as maxUserId FROM user';
    $result = $ScoreXDb->performQuery($queryText);

    $maxUserId = $result->fetch_assoc();
    $ScoreXDb->closeConnection();
    return $maxUserId['maxUserId'] + 1;
  }

