Peanut Model

This model consists of 2 different algorithms: one for GA, AL and Fl states and one for NC and SC states. I have added the pdf files of both the algorithm. Each one has its own set of files and database tables. (I have given the description below). I have also included the sql file for the complete database so that you wont have to recreate and reenter all the data. The data in the database in old (a couple of days old) and needs to be updated. The tool requires that the data in the database needs to be updated every hour for the Carolina stations and every day for the GA, AL and FL states. I am in the process of writing cron-jobs which will update the database every hour and every day, so that you don’t have to do it manually.

Regarding the graphs, I wasn’t able to use moo-tools and hence I used a jquery library for it. You will have to delete that part and use moo-tools instead. 

To calculate the risks, I used numbers as follows which makes the calculations easier:
0 – no risk
25 – low risk
50 – medium risk
75 – high risk

I have also documented as proper places in the php files. Do remember to change the username and password of the mysql connectivity.
You can have a look at this working tool here:
http://agroclimatology.engr.uga.edu/0.03/index.html

This Model consists of the following files:

index.html – The home page showing the five clickable states.
al.php – map showing stations for Alabama state
fl.php – map showing stations for Florida state
ga.php – map showing stations for Georgia state
nc.php – map showing stations for North Carolina state
sc.php – map showing stations for South Carolina state
risks1.php - the page showing the current risks graphs as well as the user’s risk for Al, FL and GA states.
risks2.php - same as risks1.php but for NC and SC states.
getrisk.php – pulls the 10 day risks from the database and sends it to risks1.php (to display it on the graph) in the form of json array.
getrisk2.php – pulls the risks data from the database (until the current hour) and sends it to risks2.php (to display it on the graph) in the form of json array.
stations1_yourrisk.php – runs the algorithm and calculates the risk for the user (for AL, FL and GA states).
stations2_yourrisk.php – same as stations1_yourrisk.php but for NC and SC states.
contact.html – contact information of me and Mark Boudreau
explanation_gaflal.html – explanation of the algorithm for the GA, FL and AL states.
explanation_ncsc.html – explanation of the algorithm for the NC and SC states.

/images – folder containing images.
/scripts – folder containing javascript files
Style.css - stylesheet



Database tables:

Stations1 – table containing stations for GA, AL and FL states along with their locations, nearest station for precipitation, nearest station for 5-day forecast and a randomly generated 3-digit id.

Stations1_nrft – table containing 5 day forecast data.

Stations1_nrst – table containing past 10 day rainfall data.

Stations1_risks – 10 day risks for all the GA, FL and AL stations

Stations2 – table containing stations for NC and SC states along with their locations, nearest station, nearest station type(AWOS, ECONET, etc) and a randomly generated 3-digit id.

Stations2_nst – contains hourly temperature and relative humidity for today.

Stations2_current_risk – contains  temperature and relative humidity for the present hour.
Stations2_nst_cond – contains favorable hours and lethal day for all the NC and SC stations from july 06 2011 until today.







