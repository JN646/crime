<!-- Header Form -->
<?php include '../partials/_header.php' ?>

  <!-- Container -->
  <div id='bodyContainer' class="container">
    <div class="row">
      <div class="col-md-3">
        <div class='col-md-12'>
          <h4>Nav Bar</h4>

          <!-- Side Bar -->
          <?php include '../partials/_admin_sidebar.php' ?>
        </div>
      </div>

      <!-- Main Block -->
      <div class="col-md-9">
        <h2>Server Information</h2>
        <p>This page contains sensative server information and config. Do not distribute.</p>
        <?php
        $dd=array(
            'Server Address'=>$_SERVER['SERVER_ADDR'],
            'Server Name'=>$_SERVER['SERVER_NAME'],
            'Server Software'=>$_SERVER['SERVER_SOFTWARE'],
            'Document Root'=>$_SERVER['DOCUMENT_ROOT'],
            'HTTP Host'=>$_SERVER['HTTP_HOST'],
            'Remote Address'=>$_SERVER['REMOTE_ADDR'],
            'Remote Port'=>$_SERVER['REMOTE_PORT'],
            'Script File Name'=>$_SERVER['SCRIPT_FILENAME'],
            'Server Admin'=>$_SERVER['SERVER_ADMIN'],
            'Serever Port'=>$_SERVER['SERVER_PORT'],
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
  </div>

  <!-- Footer -->
  <?php include '../partials/_footer.php' ?>
</body>
</html>
