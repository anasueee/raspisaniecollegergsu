<div class='footer'>

<?php
$p = "<div style='width:4px; height:4px; border-radius:5px; background:gray; margin-top:9px; margin-left:3px; margin: 9px 3px 0px 3px;'></div>";
echo "
<div style='display:flex;flex-direction:column; align-items:center;margin:auto; color:black'>
    <div style='display:flex;flex-direction:row; align-items:center; flex-wrap: wrap; margin:auto; font-size:0.7em;'>        
    </div>
    <div style='color:#0f2f50;font-size:0.7em; '> &copy;".date("Y", time())." Расписание онлайн</div>
</div>
";
?>
</div>



<script src="script.js"></script>

<script>


function remove_rasp(event){
    let fn = event.target.getAttribute('id');
    let fnEx = fn.split("#");
    if (confirm("Удаляем расписание ?")){
            let xhr = new XMLHttpRequest();
            xhr.open("get",'handler.php?remove=rasp' + '&groupID=' + fnEx[0] + '&time=' + fnEx[1]); 
            console.log('handler.php?remove=rasp' + '&groupID=' + fnEx[0] + '&time' + fnEx[1]);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.responseType = 'json';
            xhr.send(); 
            xhr.onloadend = function() { if (xhr.status == 200) {  } else { remove_rasp();  } };
            xhr.onload = function() {
            if (xhr.response==null)  return;
            let res = xhr.response
            console.log(res);
            document.location = 'rasp.php';
            }
    }
}

function remove_group(event){
    let group = event.target.getAttribute('id');
    if (confirm("Удаляем группу ?")){
            let xhr = new XMLHttpRequest();
            xhr.open("get",'handler.php?remove=group' + '&groupID=' + group); 
            // console.log('handler.php?remove=rasp' + '&groupID=' + fnEx[0] + '&time' + fnEx[1]);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.responseType = 'json';
            xhr.send(); 
            xhr.onloadend = function() { if (xhr.status == 200) {  } else { remove_group();  } };
            xhr.onload = function() {
            if (xhr.response==null)  return;
            let res = xhr.response
            console.log(res);
            document.location = 'group.php';
            }
    }
}

function remove_prepod(event){
    let prepod = event.target.getAttribute('id');
    if (confirm("Удаляем преподавателя ?")){
            let xhr = new XMLHttpRequest();
            xhr.open("get",'handler.php?remove=prepod' + '&prepodID=' + prepod); 
            // console.log('handler.php?remove=rasp' + '&groupID=' + fnEx[0] + '&time' + fnEx[1]);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.responseType = 'json';
            xhr.send(); 
            xhr.onloadend = function() { if (xhr.status == 200) {  } else { remove_prepod();  } };
            xhr.onload = function() {
            if (xhr.response==null)  return;
            let res = xhr.response
            console.log(res);
            document.location = 'prepod.php';
            }
    }
}
let id_;

let id_opt_old = document.getElementById('opt_old');
// console.log("id_opt_old" + id_opt_old);
if (id_opt_old !== null){
let opt_old = id_opt_old.innerHTML;
// console.log("innerHTML: " + opt_old);
}
function onclick_select(event){
    id_ = event.target.getAttribute('id');
console.log("id_:" + id_);
    if (id_ != null){
        const select_option = document.getElementById(id_).getElementsByTagName('option');
        // console.log(select_option);
        // let opt_old;
        for (let i = 0; i < select_option.length; i++) {
            if (select_option[i].selected == true){
                id_opt_old.innerHTML = select_option[i].value;
            }
        }
        // console.log("innerHTML: " + opt_old);

        // console.log("id_ = " + id_);
    }
}



function onchange_is_overlaping_prepod(event){
    let id = event.target.getAttribute('id');
    // console.log(id);

    const select = document.getElementById(id).value;

    const select_option = document.getElementById(id).getElementsByTagName('option');
    // console.log(select_option);
    let option;
    for (let i = 0; i < select_option.length; i++) {
        if (select_option[i].selected == true){
            option = select_option[i].value;
        }
    }
    // console.log("option: " + option);

        let selEx = select.split('#');
        let idEx = id.split('#');
    // console.log(idEx);
    let xhr = new XMLHttpRequest();
    xhr.open("get",'handler.php?prepod=overlaping' + '&groupID=' + idEx[1] + '&raspID=' + idEx[2] + '&day=' + idEx[3] + '&numPar=' + idEx[4] + '&prepodID=' + selEx[0]); 
    console.log('handler.php?prepod=overlaping' + '&groupID=' + idEx[1] + '&raspID=' + idEx[2] + '&day=' + idEx[3] + '&numPar=' + idEx[4] + '&prepodID=' + selEx[0]);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.responseType = 'json';
    xhr.send(); 
    xhr.onloadend = function() { if (xhr.status == 200) {  } else { onchange_is_overlaping_prepod();  } };
    xhr.onload = function() {
    if (xhr.response==null)  return;
    let res = xhr.response
    console.log(res);
        if (res[0] == 1) {
            id_opt_old = document.getElementById('opt_old');

            // console.log("id_opt_old: " + id_opt_old);
            // console.log("id_opt_old.innerHTML: " + id_opt_old.innerHTML);

            opt_old = id_opt_old.innerHTML;
            console.log("innerHTML: " + opt_old);

            for (let i = 0; i < select_option.length; i++) {
                if (select_option[i].value == opt_old){
                    select_option[i].selected = true;
                }
            }
            alert('Преподаватель выбранного предмета на это время занят в другой группе.\nВыберите другой предмет.')

        }
    }
}

</script>

</body>
</html>


