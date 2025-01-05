<?php
    session_start();

    $hostname = "localhost";
    $username = "root";
    $dbname = "paragoncinemadb";

    $connect = mysqli_connect($hostname, $username) OR DIE ("Connection failed!");
    $selectdb = mysqli_select_db($connect, $dbname) OR DIE ("Database cannot be accessed");

    $username = $_SESSION["username"];

    $sql = "SELECT * FROM manager WHERE username = '$username' ";  

    $sendsql = mysqli_query($connect, $sql) OR DIE("CONNECTION ERROR");

    $row = mysqli_fetch_assoc($sendsql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>MANAGER | PARAGON</title>
		<link rel="shortcut icon" href="img/paragon_logo.png" type="image/png">
    </head>

    <?php include "manager_sidenav.php"; ?>
    <body>
        <div class="container">
            <h1>Sales Details</h1>

            <?php
                $hostname = "localhost";
                $username = "root";
                $password = "";
                $dbname = "paragoncinemadb";

                $connect = mysqli_connect($hostname, $username, $password, $dbname) OR DIE ("Connection failed");

                $sql = "SELECT i.invoiceno, i.price, c.name, i.theaterName, i.hallNo, i.date, i.showtime, i.chosenSeat FROM invoice i
                        JOIN customer c ON i.custid = c.custid";
                $sendsql = mysqli_query($connect,$sql);

                if($sendsql){
                    echo "<table>
                    <tr>
                        <th>Invoice No</th>
                        <th>Price</th>
                        <th>Customer Name</th>
                        <th>Theater Name</th>
                        <th>Hall No</th>
                        <th>Date</th>
                        <th>Showtime</th>
                        <th>Seat No</th>
                    </tr>";

                    $totalPrice = 0;

                    foreach($sendsql as $row)
                    {
                        echo "<tr>";
                        echo "<td>". $row["invoiceno"] ."</td>";
                        echo "<td>". $row["price"] ."</td>";
                        echo "<td>". $row["name"] ."</td>";
                        echo "<td>". $row["theaterName"] ."</td>";
                        echo "<td>". $row["hallNo"] ."</td>";
                        echo "<td>". $row["date"] ."</td>";
                        echo "<td>". $row["showtime"] ."</td>";
                        echo "<td>". $row["chosenSeat"] ."</td>";
                        echo "</tr>";

                        $totalPrice += $row["price"];
                    }

                    echo "</table>";

                    echo "<div class=sum>
							Total Sales: RM ". $totalPrice ."
						</div>";

                } else {
                    echo "<p>Failed.</p>";
                }
            ?>
        </div>

    </body>

    <style>
        body {
            background-color: #F9F0FF;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
        }
.container {
    margin: 30px auto;
    max-width: 90%;
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 40px;
    font-weight: bold;
    color: #BF0885;
    background-color: #FFE6FF;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    text-align:center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: center;
    background-color: #ffffff;
}

table, th, td {
    border: 1px solid #BF0885;
    text-align: center;
    padding: 15px;
}

th {
    background-color: #BF0885;
    color: #ffffff;
    font-weight: bold;
}

td {
    color: #333333;
    font-weight: 500;
}
tr:nth-child(even) {
    background-color: #f2f2f2;
}

.sum {
    background-color: #28a745;
    color: #ffffff;
    padding: 20px;
    font-size: 22px;
    font-weight: bold;
    margin: 20px auto;
    text-align: center;
    border-radius: 5px;
    max-width: 300px;
}

.add {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    display: inline-block;
    border-radius: 5px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.add:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    h1 {
        font-size: 28px;
    }

    table {
        font-size: 16px;
    }

    .sum {
        font-size: 18px;
    }
}

    </style>
</html>
