<?php
include "header.php";
?>

<div class='global'>

<?php




/*div class='main' */
echo "
<div class='main'>
";

if (isset($_GET['add'])){
echo "
<form method='post' action='handler.php' style='margin-bottom:15px;'>
    <div style='font-size:0.9em; margin:20px;'>Давайте добавим нового преподавателя</div>
    <input type='text' style='font-size:0.8em; margin:10px; margin-bottom:2px;' name='prepodF' value='' placeholder='Фамилия' required/></br>
    <input type='text' style='font-size:0.8em; margin:10px; margin-bottom:2px;' name='prepodI' value='' placeholder='Имя' required/></br>
    <input type='text' style='font-size:0.8em; margin:10px; margin-bottom:2px;' name='prepodO' value='' placeholder='Отчество' required/></br>
    <input type='text' style='font-size:0.8em; margin:10px; margin-bottom:2px; margin-top:50px;' name='kabinet' value='' placeholder='Кабинет' required/></br>
    <div style='display:flex; flex-direction:row; justify-content: space-around; margin-top:50px;'>
        <textarea rows='5' wrap='soft' style='font-size:0.8em;' name='predmets' placeholder='Введите предметы преподавателя через запятую без пробелов' required/></textarea>
    </div>



    <input type='submit'  class='button' style='border:none; color:#fff; margin-top:50px !important;margin-bottom: 0px; height:50px; font-size: 1.0em;' name='prepodadd' value='ЗАПИСАТЬ'>
</form>
";
}else{
    echo "
    <h3 style='margin-bottom:25px;'>Справочник преподавателей</h3>
    ";
    $prepods = json_decode(file_get_contents("base/prepods.json"), true);
    echo "
    <div style='display:flex; flex-direction:column; width:95%; '>
    ";
    foreach ($prepods as $k=>$prep){
        echo "
        <div style='display:flex; flex-direction:column; justify-content:flex-start; position:relative; border:1px solid #0f2f50; margin-bottom:3px; padding:9px;'>
            <div style='position:absolute; top:5px; right:10px; cursor:pointer;'><i id='".$k."' class='fa-solid fa-square-minus' onclick='remove_prepod(event)' style='margin-left:10px; color:#ff2850; font-size:0.7em;'></i></div>
            <div style='text-align:left; padding:0px; color:black;'>".$prep['FIO']."</div>
            <div style='font-size:0.7em; text-align:left; padding:0px;'>каб.: ".$prep['kabinet']."</div>
            <div style='font-size:0.7em; text-align:left; padding-bottom:20px;'>Список предметов: ".implode(", ", $prep['predmets'])."</div>
        </div>
        
        ";
    }
    echo "
    </div>
    ";
   

    echo "
    <div style='display:flex; justify-content:center; flex-wrap:wrap;'>
    <a style='text-decoration:none; color:#fff;'href='prepod.php?add'>
        <div class='button' style=''>
            <span style='display:inline-block; vertival-align:middle; padding:inherit;'>ДОБАВИТЬ</span>
        </div>
    </a>
    </div> 
    ";
   
}
?>

<!-- конец <div class='main'> -->
</div>


<?php
include "footer.php";

?>
