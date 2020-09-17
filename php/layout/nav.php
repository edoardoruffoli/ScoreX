<nav id="content_nav">			
		<ul id="navigationBar">
				<li class="navigationBarList">
            <div id="mySidenav" class="sidenav">
                <a class="closebtn" onclick="closeNav()">&times;</a>

                <div class="menu_item_img profile_img"></div><a id="profileTag" href="profile.php"><?php echo $_SESSION['username'];?></a>
                <?php 
                    if($_SESSION['userType']=='socio'){
                        echo '<div class="menu_item_img my_field_img"></div><a id="myFieldTag" href="myField.php">Il Mio Campo</a>';
                    }
                ?>
                <div class="menu_item_img timeline_img"></div><a id="historyTag" href="history.php">Cronologia</a>
                <div class="menu_item_img favorites_img"></div><a id="favoriteTag" href="favorites.php">Preferiti</a>   
                <div class="menu_item_img add_img"></div><a id="addYourFieldTag" href="addYourField.php">Aggiungi il tuo campo</a>
            </div>

            <span id="sideNavIcon" onclick="openNav()">&#9776;</span>   
				</li>
				<li class="navigationBarList"><a class="navigationBarElement" id="nbeHome" href="home.php">Home </a></li>
				<li class="navigationBarList"><a class="navigationBarElement" id="nbePrenota" href="prenota.php">Prenota </a></li>
				<li class="navigationBarList"><a class="navigationBarElement" id="nbeComeFunziona" href="comefunziona.php">Come funziona</a></li>
				<li class="navigationBarList" style="float:right"><a class="navigationBarElement" href="logout.php">Logout</a></li> 	<!-- CSS -->
			</ul>	
		</nav>

