
<?php require_once("includes/Database.php");?>
<?php require_once("includes/Functions.php");?>
<?php require_once("includes/Sessions.php");?>

<?php
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Email = $_POST["Email"];
  $Password = $_POST["Password"];
  date_default_timezone_set("Asia/Kathmandu");
  $CurrentTime = time();
  $DateTime = strftime("%A %B-%d-%Y %H:%M:%S",$CurrentTime);

  if (empty($Username) || empty($Email) || empty($Password)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out!";
    Redirect_to("register.php");
  }elseif (strlen($Password) < 8) {
    $_SESSION["ErrorMessage"] = "Password should have atleast 8 characters including a number and a lowercase letter!";
    Redirect_to("register.php");
  }elseif (CheckUserNameExistOrNot($Username)) {
    $_SESSION["ErrorMessage"] = "Username exists. Try another one!";
    Redirect_to("register.php");
  }elseif (!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$Email)) {
    $_SESSION["ErrorMessage"] = "Invalid Email Format!";
    Redirect_to("register.php");
  }elseif (CheckEmailExistOrNot($Email)) {
    $_SESSION["ErrorMessage"] = "Email exists. Try another one!";
    Redirect_to("register.php");
  }else {
    //Query to insert Post in Database when everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO register(datetime,username,email,password)";
    $sql .= "VALUES(:dateTime,:userName,:emailName,:passwordName)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':userName',$Username);
    $stmt->bindValue(':emailName',$Email);
    $stmt->bindValue(':passwordName',$Password);
    $Execute = $stmt->execute();
    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Registered successfully";
      Redirect_to("login.php");
    }else {
      $_SESSION["ErrorMessage"] = "Something went wrong! Please Try Again";
      Redirect_to("register.php");
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

    <title>Sign Up</title>
  </head>
  <body>
  <!-- NAVBAR STARTS HERE-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
      <div class="container">
        <a href="index.php" class="navbar-brand text-success h1">IFFCSAT</a>
          <a href="login.php" class=" nav-link text-success ml-auto">Sign in</a>
          <a href="register.php" class="nav-link text-success">Sign Up</a>
      </div>
    </nav>
    <!-- NAVBAR ENDS HERE -->

    <!-- MAIN AREA STARTS HERE-->
    <section class="container p-2">
      <div class="row">
        <div class="offset-lg-3 col-lg-5" style="min-height:500px;">

          <?php
          echo ErrorMessage();
          echo SuccessMessage();
           ?>

          <form class="" action="register.php" method="post">
            <div class="card bg-info text-white m-3 ">
              <div class="card-header">
                <h4 class="text-center">First time here? SIGN UP!</h4>
              </div>
              <div class="card-body bg-light">
                <div class="form-group">
                  <label for="username" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Username </label>
                  <input class="form-control" type="text" name="Username" id="username">
                </div>
                <div class="form-group">
                  <label for="email" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Email </label>
                  <input class="form-control" type="email" name="Email" id="email">
                </div>
                <div class="form-group">
                  <label for="password" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Password </label>
                  <input class="form-control" type="password" name="Password" id="password">
                </div>
                <div class="text-dark">
                  <p>Make sure password is atleast 8 characters including a number and a lowercase letter.</p>
                </div>

                <div class="row">
                    <div class="col">
                        <button type="submit" name="Submit" class="btn btn-success btn-block p-3">Sign Up</button>
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
