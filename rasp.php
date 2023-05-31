<?php
include "header.php";
?>

<div class='global'>

<?php




/*div class='main' */
echo "
<div class='main'>
";




if ($_SESSION['user'] == "admin"){
    $groups = json_decode(file_get_contents("base/groups.json"), true);

    if (isset($_GET['add'])){
        echo "
        <h4 style='margin-bottom:30px;'>Составляем расписание на неделю для учебной группы:</h4>
        <h5 style='font-size:1.3em; color:#0f2f50;'>".$groups[$_GET['add']]['name']."</span></h5>
        ";
        $predmets = get_predmets();
        $parOnWeek = $groups[$_GET['add']]['parOnWeek'];
        $schoolDays = $groups[$_GET['add']]['schoolDays'];
        $countPredmet = $parOnWeek * $schoolDays;
        $monday_list = array();
        for($i = strtotime('Monday', time()); $i <= time()+60*60*24*30; $i = strtotime('+1 week', $i)){
            // echo date('l d-m-Y', $i)."</br>";
            $monday_list[] = $i;
        }
        echo "
        <div style='display:flex; justify-content:center; flex-wrap:wrap; margin:5px; color:#0f2f50;'>
            <div style='font-size:0.8em; padding:4px;'>Учебных дней: ".$groups[$_GET['add']]['schoolDays']."</div>
            <div style='font-size:0.8em; padding:4px;'>Занятий в неделю: ".$groups[$_GET['add']]['parOnWeek']."</div>
        </div>
        ";
        echo "
        <form method='get' action='handler.php' style='margin-bottom:15px; color:#0f2f50;'>
            <div style='font-size:0.9em; margin:10px;'>Выберите дату для составления расписания</div>
            <select class='sel' style='text-align:center; margin-top:5px; font-size:0.8em; width:300px;' name='monday' required>
        ";
        foreach ($monday_list as $monday){
            $dayweek = dayOfweek(date("l", $timestamp=$monday));
            echo "<option value='".$monday."'>".($dayweek."  ".date("d-m-Y", $timestamp=$monday))."</option>";
        }

        echo "
            </select>
            <div style='font-size:0.9em; text-align:right; padding:10px; margin-top:20px;'>Укажите для предмета</br>количечество в неделю</div>
            <input type='hidden' name='groupID' value='".$_GET['add']."'>
        ";
        echo "
        <div style='display:flex; flex-direction:column;'>
        ";
                    foreach ($predmets as $predmet=>$prepodID){
                        echo "
                        <div style='display:flex; flex-direction:row; justify-content: space-between; align-items:center;'>
                            <div style='width:90%; text-align:left; padding:10px; border-bottom:1px solid gray; '>".$predmet."</div>
                            <input type='hidden' name='predmet[]' value='".$prepodID."#".$predmet."'>
                            <div><input type='number' style='font-size:1.3em; width:50px;' onfocus='this.select()' min='0' max='5' name='count[]' value='0'></div>
                        </div>
                        ";

                    }
        echo "
            </div>
            <input type='submit' class='button' style='border:none; color:#fff; margin-top:50px !important; margin-bottom:0px; -webkit-text-align:center !important;' name='raspadd' value='ЗАПИСАТЬ'>
        </form>
        ";

    }elseif (!isset($_GET['mode'])){
        echo "
        <h3 style='margin-bottom:40px; padding:10px;'>Давайте составим новое расписание на неделю</h3>
        ";
            echo "
            <div style='display:flex; flex-direction:row; justify-content:center; flex-wrap:wrap; margin-bottom:70px;'>
            ";
            foreach ($groups as $key=>$value){
                echo "
                <div class='shablon_box''>
                    <div style='text-align:center; font-size:1.0em; padding:35px 15px 15px 15px; color:#0f2f50;'>".$value['name']."</div>
                    <div style='text-align:left; font-size:0.8em; padding:4px; color:#0f2f50;'>Учебных дней: ".$value['schoolDays']."</div>
                    <div style='text-align:left; font-size:0.8em; padding:4px; color:#0f2f50;'>Занятий в неделю: ".$value['parOnWeek']."</div>
                ";
                $rasp_list = get_group_rasp($key);
                if (count($rasp_list) != 0){
                    echo "
                        <div style='text-align:left; font-size:0.9em; padding:20px 9px 2px 9px; text-decoration:underline; color:#0f2f50;'>Расписания</div>
                    ";
                }else{
                    echo "
                        <div style='text-align:left; font-size:0.9em; padding:30px 9px 9px 9px;'>Нет составленных расписаний</div>
                    ";
                }
                foreach ($rasp_list as $raspID){
                    echo "
                    <div style='display:flex; flex-direction:row; align-items:center;'>
                        <div><a href='rasp.php?mode=edit&groupID=".$key."&id=".$raspID."'><i  id='".$key."#".$raspID."' class='fa-solid fa-pen-to-square' style='margin-left:10px; color:#1c9d23; font-size:0.7em;'></i></a></div>
                        <div style='text-align:left; font-size:0.7em; padding:4px; color:#0f2f50;'>".(dayOfweek(date("l", $timestamp=$raspID))."  ".date("d-m-Y", $timestamp=$raspID))."</div>
                        <div><i  id='".$key."#".$raspID."' class='fa-solid fa-square-minus' onclick='remove_rasp(event)' style='margin-left:10px; color:#ff2850; font-size:0.7em; cursor:pointer;'></i></div>
                    </div>
                    ";
                }
                
                echo "
                <a style='text-decoration:none; color:black;' href='rasp.php?add=".$key."'><i class='fa-solid fa-square-plus' style='padding:7px; font-size:1.3em; color:#3b72b0; cursor:pointer;'></i></a>
                </div>
                ";    
            }
            echo "
            </div>
            ";
 
    }

if (isset($_GET['mode'])){
    if ($_GET['mode'] == "edit"){
    $rasp = json_decode(file_get_contents("base/rasp/".$_GET['groupID']."#".$_GET['id'].".json"), true);
    $prepods = json_decode(file_get_contents("base/prepods.json"), true);

    echo "
    <p style='text-align:center; padding:15px;'>Давайте внесем исправления в расписание</p>
    <div hidden id='opt_old'></div>
    ";

    $day_last = array_key_last($rasp['raspisanie']);
    $i = 1;
    // printData($rasp);
    $predmets = get_predmets();
    // printData($predmets);
    echo "
    <form method='get' action='handler.php' style='border:none; padding:0px; margin-bottom:15px;'>
    <input hidden name='groupID' value='".$_GET['groupID']."'>
    <input hidden name='raspID' value='".$_GET['id']."'>
    ";
    foreach ($rasp['raspisanie'] as $day=>$pars){
        $border_bottom = "";
        if (($i % 2) == 0) {$background = "#fff";}else{$background = "#c6d6e0";}
        if ($day_last == $day){$border_bottom = "2px solid black";}
        echo "
        <div style='display:flex; flex-direction:row; width:99%; margin:0 10px 0 10px; border-top:2px solid black; border-bottom:".$border_bottom."; background:".$background.";'>
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
                // printData($pEx);
                echo "
                <div style='display:flex; flex-direction:row; margin:0px 0 0px 0; width:70vw; justify-content:flex-start; border-bottom:".$border_bottom2.";'>
                    <div style='border-right:2px solid gray; padding:5px; '>
                        <div style='text-align:center; flex-shrink:0; padding:2px; align-self:flex-start; font-size:0.5em; width:35px; border-radius:20px; color:#0f2f50;'>".(get_time_par($numPar))."</div>
                    </div>
                ";

                echo "
                <div style='display:flex; flex-direction:row;'>
                    <div style='display:block;'>
                    <input hidden name='DP[]' value='".$day."#".$numPar."'>
                    <select id='select#".$_GET['groupID']."#".$_GET['id']."#".$day."#".$numPar."' class='sel' onchange='onchange_is_overlaping_prepod(event)' onfocus='onclick_select(event)' style='text-align:center; margin-left:10px; margin-top:5px; font-size:0.6em; width:200px;' name='predmets[]' required>
                    <option value='0'>- -</option>
                    ";
                    foreach ($predmets as $predm=>$prepodID){
                        if (implode("#", $pEx) == $prepodID."#".$predm){
                            echo "<option selected value='".$prepodID."#".$predm."'>".$predm."</option>";
                        }else{
                            echo "<option value='".$prepodID."#".$predm."'>".$predm."</option>";
                        }
                    }

                    echo "
                    </select></div>
                </div>
                ";


                echo "  
                    <div style='display:".$disp_par.";'>
                ";
                echo "    </div>
                </div>
                ";
            }
        echo "
            </div>
        </div>
        ";
        $i++;
    }
    echo "
    <input type='submit' class='button' style='border:none; color:#fff; margin-top:50px !important; margin-bottom:0px;' name='raspedit' value='ЗАПИСАТЬ'>
    </form>
    ";

        // printData($rasp);
    }
}


}
?>

<!-- конец <div class='main'> -->
</div>


<?php
include "footer.php";

?>
