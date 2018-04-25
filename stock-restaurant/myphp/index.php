<!DOCTYPE html>
<html>
<body>
      <link href="style.css" rel="stylesheet" />

 <style>
 #timer {
  text-align: center;
  font-size: 60px;
  margin-top:0px;
}
div.timerclass{
  text-align: center;
}
</style>
 <div class = "timerclass"><span id="timer"></span></div>

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

 <h1>The Hawk</h1>
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

//require_once 'dbconfig.php';

$servername = "127.0.0.1";
$username = "postgres";
$password = "password";
$dbname = "postgres";



try {
// Create connection
//$db = "host=" + $servername + " db=" + $dbname + " user=" + $username + " password=" + $password;
    $myPDO = new PDO('pgsql:host=127.0.0.1;port=5433;dbname=postgres;user=postgres;password=password');
    if($myPDO)
    {

        $sql = "SELECT * FROM inventory;";
        $result = $myPDO->query($sql);
        if(!$result)
        {
          die(var_export($myPDO->errorinfo(),TRUE));
        }

         echo "<table class='data'><thead><tr><th>name</th><th>price</th><th>change</th></tr></thead><tbody>";
        foreach ($result as $row)
        {
          echo "<tr>";
          echo ("<td>".$row['name']."</td>");
          echo  ("<td>$".$row['price']."</td>");
          echo  ("<td>".$row['delta']."</td>");
          echo "</tr>";
        }
        echo "</tbody>";
    }
}
catch(PDOException $e)
{
  echo $e->getMessage();
}
//$conn = pg_connect (db);
// Check connection
//if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
//} 




// if ($result != false) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "<br> id: ". $row["name"]. " - price: ". $row["curPrice"]. " " . $row["delta"] . "<br>";
//     }
// } 
// else {
//     echo "0 results";
// }

//$conn->close();
?> 

</body>
</html>