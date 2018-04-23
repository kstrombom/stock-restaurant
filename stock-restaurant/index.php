<!DOCTYPE html>
<html>
<body>

 <div><span id="timer"></span></div>

<script>
document.getElementById('timer').innerHTML =
  036 + ":" + 00;
startTimer();

function startTimer() {
  var presentTime = document.getElementById('timer').innerHTML;
  var timeArray = presentTime.split(/[:]+/);
  var m = timeArray[0];
  var s = checkSecond((timeArray[1] - 1));
  if(s==59){m=m-1}
  //if(m<0){alert('timer completed')}
  
  document.getElementById('timer').innerHTML =
    m + ":" + s;
  setTimeout(startTimer, 1000);
}

function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {sec = "0" + sec}; // add zero in front of numbers < 10
  if (sec < 0) {sec = "59"};
  return sec;
}
</script>

 <h1>Barket Market</h1>
 <script>

//     $(function() {


//    var name = [];

//    $.getJSON('name.json', function(data) {
//        $.each(data.name, function(i, f) {
//           var tblRow = "<tr>" + "<td>" + f.firstName + "</td>" +
//            "<td>" + f.lastName + "</td>" + "<td>" + f.job + "</td>" + "<td>" + f.roll + "</td>" + "</tr>"
//            $(tblRow).appendTo("#userdata tbody");
//      });

//    });

// });
// </script>
    <div class="content-inner">

<?php
$servername = "127.0.0.1";
$username = "jessica";
$password = "19970409";
$dbname = "testdb";

// Create connection
//$db = "host=" + $servername + " db=" + $dbname + " user=" + $username + " password=" + $password;
$myPDO = new PDO('pgsql:host=127.0.0.1;dbname=testdb','jessica',19970409);

//$conn = pg_connect (db);
// Check connection
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT product, price, chang FROM todos";
$result = $myPDO->query($sql);

if ($result != false) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["product"]. " - price: ". $row["price"]. " " . $row["chang"] . "<br>";
    }
} 
else {
    echo "0 results";
}

//$conn->close();
?> 

</body>
</html>