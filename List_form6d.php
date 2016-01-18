<?php
#start the session before any output
session_start();
header("Cache-control: private");  

//setting up the session 'inventory' as sort of a database for the products
$_SESSION['inventory']=array(
               "poet" => array( 'title' => 'Letters to a Young Poet', 
                      'price' => 8.00,
                      'quantity' => 1 
                    ),
               "thief" => array( 'title' => 'The Book Thief', 
                      'price' => 13.00,
                      'quantity' => 1,
                    ),
               "borrower" => array( 'title' => 'The Borrower', 
                      'price' => 15.00,
                      'quantity' => 1 
                    )
             );

require($_SERVER['DOCUMENT_ROOT']."/template_top.inc"); 
?>

<html>
<head>
List of Books for Sale
</head>
<body>
<form method=GET action="List_process6d.php">
<table>
<tr><td><input type="checkbox" name="add[]" value="poet">Letters to a Young Poet by Rainer Maria Rilke<br></td>
<td>Price: $8.00</td></tr>
<tr><td>
<input type="checkbox" name="add[]" value="thief">The Book Thief by Markus Zusak<br></td>
<td>Price: $13.00</td></tr>
<tr><td>
<input type="checkbox" name="add[]" value="borrower">The Borrower by Rebecca Makkai<br></td>
<td>Price: $15.00</td></tr>
<tr><td>
<input type="submit" value="ADD TO CART"> </td></tr>
</form>

<? require($_SERVER['DOCUMENT_ROOT']."/template_bottom.inc"); ?>

</body>

</html>

