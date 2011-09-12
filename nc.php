<?php

  include('conn.php');
	$result_stations = mysql_query("SELECT * FROM stations2 where state='NC' order by name") or die (mysql_error());
	while ($st_name = mysql_fetch_array($result_stations)) {
	  $stations[] = $st_name['name'].", NC";
	  $lat[] = $st_name['lat'];
	  $long[] = $st_name['long'];
	  $nst[] = $st_name['nst_abbr'];
	}
	$stations = implode(":#:",$stations);

	$lat = implode(":#:",$lat);

	$long = implode(":#:",$long);

	$nst = implode(":#:",$nst);

	$risks=array();

	//fetching the risks for the stations from the db
	$current_risk = mysql_query("SELECT * FROM stations2,stations2_current_risk where state='NC' and stations2.nst_abbr=stations2_current_risk.nst_abbr order by name") or die (mysql_error());
	while ($cr = mysql_fetch_array($current_risk)) {
		if(($cr['rh']<40) || ($cr['temp']>99)){
		array_push($risks,"Lethal to Pathogen");
		}

		else if ($cr['rh'] > 95 && ( $cr['temp'] > 61 && $cr['temp'] < 90)){
		array_push($risks,"Favorable for disease");
		}
		
		else{ 
		array_push($risks,"Unfavorable for disease");
		}
		
	}

	$risks = implode(":#:",$risks)
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

 var nsts = "<?php print $nst; ?>";
 var nst = new Array();
 var z;  
 nst = nsts.split(":#:");

 var risk = "<?php print $risks; ?>";
 var risks = new Array();
 var r;  
 risks = risk.split(":#:");

 var stationDescription = new Array();
 var x;
  for( x=0; x<stationsName.length; x++){ 
stationDescription.push("<div class='infowindow'><div class='stname'>"+stationsName[x]+"</div><b>"+risks[x]+"</b><br><a href='risks2.php?nst="+nst[x]+"'>Click here for more Info</div>");
 }


 var markers = [];
 var image = new google.maps.MarkerImage('images/iphone_weather.png',
 new google.maps.Size(16, 16),
 new google.maps.Point(0,0),
 new google.maps.Point(8, 16));;

 function initialize() {

 var mapOptions = {
 zoom: 7,
 mapTypeId: google.maps.MapTypeId.TERRAIN,
 center: new google.maps.LatLng(35.5, -79),
 };

 var map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);


 for (var j = 0; j < stationsName.length; j++) {
 var marker = new google.maps.Marker({
 position:  new google.maps.LatLng (lat[j],long[j]),
 map: map,
 icon: image,

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
<a href="explanation_ncsc.html">Click here</a> to see how this tool works.
</body>
</html>
