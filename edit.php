<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if ID is provided via GET method
    if (isset($_GET['id'])) {
        $employee_id = $_GET['id'];
        
        // Fetch existing record details
        $sql = "SELECT * FROM employee_data WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $employee_id);
        $stmt->execute();
        
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$employee) {
            echo "Employee not found";
            exit;
        }
    } else {
        echo "Employee ID not provided";
        exit;
    }

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Prepare SQL statement for updating data
        $sql = "UPDATE employee_data SET 
                full_name = :full_name, 
                contact_number = :contact_number, 
                emergency_contact = :emergency_contact, 
                dob_adhar = :dob_adhar, 
                father_name = :father_name, 
                joining_date = :joining_date, 
                original_dob = :original_dob, 
                work_location = :work_location, 
                designation = :designation, 
                personal_email = :personal_email, 
                salary_ctc = :salary_ctc, 
                married = :married, 
                spouse_details = :spouse_details, 
                children_details = :children_details, 
                pan_number = :pan_number, 
                aadhaar_number = :aadhaar_number, 
                uan_number = :uan_number, 
                bank_name = :bank_name, 
                bank_account_number = :bank_account_number, 
                ifsc_code = :ifsc_code, 
                aadhaar_address = :aadhaar_address, 
                current_address = :current_address, 
                blood_group = :blood_group, 
                work_experience = :work_experience, 
                previous_org = :previous_org, 
                last_ctc = :last_ctc, 
                family_contacts = :family_contacts, 
                reference_contacts = :reference_contacts, 
                photo_path = :photo_path 
                WHERE id = :id";
        
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $employee_id);
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
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $photo_path = $target_file;

            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // File uploaded successfully, continue with database update
                $stmt->bindParam(':photo_path', $photo_path);
            } else {
                // Error uploading file
                throw new Exception("Error uploading photo.");
            }
        }
        
        // Execute statement
        $stmt->execute();
        
        echo "Record updated successfully";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Employee Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom stylesheet here -->
</head>
<body>
    <div class="container">
        <h2>Update Employee Details</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo $employee['full_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number *</label>
                <input type="text" id="contact_number" name="contact_number" value="<?php echo $employee['contact_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact No. *</label>
                <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo $employee['emergency_contact']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob_adhar">Date of Birth (as per Aadhar Card) *</label>
                <input type="date" id="dob_adhar" name="dob_adhar" value="<?php echo $employee['dob_adhar']; ?>" required>
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name (as per Aadhar Card) *</label>
                <input type="text" id="father_name" name="father_name" value="<?php echo $employee['father_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="joining_date">Date of Joining *</label>
                <input type="date" id="joining_date" name="joining_date" value="<?php echo $employee['joining_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="original_dob">Original Birthday Date *</label>
                <input type="date" id="original_dob" name="original_dob" value="<?php echo $employee['original_dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="work_location">Work Location *</label>
                <input type="text" id="work_location" name="work_location" value="<?php echo $employee['work_location']; ?>" required>
            </div>
            <div class="form-group">
                <label for="designation">Designation *</label>
                <input type="text" id="designation" name="designation" value="<?php echo $employee['designation']; ?>" required>
            </div>
            <div class="form-group">
                <label for="personal_email">Personal Email ID *</label>
                <input type="email" id="personal_email" name="personal_email" value="<?php echo $employee['personal_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="salary_ctc">Salary Offered (CTC) *</label>
                <input type="number" id="salary_ctc" name="salary_ctc" value="<?php echo $employee['salary_ctc']; ?>" required>
            </div>
            <div class="form-group">
                <label for="married">Married *</label>
                <select id="married" name="married" required>
                    <option value="Yes" <?php if ($employee['married'] === 'Yes') echo 'selected'; ?>>Yes</option>
                    <option value="No" <?php if ($employee['married'] === 'No') echo 'selected'; ?>>No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="spouse_details">Spouse Name and Date of Birth (if Married) *</label>
                <textarea id="spouse_details" name="spouse_details" required><?php echo $employee['spouse_details']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="children_details">Children (Names and D.O.B. as per Aadhar, if any) *</label>
                <textarea id="children_details" name="children_details" required><?php echo $employee['children_details']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="pan_number">Pan Number *</label>
                <input type="text" id="pan_number" name="pan_number" value="<?php echo $employee['pan_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aadhaar_number">Aadhaar Number *</label>
                <input type="text" id="aadhaar_number" name="aadhaar_number" value="<?php echo $employee['aadhaar_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="uan_number">UAN Number *</label>
                <input type="text" id="uan_number" name="uan_number" value="<?php echo $employee['uan_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" id="bank_name" name="bank_name" value="<?php echo $employee['bank_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="bank_account_number">Bank Account Number *</label>
                <input type="text" id="bank_account_number" name="bank_account_number" value="<?php echo $employee['bank_account_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ifsc_code">IFSC Code *</label>
                <input type="text" id="ifsc_code" name="ifsc_code" value="<?php echo $employee['ifsc_code']; ?>" required>
            </div>
            <div class="form-group">
                <label for="aadhaar_address">Address in Aadhaar Card *</label>
                <textarea id="aadhaar_address" name="aadhaar_address" required><?php echo $employee['aadhaar_address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="current_address">Current Address with Pin code (if different from Aadhaar card) *</label>
                <textarea id="current_address" name="current_address" required><?php echo $employee['current_address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="blood_group">Blood Group *</label>
                <input type="text" id="blood_group" name="blood_group" value="<?php echo $employee['blood_group']; ?>" required>
            </div>
            <div class="form-group">
                <label for="work_experience">Total Work Experience *</label>
                <input type="number" id="work_experience" name="work_experience" value="<?php echo $employee['work_experience']; ?>" required>
            </div>
            <div class="form-group">
                <label for="previous_org">Previous Organization Name *</label>
                <input type="text" id="previous_org" name="previous_org" value="<?php echo $employee['previous_org']; ?>" required>
            </div>
            <div class="form-group">
                <label for="last_ctc">Last CTC *</label>
                <input type="number" id="last_ctc" name="last_ctc" value="<?php echo $employee['last_ctc']; ?>" required>
            </div>
            <div class="form-group">
                <label for="family_contacts">Three immediate family members contact details (Name/Contact Numbers/Relation) for Emergency *</label>
                <textarea id="family_contacts" name="family_contacts" required><?php echo $employee['family_contacts']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="reference_contacts">Three reference contact details (Name/Contact Numbers/Designation and Email ID) from your last Organization. (HR DETAILS ARE A MUST) *</label>
                <textarea id="reference_contacts" name="reference_contacts" required><?php echo $employee['reference_contacts']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Passport Size Photo *</label>
                <input type="file" id="photo" name="photo" required>
            </div>
            <button type="submit">Update</button>
        </form>
        <style>
            
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}


/* Body styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f2f2f2;
}

/* Container styles */
.container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color:skyblue;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Heading styles */
h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Form styles */
form {
    width: 100%;
}

/* Form group styles */
.form-group {
    margin-bottom: 15px;
}

/* Label styles */
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

/* Input styles */
input[type="text"],
input[type="email"],
input[type="number"],
input[type="date"],
textarea,
select,
button[type="submit"] {
    width: calc(100% - 20px);
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 5px;
    margin-bottom: 10px;
}
/* button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
} */

/* Textarea styles */
textarea {
    height: 100px;
    resize: vertical;
}

/* Button styles */
button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #e21b1b;
}

/* Responsive design */
@media screen and (max-width: 500px) {
    .container {
    padding: 10px;
    }
    input[type="text"],
    input[type="email"],
    input[type="number"],
    input[type="date"],
    textarea,
    select,
    button[type="submit"] {
        width: 100%;
    }
}


        </style>
    </div>
</body>
</html>
