let size = 80;
let squaresAdded = 0;
let ClickCount = 0;
let letters = ["A", "B", "C", "D"];
let shuffledLetters = shuffle(letters);
let selectedSquares = [];

function addSquares() {
  let container = document.getElementById("container");
  let squares = [];
  for (let i = 0; i < 3; i++) {
    let square = document.createElement("div");
    square.className = "square";
    square.style.width = size + "px";
    square.style.height = size + "px";
    square.setAttribute("data-index", i);
    squares.push(square);
    size += 20;
  }
  squaresAdded += 3;
  for (let i = 0; i < squares.length; i++) {
    container.appendChild(squares[i]);
    squares[i].addEventListener("click", handleSquareClick);
  }
  let clickLimit = 2;
  if (ClickCount >= clickLimit) {
    alert("You can only click this button 3 times.");
    return false;
  } else {
    ClickCount++;
    return true;
  }
}

function handleSquareClick() {
  if (selectedSquares.length < 2 && !selectedSquares.includes(this)) {
    this.textContent = shuffledLetters[this.getAttribute("data-index")];
    selectedSquares.push(this);
    this.classList.add("flip");
  }
  if (selectedSquares.length == 2) {
    setTimeout(checkMatch, 1000);
  }
}

function checkMatch() {
  if (shuffledLetters[selectedSquares[0].getAttribute("data-index")] == shuffledLetters[selectedSquares[1].getAttribute("data-index")]) {
    selectedSquares[0].removeEventListener("click", handleSquareClick);
    selectedSquares[1].removeEventListener("click", handleSquareClick);
    selectedSquares[0].classList.add("matched");
    selectedSquares[1].classList.add("matched");
  } else {
    selectedSquares[0].textContent = "";
    selectedSquares[1].textContent = "";
    selectedSquares[0].classList.remove("flip");
    selectedSquares[1].classList.remove("flip");
  }
  selectedSquares = [];
}
function shuffle(array) {
  let currentIndex = array.length,
    temporaryValue, randomIndex;
  while (0 !== currentIndex) {
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }
  return array;
}

function reset() {
  let container = document.getElementById("container");
  container.innerHTML = "";
  selectedSquares = [];
  shuffledLetters = shuffle(letters.concat(letters));
  addSquares();
}
