<?php
// Initialise the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Set Session ID to variable.
if (isset($_SESSION["id"])) {
  // If there is a session ID.
  $userid = $_SESSION["id"];
}
?>

<!-- Header -->
<?php include '../partials/_header.php' ?>
<body>
  <div id="bodyContainer" class="container">
    <div class='col-md-12'>

      <!-- Page Header -->
        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>

        <!-- Intro Text -->
        <p>This is your dashboard. This feature is coming soon. Does not serve a purpose yet, but only to act as a landing page for a successful login of a non-admin account.</p>

        <!-- Buttons -->
        <p>
            <a href="reset-password.php" class="btn btn-warning"><i class="fas fa-key"></i></a>
            <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i></a>
        </p>

        <hr>

        <h2>Bookmarked</h2>

        <table class='table table-bordered table-sm'>

        <?php
        // get the info from the db
        $sql = "SELECT DISTINCT `report_id`, `report_comment`, `report_lat`, `report_long`
        FROM `report_log`
        WHERE `report_user` = $userid
        AND `report_bookmarked` = 1
        LIMIT 5";

        $result = mysqli_query($mysqli, $sql) or trigger_error("SQL", E_USER_ERROR);

        ?>
          <thead>
            <tr>
              <th class='text-center'>#</th>
              <th class='text-center'>Comment</th>
              <th class='text-center'>Latitude</th>
              <th class='text-center'>Longitude</th>
              <th class='text-center' colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
        // while there are rows to be fetched...
        while ($row = mysqli_fetch_assoc($result)) {
           ?>
           <tr>
             <td class='text-center'><?php echo $row['report_id']; ?></td>
             <td><?php echo $row['report_comment']; ?></td>
             <td><?php echo $row['report_lat']; ?></td>
             <td><?php echo $row['report_long']; ?></td>
             <td class='text-center'>
               <a href="crimemanager.php?edit=<?php echo $row['id']; ?>" data-toggle="" data-target="" class="btn btn-link"><i class="far fa-edit"></i></a>
             </td>
             <td class='text-center'>
               <a href="lib/crimeserver.php?del=<?php echo $row['id']; ?>" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
             </td>
           </tr>
           <?php
        }
         ?>
          </tbody>
        </table>

        <h2>Your Reports</h2>

        <table class='table table-bordered table-sm'>
          <?php
          // find out how many rows are in the table
          $sql = "SELECT COUNT(*) FROM report_log";
          $result = mysqli_query($mysqli, $sql) or trigger_error("SQL", E_USER_ERROR);
          $r = mysqli_fetch_row($result);
          $numrows = $r[0];

          // number of rows to show per page
          $rowsperpage = 20;
          // find out total pages
          $totalpages = ceil($numrows / $rowsperpage);

          // get the current page or set a default
          if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
             // cast var as int
             $currentpage = (int) $_GET['currentpage'];
          } else {
             // default page num
             $currentpage = 1;
          } // end if

          // if current page is greater than total pages...
          if ($currentpage > $totalpages) {
             // set current page to last page
             $currentpage = $totalpages;
          } // end if
          // if current page is less than first page...
          if ($currentpage < 1) {
             // set current page to first page
             $currentpage = 1;
          } // end if

          // the offset of the list, based on current page
          $offset = ($currentpage - 1) * $rowsperpage;

          // get the info from the db
          $sql = "SELECT DISTINCT `report_id`, `report_comment`, `report_lat`, `report_long`
          FROM `report_log`
          WHERE `report_user` = $userid
          AND `report_bookmarked` = 0
          LIMIT $offset, $rowsperpage";

          $result = mysqli_query($mysqli, $sql) or trigger_error("SQL", E_USER_ERROR);

          ?>
            <thead>
              <tr>
                <th class='text-center'>#</th>
                <th class='text-center'>Comment</th>
                <th class='text-center'>Latitude</th>
                <th class='text-center'>Longitude</th>
                <th class='text-center' colspan="2">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
          // while there are rows to be fetched...
          while ($row = mysqli_fetch_assoc($result)) {
             ?>
             <tr>
               <td class='text-center'><?php echo $row['report_id']; ?></td>
               <td><?php echo $row['report_comment']; ?></td>
               <td><?php echo $row['report_lat']; ?></td>
               <td><?php echo $row['report_long']; ?></td>
               <td class='text-center'>
                 <a href="crimemanager.php?edit=<?php echo $row['id']; ?>" data-toggle="" data-target="" class="btn btn-link"><i class="far fa-edit"></i></a>
               </td>
               <td class='text-center'>
                 <a href="lib/crimeserver.php?del=<?php echo $row['id']; ?>" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
               </td>
             </tr>
             <?php
          } // end while

          /******  build the pagination links ******/
          echo '<nav aria-label="Page navigation"><ul class="pagination pagination-sm justify-content-center">';
          // range of num links to show
          $range = 3;

          // if not on page 1, don't show back links
          if ($currentpage > 1) {
             // show << link to go back to page 1
             echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a></li> ";
             // get previous page num
             $prevpage = $currentpage - 1;
             // show < link to go back to 1 page
             echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a></li> ";
          } // end if

          // loop to show links to range of pages around current page
          for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
             // if it's a valid page number...
             if (($x > 0) && ($x <= $totalpages)) {
                // if we're on current page...
                if ($x == $currentpage) {
                   // 'highlight' it but don't make a link
                   echo " <li class='page-item active'><span class='page-link'> $x </span></li> ";
                // if not current page...
                } else {
                   // make it a link
                   echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a></li> ";
                } // end else
             } // end if
          } // end for

          // if not on last page, show forward and last page links
          if ($currentpage != $totalpages) {
             // get next page
             $nextpage = $currentpage + 1;
              // echo forward link for next page
             echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></li> ";
             // echo forward link for lastpage
             echo " <li class='page-item'><a class='page-link' href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></li> ";
          } // end if
          /****** end build pagination links ******/
          echo "</ul></nav>";
          ?>
          </tbody>
        </table>
    </div>
  </div>
</body>
<!-- Footer -->
<?php include '../partials/_footer.php' ?>
</html>
