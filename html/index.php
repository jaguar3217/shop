<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shop</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style> .wrapper {padding: 20px 20px 20px 20px;} </style>
    </head>
    <body>
        <div class="wrapper">
        <h1>Shop</h1>
        <h2 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h2>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
        <p>Please select the following items from the list.</p>
        <?php
            $servername = 'localhost';
            $username = 'root';
            $password = 'G4M3RZ_Rock';
            $dbname = 'shop';
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error)
                die("Connect failed: " . $conn->connect_error);
            
            $sql = "SELECT ID, `Name`, `Price`, `Available Since` FROM items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0)
            {
                echo "<table class='table'><tr><th>ID</th><th>Name</th><th>Price</th><th>Available Since</th></tr>";
                while ($row = $result->fetch_assoc())
                    echo "<tr><td>" . $row["ID"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["Price"]. "</td><td>" . $row["Available Since"]. "</td></tr>";
                echo "</table>";
            }
            else echo "No results.";

            //$conn->close();
        ?>

        <p>Please enter the ID of what you want to purchase: <form action="/purchase.php" method="post"><input type="text" name="id"> <input type="submit"></form></p>
        <p>You have <?php 
            $sql = "SELECT ID, Balance FROM users_money";
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
                while ($row = $result->fetch_assoc())
                    if ($row["ID"] == $_SESSION["id"])
                        echo $row["Balance"];
        ?> points.</p>

        <?php $conn->close(); ?>
        </div>
    </body>
</html>