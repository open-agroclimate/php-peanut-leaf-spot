<?php

$id = $_GET['id'];

//change username and password
  include('conn.php');
	$select = mysql_query("SELECT * FROM stations1 where id=".$id."") or die (mysql_error());

	$row = mysql_fetch_array($select);

	$nrpt = $row[nrpt];
	$nrst = $row[nrst];

	$result_rain = mysql_query("SELECT * FROM stations1,stations1_nrst WHERE id='$id' AND stations1.nrst = stations1_nrst.nrst")
	or die(mysql_error()); 
	
	$row_rain = mysql_fetch_array( $result_rain );

	$day1 = $row_rain['day1'];
	$day2 = $row_rain['day2'];
	$day3 = $row_rain['day3'];
	$day4 = $row_rain['day4'];
	$day5 = $row_rain['day5'];
	$day6 = $row_rain['day6'];
	$day7 = $row_rain['day7'];
	$day8 = $row_rain['day8'];
	$day9 = $row_rain['day9'];
	$day10 = $row_rain['day10'];

	$rain_events=array();
	
	if($day1 >= 0.1)
	array_push($rain_events,$day1);

	if($day2 >= 0.1)
	array_push($rain_events,$day2);

	if($day3 >= 0.1)
	array_push($rain_events,$day3);

	if($day4 >= 0.1)
	array_push($rain_events,$day4);

	if($day5 >= 0.1)
	array_push($rain_events,$day5);

	if($day6 >= 0.1)
	array_push($rain_events,$day6);

	if($day7 >= 0.1)
	array_push($rain_events,$day7);

	if($day8 >= 0.1)
	array_push($rain_events,$day8);

	if($day9 >= 0.1)
	array_push($rain_events,$day9);

	if($day10 >= 0.1)
	array_push($rain_events,$day10);
	
	$total_rain_events = count($rain_events);


?>

<!DOCTYPE html>
<html>
<head>
<title>Peanut Leaf-Spot Risk Tool</title>
 <link rel="stylesheet" type="text/css" href="style.css">
  <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
  
  <link rel="stylesheet" type="text/css" href="scripts/jquery.jqplot/dist/jquery.jqplot.css" />
  <link rel="stylesheet" type="text/css" href="scripts/jquery.jqplot/dist/examples/examples.css" />


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
 <script language="javascript" type="text/javascript" src="scripts/jquery.jqplot/dist/jquery.jqplot.js"></script>
  <script type="text/javascript" src="scripts/jquery.jqplot/dist/plugins/jqplot.dateAxisRenderer.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.jqplot/dist/plugins/jqplot.canvasTextRenderer.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.jqplot/dist/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.jqplot/dist/plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script type="text/javascript" src="scripts/jquery.jqplot/dist/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript">
	var id = <?php echo $id ?>;
	var modurl1 = 'getrisk.php?id='+id;
	var modurl2 = 'stations1_yourrisk.php?id='+id;
    $(document).ready( function() {
     			$.ajax({
          		url:modurl1,
          		dataType: 'json',
         	    success: function(data) {
            		var line1=[[data.day1, data.day1_risk,data.day1_level],
            					[data.day2, data.day2_risk,data.day2_level],
            					[data.day3, data.day3_risk,data.day3_level],
            					[data.day4, data.day4_risk,data.day4_level],
            					[data.day5, data.day5_risk,data.day5_level],
            					[data.day6, data.day6_risk,data.day6_level],
            					[data.day7, data.day7_risk,data.day7_level],
            					[data.day8, data.day8_risk,data.day8_level],
            					[data.day9, data.day9_risk,data.day9_level],
            					[data.day10, data.day10_risk,data.day10_level]];
          			 
          			 var plot1 = $.jqplot('chart1', [line1], {
    				 axesDefaults: {
        				tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        				tickOptions: {
         				 angle: -30,
         				 fontSize: '10pt'
        				}
   					 },
   					 seriesDefaults: {
	 					pointLabels:{ show:true, location:'n', ypadding:3 },
					 },
					 axes: {
						yaxis: {
        					min:-10, max:100, numberTicks:1
      					},
      					xaxis: {
        					renderer: $.jqplot.CategoryAxisRenderer
      					}
   					 }
				  });
          		}
       		 });

			$("#your_risk").click(function() {
				$('#form').show();
			});

			$("#form1").submit(function() {
				var spray = $("#spray").val();
				var rain = $("#rain").val();
				var irrigate = $("#irrigate").val();

				if(rain=="" || spray=="" || irrigate==""){
				 alert("Please enter all the fields");
				 return false;
				}

			 if (rain ==4){
				 var answer = confirm("Are you sure you want to use rainfall at weather station?");
			  	 if(answer){
				  $.post(modurl2 ,{sp: spray , ra: <?php echo $total_rain_events; ?>, ir:irrigate},
					function(data){
						$("#show").html(data);	
				  });
				 }
				}
				else{
				 $.post(modurl2, { sp: spray, ra: rain, ir:irrigate }, 
				    function(data) {
					$("#show").html(data);
				 });
				}

				return false;
			});


    });

</script>
</head>
<body>

<h1>Peanut Leaf-Spot Risk Tool</h1>
<div id="title">Risk Results for <?php echo $row['name']; ?>,<?php echo $row['state']; ?> </div>

 <div id="chart1" style="margin-left:20px; width:550px; height:220px;"></div>
 <div id="text">
    The above chart shows a 10-day risk on your field. This risk is calculated based on past rainfall at <b><span style="text-transform: uppercase"><?php echo $row['nrst'] ?></b></span> and the rain forecasts done by the Naional Weather Service for <b><?php echo $row['nrft'] ?></b>.
It is important that you add information on irrigation and if possible, past rainfall at your farm to determine your own risk.
Click on "Calculate your risk" below to do this.
<br><br>


<div id="your_risk">Calculate your risk</div>

<div id="form" style="display: none">
<form id="form1" method='post'><br>
		
		<table id = 'cal_risk'>
		
<tr><td align='right'><b>How many days since you last sprayed your peanut field?</b></td>
<td align = 'left'><select id='spray' name = 'spray'>
<option value='' selected='yes'>select...</option>
<option value='0'>10 or less</option>
<option value='1'>11</option>
<option value='1'>12</option>
<option value='1'>13</option>
<option value='1'>14</option>
<option value='2'>15</option>
<option value='2'>16</option>
<option value='2'>17</option>
<option value='2'>18</option>
<option value='2'>19</option>
<option value='2'>20 or more</option>
</select></td>		
		
<tr><td align='right'><b>How many times has it rained on your peanut field in the last 10 days?</b></td>
<td align = 'left'><select id='rain' name = 'rain'>
<option value='' selected='yes'>select...</option>
<option value='0'>0</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3 or more</option>
<option value='4'>use rainfall at weather station</option>
</select></td>

<br>
<tr><td align='right'><b>How many times have you irrigated your peanut field in the last 10 days?</b></td>
<td align='left'><select id='irrigate' name = 'irrigate'>
<option value='' selected='yes'>select...</option>
<option value='0'>0</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3 or more</option>
</select></td>
</table>
<br>
	<input id="submit1" type='submit' name='submit' value='calculate'>
		</form>
</div><br>

  <div id="show"></div>
  

</div>
</body>
</html>
