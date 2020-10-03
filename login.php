
<?php require_once("includes/Database.php");?>
<?php require_once("includes/Functions.php");?>
<?php require_once("includes/Sessions.php");?>

<?php
if (isset($_POST["Submit"])) {
  $Username = $_POST["Username"];
  $Email = $_POST["Email"];
  $Password = $_POST["Password"];

  if (empty($Username) || empty($Email) || empty($Password)) {
    $_SESSION["ErrorMessage"] = "All fields must be filled out!";
    Redirect_to("login.php");
  }else {
    //Code for checking username, email & password from database
    $Found_Account = Login_Attempt($Username,$Email,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"] =$Found_Account ["id"];
      $_SESSION["UserName"] = $Found_Account["username"];
      $_SESSION["UserEmail"] = $Found_Account["email"];
      $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["UserName"]."!";
      Redirect_to("index.php");
    }else {
      $_SESSION["ErrorMessage"] = "Incorrect USERNAME or PASSWORD";
      Redirect_to("login.php");
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

    <title>Login</title>
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
    <section class="container py-2">
      <div class="row">
        <div class="offset-lg-3 col-lg-5" style="min-height:530px;">

          <?php
          echo ErrorMessage();
          echo SuccessMessage();
           ?>

          <form class="" action="login.php" method="post">
            <div class="card bg-info text-white m-3 ">
              <div class="card-header">
                <h4 class="text-center">Already have an account? LOGIN!</h4>
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
                <div class="form-group mb-4">
                  <label for="password" class="text-warning" style="font-family:'Helvetica Neue'; font-size:1.5em;">Password </label>
                  <input class="form-control" type="password" name="Password" id="password">
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" name="Submit" class="btn btn-success btn-block p-3">Login</button>
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
