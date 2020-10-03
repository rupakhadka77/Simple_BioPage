<?php require_once("includes/Database.php"); ?>
<?php
function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}
function CheckUserNameExistOrNot($Username){
  global $ConnectingDB;
  $sql = "SELECT username FROM register WHERE username=:userName";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName',$Username);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return true;
  }else{
    return false;
  }
}
function CheckEmailExistOrNot($Email){
  global $ConnectingDB;
  $sql = "SELECT email FROM register WHERE email=:emailName";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':emailName',$Email);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return true;
  }else{
    return false;
  }
}
function Login_Attempt($Username,$Email,$Password){
  global $ConnectingDB;
  $sql = "SELECT * FROM register WHERE username=:userName AND email=:emailName AND password=:passwordName LIMIT 1";
  $stmt = $ConnectingDB->prepare($sql);
  $stmt->bindValue(':userName',$Username);
  $stmt->bindValue(':emailName',$Email);
  $stmt->bindValue(':passwordName',$Password);
  $stmt->execute();
  $Result = $stmt->rowcount();
  if ($Result == 1) {
    return $Found_Account = $stmt->fetch();
  }else{
    return null;
  }
}
function Confirm_Login(){
  if (isset($_SESSION["UserId"])) {
    return true;
  }else{
    $_SESSION["ErrorMessage"] = "Login REQUIRED!";
    Redirect_to("login.php");
  }
}






 ?>
