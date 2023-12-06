<!DOCTYPE html>
<!-- test_get.php -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Opening Entry</title>
    <style>
    <! --wow css! --> 
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .success-message {
            color: green;
            font-size: 20px;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
    //get values into variables to help w keeping db safe 
    $companyName = $_GET['COMP_NAME'];
    $companyAreaCode = $_GET['COMP_AREA_CODE'];
    $companyPhoneNumber = $_GET['COMP_PHONE_NUMBER'];
    $companyEmail = $_GET['COMP_EMAIL'];

    $server = "127.0.0.1";
    $user = "root";
    $pass = "";
    $db = "tec";

    $conn = new mysqli($server, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: we are unable to process your request at this time, please try again later." . $conn->connect_error);
    }

    // Inserting values from html into database, using $stmt as a form of sanitization
    //this code will break if you enter things that break constraints, but the scope of it is not meant to be huge, just a demonstration
    $sql = "INSERT INTO COMPANY (COMP_NAME, COMP_AREA_CODE, COMP_PHONE_NUMBER, COMP_EMAIL) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("siis", $companyName, $companyAreaCode, $companyPhoneNumber, $companyEmail);
        if ($stmt->execute()) {
            echo '<p class="success-message">Entry successful. We will contact you about a potential placement soon. Thank you for choosing TEC.</p>';
        } else {
            echo '<p class="error-message">Entry unsuccessful: please review your information or contact support for further help.' . $stmt->error . '</p>';
        }
        $stmt->close();
    } else {
        echo '<p class="error-message">Prepared statement error: please check your values.' . $conn->error . '</p>';
    }

    $conn->close();
    ?>
</body>
</html>
