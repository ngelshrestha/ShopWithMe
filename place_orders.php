<?php

include 'connect.php';

//defining a constant TAX which is the static tax percentage for each order
define("TAX", 8.25);

//count to check how many items were ordered initialized
$order_count = 0;

//total amount to be paid initialized
$total_amount = 0;

//Check if there is any order by checking the quantity placed for each product
for ($i = 0; $i < count($_POST['quantity']); $i++){

    if ($_POST['quantity'][$i] != 0) {

        //count increments
        $order_count++;

        //go on adding the price to calculate the total price
        $total_amount += $_POST['price'][$i] * $_POST['quantity'][$i];

    }

}

//If count is 0 that means no product was selected so send them back to the order page with error
if ($order_count == 0){

    //start a session
    session_start();
    $_SESSION['msg'] = "Please select at least one item before placing an order"; //session variable msg set to be sent to the main page
    header('Location: main.php'); //redirecting the page to the order page
    exit;

}

//if the customer has not inserted any customer id, then check if all the details have been provided and insert it into database to retrieve a new customer id
if($_POST['customer_id'] == 0 && $_POST['first_name'] != "" && $_POST['last_name'] != "" && $_POST['zipcode'] != "" ) {

    //query to insert the new customer into the database
    $query = "INSERT INTO customers (first_name, last_name, zipcode) VALUES ('".$_POST['first_name']."','".$_POST['last_name']."','".$_POST['zipcode']."')";

    //if inserted, get the last inserted id else set the msg variable as error and redirect back to order
    if (@ mysqli_query($mysqli,$query)){

        $_POST['customer_id'] = mysqli_insert_id($mysqli);

    } else {

        session_start();
        $_SESSION['msg'] = "There was some error with the server. Please try again";
        header('Location: main.php');
        exit;

    }

    //if both customer id and the customer details are missing, redirect back to the orders page and let the user know the error
} elseif ($_POST['customer_id'] == 0 && ($_POST['first_name'] == "" || $_POST['last_name'] == "" || $_POST['zipcode'] == "")){

    session_start();
    $_SESSION['msg'] = "Please provide either your customer id or provide correct and full information for your customer account";
    header('Location: main.php');
    exit;

    //if customer provided customer id, check if the customer id exists in the database
} elseif ($_POST['customer_id'] > 0){

    //query to select the row with the given customer id
    $query = "SELECT * FROM customers WHERE id = ".$_POST['customer_id'];

    @ $result = mysqli_query($mysqli,$query);
    //if there is no customer with that id in the database, the result would be a boolean false so if that case is encountered, redirect back with the error
    if ($result->num_rows == 0){

        session_start();
        $_SESSION['msg'] = "Please provide a valid customer id or if you don't have one, you can create one by giving your first name, last name and zipcode";
        header('Location: main.php');
        exit;

    }

}

//add tax to the total amount
$total_amount += $total_amount * TAX/100;

//query to insert the given order in the database
$query = "INSERT INTO orders (customer_id, amount, date) VALUES (".$_POST['customer_id'].",".$total_amount.", CURRENT_TIMESTAMP)";

//inserting the order and product details to the order details table
if (@ mysqli_query($mysqli,$query)){

    //order id as the foreign key for the order details table
    $order_id = mysqli_insert_id($mysqli);

    //insert the details to the order details table one by one
    for ($i = 0; $i < count($_POST['quantity']); $i++){

        if ($_POST['quantity'][$i] != 0) {

            $query = "INSERT INTO order_details (order_id, product_id, quantity, size, color) VALUES (".$order_id.",".$_POST['product_id'][$i].",".$_POST['quantity'][$i].",'".$_POST['size'][$i]."','".$_POST['color'][$i]."')";

            @ mysqli_query($mysqli,$query);
        }

    }

    //start the session and send the message as order placed successfully and redirect to the order display page
    session_start();
    $_SESSION['msg'] = "Order Placed Successfully";

    //order id to show the recently placed order in the next page
    $_SESSION['order_id'] = $order_id;
    header('Location: orders.php');
    exit;

}