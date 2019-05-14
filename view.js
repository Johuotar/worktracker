var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}

function Form1() {
  var x = document.getElementById("CreateForm");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else if(x.style.display === "block") {
    x.style.display = "none";
  }
  else{
    x.style.display = "block";
  }
}