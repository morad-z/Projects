let container = document.getElementById("container");

const texts = container.getElementsByTagName("p");
const buttons = container.getElementsByTagName("button");

for (const button of buttons) {
  button.addEventListener("click", function (event) {
    document.body.style.setProperty(
      "--drift",
      Math.floor(Math.random() * 400) - 200 + "px"
    );
    button.classList.toggle("active");
    setTimeout(() => {
      button.classList.toggle("active");
    }, 2000);
  });
}

function splitText(words) {
  for (let word of words) {
    let newword = word.textContent.split(" ");
    word.textContent = "";
    for (let i = 0; i < newword.length; i++) {
      let newWords = newword[i].split("");
      let wordwrap = document.createElement("span");
      wordwrap.classList.add("word-" + i, "word");
      wordwrap.setAttribute("data-word", newword[i]);
      let letters = newword[i].split("");
      let j = 0;
      for (let letter of letters) {
        j++;
        wordwrap.innerHTML +=
          '<span style="--char-index:' +
          j +
          '" data-char="' +
          letter +
          '">' +
          letter +
          "</span>";
      }
      word.appendChild(wordwrap);
    }
  }
  document.body.classList.add("loaded");
}

function addSVG(buttons) {
  let i = 0;
  for (let button of buttons) {
    i++;
    button.innerHTML += "<span class='overlay'></span>";
  }
}

splitText(texts);
splitText(buttons);
addSVG(buttons);

var pointerX = 0;
var pointerY = 0;
var width = window.innerWidth / 2;
var height = window.innerHeight / 2;
var body = document.body;
var light = document.getElementById("light");

window.addEventListener(
  "resize",
  function (event) {
    width = window.innerWidth / 2;
    height = window.innerHeight / 2;
  },
  true
);

document.onmousemove = function (event) {
  pointerX = ((width - event.pageX) * -1) / width;
  pointerY = ((height - event.pageY) * -1) / height;
  body.style.setProperty("--x", pointerX);
  body.style.setProperty("--y", pointerY);
  body.style.setProperty("--total", Math.abs(pointerX) + Math.abs(pointerY));
};
function jumpscare() {
  const jumpscare = document.getElementById("jumpscare");
  jumpscare.style.visibility = "visible";
  setTimeout(function () {
    jumpscare.style.visibility = "hidden";
  }, 700);
  var audio = document.getElementById("scream");
  audio.play();
}
function hideContainer() {
  var container = document.getElementById("container");
  container.classList.add("hide");

  var newContent = document.getElementById("new-content");
  setTimeout(function () {
    container.style.display = "none";
    newContent.classList.remove("hidden");
  }, 2000);
}
const bloodButton = document.getElementById("blood");
const drip1 = document.getElementById("drip-1");
const drip2 = document.getElementById("drip-2");
const drip3 = document.getElementById("drip-3");
const drip4 = document.getElementById("drip-4");
const drip5 = document.getElementById("drip-5");
const drip6 = document.getElementById("drip-6");
bloodButton.addEventListener("mouseover", (event) => {
  drip1.style.animation = "drip 1.2s ease-out";
  drip2.style.animation = "drip 2s ease-out";
  drip3.style.animation = "drip 2.5s ease-out";
  drip4.style.animation = "drip 1.5s ease-out";
  drip5.style.animation = "drip 2s ease-out";
  drip6.style.animation = "drip 2.3s ease-out";
});

bloodButton.addEventListener("mouseout", (event) => {
  if (event) {
    drip1.style.animation = "";
    drip2.style.animation = "";
    drip3.style.animation = "";
    drip4.style.animation = "";
    drip5.style.animation = "";
    drip6.style.animation = "";
  }
});

function validateForm() {
  var fullName = document.getElementById("fullName").value;
  var pass = document.getElementById("pass").value;
  var phone = document.getElementById("phone").value;
  var age = document.getElementById("age").value;
  var nameRegex = /^[a-zA-Z]+\s?[a-zA-Z]+$/;
  if (!fullName.match(nameRegex)) {
    alert("Please enter a valid name.");
    return false;
  }

  var passRegex = /(?=.*[A-Z])/;
  if (!pass.match(passRegex)) {
    alert("Please enter a password with at least one uppercase letter.");
    return false;
  }
  var phoneRegex = /^[0-9]+$/;
  if (!phone.match(phoneRegex)) {
    alert("Please enter a valid phone number.");
    return false;
  }

  if (age < 23 || age > 38) {
    alert("Please enter an age between 23 and 38.");
    return false;
  }
  return true;
}
