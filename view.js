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

//Two functions for this task, temporary solution
function Form1() {
  var x = document.getElementById("CreateForm");
  var y = document.getElementById("CreateProjectForm");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else if(x.style.display === "block") {
    x.style.display = "none";
  }
  else{
    x.style.display = "block";
    y.style.display = "none";
  }
}

function Form2() {
  var x = document.getElementById("CreateProjectForm");
  var y = document.getElementById("CreateForm");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else if(x.style.display === "block") {
    x.style.display = "none";
  }
  else{
    x.style.display = "block";
    y.style.display = "none";
  }
}

const e = React.createElement;

class LikeButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  render() {
    if (this.state.liked) {
      return 'You liked this.';
    }

    return e(
      'button',
      { onClick: () => this.setState({ liked: true }) },
      'Like'
    );
  }
}
const domContainer = document.querySelector('#like_button_container');
ReactDOM.render(e(LikeButton), domContainer);