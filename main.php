<?php

    /*
     * Name: Angel Shrestha
     * Course: COMBINED-NT752.1191.1.2231
     * Assignment: PHP-Project
     * Date: 02/08/19
     *
     * There are four php files, one css file and four images file.
     *
     * main.php - Homepage for the site
     * connect.php - This is the file that connects to the database and is included in the files that is making use of the database tables
     * place_orders.php - This is the file that acts like a web service to the site. It manipulates the input data and interacts with the database
     * orders.php - After the order is made, it shows you the detail of the order made.
     *
     * styles.css - CSS file that consists of all the styles for each class
     *
     * images - Folder that consists the product images and background images
     *
	 * User
	 * Customer_id : 1
	 * First name: Angel
	 * Last name: Shrestha
	 * Zipcode: 76205
     * */

    //including the connection to the page
    include 'connect.php';
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

        <form action="place_orders.php" method="post">

            <table>

                    <?php

                        /*
                         * Open the session, check if the other page has passed the message or not and if it has then display it once then unset the session
                         * */
                        session_start(); //starting the session

                        //$_SESSION['msg'] - session variable msg passed from other pages
                        if (isset($_SESSION['msg'])){

                            echo "<font color = 'red'>".$_SESSION['msg']."</font>";
                            session_unset();

                        }

                    ?>

                    <tr>

                        <td>

                            <h1>Product Details</h1>

                        </td>

                    </tr>

                    <?php

                        /*
                         * Products are dynamically showing here from the database
                         *
                         * $result - getting all the products and it's details present in the database
                        */
                        $result = mysqli_query($mysqli, "SELECT * FROM products");

                        if ($result) {

                            /*
                             * Iterating through the result from the above query
                             * */
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <tr>
                                    <td>

                                        <img class="images" src="images/<?= $row['product_image'] ?>"
                                             alt="<?= $row['product_image'] ?>">
                                        <br>
                                        <br>
                                    </td>

                                    <td>

                                        <table>

                                            <tr>
                                                <td><b style="font-size: x-large"><?php echo $row['product_name'] ?></b></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $row['product_description'] ?><br><br></td>
                                            </tr>
                                            <tr>
                                                <td>Price: <?php echo $row['price'] ?></td>
                                            </tr>

                                            <tr>
                                                <td>Size:
                                                    <select name="size[]">

                                                        <option value="Small" selected>Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>

                                                    </select>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>Color:
                                                    <select name="color[]">

                                                        <option value="Red" selected>Red</option>
                                                        <option value="Black">Black</option>
                                                        <option value="White">White</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Quantity: <input type="number" min="0" name="quantity[]" value="0">
                                                    <!-- Submit product id and the price as hidden values -->
                                                    <input type="hidden" name="product_id[]" value="<?=$row['id']?>">
                                                    <input type="hidden" name="price[]" value="<?php echo $row['price'] ?>">
                                                </td>
                                            </tr>

                                        </table>
                                        <br>
                                        <br>
                                    </td>
                                </tr>

                    <?php
                            }

                        }

                    ?>


                <tr>

                    <td>

                        <br>
                        <br>
                        <h1>Customer Details</h1>

                    </td>

                </tr>
                <tr>
                    <td>
                        Customer Id:
                    </td>
                    <td>
                        <input type="number" name="customer_id" min="0" value="0">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><br>
                        <b>If you don't have a customer id,<br>
                        please enter your details so that <br>
                            we can create one for you.</b><br><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        First Name:
                    </td>
                    <td>
                        <!--- First name validation (Should be only alphabetic) -->
                        <input type="text" name="first_name" pattern="[a-zA-Z]*" title="Your name should only contain alphabetic characters">

                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name:
                    </td>
                    <td>
                        <!--- Last name validation (Should be only alphabetic) -->
                        <input type="text" name="last_name" pattern="[a-zA-Z]*" title="Your name should only contain alphabetic characters">

                    </td>
                </tr>
                <tr>
                    <td>
                        Zipcode:
                    </td>

                    <td>

                        <!--- Zipcode validation (Should be only numeric and with 5 digits) -->
                        <input type="text" name="zipcode" pattern="[1-9][0-9]{4}" title="Zipcode should be 5-digit numeric character">

                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <br>

                        <!--- Place Order button submits the file and places order -->
                        <!--- Cancel button cancels the current order -->

                        <button type="submit" value="Submit">Place Order</button>
                        <button type="reset" value="Cancel">Cancel</button>
                    </td>
                </tr>

            </table>

        </form>

    </div>

</BODY>

</HTML>