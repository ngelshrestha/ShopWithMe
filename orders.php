<?php

include 'connect.php';

//Constant to get the tax from the total amount for displaying in the front end
define("TAX",1.0825);



?>

<!DOCTYPE>

<HTML>

<HEAD>

    <!--
       Providing a title to the site and linking to the stylesheet
    -->
    <TITLE>SHOPWITHME</TITLE>
    <LINK REL="stylesheet" HREF="styles.css">

</HEAD>

<BODY>

    <!--
        Header block for the website
    -->
    <div class="header">

        <span id="ctl_txt">Shop With Me</span>

    </div>

    <!--
       Major block that consists of the form
    -->
    <div class="content">

        <table border="1">

            <?php

            session_start();

            /*
             * Check the session variable and print the message if it is set else show that you have to place the order to see the order details
             * */
            if (isset($_SESSION['msg'])){

                echo "<br><font color = 'red'>".$_SESSION['msg']."</font><br>";

            } else {

                echo "<br><font color = 'red'> Please go back to the home page and order some item. Thank you!</font><br>";

            }

            /*
             * Get the orders just placed and display the details
             * */
            if (isset($_SESSION['order_id'])){

                //customer details and order summary for the order just placed
                $order = "SELECT first_name, last_name, zipcode, amount, date FROM orders JOIN customers ON customer_id = customers.id WHERE orders.id = ".$_SESSION['order_id'];

                //order details
                $order_details = "SELECT product_name, product_description, price, quantity, size, color FROM order_details JOIN products ON product_id = products.id WHERE order_id = ".$_SESSION['order_id'];

                if($result2 = @ mysqli_query($mysqli, $order)) {

                    while ($row = @ $result2->fetch_assoc()){

                        //order amount excluding tax
                        $order_amount = $row['amount'] / TAX;

                        //tax amount
                        $tax = $row['amount'] - $order_amount;

                        echo "<tr>";
                        echo "Customer Name: ".$row['first_name']." ".$row['last_name']."<br>";
                        echo "Customer Zipcode: ".$row['zipcode']."<br>";
                        echo "Order Amount: $".$order_amount."<br>";
                        echo "Tax: $".$tax."<br>";
                        echo "Total Amount: $".$row['amount']."<br>";
                        echo "Order Date: ".$row['date']."<br>"."<br>";
                        echo "</tr>";

                    }

                }

                //Display the order details
                if ($result1 = @ mysqli_query($mysqli, $order_details)){

                    echo "<tr>";
                    echo "<th>";
                    echo "Product Name";
                    echo "</th>";

                    echo "<th>";
                    echo "Product Description";
                    echo "</th>";

                    echo "<th>";
                    echo "Product Price each";
                    echo "</th>";

                    echo "<th>";
                    echo "Quantity Bought";
                    echo "</th>";

                    echo "<th>";
                    echo "Size";
                    echo "</th>";

                    echo "<th>";
                    echo "Color";
                    echo "</th>";
                    echo "</tr>";

                    //looping through each product ordered to display
                    while ($row = $result1->fetch_assoc()){

                        echo "<tr>";

                        echo "<td align='center'>";
                        echo $row['product_name'];
                        echo "</td>";

                        echo "<td align='center'>";
                        echo $row['product_description'];
                        echo "</td>";

                        echo "<td align='center'>";
                        echo "$".$row['price'];
                        echo "</td>";

                        echo "<td align='center'>";
                        echo $row['quantity'];
                        echo "</td>";

                        echo "<td align='center'>";
                        echo $row['size'];
                        echo "</td>";

                        echo "<td align='center'>";
                        echo $row['color'];
                        echo "</td>";

                        echo "</tr>";

                    }

                }


            }

            //unset the session
            session_unset();
            ?>

        </table>

        <br>
        <br>

        <!--- Back button to return to the home page -->
        <button onclick="location.href = 'main.php';" id="myButton">Back</button>

    </div>

</BODY>

</HTML>
