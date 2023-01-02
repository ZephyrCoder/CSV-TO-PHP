<?php
// Connect to the database
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'database';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Check if the file was uploaded
  if ($_FILES['csv_file']['error'] == 0) {
    // Get the uploaded CSV file
    $csv_file = $_FILES['csv_file']['tmp_name'];

    // Read the CSV file
    $csv_data = file_get_contents($csv_file);

    // Convert the CSV data to an array
    $csv_data = array_map('str_getcsv', explode("\n", $csv_data));

    // Check if the CSV data is valid
    if (!empty($csv_data)) {
      // Loop through the array and insert the data into the database
      foreach ($csv_data as $row) {
        // Check if the array is defined and has the required keys
        if (isset($row[0]) && isset($row[1]) && isset($row[2])) {
          $name = $row[0];
          $email = $row[1];
          $age = $row[2];

          // Check if the age value is not empty
          if (!empty($age)) {
            // Prepare the SQL statement
            $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, age) VALUES (?, ?, ?)");

            // Bind the values to the placeholders
            mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $age);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Check if the query was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
              echo "New record created successfully<br>";
            } else {
              echo "Error: " . mysqli_stmt_error($stmt) . "<br>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
          }
        }
      }
    } else {
      echo "Error: Invalid CSV data<br>";
    }
  } else {
    echo "Error: File not uploaded<br>";
  }
}
?>

<html>
<head>
  <style>
    input[type="file"] {
      height: 200px;
      width: 500px;
      border: 2px dashed #ccc;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ccc;
      font-size: 18px;
    }

    input[type="file"]:before {
      content: "Drag & Drop CSV file here";
    }
  </style>
</head>
<body>
  <!-- Display the form -->
  <form method="post" action="main.php" enctype="multipart/form-data">
    <label for="csv_file">Select a CSV file:</label><br>
    <input type="file" name="csv_file" id="csv_file" accept=".csv" multiple draggable>
    <br>
    <input type="submit" value="Submit" name="submit">
  </form>
</body>
</html>