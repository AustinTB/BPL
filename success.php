<!DOCTYPE html>
<html lang="en">
<head>
  <title>Success</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.php') ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>You've logged in successfully. Welcome!</h1>
        </div>
        <div class="grid-row">
            <form action="homepage.php">
                <br/>
                <input type="submit" class="btn-grid" value="Home Page" />
                <br/>
            </form>
        </div>
    </div>
</body>
</html>