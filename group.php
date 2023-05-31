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
    <div style='font-size:0.9em; margin:20px;'>Давайте добавим новую группу</div>
    <input type='text' style='text-align:center; width:300px; font-size:0.8em; margin:10px; margin-bottom:2px;' name='name' value='' placeholder='Название' required/></br>
    <input type='number' style='text-align:center; width:300px; font-size:0.8em; margin:10px; margin-bottom:2px;' name='parOnWeek' min='1' max='50' value='' placeholder='Занятий в неделю' required/></br>
    <input type='number' style='text-align:center; width:300px; font-size:0.8em; margin:10px; margin-bottom:2px;' name='schoolDays' min='1' max='7' value='' placeholder='Учебных дней в неделю' required/></br>

    <input type='submit' class='button' style='border:none; color:#fff; margin-top:50px !important; margin-bottom: 0px; height:50px; font-size:1.0em; ' name='groupadd' value='ЗАПИСАТЬ'>
</form>
";
}else{
    echo "
    <h3 style='margin-bottom:25px;'>Справочник групп</h3>
    ";
    $groups = json_decode(file_get_contents("base/groups.json"), true);
    echo "
    <div style='display:flex; flex-direction:column;width:95%; '>
    ";
    foreach ($groups as $k=>$grp){
        echo "
        <div style='display:flex; flex-direction:column; justify-content:flex-start; border:1px solid #0f2f50; margin-bottom:3px; padding:9px; position:relative;'>
            <div style='position:absolute; top:5px; right:10px; cursor:pointer;'><i id='".$k."' class='fa-solid fa-square-minus' onclick='remove_group(event)' style='margin-left:10px; color:#ff2850; font-size:0.7em;'></i></div>
            <div style='text-align:left; font-size:1.3em;  padding:0px; color:black;'>".$grp['name']."</div>
            <div style='text-align:left; font-size:0.9em;  padding:0px; color:gray;'>Занятий в неделю: ".$grp['parOnWeek']."</div>
            <div style='text-align:left; font-size:0.9em;  padding:0px; color:gray;'>Учебных дней в неделю: ".$grp['schoolDays']."</div>
        </div>
        
        ";
    }
    echo "
    </div>
    ";
   

    echo "
    <a style='text-decoration:none; color:#fff1f4;'href='group.php?add'>
        <div class='button' >
            <span style='display:inline-block; vertival-align:middle; padding:inherit;'>ДОБАВИТЬ</span>
        </div>
    </a>
    ";
   
}
?>

<!-- конец <div class='main'> -->
</div>


<?php
include "footer.php";

?>
