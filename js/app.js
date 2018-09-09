$(document).ready(function(){
	$.ajax({
		url: "../lib/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var Crime_Type = [];
			var Longitude = [];

			for(var i in data) {
				Crime_Type.push("Crime_Type " + data[i].playerid);
				Longitude.push(data[i].Longitude);
			}

			var chartdata = {
				labels: Crime_Type,
				datasets : [
					{
						label: 'Crime Type Counts',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: Longitude
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});
