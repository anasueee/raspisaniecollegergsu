<?php
include "header.php";
?>

<div class='global'>

<?php

echo "
<div class='main'>
";


$groups = json_decode(file_get_contents("base/groups.json"), true);
$prepods = json_decode(file_get_contents("base/prepods.json"), true);

if (!isset($_GET['groupID'])){
echo "
<h2>Выберите группу</h2>

<div style='display:flex; flex-direction:row; justify-content:center; flex-wrap:wrap;'>
";
foreach ($groups as $k=>$grp){
    echo "
    <a href='index.php?groupID=".$k."' style='text-decoration:none;'>
    <div class='dayweek_box' style='display:flex; flex-direction:column; width:300px; justify-content:flex-start; margin:10px; margin-bottom:3px; padding:9px; border-radius:5px;'>
        <div style='text-align:left; font-size:1.3em;  padding:0px; color:#0f3f50;'>".$grp['name']."</div>
        <div style='text-align:left; font-size:0.8em;  padding:0px; color:#0f3f50;'>Занятий в неделю: ".$grp['parOnWeek']."</div>
        <div style='text-align:left; font-size:0.8em;  padding:0px; color:#0f3f50;'>Учебных дней в неделю: ".$grp['schoolDays']."</div>
    </div>
    </a>
    ";
}
echo "
</div>
";
}else{
// printData($prepods);
    $files_rasp = glob("base/rasp/".$_GET['groupID']."*.json");
    echo "
    <div style='display:flex; flex-direction:column; width:99%;'>
    ";
    if (count($files_rasp) != 0){
        echo "
        <h3 style='text-align:center; margin-top:20px;'>Группа: ".$groups[$_GET['groupID']]['name']."</h3>
        ";
    }

    foreach ($files_rasp as $file){
        $rasp = json_decode(file_get_contents($file), true);
        echo "
        <p style='text-align:left; padding:25px 0 0px 15px;'>Неделя: ".(date("d.m.Y", $rasp['monday'] ))." - ".(date("d.m.Y", $rasp['monday']+60*60*24*6))."</p>
        ";
        $day_last = array_key_last($rasp['raspisanie']);
        $i = 1;
        foreach ($rasp['raspisanie'] as $day=>$pars){
            $border_bottom = "";
            if (($i % 2) == 0) {$background = "#fff";}else{$background = "#c6d6e0";}
            if ($day_last == $day){$border_bottom = "2px solid black";}
            echo "
            <div style='display:flex; flex-direction:row; width:95%; margin:0 10px 0 10px; border-top:2px solid black; border-bottom:".$border_bottom."; background:".$background.";'>
                <div style='padding:5px; width:50px; color:#0f2f50;'><span style='font-size:1.0em;'>".(dayOfweekShort(date("l", $timestamp=$day))."</span></br><span style='font-size:0.5em;'>".date("d-m", $timestamp=$day))."</span></div>
                <div style='display:flex; flex-direction:column;'>
                "; 

                $par_last = array_key_last($pars);
                foreach ($pars as $numPar=>$predmet){
                    $disp_par = "flex";
                    if ($predmet == ""){
                        $disp_par = "none";
                    }
                    $border_bottom2 = "1px solid gray";
                    if ($par_last == $numPar){
                        $border_bottom2 = "";
                    }        
                    $pEx = explode("#", $predmet);
                    echo "
                    <div style='display:flex; flex-direction:row; margin:0px 0 0px 0; width:80vw; justify-content:flex-start; border-bottom:".$border_bottom2.";'>
                        <div style='border-right:2px solid gray; padding:5px; '>
                            <div style='text-align:center; flex-shrink:0; padding:2px; align-self:flex-start; font-size:0.5em; width:35px; border-radius:20px; color:#0f2f50;'>".(get_time_par($numPar))."</div>
                        </div>
                        <div style='display:".$disp_par.";'>
                            <div style='text-align:left; margin-left:5px; padding:5px; font-size:0.8em; color:#0f2f50;'>".$pEx[1]." - <span style=' font-size:0.7em; color:#0f2f50;'>".$prepods[$pEx[0]]['FIO']."</span></div>
                            <div style='text-align:left; margin-left:5px; padding:5px; font-size:0.8em; color:#0f2f50;'><span style=' font-size:0.7em; color:#0f2f50;'>каб. ".$prepods[$pEx[0]]['kabinet']."</span></div>
                        </div>
                    </div>
                    ";
                }
            echo "
                </div>
            </div>
            ";
            $i++;
        }        
    }
    echo "
    </div>
    ";
}


/*div class='main' */
?>
</div>


<?php
include "footer.php";

?>
