<?php
#start the session before any output
session_start();

require($_SERVER['DOCUMENT_ROOT']."/template_top.inc");
if ($_GET['error'] == "1") {
   $error_code = 1;  //this means that there's been an error and we need to notify the customer
}

?>

<html>
<h3>Thank you for your order!</h3>

Please tell us your name and email address so we can send you a confirmation.<br><br>
<?
if ($error_code) {
echo "<div style='color:red'>Please help us with the following:</div>";
}
?>

<form method="GET" action="checkout3.php">
<table>
<tr>
<td align="right">
First Name:
</td>
<td align="left">
<?
if ($_COOKIE['firstname']) {
   echo $_COOKIE['firstname'];
}
else {
?>
<input type="name" size="25" name="firstname" value="<? echo $_GET['firstname']; ?>" />

<?
}
if ($error_code && !($_GET['firstname'] || $_COOKIE['firstname'])) {
   echo "<b>Please include your name.</b>";
}
?>
</td>
</tr>
<tr>
<td align="right">
Last Name:
</td>
<td>
<?
if ($_COOKIE['lastname']) {
   echo $_COOKIE['lastname'];
}
else {
?>
<input type="name" size="25" name="lastname" value="<? echo $_GET['lastname']; ?>" />
<input type="checkbox" name="remember" /> Remember me on this computer
<?
}
if ($error_code && !($_GET['lastname'] || $_COOKIE['lastname'])) {
   echo "<b>Please include your name.</b>";
}
?>
</td>
</tr>
<tr>
<td align="right">
Email:
</td><td>
<?
if ($_COOKIE['email']) {
   echo $_COOKIE['email'];
}
else {
?>
<input type="text" size="25" name="email" value="<? echo htmlspecialchars($_GET['email'],ENT_QUOTES, 'UTF-8'); ?>" />
<?
}
if ($error_code && !($_GET['email'] || $_COOKIE['email'])) {
   echo "<b>Please include your email address.</b>";
} else {
$email = test_input($_GET['email']);
  //check if email address is well-formed
  if ($error_code && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<b>Invalid email format.</b>";
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
</td>
</tr>
<tr>
<td align="center">
<input type="submit" value="Checkout"> 
</td>
</tr>
</form>
</html>

<?php
require($_SERVER['DOCUMENT_ROOT']."/template_bottom.inc");
?>