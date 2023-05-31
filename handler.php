<?php
include_once("function.php");

// printData($_POST);

/*  ОБРАБОТЧИК ДЛЯ well.php НАЧАЛО*/
if ($_POST['enter'] == "Войти") {
    authorizationLOGIN("", "index.php");
}
/*  ОБРАБОТЧИК ДЛЯ well.php КОНЕЦ*/




if (isset($_POST['prepodadd'])){

    $prepods = array();
    $pEx = explode(",", trim($_POST['predmets']));

    if(file_exists("base/prepods.json")){
        $prepods = json_decode(file_get_contents("base/prepods.json"), true);
        $prepods["ID_".get_auto_inc("prepod")] = array(
            "FIO" => $_POST['prepodF']." ".$_POST['prepodI']." ".$_POST['prepodO'],
            "kabinet" => $_POST['kabinet'],
            "predmets" => $pEx
        );
    }else{
        $prepods["ID_".get_auto_inc("prepod")] = array(
            "FIO" => $_POST['prepodF']." ".$_POST['prepodI']." ".$_POST['prepodO'],
            "kabinet" => $_POST['kabinet'],
            "predmets" => $pEx
        );
    }

    file_put_contents("base/prepods.json", json_encode($prepods,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

    header("Location: prepod.php");

}


if (isset($_POST['groupadd'])){

    $groups = array();

    if(file_exists("base/groups.json")){
        $groups = json_decode(file_get_contents("base/groups.json"), true);
        $groups["ID_".get_auto_inc("group")] = array(
            "name" => $_POST['name'],
            "parOnWeek" => (int)$_POST['parOnWeek'],
            "schoolDays" => (int)$_POST['schoolDays']

        );
    }else{
        $groups["ID_".get_auto_inc("group")] = array(
            "name" => (int)$_POST['name'],
            "schoolDays" => (int)$_POST['schoolDays']
        );
    }

    file_put_contents("base/groups.json", json_encode($groups,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

    header("Location: group.php");

}


if (isset($_GET['raspadd'])){
    // printData($_GET);
    $groups = json_decode(file_get_contents("base/groups.json"), true);
    $parOnWeek = $groups[$_GET['groupID']]['parOnWeek'];
    $schoolDays = $groups[$_GET['groupID']]['schoolDays'];
    $filename_rasp = $_GET['groupID']."#".$_GET['monday'];

    $tank_predmets = array();/* Наполняем предметами накопитель */
    foreach ($_GET['predmet'] as $k=>$v){
        if ($_GET['count'][$k] != 0){
            if (!isset($tank_predmets[$v])){
                $tank_predmets[$v] = $_GET['count'][$k];
            }else{
                $tank_predmets[$v] += $_GET['count'][$k];
            }
        }
    }
    // printData($tank_predmets);

/* Создаем пустой шаблон расписания*/
    $shablon = array();   
    for ($day=$_GET['monday']; $day<$_GET['monday']+60*60*24*$schoolDays; $day += 60*60*24){ 
        for ($par=1; $par<=8; $par++){
            $shablon[$day][$par] = "";
        }
    }
// printData($shablon);
// printData($tank_predmets);
// printData(array_sum($tank_predmets));
/* Заполняем шаблон расписания */
    while (array_sum($tank_predmets) > 0){
        foreach ($tank_predmets as $predmet=>$count){
            if ($count > 0){
                $day_rand = array_rand($shablon, 1);
                $par_rand = array_rand($shablon[$day_rand], 1);            
                // printData($day_rand);
                // printData($par_rand);
                // printData($shablon);

                if ($shablon[$day_rand][$par_rand] == ""){
                    $is_overlaping_prepod = is_overlaping_prepod("0", "0", $prepodID, $day_rand, $par_rand);
                    if ($is_overlaping_prepod == 0){
                        $shablon[$day_rand][$par_rand] = $predmet;
                        $tank_predmets[$predmet]--;
                    }
                }
            }
        }
    }

    $rasp = array(
        "monday" => $_GET['monday'],
        "groupID" => $_GET['groupID'],
        "raspisanie" => $shablon
    );
    // printData($rasp);
    // printData($shablon);

    file_put_contents("base/rasp/".$filename_rasp.".json", json_encode($rasp,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));
    header("Location: rasp.php");

}


if (isset($_GET['get'])){
    if ($_GET['get'] == "predmets"){
        $predmets = get_predmets();
        $res = array();
        foreach ($predmets as $k=>$v){
            $res[] = array(
                "predmet" =>$k,
                "prepodID" =>$v
            );
        }
        echo json_encode($res,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
}

if (isset($_GET['remove'])){
    // printData($_GET);
    if ($_GET['remove'] == "rasp"){
        $filename = "base/rasp/".$_GET['groupID']."#".$_GET['time'].".json";
        $res = ["удалено", $filename];
        unlink($filename);
        echo json_encode($res,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
}

if (isset($_GET['remove'])){
    // printData($_GET);
    if ($_GET['remove'] == "group"){
        $groups = json_decode(file_get_contents("base/groups.json"), true);

        $res = ["удалено", $groups[$_GET['groupID']]];
        unset($groups[$_GET['groupID']]);
        file_put_contents("base/groups.json", json_encode($groups,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

        echo json_encode($res,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
}

if (isset($_GET['remove'])){
    // printData($_GET);
    if ($_GET['remove'] == "prepod"){
        $prepods = json_decode(file_get_contents("base/prepods.json"), true);

        $res = ["удалено", $prepods[$_GET['groupID']]];
        unset($prepods[$_GET['prepodID']]);
        file_put_contents("base/prepods.json", json_encode($prepods,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

        echo json_encode($res,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
}


if (isset($_GET['raspedit'])){
    $rasp = json_decode(file_get_contents("base/rasp/".$_GET['groupID']."#".$_GET['raspID'].".json"), true);
    // printData($rasp);
    $r = array();
    foreach ($_GET['DP'] as $key=>$value){
        $vEx = explode("#", $value);
        $ras[$vEx[0]][$vEx[1]] = $_GET['predmets'][$key];
    }

    $rasp['raspisanie'] = $ras;
    file_put_contents("base/rasp/".$_GET['groupID']."#".$_GET['raspID'].".json", json_encode($rasp,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ));

    // printData($_GET);
    // printData($rasp);
    header("Location: rasp.php");


}

if (isset($_GET['prepod'])){
    if ($_GET['prepod'] == "overlaping"){
        // $res = array();
        $res[0] = is_overlaping_prepod($_GET['groupID'], $_GET['raspID'], $_GET['prepodID'], $_GET['day'], $_GET['numPar']);

        echo json_encode($res,  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        // printData($res);
    }
}
?>