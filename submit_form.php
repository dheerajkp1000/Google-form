<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Prepare SQL statement for inserting data
        $sql = "INSERT INTO employee_data (full_name, contact_number, emergency_contact, dob_adhar, father_name, joining_date, original_dob, work_location, designation, personal_email, salary_ctc, married, spouse_details, children_details, pan_number, aadhaar_number, uan_number, bank_name, bank_account_number, ifsc_code, aadhaar_address, current_address, blood_group, work_experience, previous_org, last_ctc, family_contacts, reference_contacts, photo_path) 
                VALUES (:full_name, :contact_number, :emergency_contact, :dob_adhar, :father_name, :joining_date, :original_dob, :work_location, :designation, :personal_email, :salary_ctc, :married, :spouse_details, :children_details, :pan_number, :aadhaar_number, :uan_number, :bank_name, :bank_account_number, :ifsc_code, :aadhaar_address, :current_address, :blood_group, :work_experience, :previous_org, :last_ctc, :family_contacts, :reference_contacts, :photo_path)";
        
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':full_name', $_POST['full_name']);
        $stmt->bindParam(':contact_number', $_POST['contact_number']);
        $stmt->bindParam(':emergency_contact', $_POST['emergency_contact']);
        $stmt->bindParam(':dob_adhar', $_POST['dob_adhar']);
        $stmt->bindParam(':father_name', $_POST['father_name']);
        $stmt->bindParam(':joining_date', $_POST['joining_date']);
        $stmt->bindParam(':original_dob', $_POST['original_dob']);
        $stmt->bindParam(':work_location', $_POST['work_location']);
        $stmt->bindParam(':designation', $_POST['designation']);
        $stmt->bindParam(':personal_email', $_POST['personal_email']);
        $stmt->bindParam(':salary_ctc', $_POST['salary_ctc']);
        $stmt->bindParam(':married', $_POST['married']);
        $stmt->bindParam(':spouse_details', $_POST['spouse_details']);
        $stmt->bindParam(':children_details', $_POST['children_details']);
        $stmt->bindParam(':pan_number', $_POST['pan_number']);
        $stmt->bindParam(':aadhaar_number', $_POST['aadhaar_number']);
        $stmt->bindParam(':uan_number', $_POST['uan_number']);
        $stmt->bindParam(':bank_name', $_POST['bank_name']);
        $stmt->bindParam(':bank_account_number', $_POST['bank_account_number']);
        $stmt->bindParam(':ifsc_code', $_POST['ifsc_code']);
        $stmt->bindParam(':aadhaar_address', $_POST['aadhaar_address']);
        $stmt->bindParam(':current_address', $_POST['current_address']);
        $stmt->bindParam(':blood_group', $_POST['blood_group']);
        $stmt->bindParam(':work_experience', $_POST['work_experience']);
        $stmt->bindParam(':previous_org', $_POST['previous_org']);
        $stmt->bindParam(':last_ctc', $_POST['last_ctc']);
        $stmt->bindParam(':family_contacts', $_POST['family_contacts']);
        $stmt->bindParam(':reference_contacts', $_POST['reference_contacts']);
        $stmt->bindParam(':photo_path', $photo_path);

        // Upload file if exists
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $photo_path = $target_file;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Fetch and display data
    $sql = "SELECT id, full_name, contact_number, personal_email, joining_date, work_location, aadhaar_number, pan_number, photo_path FROM employee_data";
    $stmt = $conn->query($sql);

    // Check if any rows were returned
    if ($stmt->rowCount() > 0) {
        echo "<table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Contact Number</th>
            <th>Personal Email</th>
            <th>Joining Date</th>
            <th>Work Location</th>
            <th>Aadhaar Number</th>
            <th>PAN Number</th>
            <th>Photo Path</th>
            <th>Actions</th>
        </tr>";

        $counter = 1; // Initialize counter for IDs
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$counter}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['contact_number']}</td>
                <td>{$row['personal_email']}</td>
                <td>{$row['joining_date']}</td>
                <td>{$row['work_location']}</td>
                <td>{$row['aadhaar_number']}</td>
                <td>{$row['pan_number']}</td>
                <td><img src='{$row['photo_path']}' height='50' width='50'></td>
                <td>
                   <button class='Insert'> <a href='index.html'>Insert </a> </button>
                   <button class='Edit'> <a href='edit.php?id={$row['id']}'>Edit</a></button>
                    <button class ='Delete'> <a href='delete.php?id={$row['id']}'>Delete</a></button>
                </td>
            </tr>";
            
            $counter++; // Increment counter for next ID
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
<style>
    table {
        width: 100%;
        border-collapse: separate;
        margin-bottom: 20px;
    }
    th, td {
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    td {
        background-color: #f2f2f2;
    }
    button {
        padding: 5px 7px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }
    .Insert {
        background-color: #4CAF50;
        color: white;
    }
    .Edit {
        background-color: #2196F3;
        color: white;
    }
    .Delete {
        background-color: #f44336;
        color: white;
    }
    a {
        text-decoration: none;
        color: white;
    }
    img {
        max-width: 50px;
        max-height: 50px;
        border-radius: 50%;
    }

    /* Responsive design */
    @media screen and (max-width: 600px) {
        table {
            font-size: 12px;
        }
        img {
            max-width: 30px;
            max-height: 30px;
        }
    }
</style>
