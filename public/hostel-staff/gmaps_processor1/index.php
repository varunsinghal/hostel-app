<?php

ob_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>College Distance Calculator</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script>


var geocoder, location1, location2, gDir;

	function initialize() {
		geocoder = new GClientGeocoder();
		gDir = new GDirections();
		GEvent.addListener(gDir, "load", function() {
			var drivingDistanceMiles = gDir.getDistance().meters / 1609.344;
			var drivingDistanceKilometers = gDir.getDistance().meters / 1000;
			document.getElementById('results').innerHTML = drivingDistanceKilometers;
			window.location = 'fwddata.php?i=<?php echo $_GET['id']; ?>&d='+drivingDistanceKilometers;
		});
	}

	function showLocation() {
		geocoder.getLocations(document.forms[0].address1.value, function (response) {
			if (!response || response.Status.code != 200)
			{
				document.getElementById('results').innerHTML = "Sorry, we were unable to geocode the first address";
				window.location = 'fwddata.php?i=<?php echo $_GET['id']; ?>&d=1';
			}
			else
			{
				location1 = {lat: response.Placemark[0].Point.coordinates[1], lon: response.Placemark[0].Point.coordinates[0], address: response.Placemark[0].address};
				geocoder.getLocations(document.forms[0].address2.value, function (response) {
					if (!response || response.Status.code != 200)
					{
						document.getElementById('results').innerHTML = "Sorry, we were unable to geocode the first address";
						window.location = 'fwddata.php?i=<?php echo $_GET['id']; ?>&d=1';
					}
					else
					{
						location2 = {lat: response.Placemark[0].Point.coordinates[1], lon: response.Placemark[0].Point.coordinates[0], address: response.Placemark[0].address};
						gDir.load('from: ' + location1.address + ' to: ' + location2.address);
					}
				});
			}
		});
	}
</script>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyDsq3u44pvUGZVMym06AEI4awQUSr9wR6w"></script>
</head>

<body onload="initialize(); showLocation();">

<div class="container">
  <div class="content">
  <center>
  <font color="#FF3300" size="5px">DTU-HOME DISTANCE CALCULATOR</font><br /><br />
	<form action="#" name="aman" onsubmit="showLocation(); return false;">
		<p>
			Enter address : <input type="text" name="address1" value="<?php echo $_GET['addr']; ?>" />
			<input type="hidden" name="address2" value="Delhi Technological University, Bawana Auchandi Rd, Rohini, New Delhi, Delhi" />
			<input type="submit" value="Search" />
		</p>
	</form>

    <p id="results"></p>


    <div style='width: 100%; font-size:10px; background-color:#CCC;'><a href="../distance_calculator_index.php">Go Back</a> | Powered by DWD - DTU</div>
</center>
    <!-- end .content --></div>
  <!-- end .container --></div>

</body>
</html>
<?php

ob_end_flush();

?>