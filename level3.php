<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Game</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

</head>
<body>
    <div id="game-container">
        <h1>Level 3 Quiz Game</h1>
        <button id="start-btn">Start Game</button>
        <div id="quiz-container" style="display: none;">
            <div id="question-container">
                <img id="question-image" src="" alt="Question Image">
            </div>
            <div id="options"></div>
            <button id="submit-btn">Submit</button>
        </div>
    </div>

    <div id="result-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="result-text"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Game</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div id="game-container">
        <h1 style="color:white">Level 3 </h1>
        <h1 style="color:white;font-family: Land Speed Record V1 ; font-size:60px">Passage Quiz Game</h1>
        <button id="start-btn">Start Game</button>
        <div id="quiz-container" style="display: none;">
            <div id="passage-container">
                <h2 id="passage-heading" style="color:white"></h2>
                <p id="passage-text" style="color:white;font-family: Mukta, sans-serif;font-weight: 400;font-style: normal;"></p>
            </div>
            <div id="question-container" style="display: none;">
            <div id="question-text" style="color:white;font-family: Mukta, sans-serif;font-weight: 400;font-style: normal;border: 2px solid pink;
    border-radius: 10px;"></div><br />
                <div id="options" style="color:white;font-family: Mukta, sans-serif;font-weight: 400;font-style: normal;"></div>
                <button id="submit-btn">Submit</button>
            </div>
        </div>
    </div>

    <div id="result-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="result-text"></p>
            <div id="certificate">
            <a id="certificate-link" href="certificate.php" style="color: gold; text-decoration: none;text-align: center;">Download Certificate</a>
        </div>
        </a> 
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    var passages = []; // Array to store passages
    var currentPassage = null; // Variable to store the current passage
    var currentQuestion = 0; // Variable to track the current question index
    var correctAnswers = 0; // Variable to track the number of correct answers

    $('#start-btn').click(function() {
        $.getJSON("quiz_questions.json", function(data) {
            passages = data; // Assign the array of passages to the passages variable
            startGame();
        });
    });

    function startGame() {
        if (passages.length === 0) {
            alert("No passages available.");
            return;
        }
        currentPassage = passages.shift(); // Get and remove the first passage from the array
        passages.push(currentPassage); // Push the passage to the end of the array
        currentQuestion = 0; // Reset the current question index
        correctAnswers = 0; // Reset the number of correct answers
        displayPassage(currentPassage); // Display the current passage
        $('#quiz-container').show(); // Show the quiz container
        $('#start-btn').hide(); // Hide the start button
    }

    $('#submit-btn').click(function() {
        var selectedAnswer = $("input[name='answer']:checked").val();
        console.log("Correct Answer", selectedAnswer);
        var correctAnswer = currentPassage.questions[currentQuestion].correctAnswer;
        
        if (selectedAnswer === correctAnswer) {
            correctAnswers++;
        }
        
        currentQuestion++;
        
        if (currentQuestion < currentPassage.questions.length) {
            displayQuestion(currentQuestion);
        } else {
            showResult();
        }
    });

    function displayPassage(passage) {
        $('#passage-heading').text(passage.passage.heading);
        $('#passage-text').text(passage.passage.text);
        displayQuestion(currentQuestion);
    }

    function displayQuestion(index) {
    var question = currentPassage.questions[index];
    $('#question-text').text(question.text); // Set the text of the question
    $('#options').empty();
    question.options.forEach(function(option, i) {
        $('#options').append('<label class="option"><input type="radio" name="answer" value="' + String.fromCharCode(65 + i) + '"> ' + option + '</label>');
    });
    $('#question-container').show();
}


    function showResult() {
        var resultText = '';
        if (correctAnswers > 5) {
            resultText = "Congratulations! You win.";
            $('#certificate-link').show();
        } else {
            resultText = "Sorry! You need to restart the game.";
            $('#certificate-link').hide();
            $('#result-text').text(resultText);
        // Redirect to level3.php after 3 seconds
        setTimeout(() => {
            window.location.href = 'level3.php';
        }, 3000);
           
        }
        $('#result-text').text(resultText);
        $('#result-modal').show();
        // if(resultText === "Congratulations! You win."){
        //     $('$certificate').attr("style", "display:block");
        // }
        // else if(resultText === "Sorry! You need to restart the game."){
        //     $('$certificate').attr("style", "display:none");
        //     setTimeout(() => {
        // window.location.href = 'level3.php';
        // }, 3000);
        // }
    }

    // Close modal when close button is clicked
    $('.close').click(function() {
        $('#result-modal').hide();
        if (correctAnswers <= 5) {
            startGame(); // Restart the game if the user needs to restart
            window.location.href = 'level3.php';
        }
        else{
            window.location.href = 'index.php';
        }
        
    });

    // Close modal when clicking outside of it
    $(window).click(function(event) {
        if (event.target == $('#result-modal')[0]) {
            $('#result-modal').hide();
        }
    });
});

    </script>
</body>
</html>

