'use strict';

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

function CloseForm(clickedForm) {
    clickedForm.style.display = "none";
}

function Form(clickedForm) {
  if (clickedForm.style.display === "none") {
    clickedForm.style.display = "block";
  } else if(clickedForm.style.display === "block") {
    clickedForm.style.display = "none";
  }
  else{
    clickedForm.style.display = "block";
  }
}