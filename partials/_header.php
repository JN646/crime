<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>Crime Application</title>

    <!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="js/Chart.min.js"></script>

    <!-- Function File -->
    <?php require_once 'config/config.php' ?>
    <?php require_once 'lib/functions.php' ?>
  </head>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Crime</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>

  <!-- Header -->
  <div id='headerOuter' class="fluid-container">
    <div id='headerBlock' class="container header">
      <h1 id='headerTitle' class=''>The Crimes</h1>
      <p id='headerSubtitle' class=''>What is happening around you?</p>
    </div>
  </div>
<body>
