<?php
	$nst = $_GET['nst'];


	$arr = array();

	//change username and password before running
  include('conn.php');	
	$result = mysql_query("SELECT * FROM stations2_nst where nst_abbr='$nst' ") or die (mysql_error());

	while($row = mysql_fetch_array($result))
	{
	 	$time = strtotime(($row['datetime']));
		$final_time=date("H:i", $time);

		$temp = $row['temp'];
		$rh = $row['rh'];
		if ($temp > 99 && $rh < 40){
			$risk = 0;
		}
		else if ($rh > 95 && ( $temp > 61 && $temp < 90)){
			$risk = 75;
		} 
		else{
			$risk = 25;
		}

		array_push($arr,$final_time,$risk);
		
	}


//encoding the array in json	
$arr2 = json_encode($arr);

print_r($arr2);

?>
