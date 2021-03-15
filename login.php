<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html') ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Log In</h1>
        </div>
        <div class="grid-row">
            <form action="success.php" onsubmit="return (validateInfo())">
                <h3>Username: </h3> 
                <input type="text" id="username" class="grid-input" autofocus required />
                <div id="user-msg" class="feedback"></div> 
                <br/>
                <h3>Password: </h3> 
                <input type="password" id="pwd" class="grid-input" required />
                <div id="pwd-msg" class="feedback"></div> 
                <br/>
                <input type="submit" class="btn-grid" value="Log in" />   <!-- use input type="submit" with the required attribute -->
            </form>
        </div>
    </div>

    <script>
        var user = document.getElementById("username");

        user.addEventListener('blur', function() {
            checkUsername(8);
        }, false);

        function checkUsername(minlength) {
            var msg = document.getElementById("user-msg");
            if (user.value.length < minlength && user.value.length > 0)
                msg.textContent = "Username is too short";
            else
                msg.textContent = "";
            }

        function validateInfo() {
            var pwd = document.getElementById("pwd").value;       
            if (user.value.length < 8)
            {    	  
                document.getElementById("user-msg").innerHTML = "Username is too short";
                document.getElementById("username").focus();
                return false;
            }
            return true;
        } 
    </script>
</body>
</html>