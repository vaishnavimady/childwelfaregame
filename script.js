$(document).ready(function() {
    var questions;
    var currentQuestion = 0;
    var correctAnswers = 0;
    var passages = []; // Array to store passages

    $('#start-btn').click(function() {
        $.getJSON("quiz_questions.json", function(data) {
            questions = data;
            // Extract passages from questions and shuffle them
            passages = getUniquePassages(questions).sort(() => Math.random() - 0.5);
            startGame();
        });
    });

    function startGame() {
        if (passages.length === 0) {
            alert("No passages available.");
            return;
        }
        currentQuestion = 0;
        correctAnswers = 0;
        displayPassage(passages.pop()); // Get and remove the last passage from the array
        $('#game-container').css('text-align', 'center');
        $('#quiz-container').show();
        $('#start-btn').hide();
    }

    $('#submit-btn').click(function() {
        var selectedAnswer = $("input[name='answer']:checked").val();
        var correctAnswer = questions[currentQuestion].correctAnswer;
        
        if (selectedAnswer === correctAnswer) {
            correctAnswers++;
        }
        
        currentQuestion++;
        
        if (currentQuestion < questions.length) {
            displayQuestion(currentQuestion);
        } else {
            showResult();
        }
    });

    function displayPassage(passage) {
        $('#passage-heading').text(passage.heading);
        $('#passage-text').text(passage.text);
        displayQuestion(currentQuestion);
    }

    function displayQuestion(index) {
        var question = questions[index];
        $('#question-image').attr('src', question.image);
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
        } else {
            resultText = "Sorry! You need to restart the game.";
        }
        $('#result-text').text(resultText);
        $('#result-modal').show();
    }

    // Close modal when close button is clicked
    $('.close').click(function() {
        $('#result-modal').hide();
    });

    // Close modal when clicking outside of it
    $(window).click(function(event) {
        if (event.target == $('#result-modal')[0]) {
            $('#result-modal').hide();
        }
    });

    // Function to extract unique passages from questions
    function getUniquePassages(questions) {
        var uniquePassages = {};
        questions.forEach(function(question) {
            uniquePassages[question.passage.text] = question.passage;
        });
        return Object.values(uniquePassages);
    }
});
