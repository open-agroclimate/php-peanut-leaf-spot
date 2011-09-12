<?php
	$nst = $_GET["nst"];
	$sp = $_POST["sp"];



  include('conn.php');
 	$today = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d"),date("Y")));
	$spray_date = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d")+10-$sp,date("Y")));


	

	if ($sp <= 10){
		$spr_dt = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d")+10-$sp,date("Y")));
		echo "Your set date<a target='_blank' href='explanation_ncsc.html#setdate'><img style='margin:0px 0px 5px -3px' src='images/questionmark.png'></a>: ".$spray_date."<br>";
		echo "<b><font color='green'>NO RISK. DO NOT SPRAY!</font></b><br> Your Plants are protected until the set date.<br><br>";
	}
	else {

	$select = mysql_query("SELECT * FROM stations2_nst_cond where nst_abbr='$nst' and date>='$spray_date' and date<='$today'") or die (mysql_error());
	while($row = mysql_fetch_array($select))
  	{
		if($row['leth_day']=="yes") {
			$spray_date=$row['date'];
			break;
		}
  	}	


	$july6 = date("Y-m-d", mktime(0, 0, 0, 7, 6, 2011)); 


	if($july6 > $spray_date){
	 $set_date = $july6;
	}
	else{ 
	 $set_date = $spray_date;
	}

	echo "Your set date<a target='_blank' href='explanation_ncsc.html#setdate'><img style='margin:0px 0px 5px -3px' src='images/questionmark.png'></a>: ".$set_date."<br>";

	$total_fav_hrs = 0;	

	$fh = mysql_query("SELECT * FROM stations2_nst_cond where nst_abbr='$nst' and date>='$set_date' and date<='$today'") or die (mysql_error());
	while($row = mysql_fetch_array($fh))
  	{
  	$total_fav_hrs += $row['fav_hrs'];
  	}	

	if ($total_fav_hrs >=48){
		echo "<b><font color='red'>HIGH RISK. SPRAY TODAY!</font></b><br>";
	}
	else{
		echo "<b><font color='green'>LOW RISK. DO NOT SPRAY!</font></b><br>";
	}


	echo "There have been <u>".$total_fav_hrs."</u> hours favorable for disease since the set date.<br><br>"; 

	}
?>


<div id="table">
<?php

 	$end_date = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d"),date("Y")));
	$start_date = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d")-14,date("Y")));

	echo "The following table shows the number of favorable hours for disease <br>development and the occurence of days lethal to pathogen the past two weeks<br><br>";
	
	echo "<table id='conds'><th>date</th><th>favorable hours</th><th>lethal day</th>";
	
	$select = mysql_query("SELECT * FROM stations2_nst_cond where nst_abbr='$nst' and date>='$start_date' and date<='$end_date'") or die (mysql_error());
	while($row = mysql_fetch_array($select))
  	{
  	echo "<tr><td>".$row['date']."</td><td>".$row['fav_hrs']."</td><td>".$row['leth_day']."</td></tr>";
  	}

?>
</div>
