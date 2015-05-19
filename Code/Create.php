<!DOCTYPE html>
<html>

<head>
<title>Create Mode</title>
<script src="interact.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<body onload="startTime()">
<body onload="document.refresh();"> 
<style>
html { 
  background-image: url(background.jpg);
	
-moz-background-size: cover;
-webkit-background-size: cover;
background-size: cover;
background-position: top center !important;
background-repeat: no-repeat !important;
background-attachment: fixed;
}

h1 {
	background-color: #ffffff;
	float: right;
}

img {
	float: left;
	margin: 5px;
}

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	background-color: #ffffff;
}
th, td {
    padding: 15px;
}

</style>
</head>

<body>
<img id="banner" src="logo.jpg" alt="Banner Image"/>
<h1>Manage The Dining Room</h1>
<table style="width:100%">
  <tr>
    <td>Hover over table to view the info</td>
	<td><div id="txt"></div></td>
  </tr>
  <tr>
    <td>Table Number</td>
	<td><div id="txt5"></div></td>
  </tr>
  <tr>
    <td>Occupency</td>
    <td><div id="txt2"></div></td>		
  </tr>
  <tr>
    <td>Server</td>
    <td><div id="txt4"></div></td>		
  </tr>
<tr>
    <td>Number of seats</td>
    <td><div id="txt3"></div></td>		
  </tr>
</table>

<button type="button" onclick="createTable()">Add Table</button>

<?php
require_once('mysql.php');
$query = "SELECT * FROM `data` ORDER BY `id` ASC ";

$response = @mysqli_query($dbc, $query);

if ($response) {
	$xValues = array();
	$yValues = array();
	$tableValues = array();
	$occupiedValues = array();
	$seatValues = array();
	$serverValues = array();
	
	while($row = mysqli_fetch_array($response)){
	

	array_push($tableValues, $row['table']);
	array_push($xValues, $row['x']);
	array_push($yValues, $row['y']);
	array_push($occupiedValues, $row['occupied']);
	array_push($seatValues, $row['seats']);
	array_push($serverValues, $row['server']);

	 
	}
	 
	 
	} else {
	 
//	echo "Couldn't issue database query<br />";
	 
//	echo mysqli_error($dbc);
	 
	}
	
	// Grab Employees
	$query = "SELECT * FROM `employee` ORDER BY `id` ASC ";
	$response = @mysqli_query($dbc, $query);
	
	if ($response) {
	$names = array();
	while($row = mysqli_fetch_array($response)){
	
	array_push($names, $row['Name']);
 
	}
	}
		 
	// Close connection to the database
	mysqli_close($dbc);
?>

<form action = "delete.php" method = "post">
  <p>Delete (Lowest input 1):</p>
  <input type="number" name="delete" min="1" id = "deleteRow" required>
  <input type="submit" value = "Delete">
</form>

<form action = "data.php" method = "post">
<input type="hidden"  name = "data" id = "tableList">
<input type="hidden"  name = "dataOccupied" id = "occupiedList">
<input type="hidden"  name = "dataX" id = "xList">
<input type="hidden"  name = "dataY" id = "yList">
<input type="hidden"  name = "dataSeat" id = "seatList">
<input type="hidden"  name = "dataServer" id = "serverList">
<input type="submit" value = "Save">
</form>

<select id="employees">
<option disabled>Assign Employee to Table, When Created or Changed</option>
<?php for ($i = 0; $i < sizeOf($names); $i++)
{
    echo "<option>" . $names[$i] . "</option>";
}

?>
</select>

<script>
// Creates canvas 
var numTables = 0;
var paper = Raphael(400, 500, 500, 500);
paper.canvas.style.backgroundColor = '#000';
var myTables = [];
var myText = [];
var myOccupied = [];
var xLoc = [];
var yLoc = [];
var tableList = [];
var seatList = [];
var employeeList = [];

function initalizeData() {
	var elemTable = "<?php echo implode(" ",$tableValues); ?>"	
	var elemX  = "<?php echo implode(" ",$xValues); ?>"
	var elemY = "<?php echo implode(" ",$yValues); ?>"
	var elemOccupied = "<?php echo implode(" ",$occupiedValues); ?>"
	var elemSeats = "<?php echo implode(" ",$seatValues); ?>"
	var elemServers = "<?php echo implode(" ",$serverValues); ?>"
	
	tableList = elemTable.split(" ");	
	xLoc  = elemX.split(" ");	
	yLoc = elemY.split(" ");
	seatList = elemSeats.split(" ");	
	employeeList = elemServers.split(" ");
	myOccupied = elemOccupied.split(" ");
	
	var re = /~/gi;
	for (i = 0; i < myOccupied.length; i++) {
		myOccupied[i] = myOccupied[i].replace(re, ' ')
	}
	
	if (tableList[0] == "") {
		tableList = [];
		xLoc  = [];
		yLoc = [];
		myOccupied = [];
		seatList = [];
		employeeList = [];
	}
	
	var elem = document.getElementById("tableList");
	elem.value = tableList;

	var element = document.getElementById("occupiedList");
	element.value = myOccupied;

	var element2 = document.getElementById("xList");
	element2.value = xLoc;

	var element3 = document.getElementById("yList");
	element3.value = yLoc;

	var element4 = document.getElementById("seatList");
	element4.value = seatList;

	var element5 = document.getElementById("serverList");
	element5.value = employeeList;

}

function setData() {
	for (i = 0; i < tableList.length; i++) {
	
		var table = paper.rect(parseInt(xLoc[i]), parseInt(yLoc[i]), 50, 50);
		var x = +xLoc[i] + 20;	
		var y = +yLoc[i] + 20;

		// Sets the fill attribute of the circle to red (#f00)
		table.attr("fill", "#0002ff");

		// Sets the stroke attribute of the circle to white
		table.attr("stroke", "#fff");
		
		numTables++;
		
		var theText = +tableList[i].toString();
		var recttext = paper.set();
		text = paper.text(x, y, theText).attr({fill:'#fff',"font-size": 30});
		recttext.push(table);
		recttext.push(text);

		//Create Drag Handler
		table.drag(move, dragger, up);
//		table.dblclick(onClick);
		table.dblclick(function() {
		var index;
		for (i = 0; i < myTables.length; i++) {
			if (this == myTables[i]) {
				index = i;
			}
		}
		fillTable("OK: Fill Table or Cancel: Clear Table", index, myTables[index]);
		changeServer("Change The Server?", index);
		});
		
		table.mouseover(showTime);

		//Add to the list
		myTables.push(table);
		myText.push(text);
		
		if (myOccupied[i].trim() != "empty") {
			table.attr("fill", "#f00"); 
		}
	}

}

function createTable() {
// Creates circle at x = 50, y = 40, with radius 10
var table = paper.rect(10, 10, 50, 50);
// Sets the fill attribute of the circle to red (#f00)
table.attr("fill", "#0002ff");

// Sets the stroke attribute of the circle to white
table.attr("stroke", "#fff");
var count = 0;

for (i = 0; i < tableList.length; i++) {
	if (tableList.indexOf((i+1).toString()) > -1) {

	}
	else {
		count = i+1;
		break;
	}
}

var theText = "";
numTables++;

if (count != 0) {
theText = count.toString();
}
else {
theText = numTables.toString();
}

var recttext = paper.set();
text = paper.text(30,30, theText).attr({fill:'#fff',"font-size": 30});
recttext.push(table);
recttext.push(text);

//Get number of seats
var seats = prompt("How many seats are at the table?", "Please enter an integer");
    
//Create Drag Handler
table.drag(move, dragger, up);
//table.dblclick(onClick);
table.dblclick(function() {
		var index;
		for (i = 0; i < myTables.length; i++) {
			if (this == myTables[i]) {
				index = i;
			}
		}
		fillTable("OK: Fill Table or Cancel: Clear Table", index, myTables[index]);
		changeServer("Change The Server?", index);
		});
table.mouseover(showTime);

//Add to the list
myTables.push(table);
myText.push(text);
myOccupied.push("empty");
xLoc.push(10);
yLoc.push(10);
seatList.push(parseInt(seats));
tableList.push(theText);

var e = document.getElementById("employees");
var strUser = e.options[e.selectedIndex].value;
employeeList.push(strUser);


var elem = document.getElementById("tableList");
elem.value = tableList;

var element = document.getElementById("occupiedList");
element.value = myOccupied;

var element2 = document.getElementById("xList");
element2.value = xLoc;

var element3 = document.getElementById("yList");
element3.value = yLoc;

var element4 = document.getElementById("seatList");
element4.value = seatList;

var element5 = document.getElementById("serverList");
element5.value = employeeList;


}

var dragger = function() {
    this.ox = this.type == "rect" ? this.attr("x") : this.attr("cx");
    this.oy = this.type == "rect" ? this.attr("y") : this.attr("cy");
    this.animate({
        "fill-opacity": 2
    }, 500);
},
    move = function(dx, dy) {
        var mx = this.ox + dx;
        var my = this.oy + dy;


        var att = this.type == "rect" ? {
            x: mx,
            y: my
        } : {
            cx: mx,
            cy: my
        };


        this.attr(att);
		
		var thistext;
		for (i = 0; i < myText.length; i++) {
			if (this == myTables[i]) {
				thistext = i;
				xLoc[i] = mx;
				yLoc[i] = my;
			}
		}
		
		var element2 = document.getElementById("xList");
		element2.value = xLoc;

		var element3 = document.getElementById("yList");
		element3.value = yLoc;
		
        var att2 = {
          x: mx + 20,
          y: my + 20
        }
       myText[thistext].attr(att2);


    },
    up = function() {
        this.animate({
            
        }, 500);

    };
	

function changeServer(message, index){
    $('<div></div>').appendTo('body')
                    .html('<div><h6>'+message+'?</h6></div>')
                    .dialog({
                        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                var e = document.getElementById("employees");
								employeeList[index] = e.options[e.selectedIndex].value;
								var element = document.getElementById("serverList");
								element.value = employeeList;

                                $(this).dialog("close");
                            },
                            No: function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });
    };
	
	function fillTable(message, index, table){
    $('<div></div>').appendTo('body')
                    .html('<div><h6>'+message+'?</h6></div>')
                    .dialog({
                        modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                table.attr("fill", "#f00");   	
								var today=new Date().toString();
								myOccupied[index] = today;
								var element = document.getElementById("occupiedList");
								element.value = myOccupied;
                                $(this).dialog("close");
                            },
                            No: function () {
								table.attr("fill", "#0002ff");   
								myOccupied[index] = "empty";
								var element = document.getElementById("occupiedList");
								element.value = myOccupied;
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });
    };


function showTime() {
	
	var index;
		for (i = 0; i < myTables.length; i++) {
			if (this == myTables[i]) {
				index = i;
				calculateTime(index);
				showSeats(index);
			}
		}
}

function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('txt').innerHTML = h+":"+m+":"+s;
    var t = setTimeout(function(){startTime()},500);
	setInterval(function(){ updateTime(); }, 15000);
}

function calculateTime(index) {

	var today=new Date();
	var pastString = myOccupied[index].trim();
	if (pastString != "empty") {
	var past = new Date(pastString);
	
	var diff = (today - past);
	var msec = diff;
	var hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	var mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	var ss = Math.floor(msec / 1000);
	msec -= ss * 1000;
	
	document.getElementById('txt2').innerHTML = hh+":"+mm+":"+ss;
	}
	else {
		document.getElementById('txt2').innerHTML = pastString.replace("empty)", "empty");
	}
}

function updateTime() {
	for (i = 0; i < myOccupied.length; i++) {
	
	var today=new Date();
	var pastString = myOccupied[i].trim();
	if (pastString.replace("empty)", "empty") != "empty") {
	var past = new Date(pastString);
	
	var diff = (today - past);
	var msec = diff;
	var hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	var mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	var ss = Math.floor(msec / 1000);
	msec -= ss * 1000;
	
	if (hh > 0 || mm > 45) {
		myTables[i].attr("fill", "#93ee00")
	}
	else if (mm > 30) {
		myTables[i].attr("fill", "#eedc00")
	}
	else if (mm > 15) {
		myTables[i].attr("fill", "#ee9300")
	}
			
	}
	}
}

function showSeats(index) {
	document.getElementById('txt5').innerHTML = "Table Number: " + tableList[i];
	document.getElementById('txt3').innerHTML = "This table seats: " + seatList[i];
	document.getElementById('txt4').innerHTML = "The server is: " + employeeList[i];
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

initalizeData();
setData();
updateTime();
</script>


</body>

</html>