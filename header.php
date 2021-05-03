<head>
    <meta charset="utf-8">   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        label { display: block; }
        input, textarea { display:inline-block; font-family:arial; margin: 5px 10px 5px 40px; padding: 8px 12px 8px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; width: 90%; font-size: small; }
        div { margin-left: auto; margin-right: auto; width: 60%; }
        h1 { text-align: center; }    
        input[type=submit] { padding:5px 15px; border:0 none; cursor:pointer; border-radius: 5px; }
        input[type=submit]:hover { background-color: #ccceee; }
        .msg { margin-left:40px; font-style: italic; color: red; }    
        html{ height:100%; }
        body{ min-height:100%; padding:0; margin:0; position:relative; }    
        footer { position: absolute; bottom: 0; width: 100%; height: 50px; color: WhiteSmoke; padding: 10px; }
        .navbar-custom {
            background-color: purple;
        }
        .nav-search {
            position:absolute;
            text-align: left;
            max-width: 25%;
            right: 0;
        }
    </style>
</head>

<header>
    <?php
    session_start();
    ?>

    <nav class="navbar navbar-custom navbar-expand-md navbar-dark">
        <a class="navbar-brand" href="homepage.php">
            <h1 id="header-title">BPL</h1>
        </a>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">   
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="select-league.php">League Statistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="player-stats.php">Player Statistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php if (isset($_SESSION['admin'])) {echo 'my-leagues.php';} else if (isset($_SESSION['id'])) {echo 'player-stats.php?id=' . $_SESSION['id'];}?>">
                    <?php if (isset($_SESSION['admin'])) {echo 'My Leagues';} else if (isset($_SESSION['id'])) {echo 'My Stats';} ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php if (isset($_SESSION['user'])) {echo 'logout.php';} else {echo 'login.php';}?>">
                    <?php if (isset($_SESSION['user'])) {echo 'Log Out';} else {echo 'Log In';}?>
                    </a>
                </li>
                <li class="nav-item">
                    <font color="white" style="font-style:italic"><?php if (isset($_SESSION['user']) && isset($_COOKIE['name'])) echo 'Signed in as: ' . $_COOKIE['name'] ?></font>
                </li>
                <li class="nav-item">
                    <input type="search" class="form-control nav-search" placeholder="Search for players, teams, or events"/>
                </li>
            </ul>
        </div>  
                
    </nav>
</header>

<body onload="setHeaderTitle()"></body>

<script>
    function setHeaderTitle() {
        var concatTitle = function(title) {
            return "BPL - " + title;
        };
        document.getElementById("header-title").innerHTML = concatTitle(document.title);
    }
</script>