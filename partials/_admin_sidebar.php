<!-- Links -->
<div class="card">
  <div class="card-header">
    <h5>Links</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="admin.php"><i class="fas fa-home"></i> Home</a></li>
  </ul>
</div>
<br>

<!-- Config -->
<div class="card">
  <div class="card-header">
    <h5>Config</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="usermanager.php"><i class="fas fa-user"></i> User Manager</a></li>
  </ul>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="crimemanager.php"><i class="fas fa-list"></i> Crime Manager</a></li>
  </ul>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href='' data-toggle="modal" data-target=".server-info-modal"><i class="fas fa-server"></i> Server Info</a></li>
  </ul>
</div>
<br>

<!-- Cron Jobs -->
<div class="card">
  <div class="card-header">
    <h5>Cron Jobs</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href='' data-toggle="modal" data-target=".cron-job-modal"><i class="fas fa-clock"></i> Cron Job List</a></li>
  </ul>
</div>
<br>

<!-- Accounts -->
<div class="card">
  <div class="card-header">
    <h5>Account</h5>
  </div>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link" href="../users/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</div>
<br>

<!-- Server Information -->
<div class="modal fade server-info-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Server Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This page contains sensitive server information and config. Do not distribute.</p>
        <?php
        // set default timezone
        date_default_timezone_set('Europe/London'); // GMT
        $current_date = date('d/m/Y == H:i:s');

        $dd=array(
            'Server Address'=>$_SERVER['SERVER_ADDR'],
            'Server Name'=>$_SERVER['SERVER_NAME'],
            'Server Time'=>$current_date,
            'Server Software'=>$_SERVER['SERVER_SOFTWARE'],
            'Document Root'=>$_SERVER['DOCUMENT_ROOT'],
            'HTTP Host'=>$_SERVER['HTTP_HOST'],
            'Remote Address'=>$_SERVER['REMOTE_ADDR'],
            'Remote Port'=>$_SERVER['REMOTE_PORT'],
            'Script File Name'=>$_SERVER['SCRIPT_FILENAME'],
            'Server Admin'=>$_SERVER['SERVER_ADMIN'],
            'Server Port'=>$_SERVER['SERVER_PORT'],
            'Script Name'=>$_SERVER['SCRIPT_NAME'],
            'Request URI'=>$_SERVER['REQUEST_URI'],
            'PHP Self'=>$_SERVER['PHP_SELF']
        );
        ?>
          <table class='table table-bordered' align="center">
            <tr>
              <th class='text-center'>Name</th>
              <th class='text-center'>Value</th>
            </tr>
          <?php
          foreach ($dd as $key=>$value) {
              ?>
            <tr>
              <td><?php echo $key?> </td>
              <td><?php echo $value?></td>
            </tr>
          <?php
          } ?>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cron Jobs -->
  <div class="modal fade cron-job-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cron Jobs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Here are timed server jobs that you can run manually here.</p>
          <div class="row">
            <ul class="nav flex-column col-md-4">
              <li class="nav-item text-center"><a class="nav-link" href="../cron/cron_count.php"><i class="far fa-clock"></i> Count Stats</a></li>
            </ul>
            <ul class="nav flex-column col-md-4">
              <li class="nav-item text-center"><a class="nav-link" href="../cron/cron_createTables.php"><i class="fas fa-table"></i> Create Tables</a></li>
            </ul>
            <ul class="nav flex-column col-md-4">
              <li class="nav-item text-center"><a class="nav-link" href="../cron/cron_genBoxes.php"><i class="fas fa-box"></i> Generate Boxes</a></li>
            </ul>
            <ul class="nav flex-column col-md-4">
              <li class="nav-item text-center"><a class="nav-link" href="../cron/cron_boxMonth.php"><i class="fas fa-chart-line"></i> Process Time Series</a></li>
            </ul>
            <ul class="nav flex-column col-md-4">
              <li class="nav-item text-center"><a class="nav-link" href="../cron/cron_prioritiseBoxes.php"><i class="fas fa-sort-amount-down"></i> Prioritise Boxes</a></li>
            </ul>
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
