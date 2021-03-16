<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">   
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>Match</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css" />

    <style> 
        .grid-container{
            display: grid;
            grid-template-columns: 90px 1fr 25px 1fr 90px;
            grid-template-rows: 45px auto;
            width: 100%;
        }
        .grid-con-bucket{
            background-color: #bdb6a3;
            border-style: solid;
            border-radius: 5px;
            width: 100%;
        }
        .grid-row-bucket{
            border-bottom: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            width: 100%;
        }
        .jumbotron{
            background-image: url(pongflipped.jpg); 
            background-position: center center; 
            background-size: cover; 
            height: 100%;
            width: 100%;
        }
    </style> 

</head>

<body>

     <?php include('header.html') ?>

    <div class="jumbotron">
        <h1 style="color: white; text-align:left;">The Three Bucketeers vs. The Blue Mountains</h1>
        <p style="color: white;">This match between The Three Bucketeers (2) and The Blue Mountains (5) </br>is occuring at 6:30 (PM) on Saturday, March 27.</p>
        </div>

    <div class="grid-container"> 
        <div class="container"> </div> <!-- dont need -->
        
        <div class="grid-con-bucket">
            <h3>The Three Bucketeers (2)</h3>
        </div>
        
        <div class="container"> </div> <!-- spacer -->
        
        <div class="grid-con-bucket"> 
            <h3>The Blue Mountains (5)</h3>
        </div>
        
        <div class="container"> </div> <!-- dont need -->

        <div class="container"> </div> <!-- dont need -->
        
        <div class="grid-row-bucket">
            <h4>Me</h4>
            <h4>Whoever</h4>
            <h4>Guy 3</h4>
        </div>
        
        <div class="container"> </div> <!-- spacer -->
        
        <div class="grid-row-bucket"> 
            <h4>You</h4>
            <h4>Middle Person</h4>
            <h4>Last Human</h4>
        </div>
        
        <div class="container"> </div> <!-- dont need -->

    </div>

</body>

</html>