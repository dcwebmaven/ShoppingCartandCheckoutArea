<?php
#start the session before any output
session_start();



//Check if we need to add anything to the cart
if (isset($_GET['add'])){ //check to see if any items were selected

  foreach($_GET['add'] as $id) { //iterate through the add array to get prices

    // check if it already exists

    if(!$_SESSION['cart'][$id]) {

      $_SESSION['cart'][$id] = 1;

    }

    else {

      $_SESSION['cart'][$id]++;

    }

  }

}

//Removes

if (isset($_GET['removes'])){ //check to see if any items were selected

  foreach($_GET['removes'] as $id) { //iterate through the removes array

    // check if it already exists

    if($_SESSION['cart'][$id] == 1) {

      unset($_SESSION['cart'][$id]);

    }

    else {

      $_SESSION['cart'][$id]--;

    }

  }

}

header("Cache-control: private"); 

require($_SERVER['DOCUMENT_ROOT']."/template_top.inc"); 

//Check if any selections were made

if (empty($_SESSION['cart'])) {
  echo "Your cart is empty.  Please make a selection from the Book List.<br/><br/>";
} else {

//pull info from form into php for processing

echo "Here is a summary of the items in your shopping cart: "."<br/><br/>";

?>

<form>

<?php
$subtotal = 0;

//Show what's in the cart

foreach($_SESSION['cart'] as $id => $quantity) {
  $title = $_SESSION['inventory'][$id]['title'];
  $line_item_price = $_SESSION['inventory'][$id]['price'];
  
  $product_price = $line_item_price * $quantity;
  
  echo "Title: ".$title."<br/>";
  echo "Price: $".number_format($line_item_price,2)."<br/>";
  
  $subtotal += $product_price;


?>

<input type="checkbox" name="removes[]" value="<?php echo $id; ?>">Remove Item<br/><br/>

<?php
}


}
 

echo "The subtotal is $".number_format($subtotal,2)."<br/>";

$tax = $subtotal *.08;//cost with tax
echo "Tax= $".number_format($tax,2)."<br/>";
$shipping = 5.00;//price for flat-rate shipping
echo "Shipping= $".number_format($shipping,2)."<br/><br/>";
$grand_total = $subtotal + $tax + $shipping;
echo "The total cost for your order is $".number_format($grand_total,2)."<br/><br/>";

?>

<input type="submit" value="UPDATE CART"><br/><br/>

<a href="List_form6d.php">CONTINUE SHOPPING</a>

<a href="register3.php">CHECKOUT</a>
</form>

<?php
require($_SERVER['DOCUMENT_ROOT']."/template_bottom.inc");
?>
