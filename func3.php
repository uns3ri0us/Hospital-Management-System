<?php
session_start();
$con=mysqli_connect("localhost","root","","myhmsdb");
if (mysqli_connect_errno()) {
    die("Failed to connect to database: " . mysqli_connect_error());
}
if(isset($_POST['adsub'])){
	$username = htmlspecialchars(trim($_POST['username1']), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST['password2']);
	$stmt = $con->prepare("SELECT * FROM admintb WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
	if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['username'] = $username;
            header("Location: admin-panel1.php");
        } else {
            echo "<script>alert('Invalid Username or Password. Try Again!');
                  window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password. Try Again!');
              window.location.href = 'index.php';</script>";
    }

    $stmt->close();
}
if (isset($_POST['update_data'])) {
    $contact = htmlspecialchars(trim($_POST['contact']), ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars(trim($_POST['status']), ENT_QUOTES, 'UTF-8');

    // Prepared statement to update payment status
    $stmt = $con->prepare("UPDATE appointmenttb SET payment = ? WHERE contact = ?");
    $stmt->bind_param("ss", $status, $contact);

    if ($stmt->execute()) {
        header("Location: updated.php");
    } else {
        echo "<script>alert('Update failed. Please try again.');</script>";
    }

    $stmt->close();
}

function display_docs() {
    global $con;
    $query = "SELECT * FROM doctb";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {
        $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        echo '<option value="' . $name . '">' . $name . '</option>';
    }
}

if (isset($_POST['doc_sub'])) {
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');

    // Prepared statement to insert new doctor
    $stmt = $con->prepare("INSERT INTO doctb (name) VALUES (?)");
    $stmt->bind_param("s", $name);

    if ($stmt->execute()) {
        header("Location: adddoc.php");
    } else {
        echo "<script>alert('Adding doctor failed. Please try again.');</script>";
    }

    $stmt->close();
}
?>