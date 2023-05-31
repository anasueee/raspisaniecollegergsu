<!DOCTYPE HTML>
<html lang="ru">
<?php
include_once("function.php");
include_once("config.php");

// ini_set('log_errors', 'On');
// ini_set('error_log', 'php_errors.log');

echo "
<head>
<meta charset='UTF-8'>
<link rel='icon' href='".$params['domen'].$params['rootDir']."/favicon.png' type='image/png'>
<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Roboto'>

";


$user = "";
$user_fio = "";
$user_role = "";

if (!isset($_COOKIE['Autorized'])){
    session_start();
    session_unset();
    session_destroy();
}
if (!isset($_SESSION)) session_start();
// printData($user);
// printData($_SESSION);
// printData($_SERVER["REQUEST_URI"]);
// printData($user_role);

/* если есть кука Autorized - ставим сессию из куки */
    authorizationCOOKIE("");

        $user_fio = "";
        $user_role = "";
        if (isset($_SESSION['user'])){
            $user = json_decode(file_get_contents("base/users/".$_SESSION['user'].".txt"), true);
            $user_fio = $_SESSION['user_fio'];
            $user_role = $_SESSION['user_role'];
        }

        if(strpos($_SERVER["REQUEST_URI"], "prepod.php") ||
            strpos($_SERVER["REQUEST_URI"], "group.php") ||
            strpos($_SERVER["REQUEST_URI"], "rasp.php")) {
                if (!isset($_SESSION['user'])) {
                        header("Location: ".$params['root']."well.php");
                }   
        }
        


// $title = ""; $description = "";
// if  (  ($_SERVER["REQUEST_URI"] == "/index.php") || ($_SERVER["REQUEST_URI"] == "/") ){
//         $dataPage = "index.php";
//         $title = "";
//         $description = "";    
//         echo "<link rel='canonical' href='".$params['domen'].$params['rootDir']."'>";
//     }
// echo "<title>" . $title . "</title>";
// echo "<meta name='description' content='" . $description . "'>";
    
?>
<meta name='viewport' content='width=device-width'>
<link rel="stylesheet" href="fontawesome/all.css">

<style>

* {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    
}
body {
    margin: auto;
    font-size: 1.8em;
    color: #6a7a7a;
    text-align: center;
}
h1, h2, h3, h4, p{
    text-align:center;
    color:#0f2f50;
}
.header {
    display: flex;    
    flex-direction:row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 80px;
    top: 0px;
    background-color: #2871A0;    
    border-bottom:1px solid #dfdfdf;
    margin-top: 0px;
    position: sticky;
    z-index: 101;
    /* opacity:75%; */
    position: -webkit-sticky;
}
.headeradm {
    display: flex;
    flex-direction: row;
    width: 100%;
    top: 0px;
    align-items: center;
    justify-content: space-between;
    background-color: #2871A0;
    border-bottom:1px solid #dfdfdf;
    margin-top: 0px;
    margin-bottom:15px;
    position: sticky;
    z-index: 101;
    position: -webkit-sticky;
}


.footer {
    display: flex;
    width: 100vw;
    justify-content: center;
    align-content: center;
    padding: 10px 0;
    align-items: center;
    border-top:1px solid gray;
    z-index:200;
    }
.global {
    display: flex;
    max-width: 1200px;
    flex-direction: column;
    }
.main {
    display: flex;
    flex-direction:column;
    width: 100vw;
    justify-content: row;
    flex-wrap:wrap;
    padding: 10px 0px 10px 0px;
    /* flex-wrap: wrap; */
    align-content: center;
    align-items: center;
    /* transition: all ease-in-out 1s; */
    -webkit-overflow-scrolling: touch;
    }

@media screen and (min-width: 701px) {

}
@media screen and (max-width: 700px) {

}


@media screen and (max-width: 369px) {

}

@media screen and (min-width: 697px) {

}
@media screen and (max-width: 696px) {

}

@media screen and (max-width: 520px) {
}


/* меню */
.topnav {
  overflow: hidden;
  position: relative;
}

.topnav #barmenuLinks {
  display: none;
}

.topnav a {
  display: block;
  color: #fff;
  padding:5px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #fff;
}

.topnav a .fa-bars:hover{
    color:#3b72b0 !important;
}

.topnav div a:hover{
    color:black !important;
}

.menuactive {
  background-color: #c6d6e0;
  color: #0f2f50 !important;
}
/* меню */


.form {
    text-align:center;
    width:340px;
    border: 1px solid #ff6d94;
    padding: 17px 0 17px 0;
}
.form input{
    width:90%;
    text-align:center;
    height:30px; 
    font-size:1.5em;
    margin-bottom:4px;
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

.shablon_box{
    display:flex; 
    flex-direction:column; 
    justify-content:center;
    background:#f5f5f6;
    width:300px;
    margin:10px;
    padding:6px; 
    border-radius:10px;
    -webkit-box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;
    -moz-box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;
    box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;    
}
.dayweek_box{
    background-color:#f5f5f6;
    -webkit-box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;
    -moz-box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;
    box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2) inset;    
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


form{
    border:1px solid gray; 
    padding:5px 15px 15px 5px; 
    border-radius:5px; 
    margin:10px; 
    margin-bottom:15px;
}

</style>  

</head>


<?php
echo "
<body data-page=".$_SERVER['REQUEST_URI'].">
";


// printData($user);
// printData($_SESSION);
// printData($_SERVER["REQUEST_URI"]);
// printData($user_role);

    if ($user_role == "admin"){

    echo "
    <div class='headeradm'>
    ";

        echo"
        <div style='display:flex; flex-direction:row; justify-content:space-between; align-items: center;' >
        ";
            // Боковое меню навигации
            echo "
            <div class='topnav'>
                <div id='barmenuLinks' onmouseleave='mouseleave_barmenuLinks()' style='position:fixed; color:black; background:#0f2f50; top:0px; left:0px; height:100vh; width:200px;'>
                        <div style='position:absolute; top:5px; right:5px;'><i onclick='closemenu()' class='fa-thin fa-circle-xmark' style='color: #fff;'></i></div>
                        <div style='text-align:left; margin-top:55px; margin-left:10px;'><a class='".($_SERVER["REQUEST_URI"] == $params['rootDir'].'/rasp.php' ? 'menuactive' : '')."' style='margin-top:10px;' href='rasp.php'>Составить расписание</a></div>
                        <div style='text-align:left; margin-top:25px; margin-left:3px; font-size:0.9em; color:#fff;'>Справочники</div>
                        <div style='text-align:left; margin-left:10px;'><a class='".($_SERVER["REQUEST_URI"] == $params['rootDir'].'/group.php' ? 'menuactive' : '')."' style='margin-top:10px;' href='group.php'>Группы</a></div>
                        <div style='text-align:left; margin-left:10px;'><a class='".($_SERVER["REQUEST_URI"] == $params['rootDir'].'/prepod.php' ? 'menuactive' : '')."' style='margin-top:10px;' href='prepod.php'>Преподаватели</a></div>
                </div>
                <div style='display:flex; width:34px; flex-shrink:0;'><a href='javascript:void(0);' style='margin-left:5px;' onclick='onclick_BarMenu()'><i  style='color:#fff; font-size:1.3em;' class='fa fa-bars'></i></a></div>
            </div>
            <div><a href='".$params['domen'].$params['rootDir']."'><img style='margin-top:5px; margin-bottom:5px; padding-left:10px; width:35px; height:35px;' src='img/logo.png'></a></div>
            <div style='font-size:0.9em; line-height:0.9; margin-left:5px;'><a style='text-decoration:none; color:#fff;' href='".$params['domen'].$params['rootDir']."' >Расписание онлайн</a></div>
        ";
        echo "
        </div>
        ";
        echo "
        <div style='align-items:center; padding-right:15px;'><a style='text-decoration:none; color:#fff;' href='well.php?mode=logout'><i class='fa-light fa-right-from-bracket' style='font-size:0.8em;'></i></a></div>
        ";

        echo "
        </div>
        ";
    }else{
        echo "
        <div class='header'>
                <div><a href='".$params['domen'].$params['rootDir']."'><img style='padding-left:20px; width:35px; height:35px;' src='img/logo.png'></a></div>
                <div style='display:flex; flex-direction:column; justify-content:center; align-items:center; padding-left:10px;'>
                    <a style='padding-left:0px; text-decoration:none; line-height:0.7; font-weight:600; font-size:1.0em; color:#fff; line-height:1.0;' href='".$params['domen'].$params['rootDir']."'>Расписание онлайн</a>
                </div>
                <div style='margin-right:15px;'>
                    <a style='text-decoration:none; color:#fff;' href='well.php'><i class='fa-light fa-right-to-bracket' style='font-size:0.9em;'></i></a>
                </div>
        </div>
        ";  
    }
?>
