<?php

$nst = $_GET['nst'];


	$today = date("Y-m-d", mktime(0, 0, 0, date("m"),date("d"),date("Y")));

	//change username and password
  include('conn.php');

	$result = mysql_query("SELECT * FROM stations2 where nst_abbr='$nst' ") or die (mysql_error());

	$row = mysql_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Peanut Leaf-Spot Risk Tool</title>
 <link rel="stylesheet" type="text/css" href="style.css">
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
	var nst = "<?php echo $nst ?>";
	var modurl1 = 'getrisk2.php?nst='+nst;
	var modurl2 = 'stations2_yourrisk.php?nst='+nst;
	var risks = new Array();
	var times = new Array();
	var show_risks = new Array();
 $(document).ready( function() {
			$.ajax({
          		url:modurl1,
          		dataType: 'json',
         	   	success: function(data) {
				for(var i=0;i<data.length;i=i+2){
					times.push(data[i]);
				}
				for(var i=1;i<=data.length;i=i+2){
					risks.push(data[i]);
				}
					console.log(risks);					
					console.log(times); 
			
					show_risks.push('high','high','high','low','low','high','no','high','low','no','high');
				var plot1 = $.jqplot('chart1', [risks], {
    				 axesDefaults: {
        				tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
        				tickOptions: {
         				 angle: -30,
         				 fontSize: '10pt'
        				}
   					 },

   					 seriesDefaults: {
	 					pointLabels:{ show:true, location:'n', ypadding:3, fill:true, fillColor: "red", },
					 },
					 axes: {
						yaxis: {
						min:-10, max:100, numberTicks:1
      					},
      					xaxis: {
        					renderer: $.jqplot.CategoryAxisRenderer,
						ticks: times
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
				if(isNaN(spray) || spray==""){
				 alert("Please enter a valid number");
				 return false;
				}

				 $.post(modurl2, { sp: spray }, 
				    function(data) {
					$("#show").html(data);
				 });
				
				return false;
			});

});

</script>

</head>

<body>
<h1>Peanut Leaf-Spot Risk Tool</h1>
<div id="title">Risk Results for <?php echo $row['name']; ?>, <?php echo $row['state']; ?> on <?php echo $today; ?></div>

 <div id="chart1" style="margin-left:20px; width:650px; height:220px;"></div>
<br>
<div id="your_risk">Calculate your risk</div>
<br>

<div id="form" style="display: none" >
<form id="form1" method='post'><br>
How many days since your last spray? <input id="spray" size="10" type="text">
<input id="submit1" type='submit' name='submit' value='calculate'>
</form>
</div>
<br>
 <div id="show"></div>

<br>

</body>
</html>
