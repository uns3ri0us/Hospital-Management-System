<!DOCTYPE html>
 <?php #include("func.php");?>
<html>
<head>
	<title>Doctor Details</title>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
<?php
  include("newfunc.php");

  if(isset($_POST['doctor_search_submit'])) {
    // Sanitize and validate input
    $contact = mysqli_real_escape_string($con, $_POST['doctor_contact']);

    // Use a prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT username, password, email, docFees FROM doctb WHERE email = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results were returned
    if ($result->num_rows === 0) {
      echo "<script>alert('No entries found!'); window.location.href = 'admin-panel1.php#list-doc';</script>";
    } else {
      // Start generating the output table
      echo "<div class='container-fluid' style='margin-top:50px;'>
          <div class='card'>
            <div class='card-body' style='background-color:#342ac1;color:#ffffff;'>
              <table class='table table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>Username</th>
                    <th scope='col'>Password</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>Consultancy Fees</th>
                  </tr>
                </thead>
              <tbody>";
          
      // Fetch and display results
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['username']) . "</td>
            <td>" . htmlspecialchars($row['password']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['docFees']) . "</td>
          </tr>";
        }

        echo "</tbody></table>
            <center><a href='admin-panel1.php' class='btn btn-light'>Back to dashboard</a></div></center>
            </div>
            </div>
            </div>";
      }

      // Free resources and close the prepared statement
      $stmt->close();
  }

?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script> 
</body>
</html>