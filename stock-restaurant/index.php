<!DOCTYPE html>
<html>
<body>
      <link href="style.css" rel="stylesheet" />

 <style>
 #time {
  text-align: center;
  font-size: 60px;
  margin-top:0px;
}
div.timerclass{
  text-align: center;
}
</style>
 <div class = "timerclass"><span id="time"></span></div>

<script>


function startTimer(duration, display) {
    var timer = duration, minutes, seconds;

    setInterval(function () {
      if(timer == 0)
      {
        window.location.reload(true);
      }
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;


        if (--timer < 0) {
            timer = duration;
        }

    }, 1000);
}

window.onload = function () {
    var displayMinutes = 60 * 30,
        display = document.querySelector('#time');
    startTimer(displayMinutes, display);
};




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

            if($row['delta'] < 0) {
    $tdStyle='color:red;';
} else if($row['delta'] >0){
    $tdStyle='color:green;';
}
else
{
   $tdStyle='color:black;';
}

          echo "<tr>";
          echo ("<td>".$row['name']."</td>");
          echo  ("<td>".$row['price']."</td>");
          //echo  ("<td>".$row['delta']."</td>");
          echo "</td><td style=\"".$tdStyle."\">";        
    echo $row['delta']; 
          echo "</td></tr>";
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
