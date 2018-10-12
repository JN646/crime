<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chart Test</title>
    <script src="js/Chart.min.js" charset="utf-8"></script>
  </head>
  <body>
    <h1>Chart Test</h1>
    <canvas id="myChart" width="400px" height="400px"></canvas>
    <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        }
    });
    </script>
  </body>
</html>
