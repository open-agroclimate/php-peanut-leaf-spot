<?php
	$id = $_GET['id'];

	//change username and password before running
  include('conn.php');	
	//fetching 10 day risks and adding them in an array
	$result = mysql_query("SELECT day1_risk,day2_risk,day3_risk,day4_risk,day5_risk,day6_risk,day7_risk,day8_risk,day9_risk,day10_risk FROM stations1_risks WHERE id='".$id."' ;")
	or die(mysql_error());


$row = mysql_fetch_array($result);

$risk_results = array(
					'day1_risk' => $row[day1_risk],
					'day2_risk' => $row[day2_risk],
					'day3_risk' => $row[day3_risk],
					'day4_risk' => $row[day4_risk],
					'day5_risk' => $row[day5_risk],
					'day6_risk' => $row[day6_risk],
					'day7_risk' => $row[day7_risk],
					'day8_risk' => $row[day8_risk],
					'day9_risk' => $row[day9_risk],
					'day10_risk' => $row[day10_risk]
					);
					
$levels = calculate_risk($risk_results);
					
					
$risk_levels = array(
					'day1' => date( "m/d/y", strtotime ("-9 day" )),
					'day1_risk' => $row[day1_risk],
					'day1_level' => $levels[0],
					'day2' => date( "m/d/y", strtotime ("-8 day" )),
					'day2_risk' => $row[day2_risk],
					'day2_level' => $levels[1],
					'day3' => date( "m/d/y", strtotime ("-7 day" )),
					'day3_risk' => $row[day3_risk],
					'day3_level' => $levels[2],
					'day4' => date( "m/d/y", strtotime ("-6 day" )),
					'day4_risk' => $row[day4_risk],
					'day4_level' => $levels[3],
					'day5' => date( "m/d/y", strtotime ("-5 day" )),
					'day5_risk' => $row[day5_risk],
					'day5_level' => $levels[4],
					'day6' => date( "m/d/y", strtotime ("-4 day" )),
					'day6_risk' => $row[day6_risk],
					'day6_level' => $levels[5],
					'day7' => date( "m/d/y", strtotime ("-3 day" )),
					'day7_risk' => $row[day7_risk],
					'day7_level' => $levels[6],
					'day8' => date( "m/d/y", strtotime ("-2 day" )),
					'day8_risk' => $row[day8_risk],
					'day8_level' => $levels[7],
					'day9' => date( "m/d/y", strtotime ("-1 day" )),
					'day9_risk' => $row[day9_risk],
					'day9_level' => $levels[8],
					'day10' => date( "m/d/y"),
					'day10_risk' => $row[day10_risk],
					'day10_level' => $levels[9],
					);
					
//encoding the array in json
print json_encode($risk_levels); 


mysql_close($con);


function calculate_risk($risk){
$level = array();
	foreach ($risk as $i) {
		if($i==0){
			array_push($level, "no");
		}
		if($i==25){
			array_push($level, "low");
		}
		if($i==50){
			array_push($level, "med");
		}
		if($i==75){
			array_push($level, "high");
		}
	}

	return $level;

	
}

?>
