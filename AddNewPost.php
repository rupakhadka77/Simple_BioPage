
<?php require_once("includes/Database.php");?>
<?php require_once("includes/Functions.php");?>
<?php require_once("includes/Sessions.php");?>
<?php Confirm_Login() ?>
<?php
if (isset($_POST["Submit"])) {
  $MyPost = $_POST["PostTitle"];
  $MyContent = $_POST["PostContent"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Uploads/".basename($_FILES["Image"]["name"]);
  $Admin = "Roops";
  date_default_timezone_set("Asia/Kathmandu");
  $CurrentTime = time();
  $DateTime = strftime("%A %B-%d-%Y %H:%M:%S",$CurrentTime);

  if (empty($MyPost)) {
    $_SESSION["ErrorMessage"] = "Title cannot be empty!";
    Redirect_to("AddNewPost.php");
  }elseif (strlen($MyPost) < 5) {
    $_SESSION["ErrorMessage"] = "Title should have atleast 5 characters!";
    Redirect_to("AddNewPost.php");
  }elseif (strlen($MyContent) > 999) {
    $_SESSION["ErrorMessage"] = "Your Post should have no more than 1000 characters!";
    Redirect_to("AddNewPost.php");
  }else {
    //Query to insert Post in Database when everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO post(title,content,image,user,datetime)";
    $sql .= "VALUES(:postName,:postContent,:postImage,:userName,:dateTime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':postName',$MyPost);
    $stmt->bindValue(':postContent',$MyContent);
    $stmt->bindValue(':postImage',$Image);
    $stmt->bindValue(':userName',$Admin);
    $stmt->bindValue(':dateTime',$DateTime);
    $Execute = $stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Post added successfully";
      Redirect_to("index.php");
    }else {
      $_SESSION["ErrorMessage"] = "Something went wrong! Please Try Again";
      Redirect_to("AddNewPost.php");
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

    <title>Add New Post</title>
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
        <form class="form-inline d-none d-sm-block" action="index.php">
          <div class="form-group">
            <input class="form-control mr-1" type="text" name="Search" placeholder="Search">
            <button class="btn btn-success mr-5" type="button" name="SearchButton">Go</button>
          </div>
        </form>
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
        <div class="offset-lg-1 col-lg-10" style="min-height:500px;">

          <?php
          echo ErrorMessage();
          echo SuccessMessage();
           ?>

          <form class="" action="index.php" method="post" enctype="multipart/form-data">
            <div class="card bg-success text-white m-3 ">
              <div class="card-header">
                <h4>Add New Post</h4>
              </div>
              <div class="card-body bg-dark">
                <div class="form-group">
                  <label for="title" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Title of the Post : </label>
                  <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Write Title here">
                </div>
                <div class="form-group">
                  <label for="content" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Content of the Post : </label>
                  <textarea class="form-control" type="textarea" name="PostContent" id="content" rows="5" cols="80"
                    placeholder="Write Content here"></textarea>
                </div>
                <label for="content" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Upload Image : </label>
                <div class="custom-file mb-3">
                  <input class="form-control custom-file-input" type="File" name="Image" id="ImageSelect">
                  <label for="ImageSelect" class="custom-file-label">Select Image</label>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-2">
                        <input type="reset" class="btn btn-warning btn-block" value="Cancel">
                    </div>
                    <div class="col-lg-6 mb-2">
                        <button type="submit" name="Submit" class="btn btn-primary btn-block">
                          <i class="fas fa-check"></i>Post</button>
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
