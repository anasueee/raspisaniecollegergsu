<!DOCTYPE HTML>
<html lang="ru">

<head>
    <!-- <meta name="theme-color" content="green"> -->
<!-- <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Neucha|Open+Sans+Condensed:300&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet"> -->
<meta name='viewport' content='width=device-width'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Roboto'>

<style>
* {
    /* -webkit-appearance: none;  */
    margin: 0;
    /* text-decoration: none; */
    font-family: 'Roboto', sans-serif;
    
}

body {
    /* max-width: 1200px; */
    margin: auto;
    /* font-size: 24px; */
    color: #6a7a7a;
    background-size: cover;
}

input[type=submit] {
    background:linear-gradient(to top, rgb(206, 206, 206), rgb(255, 255, 255)); 
    color:black; 
    border:2px solid green; 
    height:70px; 
    font-size: 24pt; 
    margin:auto;
    margin-top:30px;
    margin-bottom: 10px; 
    cursor:pointer; 
    -moz-border-radius: 5px; 
    -webkit-border-radius: 5px; 
    border-radius:5px;
}
.button{
    display:block;
    width:300px;
    margin:10px;
    padding:6px; 
    /* border:2px solid gray;  */
    border-radius:10px;
    cursor:pointer; 
    height:50px; 
    background:#3b72b0 !important;
    -webkit-box-shadow: -5px -5px 5px -5px rgba(34, 60, 80, 0.6) inset;
    -moz-box-shadow: -5px -5px 5px -5px rgba(34, 60, 80, 0.6) inset;
    box-shadow: -5px -5px 5px -5px rgba(34, 60, 80, 0.6) inset;
}
</style>

</head>


<body>

    <!-- <script src="cookie.js"></script> -->

<?php 

include_once("function.php");

if ($_GET['mode'] == "logout"){
/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
/* перед тем как разрушить переменные текущей сессии надо сессию открыть на этой странице, */
/* тк нелья разрушить если сессия открыта на другой странице */
/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

    session_start();
    session_unset();
    session_destroy();

    setrawcookie("Autorized", "", time()-3600);
    header('Location: index.php'); 

}

if (!isset($_SESSION)) session_start();

    // if (headers_sent()) {
    //     var_dump(headers_list());
    // }

if (isset($_SESSION['user'])) { 
    header('Location: rasp.php'); 
}
?>

            <?php 
            ?>
                <div  style="display:flex; justify-content: center; position: fixed; top: 0; left: 0; width:100%; height:100%; align-items: center; align-content: center; ">
                    <div style="display:flex;flex-direction:column;justify-content:center; align-content:center; width:250px; align-items:center !important; background:#fff; border:1px solid #0f2f50 !important; padding: 20px 10px 10px 10px; margin:0px 0;   border-radius:10px; ">
                    <div style='display:flex; margin:auto; padding:0px 0px 20px 0px; '><img style='width:35px; height:50px;' src='img/logo-b.png'></div>

                                <form style='margin-top:10px' method="post" action='handler.php'>
                                    <div style='display:flex;flex-direction:column;'>
                                        <div style='display:flex; justify-content: center;'>
                                            <input style='margin-bottom:10px;width:200px; font-size:1.0em;' type="text" name="user" placeholder='логин' required >
                                        </div>
                                        <div style='display:flex; justify-content: center;'>
                                            <input style='width:200px; cursor:pointer; font-size:1.0em;' type="password"  name="pass" placeholder='пароль' required>
                                        </div>
                                    </div>
                                <div style='display:flex;justify-content: center;margin-top:10px;'>
                                    <input  type="submit"  class='button' style='border:none; color:#fff; width:220px;height:50px; font-size:1.8em; ' name="enter" value="Войти" >
                                </div>
                                </form>

                    </div>
                </div>
            


    
   
</body>
</html>