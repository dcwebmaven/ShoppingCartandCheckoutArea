<?php
#start the session before any output
session_start();


function mail_message($customer_firstname, $customer_email, $grand_total) {

   #get template contents, and replace variables with data
   $email_message = "Dear ".$customer_firstname.","."\n";
   $email_message .= "Thank you for shopping with us!\n";
   $email_message .= "The total for your order is $".number_format($grand_total,2)."\n";
   $email_message .= "We will let you know if there is any problem with your order.";
         
   #construct the email headers
   $to = $customer_email;  //for testing purposes, this should be YOUR email address.
   $from = "nlinzau@gmail.com";
   $email_subject = "ORDER #".time();

$headers  = "From: " . $from . ";\r\n";
$headers .= 'MIME-Version: 1.0' . ";\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";   #now mail

   mail($to, $email_subject, $email_message, $headers);
  }


$customer_firstname = $_COOKIE['firstname'];
if (!($customer_firstname)) {
   $customer_firstname = $_GET['firstname'];
}
$customer_lastname = $_COOKIE['lastname'];
if (!($customer_lastname)) {
   $customer_lastname = $_GET['lastname'];
}
$customer_email = $_COOKIE['email'];
if (!($customer_email)) {
   $customer_email = $_GET['email'];
}


#Remember, if you place any output before a header() call, you'll get an error.
#We used the superglobal $_GET here 
//need to format the message in the form so it can carry across (will use session array)
if (!($customer_firstname && $customer_lastname && $customer_email)) {

   #with the header() function, no output can come before it.
   #echo "Please make sure you've filled in all required information.";

   $query_string = $_SERVER['QUERY_STRING'];
   #add a flag called "error" to tell contact_form.php that something needs fixed
   $url = "http://".$_SERVER['HTTP_HOST']."/register5.php?".$query_string."&error=1";
   header("Location: ".$url);
   exit();  //stop the rest of the program from happening
   
}

#we want a deadline 2 days after the message date.
   $deadline_array = getdate();
   $deadline_day = $deadline_array['mday'] + 2;

   $deadline_stamp = mktime($deadline_array['hours'],$deadline_array['minutes'],$deadline_array['seconds'],
       $deadline_array['mon'],$deadline_day,$deadline_array['year']);
   $deadline_str = date("F d, Y", $deadline_stamp);


if (isset($_GET['remember'])) {
   #the customer wants us to remember him/her for next time
   ### set errcode cookie
                /*
                cookie expires in one year
                365 days in a year
                24 hours in a day
                60 minutes in an hour
                60 seconds in a minute
                */
   $mytime = time() + (365 * 24 * 60 * 60);
   setcookie("firstname",$customer_firstname,$mytime);
   setcookie("lastname",$customer_lastname,$mytime);
   setcookie("email",$customer_email,$mytime);
}

include($_SERVER['DOCUMENT_ROOT']."/template_top.inc");

extract($_GET, EXTR_PREFIX_SAME, "get");

echo "<h3>Thank you!</h3>";
echo "We'll get back to you by ".$deadline_str.".<br/><br/>";
echo "Here is a copy of your order:<br/><br/>";

$subtotal = 0;

//Show what's in the cart
if ($_SESSION['cart']){
foreach($_SESSION['cart'] as $id => $quantity) {
  $title = $_SESSION['inventory'][$id]['title'];
  $line_item_price = $_SESSION['inventory'][$id]['price'];
  
  $product_price = $line_item_price * $quantity;
  
  echo "Title: ".$title."<br/>";
  echo "Price: $".number_format($line_item_price,2)."<br/><br/>";
  
  $subtotal += $product_price;


}
}

echo "The subtotal is $".number_format($subtotal,2)."<br/>";

$tax = $subtotal *.08;//cost with tax
echo "Tax= $".number_format($tax,2)."<br/>";
$shipping = 5.00;//price for flat-rate shipping
echo "Shipping= $".number_format($shipping,2)."<br/><br/>";
$grand_total = $subtotal + $tax + $shipping;
echo "The total cost for your order is $".number_format($grand_total,2)."<br/><br/>";

echo "ORDER #".time()."<br/>";
echo "Order Date: ".date("F d, Y h:i a")."<br/>";
echo "Name: ".$customer_firstname." ".$customer_lastname."<br/>";
echo "Email: ".$customer_email."<br/>";

//DOCUMENT_ROOT is the file path leading up to the template name.
mail_message($customer_firstname, $customer_email, $grand_total);

include($_SERVER['DOCUMENT_ROOT']."/template_bottom.inc");


?>
