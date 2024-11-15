<?php
// session_start();
$con=mysqli_connect("localhost","root","","myhmsdb");
if (!$con) {
  die("Database connection failed: " . mysqli_connect_error());
}
// if(isset($_POST['submit'])){
//  $username=$_POST['username'];
//  $password=$_POST['password'];
//  $query="select * from logintb where username='$username' and password='$password';";
//  $result=mysqli_query($con,$query);
//  if(mysqli_num_rows($result)==1)
//  {
//   $_SESSION['username']=$username;
//   $_SESSION['pid']=
//   header("Location:admin-panel.php");
//  }
//  else
//   header("Location:error.php");
// }
if (isset($_POST['update_data'])) {
  $contact = mysqli_real_escape_string($con, $_POST['contact']);
  $status = mysqli_real_escape_string($con, $_POST['status']);
  $query = "UPDATE appointmenttb SET payment='$status' WHERE contact='$contact'";
  if (mysqli_query($con, $query)) {
    header("Location:updated.php");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($con);
  }
}

// function display_docs()
// {
//  global $con;
//  $query="select * from doctb";
//  $result=mysqli_query($con,$query);
//  while($row=mysqli_fetch_array($result))
//  {
//   $username=$row['username'];
//   $price=$row['docFees'];
//   echo '<option value="' .$username. '" data-value="'.$price.'">'.$username.'</option>';
//  }
// }


function display_specs() {
  global $con;
  $query = "SELECT DISTINCT spec FROM doctb";
  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_array($result)) {
      $spec = htmlspecialchars($row['spec']);  // Sanitize output
      echo "<option data-value='$spec'>$spec</option>";
  }
}

function display_docs() {
  global $con;
  $query = "SELECT * FROM doctb";
  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_array($result)) {
      $username = htmlspecialchars($row['username']);
      $price = htmlspecialchars($row['docFees']);
      $spec = htmlspecialchars($row['spec']);
      echo "<option value='$username' data-value='$price' data-spec='$spec'>$username</option>";
  }
}

// function display_specs() {
//   global $con;
//   $query = "select distinct(spec) from doctb";
//   $result = mysqli_query($con,$query);
//   while($row = mysqli_fetch_array($result))
//   {
//     $spec = $row['spec'];
//     $username = $row['username'];
//     echo '<option value = "' .$spec. '">'.$spec.'</option>';
//   }
// }


if (isset($_POST['doc_sub'])) {
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $query = "INSERT INTO doctb (username) VALUES ('$username')";
  if (mysqli_query($con, $query)) {
      header("Location:adddoc.php");
      exit();
  } else {
      echo "Error adding doctor: " . mysqli_error($con);
  }
}

?>