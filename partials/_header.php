<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>Crime Application</title>

    <!-- Function File -->
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/crime/config/config.php");?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/crime/lib/functions.php");?>

    <!-- Stylesheets -->
	  <link rel="stylesheet" href="<?php echo $environment; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $environment; ?>css/master.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  </head>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?php echo $environment; ?>index.php">Crime</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $environment; ?>admin/admin.php">Admin</a>
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
