
<?php require_once("includes/Database.php");?>
<?php require_once("includes/Functions.php");?>
<?php require_once("includes/Sessions.php");?>
<?php Confirm_Login() ?>
<?php
//Fetching the existing user data
$UserId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM register WHERE id='$UserId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $ExistingName = $DataRows['username'];
  $ExistingFullName = $DataRows['fullname'];
  $ExistingImage = $DataRows['profileimage'];
  $ExistingBio = $DataRows['bio'];

}
 ?>
<?php
if (isset($_POST["Submit"])) {
  $MyName = $_POST["FullName"];
  $MyRoll = $_POST["CRN"];
  $Department = $_POST["dept"];
  $Semester = $_POST["sem"];
  $Shift = $_POST["shift"];
  $ProfileBio = $_POST["Bio"];
  $Image = $_FILES["Image"]["name"];
  $Target = "images/".basename($_FILES["Image"]["name"]);

  if (strlen($ProfileBio) > 999) {
    $_SESSION["ErrorMessage"] = "Your Bio should have no more than 1000 characters!";
    Redirect_to("Profile.php");
  }else {
    //Query to insert Post in Database when everything is fine
    global $ConnectingDB;
    if (!empty($_FILES["Image"]["name"])) {
      $sql = "UPDATE register
              SET fullname = '$MyName', rollno = '$MyRoll', department = '$Department',
               semester = '$Semester', shift = '$Shift', profileimage = '$Image', bio = '$ProfileBio'
              WHERE id = '$UserId'";
    }else{
      $sql = "UPDATE register
              SET fullname = '$MyName', rollno = '$MyRoll', department = '$Department',
               semester = '$Semester', shift = '$Shift', bio = '$ProfileBio'
              WHERE id = '$UserId'";
    }
    $Execute = $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Post updated successfully";
      Redirect_to("profile.php");
    }else {
      $_SESSION["ErrorMessage"] = "Something went wrong! Please Try Again";
      Redirect_to("profile.php");
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="fontawesome/solid.css">
    <link rel="stylesheet" href="fontawesome/brands.css">
    <link rel="stylesheet" href="fontawesome/regular.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.css">
    <!-- fontawesome JS-->
    <script defer src="fontawesome/all.js"></script>
    <script defer src="fontawesome/solid.js"></script>
    <script defer src="fontawesome/brands.js"></script>
    <script defer src="fontawesome/regular.js"></script>
    <script defer src="fontawesome/fontawesome.js"></script>

    <title>Profile</title>
  </head>
  <body>
  <!-- NAVBAR STARTS HERE-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
      <div class="container">
        <a href="index.php" class="navbar-brand text-success h1">IFFCSAT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseCMS"
         aria-controls="navbarcollapseCMS" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="index.php" class="nav-link text-success">
            <i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a href="profile.php" class="nav-link text-success">
            <i class="fas fa-user"></i> Profile</a>
        </li>
        <li class="nav-item">
          <a href="posts.php" class="nav-link text-success">
            <i class="fas fa-sticky-note"></i> Posts</a>
        </li>
        <li class="nav-item">
          <a href="college.php" class="nav-link text-success">
            <i class="fas fa-university"></i> College</a>
        </li>
        <li class="nav-item">
          <a href="teachers.php" class="nav-link text-success">
            <i class="fas fa-user-tie"></i> Teachers</a>
        </li>
        <li class="nav-item">
          <a href="students.php" class="nav-link text-success">
            <i class="fas fa-user-graduate"></i> Students</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="logout.php" class="nav-link text-danger">
            <i class="fas fa-user-times"></i> Logout</a>
        </li>
      </ul>
      </div>
      </div>
    </nav>
    <div style="height:5px;background:teal;"></div>
    <!-- NAVBAR ENDS HERE -->

    <!-- MAIN AREA STARTS HERE-->
    <section class="container">
      <div class="row">
        <!-- LEFT AREA-->
        <div class="col-md-3">
          <div class="card m-3">
            <div class="card-header bg-info text-light ">
              <h3>@<?php echo $ExistingName; ?></h3>
            </div>
            <div class="card-body">
              <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
              <h3><?php echo $ExistingFullName; ?></h3>
              <div class="">
                <?php echo $ExistingBio; ?>
              </div>
            </div>
          </div>
        </div>
        <!-- RIGHT AREA-->
        <div class="col-md-9" style="min-height:500px;">

          <?php
          echo ErrorMessage();
          echo SuccessMessage();
           ?>

          <form class="" action="profile.php" method="post" enctype="multipart/form-data">
            <div class="card bg-success text-white m-3 ">
              <div class="card-header">
                <h4> <i class="fas fa-user-edit"></i> Edit Profile</h4>
              </div>
              <div class="card-body bg-light">
                <div class="form-group">
                  <input class="form-control mb-4" type="text" name="FullName" id="title" placeholder="Full Name">
                  <input class="form-control" type="text" name="CRN" id="title" placeholder="Roll Number">
                </div>
                <div class="form-group">
                  <label for="user_dept" class="text-dark" style="font-family:'Helvetica Neue'; font-size:1.5em;">Department: </label>
                  <select id="user_dept" name="dept" class="form-control" size="0">
                    <option value="civil">BE Civil</option>
                    <option value="it">BE IT</option>
                    <option value="software">BE Software</option>
                    <option value="computer">BE Computer</option>
                    <option value="mechanical">BE Mechanical</option>
                    <option value="electrical">BE Electrical</option>
                    <option value="architecture">BE Architecture</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="user_semester" class="text-dark" style="font-family:'Helvetica Neue'; font-size:1.5em;">Semester: </label>
                  <select id="user_semester" name="sem" class="form-control" size="0">
                       <option value="1">1st</option>
                       <option value="2">2nd</option>
                       <option value="3">3rd</option>
                       <option value="4">4th</option>
                       <option value="5">5th</option>
                       <option value="6">6th</option>
                       <option value="7">7th</option>
                       <option value="8">8th</option>
                   </select>
                </div>
                <div class="form-group">
                  <label for="shift" class="text-dark" style="font-family:'Helvetica Neue'; font-size:1.5em;">Shift: </label>
                  <select id="shift" name="shift" class="form-control" size="0">
                        <option value="morning">Morning</option>
                        <option value="day">Day</option>
                    </select>

                </div>
                <label for="content" class="text-dark" style="font-family:'Helvetica Neue'; font-size:1.5em;">Upload Image : </label>
                <div class="custom-file mb-3">
                  <input class="form-control custom-file-input" type="File" name="Image" id="ImageSelect">
                  <label for="ImageSelect" class="custom-file-label">Select Image</label>
                </div>
                <div class="form-group">
                  <label for="content" class="text-dark" style="font-family:'Helvetica Neue'; font-size:1.5em;">Write something about yourself: </label>
                  <textarea class="form-control" type="textarea" name="Bio" id="content" rows="3" cols="80"
                    placeholder="Eg. Hobbies, Likes,Dislikes,etc"></textarea>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <input type="reset" class="btn btn-warning btn-block" value="Cancel">
                    </div>
                    <div class="col-lg-6 mb-2">
                        <button type="submit" name="Submit" class="btn btn-primary btn-block">
                          <i class="fas fa-check"></i>Update</button>
                    </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>



    <!-- MAIN AREA ENDS HERE -->

    <!-- FOOTER STARTS HERE-->
    <div style="height:5px;background:teal;"></div>
    <footer class="bg-warning text-white">
      <div class="container">
        <div class="row">
          <div class="col">
          <p class="lead text-center m-auto p-1 text-success">Project By | Roops |&copy; ----All right Reserved.</p>
           </div>
         </div>
      </div>
    </footer>
    <!-- FOOTER ENDS HERE-->

  </body>
</html>
