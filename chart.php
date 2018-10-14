<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8"/>
    <title>Chart Test</title>
    <script src="js/Chart.min.js" charset="utf-8"></script>
  </head>
  <body>
    <h1>Chart Test</h1>
    <?php
    $data = array(9,4,1,7,4);
    ?>
    <canvas id="myChart" width="400px" height="400px"></canvas>
    <script>
    var myData = <?php echo json_encode($data); ?>;
    
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: myData,
                borderWidth: 1
            }]
        }
    });
    </script>
  </body>
</html>
