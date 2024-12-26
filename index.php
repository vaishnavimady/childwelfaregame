<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChildWelfareRights</title>
    <link rel="stylesheet" href="/jquery/jquery-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
	body{
        margin:auto;
        background-image: url('welgamelevelback.jpg');
        background-repeat: no-repeat;
        background-size: cover;
    }
        #puzzle{width:600px;margin:auto; margin-top:90px}
        .tile{
            background-image:url('puzzlelevel1.jpeg');
            width:200px;
            height:200px;
            float:left;
            border:1px solid silver;
            box-sizing:border-box;
        }
        #tile1 { background-position:0 0 }
        #tile2 { background-position:-200px -0px }
        #tile3 { background-position:-400px -0px }
        #tile4 { background-position:-0 -200px }
        #tile5 { background-position:-200px -200px }
        #tile6 { background-position:-400px -200px }
        #tile7 { background-position:-0 -400px }
        #tile8 { background-position:-200px -400px }
        #tile9 { background-position:-400px -400px }
		
		#popup{position:absolute;width:100%;
background:rgba(0,0,0,0.5);top:25%;
text-align:center;color:#fff;}
.start-btn{
    padding: 15px 30px;
    font-size: 16px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    animation: pulse 1.5s infinite;
}
@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0px rgba(52, 152, 219, 0.7);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 0 15px rgba(52, 152, 219, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0px rgba(52, 152, 219, 0);
    }
}
.loading {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: rgba(255, 255, 255, 0.8);
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}
.str-head-text{
    color:#f7c854;font-family: "Press Start 2P", system-ui;
    font-weight: 400;
    font-style: normal;
}
    </style>
</head>
<body>
  
    <div id="puzzle" class="sortable">
        <div id='tile1' class='tile'></div>
        <div id='tile2' class='tile'></div>
        <div id='tile3' class='tile'></div>
        <div id='tile4' class='tile'></div>
        <div id='tile5' class='tile'></div>
        <div id='tile6' class='tile'></div>
        <div id='tile7' class='tile'></div>
        <div id='tile8' class='tile'></div>
        <div id='tile9' class='tile'></div>
    </div>
	<div id="loading" class="loading">Loading...</div>
	<div id='popup' style='display:block;'>

<div id='message'>
<h1 class="str-head-text" style="">Child Welfare Game</h1>
<h2 class="str-head-text" style="">Level- 1</h2>
Click on start button and Start Level 1 Game Rearrange Proper Image [Puzzle Game].</div><br/><br/>
<form id="form">
    <input type="text" name="name" placeholder="Enter Your Name"  /><br/><br/>
    <input type="text" name="age" placeholder="Enter Your Age"  /><br/><br/>
    <br/><br/>
    
</form>
<button  id='startBtn' class="start-btn" style='display:inline;' onclick="shuffle()">Start Game</button><br/><br/>

</div>

    <h1 style="position:absolute;top:0px;right:0px;padding:10px;" id='timer'></h1>
    
    <script src="jquery/jquery.min.js"></script>
    <script src="jquery/jquery-ui.js"></script>
	
	<!-- <script src="jquery/touch-dnd.js"></script> -->
    <script>
        var sec=0;
        let timer;
        function shuffle() {

			$( "#popup" ).hide('');
            $('#form').hide();
			$('#startBtn').hide();
            let array = [1, 2, 3, 4, 5, 6, 7, 8, 9];
            array.sort(function(a, b){return 0.5 - Math.random()});
            
            $('#puzzle').html('');
            for (var i = 0; i < array.length; i++) {
                $( "#puzzle" ).append("<div id='tile"+array[i]+"' class='tile'></div>");
            }
            
            sec=0;
            timer = setInterval(function(){ 
                sec=sec+1;
                $( "#timer" ).html(sec);
            }, 1000);
        }

        

        $( ".sortable" ).sortable({connectWith: ".sortable"},
        {
            update: function( event, ui ) {
                countRight=0;
                $("#puzzle > div").each((index, elem) => {
                if('tile'+(index+1)==elem.id){
                    countRight=countRight+1;
                }
                if(countRight==9){
                    let completedin=sec;
                    sec=0;
                    clearInterval(timer);
                    $( "#timer" ).html('');
                    var name = $("input[name='name']").val(); // Retrieve name from input field
                    var age = $("input[name='age']").val(); // Retrieve age from input field
                    document.cookie = "name=" + name + "; path=/"; // Set cookie for name
                    document.cookie = "age=" + age + "; path=/"; 
					// $('#startBtn').show();
					$( "#popup" ).show();
                    $( "#form" ).hide();
                    $( "#message" ).html("<h2>👏 Congratulations !</h2><h1></h1> You have solved the puzzle in "+completedin+" seconds");
                    $('#loading').show();
                    setTimeout(function() {
                        $('#loading').hide();
                        window.location.href = 'level2.php'; // Replace '/next-route' with the actual URL of the next route
                    }, 3000);
                }
            });
            }
        });
		$("#sortable").disableSelection();

    </script>
</body>
</html>
