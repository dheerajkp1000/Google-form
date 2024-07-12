<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

// Variable to hold the confirmation message
$confirmationMessage = "";

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the ID is set in the query string
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare SQL statement to delete data
        $sql = "DELETE FROM employee_data WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) { 
            $confirmationMessage = "Record deleted successfully.";
        } else {
            $confirmationMessage = "Error deleting record.";
        }
    } else {
        $confirmationMessage = "ID not provided.";
    }
} catch (PDOException $e) {
    $confirmationMessage = "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Employee Record</title>
    <!-- Add any styling or scripts for popups here -->
</head>
<body>
    <!-- Display confirmation message in a popup -->
    <script>
        alert("<?php echo $confirmationMessage; ?>");
        window.location.href = "edit.php"; // Redirect back to the edit page after showing the alert
    </script>
</body>
</html>
