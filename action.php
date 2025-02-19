<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "users";

// Check if 'user', 'password', and 'email' are set via POST
if (isset($_POST['user']) && isset($_POST['password']) && isset($_POST['email'])) {
    // Establish connection to the database
    $conn = mysqli_connect($host, $user, $password, $db);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the POST data
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Prepare the SQL query to check if the email or username already exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM admin1 WHERE user = ? OR email = ?");
    
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $user, $email);

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if the user or email already exists
        if (mysqli_num_rows($result) > 0) {
            echo "Error: Username or Email already exists!";
            mysqli_stmt_close($stmt); // Close the prepared statement
            mysqli_close($conn); // Close the connection
            exit();
        } else {
            // If not exists, hash the password before inserting
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL query to insert the new user into the database
            $insert_sql = "INSERT INTO admin1 (`user`, `email`, `password`) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_sql);

            if ($stmt_insert) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt_insert, "sss", $user, $email, $hashed_password);

                // Execute the query
                $query = mysqli_stmt_execute($stmt_insert);

                // Check if the query was successful
                if ($query) {
                    header("Location: login.php");
                    echo "Registration Successful";
                } else {
                    echo "Error: " . mysqli_error($conn);  // Show actual database error
                }

                // Close the insert statement
                mysqli_stmt_close($stmt_insert);
            } else {
                echo "Error in preparing the insert query.";
            }
        }

        // Close the select statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing the select query.";
    }

    // Close the connection
    mysqli_close($conn);

} else {
    include('registration.php');
    echo "Required fields are missing!";
}
?>

