<!DOCTYPE html>
<html lang="en">
<head> 
  <title>BPL - Home</title>
  <style>
    .grid-container {
      display: grid;
      padding-bottom: 50px;
      width: 100%;
    }
    .grid-header {
      background-color: goldenrod;
      width: 100%;
    }
    .grid-row {
      position: relative;
      top: 25px;
      border-radius: 25px;
      border-style: solid;
      background-color: #ba8dba;
      text-align: center;
      padding-bottom: 20px;
      width: 75%;
    }
    .btn-grid {
      height: 35%;
      min-width: 20%;
      color: white;
      background-color: purple;
      border-radius: 25px;
    }
  </style>
</head>

<body>
  <?php include('header.html') ?>

  <div class="grid-container">
    <div class="grid-header">
      <h1>Upcoming Matches</h1>
    </div>
    <div class="grid-row">
      <h2>BPL 2021 - 4/17/21</h2>
      <h3>VS. The Blue Mountains</h3>
      <button class="btn-grid">
        <a href="#"></a>
        View Match
      </button>
    </div>
    <div class="grid-row">
      <h2>Exhibition - 4/19/21</h2>
      <h3>VS. The Dudes</h3>
      <button class="btn-grid">
        <a href="#"></a>
        View Match
      </button>
    </div>
  </div>

  <div class="grid-container">
    <div class="grid-header">
      <h1>My Teams</h1>
    </div>
    <div class="grid-row">
      <h2>The Three Bucketeers</h2>
      <h3>League: BPL</h3>
      <button class="btn-grid">
        <a href="#"></a>
        View Team
      </button>
    </div>
  </div>

</body>

</html>