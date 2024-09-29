<?php
session_start();

// Initialize session of array if it doesn't exist
if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = array();
}

// Variable to store messages
$error = ""; 
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = trim($_POST['item']);
    $quantity = trim($_POST['quantity']);
    $search_item = trim($_POST['searchItem']);

    if(isset($_POST['btnAdd'])){
        // Validate input
        if (empty($item) || empty($quantity)) {
            $error = "Item or quantity cannot be blank";
        } elseif (!is_numeric($quantity) || $quantity <= 0) {
            $error = "Quantity must be a number greater than 0";
        } elseif (array_key_exists($item, $_SESSION['items'])) {
            $error = "Item already exists";
        } else {
            // If no errors, add the item
            $_SESSION['items'][$item] = $quantity;
        }
    }
    if(isset($_POST['btnSearch'])){
        if (array_key_exists($search_item, $_SESSION['items'])) {
            $message = "Product: " . $search_item. "<br>" . "Quantity: " . $_SESSION['items'][$search_item];
        } else {
            $message = "Product not found";
        }           
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
</head>
<body>
    <h1>Inventory Management</h1>

    <!--Item Management -->
    <h3>Add Item/s</h3>
    <form action="" method="POST">
        <label for="item">Item Name: </label><br>
        <input type="text" name="item" value=""><br>

        <label for="quantity">Quantity: </label><br>
        <input type="text" name="quantity" value=""><br>

        <input type="submit" value=" Add " name="btnAdd">
    </form>
    <br>

    <!-- Display error messages -->
    <?php 
        if (!empty($error)) : 
            echo $error;
        endif;
    ?>
    
    <br><br>

    <!--Search -->
    <h3>Search Item/s</h3>
    <form action="" method="POST">
        <label for="search">Search Item:</label><br>
        <input type="text" name="searchItem">
        <input type="submit" value="Search" name="btnSearch">         
    </form>
    <br>
    
    <?php 
        if (!empty($message)) : 
            echo $message;
        endif;
    ?>
    <br><br>

    <!--List of items -->
    <h3>List of Items</h3>
    <table border="2">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
            </tr>            
        </thead>
        <tbody>
            <?php
            if (!empty($_SESSION['items'])) {
                foreach ($_SESSION['items'] as $item => $quantity) {
                    echo "<tr>";
                    echo "<td>$item</td>";
                    echo "<td>$quantity</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>
</html>
