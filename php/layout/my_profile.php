<?php 
    require_once "./util/fieldsManagerDb.php";
    require_once "./util/sessionUtil.php";
    require_once "./util/message_Util.php";

    function showProfileInfo(){
        $userId = $_SESSION['userId'];

        $result = getUserInfoById($userId);
        $userInfo = $result->fetch_assoc();
        $nPrenotazioni = getNBookingsByUserId($userId);
        $nRecensioni = getNReviewsByUserId($userId);

        echo '<div id="profile_section">';
            echo '<div class="avatar_box">'; 
                echo '<img src="../css/images/profile.png" alt="profile">';
                echo '<div class="info_box">'; 
                    echo '<h1>' . $userInfo['username'] .'</h1>'; 
                    echo '<h3>' . $userInfo['email'] .'</h3>';
                    echo '<p>'. $nPrenotazioni .' Prenotazioni Effettuate</p>';
                    echo '<p>'. $nRecensioni .' Recensioni Pubblicate</p>';
                echo '</div>'; 
                echo '<div id="change_box">';
                    echo '<form name="psw_form" action="updatePassword.php" method="post" onSubmit= "return validatePassword()">';
                        echo '<a id="changeLink" onclick="changePassword()"><div id="updateIcon"></div>Modifica Password</a>';
                    echo '</form>';
                echo '</div>';  
                echo '<div class="bottom_box">';  
                    if($userInfo['userType'] != 'socio'){
                        echo '<form action="insertSocio.php" method="post">';
                            echo '<h3>Vuoi aggiungere il tuo campo? </h3>';
                            echo '<button>Diventa Socio ScoreX</button>';
                        echo '</form>';
                    }
                echo '</div>'; 
            echo '</div>';             
        echo '</div>';

        echo '<div id="PopUpModal" class="modal">';
        echo '<div class="modal-content">';
        echo '<span class="close" onClick="closePopUp()">&times;</span>';
        echo '<p id="errorText"></p>';
        echo '</div></div>';

        if (isset($_GET['message'])){				
            echo '<script> openPopUp();'; 
            echo 'document.getElementById("errorText").textContent = "' . $_GET['message'] .'";';
            echo '</script>';
        }		
        echo '</div>';
    }


?>