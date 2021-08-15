<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if ($conn->connect_error)
                die("Connect failed: " . $conn->connect_error);

                $sql = "SELECT ID, `Name`, `Price`, `Available Since` FROM items";
                $result = $conn->query($sql);
    
                $price = 0;
                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                        if ($_POST['id'] == $row['ID'])
                            $price = $row['Price'];
                }
                
            $sql = "UPDATE users_money SET Balance = Balance - " . $price . " WHERE ID = " . $_SESSION["id"];
            $result = $conn->query($sql);
}

header("location: index.php");
?>