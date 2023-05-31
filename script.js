
function onclick_BarMenu() {
  var x = document.getElementById("barmenuLinks");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function mouseleave_barmenuLinks(){
  var barmenuLinks = document.getElementById("barmenuLinks");
  barmenuLinks.style.display = "none";
}

function closemenu(){
  var barmenuLinks = document.getElementById("barmenuLinks");
  barmenuLinks.style.display = "none";
}