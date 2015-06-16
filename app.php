<?php
#######################
#Post-Login-On-Facebook-Php-Sdk-4
#filename: app.php
#marco.bore@gmail.com
#######################

session_start();

if(isset($_SESSION)){
    if($_SESSION['FBID']){
        echo '
         <html>
		<head>
		<title>Autopost on FaceBook</title>
		</head>
		<body>



        ';
        echo '<br/><div style="text-align:center;">';
        echo '<img src="https://graph.facebook.com/'.$_SESSION['FBID'].'/picture"><br/>';
        echo 'FBID: '. $_SESSION['FBID'].'<br/>';
        echo 'Mail: '. $_SESSION['EMAIL'].'<br/>';
        echo 'Name: '. $_SESSION['FULLNAME'].'<br/>';
        
        echo '
        <form method="POST" action="post.php"><br/>

        <textarea name="text" placeholder="Your comment" tabindex="1" style="width:260px; height:200px"></textarea><br/>
        
        <input type="text" name="link" placeholder="Link to share" tabindex="2"  style="width:260px;"><br/>
        
        <input type="submit" value="POST" tabindex="4" style="width:260px; height:50px"><br/>
        </form>';

        if(isset($_SESSION['MESSAGES'])){
            print_r($_SESSION['MESSAGES']);
            unset($_SESSION['MESSAGES']);
        }
        
        echo '<br/><a href="logout.php">Logout</a>';

        echo '</div></br>';
	echo '</body>
		</html>
	';
    }
}




?>
