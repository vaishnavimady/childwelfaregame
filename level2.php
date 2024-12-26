<?php
// Retrieve name and age from cookies
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : '';
$age = isset($_COOKIE['age']) ? $_COOKIE['age'] : '';

// Now you can use $name and $age variables as needed
echo "Name: $name, Age: $age";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game with JavaScript</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        html {
    width: 100%;
    height: 100%;
    background-image: url('HD Wallpaper For Kids.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    font-family: Arial, Helvetica, sans-serif;
    overflow: hidden;
}
.game {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.controls {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}
button {
    background: #282A3A;
    color: #FFF;
    border-radius: 5px;
    padding: 10px 20px;
    border: 0;
    cursor: pointer;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18pt;
    font-weight: bold;
}
.disabled {
    color: #757575;
}
.stats {
    color: #FFF;
    font-size: 14pt;
    font-weight: bold;
}
.board-container {
    position: relative;
}
.board,
.win {
    border-radius: 5px;
    box-shadow: 0 25px 50px rgb(33 33 33 / 25%);
    background: linear-gradient(135deg, #03001e 0%, #8ec6ff 0%, #9fed5c 50%, #fdeff9 100%);
    transition: transform .6s cubic-bezier(0.4, 0.0, 0.2, 1);
    backface-visibility: hidden;
}
.board {
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(4, auto);
    grid-gap: 20px;
}
.board-container.flipped .board {
    transform: rotateY(180deg) rotateZ(50deg);
}
.board-container.flipped .win {
    transform: rotateY(0) rotateZ(0);
}
.card {
    position: relative;
    width: 100px;
    height: 100px;
    cursor: pointer;
}
.card-front,
.card-back {
    position: absolute;
    border-radius: 5px;
    width: 100%;
    height: 100%;
    background: #282A3A;
    transition: transform .6s cubic-bezier(0.4, 0.0, 0.2, 1);
    backface-visibility: hidden;
}
.card-back {
    transform: rotateY(180deg) rotateZ(50deg);
    font-size: 28pt;
    user-select: none;
    text-align: center;
    line-height: 100px;
    background: #FDF8E6;
}
.card.flipped .card-front {
    transform: rotateY(180deg) rotateZ(50deg);
}
.card.flipped .card-back {
    transform: rotateY(0) rotateZ(0);
}
.win {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    background: #FDF8E6;
    transform: rotateY(180deg) rotateZ(50deg);
}
.win-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 21pt;
    color: #282A3A;
}
.highlight {
    color: #7303c0;
}
.str-head-text{
    color:#c11b1b;font-family: "Press Start 2P", system-ui;
    font-weight: 400;
    font-style: normal;
    text-align: center;
}
    </style>
</head>
<body>

    <div class="game">
    <h1 class="str-head-text" style="">Mind Game</h1>
<h2 class="str-head-text" style="">Level- 2</h2>
        <div class="controls">
            <button style="display:none">Start</button>
            <div class="stats">
                <div class="moves">0 moves</div>
                <div class="timer">Time: 0 sec</div>
            </div>
        </div>
        <div class="board-container">
            <div class="board" data-dimension="4"></div>
            <div class="win">You won!
          
        </div>
        </div>
    </div>
    <script>
        const selectors = {
    boardContainer: document.querySelector('.board-container'),
    board: document.querySelector('.board'),
    moves: document.querySelector('.moves'),
    timer: document.querySelector('.timer'),
    start: document.querySelector('button'),
    win: document.querySelector('.win')
}

const state = {
    gameStarted: false,
    flippedCards: 0,
    totalFlips: 0,
    totalTime: 0,
    loop: null
}

const shuffle = array => {
    const clonedArray = [...array]

    for (let i = clonedArray.length - 1; i > 0; i--) {
        const randomIndex = Math.floor(Math.random() * (i + 1))
        const original = clonedArray[i]

        clonedArray[i] = clonedArray[randomIndex]
        clonedArray[randomIndex] = original
    }

    return clonedArray
}

const pickRandom = (array, items) => {
    const clonedArray = [...array]
    const randomPicks = []

    for (let i = 0; i < items; i++) {
        const randomIndex = Math.floor(Math.random() * clonedArray.length)
        
        randomPicks.push(clonedArray[randomIndex])
        clonedArray.splice(randomIndex, 1)
    }

    return randomPicks
}


const generateGame = () => {
    const dimensions = selectors.board.getAttribute('data-dimension');
    
    if (dimensions % 2 !== 0) {
        throw new Error("The dimension of the board must be an even number.");
    }

    // Define your image URLs here
    const imageUrls = ['image1.jpeg', 'image2.jpeg', 'image3.jpeg', 'image4.jpeg', 'image5.jpeg', 'image6.jpeg', 'image7.jpeg', 'image8.jpeg', 'image9.jpeg', 'image10.jpg'];

    // Duplicate each image URL to create pairs
    const imagePairs = imageUrls.concat(imageUrls);

    // Shuffle the image pairs
    const shuffledPairs = shuffle(imagePairs);

    const cards = `
        <div class="board" style="grid-template-columns: repeat(${dimensions}, auto)">
            ${shuffledPairs.map((item, index) => `
                <div class="card">
                    <div class="card-front"></div>
                    <div class="card-back"><img src="${item}" width="100" height="100" alt="Image${index}"></div>
                </div>
            `).join('')}
       </div>
    `;
    
    const parser = new DOMParser().parseFromString(cards, 'text/html');

    selectors.board.replaceWith(parser.querySelector('.board'));
};

const startGame = () => {
    state.gameStarted = true
    selectors.start.classList.add('disabled')

    state.loop = setInterval(() => {
        state.totalTime++

        selectors.moves.innerText = `${state.totalFlips} moves`
        selectors.timer.innerText = `Time: ${state.totalTime} sec`
    }, 1000)
}

const flipBackCards = () => {
    document.querySelectorAll('.card:not(.matched)').forEach(card => {
        card.classList.remove('flipped')
    })

    state.flippedCards = 0
}

const flipCard = card => {
    state.flippedCards++
    state.totalFlips++

    if (!state.gameStarted) {
        startGame()
    }

    if (state.flippedCards <= 2) {
        card.classList.add('flipped')
    }

    if (state.flippedCards === 2) {
        const flippedCards = document.querySelectorAll('.flipped:not(.matched)')

        if (flippedCards[0].querySelector('.card-back img').src === flippedCards[1].querySelector('.card-back img').src) {
            flippedCards[0].classList.add('matched')
            flippedCards[1].classList.add('matched')
        }

        setTimeout(() => {
            flipBackCards()
        }, 1000)
    }
    if (!document.querySelectorAll('.card:not(.flipped)').length) {
        setTimeout(() => {
            selectors.boardContainer.classList.add('flipped')
            selectors.win.innerHTML = `
                <span class="win-text">
                    You won!<br />
                    with <span class="highlight">${state.totalFlips}</span> moves<br />
                    under <span class="highlight">${state.totalTime}</span> seconds
                </span>
            `
            
            clearInterval(state.loop)
        }, 1000);
        setTimeout(() => {
        window.location.href = 'level3.php';
    }, 3000);
    }
}

const attachEventListeners = () => {
    document.addEventListener('click', event => {
        const eventTarget = event.target
        const eventParent = eventTarget.parentElement

        if (eventTarget.className.includes('card') && !eventParent.className.includes('flipped')) {
            flipCard(eventParent)
        } else if (eventTarget.nodeName === 'BUTTON' && !eventTarget.className.includes('disabled')) {
            startGame()
        }
    })
}
document.addEventListener('DOMContentLoaded', function() {
    generateGame();
    attachEventListeners();
});
// generateGame()
// attachEventListeners()
    </script>
</body>
</html>