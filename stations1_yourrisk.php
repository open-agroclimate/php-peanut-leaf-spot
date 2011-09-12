<?php
	$id = $_GET["id"];

	$spray = $_POST["sp"];
	
	$rain = $_POST["ra"];

	$irrigate = $_POST["ir"];

	$total = ($rain + $irrigate);
	
	if($spray <= $total){
		$rain_events = $spray;
	}
	else {
		$rain_events = $total;
		}
		
	
  include('conn.php');	
	$result_ppt = mysql_query("SELECT 24hr,48hr,72hr,96hr,120hr FROM stations1,stations1_nrft WHERE id='$id' AND stations1.nrft = stations1_nrft.nrft ;")
	or die(mysql_error());

	$row_ppt = mysql_fetch_array( $result_ppt );

	$hr24 = $row_ppt['24hr'];
	$hr48 = $row_ppt['48hr'];
	$hr72 = $row_ppt['72hr'];
	$hr96 = $row_ppt['96hr'];
	$hr120 = $row_ppt['120hr'];
	
	$avg_ppt = ($hr24 + $hr48 + $hr72 + $hr96 +$hr120)/5;
	
	if($avg_ppt >= 50){
	echo "Your Risk: <b><font color='red'>High Risk</font></b>";
	$risk_cal = 75;
	}

	else if($rain_events >=1 && $avg_ppt >= 40){
	echo "Your Risk: <b><font color='red'>High Risk</font></b>";
	$risk_cal = 75;
	}

	else if($rain_events >=2 && $avg_ppt >= 20){
	echo "Your Risk: <b><font color='red'>High Risk</font></b>";
	$risk_cal = 75;
	}
	
	else if($rain_events >=3 && $avg_ppt < 20){
	echo "Your Risk: <b><font color='red'>High Risk</font></b>";
	$risk_cal = 75;
	}

	else if($rain_events ==0 && $avg_ppt >= 40 && $avg_ppt <=49){
	echo "Your Risk: <b><font color='orange'>Medium Risk</font></b>";
	$risk_cal = 50;
	}

	else if($rain_events <2 && $avg_ppt >= 20 && $avg_ppt <=39){
	echo "Your Risk: <b><font color='orange'>Medium Risk</font></b>";
	$risk_cal = 50;
	}

	else if($rain_events <3 && $avg_ppt < 20){
	echo "Your Risk: <b><font color='green'>Low Risk</font></b>";
	$risk_cal = 25;
	}
	else{
	echo "Your Risk: <b><font color='green'>Low Risk</font></b>";
	}
	echo "<br>";

	if($spray == 0 ){
	echo "Spray Recommendation: <b><font color='green'>Do not Spray!</font></b>";
	}

	if($spray ==1 && $risk_cal ==75){
	echo "Spray Recommendation: <b><font color='red'>Spray!</font></b>";
	}

	if(($spray ==1 && $risk_cal == 50) || ($spray ==1 && $risk_cal == 25)){
	echo "Spray Recommendation: <b><font color='green'>Do not Spray!</font></b>";
	}

	if($spray ==2 && $risk_cal == 25){
	echo "Spray Recommendation: <b><font color='green'>Do not Spray!</font></b>";
	}

	if(($spray ==2 && $risk_cal == 75) || ($spray ==2 && $risk_cal == 50)){
	echo "Spray Recommendation: <b><font color='red'>Spray!</font></b>";
	}


?>
