    <!-- Footer Block -->
    <div id='footerContainer' class='container'>
      <div class='row'>
        <div class="col-md-4">
          <div id='socialBlock' class="col-md-12">
            <ul>
              <li id='socialFacebook'><a href='#'><i class="fab fa-facebook fa-2x"></i></a></li>
              <li id='socialTwitter'><a href='#'><i class="fab fa-twitter fa-2x"></i></a></li>
              <li id='socialGithub'><a href='https://github.com/JN646/crime/tree/development'><i class="fab fa-github fa-2x"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <p class='footerText text-center'>Copyright &copy; 2018 Copyright Zuviar Ltd All Rights Reserved. <br> <?php echo 'Version: ' . ApplicationVersion::get(); ?></p>
        </div>
        <div class="col-md-4">
          <p class="footerText text-right"><a href='' data-toggle="modal" data-target=".update-log-modal"><i class="fas fa-download"></i> Update Log</a></p>
        </div>
      </div>
    </div>
    <!-- Global JS File -->
    <script src="<?php echo $environment; ?>js/global.js" charset="utf-8"></script>
    <script src="<?php echo $environment; ?>js/Chart.min.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Server Information -->
    <div class="modal fade update-log-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Log</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>This is the update log.</p>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
