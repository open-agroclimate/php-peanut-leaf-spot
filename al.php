<?php

  include('conn.php');
	$result_stations = mysql_query("SELECT * FROM stations1 where state='AL' order by name") or die (mysql_error());
	while ($st_name = mysql_fetch_array($result_stations)) {
	  $stations[] = $st_name['name'].", AL";
	  $lat[] = $st_name['lat'];
	  $long[] = $st_name['long'];
	}
	$stations = implode(":#:",$stations);

	$lat = implode(":#:",$lat);

	$long = implode(":#:",$long);

	//fetching the risks for the stations from the db
	$result_risk = mysql_query("SELECT * FROM stations1_risks where state='AL' order by name") or die (mysql_error());
	while ($risks = mysql_fetch_array($result_risk)) {

		$id[] = $risks['id'];

		if($risks['day10_risk'] == 25)
			$risk_level[] = "Low Risk";

		if($risks['day10_risk'] == 50)
			$risk_level[] = "Medium Risk";

		if($risks['day10_risk'] == 75)
			$risk_level[] = "High Risk";

		if($risks['day10_risk'] == 0)
			$risk_level[] = "No Risk";


	}
	$risk_level = implode(":#:",$risk_level);
	$id = implode(":#:",$id);

?>

<!DOCTYPE html>
<html>
<head>
<title>Peanut Leaf-Spot Risk Tool</title>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/standard.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{
margin:20px;
}

.infowindow{
font-family: Arial,sans-serif;
font-size:12px;
text-align: center;
width:220px;
height:65px;
border: 1px solid;
}

.stname{
font-weight: bold; 
font-style: italic; 
color:white;
background-color:#3F48CC;
text-align: center;
width:218px;
height:23px;
border: 1px solid;
}
</style>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
 var stations = "<?php print $stations; ?>";
 var stationsName = new Array();
 console.log(stations);
 var y;  
 stationsName = stations.split(":#:");

 var lats = "<?php print $lat; ?>";
 var lat = new Array();
 var p;  
 lat = lats.split(":#:");


 var longs = "<?php print $long; ?>";
 var long = new Array();
 var q;  
 long = longs.split(":#:");

 var ids = "<?php print $id; ?>";
 var id = new Array();
 var i;  
 id = ids.split(":#:");


 var risk_level = "<?php print $risk_level; ?>";
 var risks = new Array();
 var k;  
 risks = risk_level.split(":#:");


 var stationDescription = new Array();
 var x;
  for( x=0; x<stationsName.length; x++){ 
stationDescription.push("<div class='infowindow'><div class='stname'>"+stationsName[x]+"</div><b>"+risks[x]+"</b><br><a href='risks1.php?id="+id[x]+"'>Click here for more Info</div>");
 }


 var markers = [];
 
 function initialize() {
 var mapOptions = {
 zoom: 7,
 mapTypeId: google.maps.MapTypeId.TERRAIN,
 center: new google.maps.LatLng(32.5, -86),
 };

 var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);


 for (var j = 0; j < stationsName.length; j++) {
 var marker = new google.maps.Marker({
 position:  new google.maps.LatLng (lat[j],long[j]),
 map: map
 });


 attachMessage(marker, j);
 }

  var infowindow = new google.maps.InfoWindow();

 function attachMessage(marker, number) {

  google.maps.event.addListener(marker, 'click', function() {
  infowindow.setContent(stationDescription [number]);
  infowindow.open(map,marker);
  });
 }


 }
</script>
</head>
<body onload="initialize()" onunload="GUnload()">
<h1>Peanut Leaf-Spot Risk Tool</h1>
<h4>Click on a location to see current condtions for disease development</h4>
<div id="map_canvas" style="width:600px; height: 600px"></div>
<a href="explanation_gaflal.html">Click here</a> to see how this tool works.
<div "raw"><?php echo $stations.'<br>'.$lat.'<br>'.$long ?>
</body>
</html>
