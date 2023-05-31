<?php

function logSave($data, $txt, $folderUP){

    $s = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    file_put_contents($folderUP."logs/".date('d-m-Y').".txt",date('d-m-Y_H:i:s')." ".$txt." ".$s.PHP_EOL, FILE_APPEND);
}

/* вывод массива */
function printData($data){
    print_r('<pre><p style="width:90vw; text-align:left; background-color: beige; color: maroon; padding: 10px; margin: 5px; border: 1px maroon solid;">');
    print_r($data);
    print_r('</p></pre>');
}
/* вывод массива КОНЕЦ*/

/* вывод массива */
function printDataW($data){
    print_r('<pre><p style="width:90vw;font-size:1.3em;background-color: beige; color: maroon; padding: 10px; margin: 5px; border: 1px maroon solid;">');
    foreach ($data as $k=>$v){
    print_r("[".$k."] ".$v);
    }
    print_r('</p></pre>');
}
/* вывод массива КОНЕЦ*/




function getUsers($folderUp){
    $u = array();
    $user_files = glob($folderUp."base/users/*.txt");
    foreach ($user_files as $value){
        $user = json_decode(file_get_contents($value), true);
        // if ($user['role'] == "admin"){
            $u[] = array(
                "tel" => $user['tel'],
                "password" => $user['password'],
                "fio" => $user['fio'],
                "role" => $user['role'],
                "permission" => $user['permission'],
                "shopID" => $user['shop']
            );
        // }
    }
    return $u;
}

function authorizationLOGIN($folderUP, $goURL) {
    if (!isset($_SESSION)) session_start();
    $users = getUsers($folderUP);
    $usr = mb_strtolower($_POST['user'], 'UTF-8');
    $pwd = $_POST['pass'];
            // logSave($users, "t1", $folderUP);
// printData($users);
    foreach ($users as $value){
            // printData($value);
            // logSave($value, "t1", $folderUP.$well);

            if ($value['tel'] == $usr && $value['password'] == $pwd){
                /* перед нами пользователь с правильным логином и паролем - ставим сессию из роли пользователя и куку */
                $_SESSION['user_role'] = $value['role'];
                $_SESSION['user_fio'] = $value['fio'];
                $_SESSION['user'] = $usr;
                $_SESSION['permission'] = $value['permission'];
                setrawcookie("Autorized", $usr, time()+60*60*24*7);
                $log['date'] = date("Y-m-d H:i:s");
                $log['user'] = $usr;
                $log['role'] = $value['role'];
                header("Location: ".$goURL."");
                // printData($_SESSION);
            }else{
                header("Location: ".$folderUP."well.php");
            }
    }
}



function authorizationCOOKIE($folderUP){
    if (isset($_COOKIE["Autorized"]) && !isset($_SESSION["user"]))  { 
        $users = getUsers($folderUP);
        $usr = $_COOKIE["Autorized"];
        foreach ($users as $value){
                if ($value['tel'] == $usr){
                    /* перед нами user с правильным логином и паролем - ставим  сессию  */
                    $_SESSION['user_role'] = $value['role'];
                    $_SESSION['user_fio'] = $value['fio'];
                    $_SESSION['user'] = $usr;
                    $_SESSION['permission'] = $value['permission'];
                    setrawcookie("Autorized", $usr, time()+60*60*24*7);
                }
        }
    }
}


function mb_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}


function get_auto_inc($filed){
$autoinc = json_decode(file_get_contents("base/autoinc.json"),true);
$autoinc[$filed]++;
file_put_contents("base/autoinc.json", json_encode($autoinc, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
return $autoinc[$filed];
}

function get_predmets(){
    $prepods = json_decode(file_get_contents("base/prepods.json"), true);
    $predmets = array();
    foreach ($prepods as $key=>$value){
        foreach($value['predmets'] as $predmet){
            $predmets[$predmet] = $key;
        }
    }
    return $predmets;
}

function Fio($fio){
$fioEx = explode(" ",  $fio);
$Fio = $fioEx[0].". ".mb_substr($fioEx[1], 0, 1).". ".mb_substr($fioEx[2], 0, 1);
return $Fio;
}

function get_random_predmet($tank_predmets){

    return array_rand($tank_predmets, 1);
    
}


function remove_zero_tank_predmets($tank_predmets){
    foreach ($tank_predmets as $predmet=>$count){
        if ($count == 0){
            unset($tank_predmets[$predmet]);
        }
    }
    return $tank_predmets;
}

function dayOfweek($day){
    if ($day == "Monday"){
        return "Понедельник";
    }elseif ($day == "Tuesday"){
        return "Вторник";
    }elseif ($day == "Wednesday"){
        return "Среда";
    }elseif ($day == "Thursday"){
        return "Четверг";
    }elseif ($day == "Friday"){
        return "Пятница";
    }elseif ($day == "Saturday"){
        return "Суббота";
    }else{
        return "Воскресенье";
    }
}

function dayOfweekShort($day){
    if ($day == "Monday"){
        return "ПН";
    }elseif ($day == "Tuesday"){
        return "ВТ";
    }elseif ($day == "Wednesday"){
        return "СР";
    }elseif ($day == "Thursday"){
        return "ЧТ";
    }elseif ($day == "Friday"){
        return "ПТ";
    }elseif ($day == "Saturday"){
        return "СБ";
    }else{
        return "ВС";
    }
}

function get_time_par($numPar){
    if ($numPar == 1){
        return "08:30-<wbr>10:00";
    }elseif ($numPar == 2){
        return "10:15-<wbr>11:45";
    }elseif ($numPar == 3){
        return "12:00-<wbr>13:30";
    }elseif ($numPar == 4){
        return "14:00-<wbr>15:30";
    }elseif ($numPar == 5){
        return "15:45-<wbr>17:15";
    }elseif ($numPar == 6){
        return "17:30-<wbr>19:00";
    }elseif ($numPar == 7){
        return "19:15-<wbr>20:45";
    }elseif ($numPar == 8){
        return "21:00-<wbr>22:30";
    }


}
function is_overlaping_prepod($groupID, $raspID, $prepodID, $day, $numPar){
    $res = array();
    $files_rasp = glob("base/rasp/*.json");
    // printData($files_rasp);
    if (empty($files_rasp)) {return 0;}

    if ($groupID != "0"){
        $edit_file = "base/rasp/".$groupID."#".$raspID.".json";
        $k = array_search($edit_file, $files_rasp);
        unset($files_rasp[$k]);
    }

    if (!empty($files_rasp)) {
        foreach ($files_rasp as $file){
            $rasp = json_decode(file_get_contents($file), true);
            // printData($rasp);
            if (!empty($rasp['raspisanie'][$day][$numPar])){
                $pid = explode("#", $rasp['raspisanie'][$day][$numPar]);
                // printData($pid);
                if ($pid[0] == $prepodID){
                    return 1;
                }
            }
        }
    }


    return 0;
}



function get_group_rasp($groupID){
    $files_rasp = glob("base/rasp/".$groupID."*.json");
    $res = array();
    foreach ($files_rasp as $file){
        $rasp = json_decode(file_get_contents($file), true);
        $res[] = $rasp['monday'];
    }
    return $res;
}
?>



