<?php
session_start();

include "Connect.php"; // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $caccount = $_POST["caccount"];
    $cpassword = $_POST["cpassword"];

    // Validate input (you may want to add more validation)
    if (empty($caccount) || empty($cpassword)) {
        $error = "caccount and cpassword are required.";
    } else {
        // Check user credentials
        $query = "SELECT * FROM customer WHERE caccount = ? AND cpassword = ?";
        $stmt = $conn->prepare($query);

        // Check for errors in prepare
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $caccount, $cpassword);
        $stmt->execute();

        // Check for errors in execute
        if ($stmt->error) {
            die("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        // Rest of your code...


        if ($result->num_rows == 1) {
            // Valid login, set session variables
            $row = $result->fetch_assoc();
            if ($row['cstatus'] == 0) {
                $lock = "Tài khoản của bạn đang bị khóa nên không đăng nhập được!!";
                
               
            } else {
                $_SESSION["cid"] = $row["cid"];
                $_SESSION["cname"] = $row["cname"];

                // Redirect to a dashboard or home page
                header("Location:../index.php");
                exit();
            }
        } else {
            $error = "Invalid caccount or cpassword.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <!-- Add your CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 300px;
            margin: auto;
            margin-top: 100px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đăng nhập</h2>

        <?php
        if (isset($error)) {
            echo '<p style="color: red;">' . $error . '</p>';
        }
        if (isset($lock)) {
            echo '<p style="color: red;">' . $lock . '</p>';
        }
        ?>
        

        <form method="post" action="">
            <label for="caccount"><b>Account</b></label>
            <input type="text" placeholder="Enter caccount" name="caccount" required>

            <label for="cpassword"><b>Password</b></label>
            <input type="cpassword" placeholder="Enter cpassword" name="cpassword" required>


            <button type="submit">Login</button>
        </form>
    </div>
</body>
<?php
    
?>
</html>