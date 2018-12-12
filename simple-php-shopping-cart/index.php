<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
    case "add":
        if(!empty($_POST["quantity"])) {
            $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
            $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
            
            if(!empty($_SESSION["cart_item"])) {
                if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                    }
                } else {
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                }
            } else {
                $_SESSION["cart_item"] = $itemArray;
            }
        }
    break;
    case "remove":
        if(!empty($_SESSION["cart_item"])) {
            foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);              
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
            }
        }
    break;
    case "empty":
        unset($_SESSION["cart_item"]);
    break;  
}
}
?>
<HTML>
<HEAD>
<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../node_modules/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css">

<TITLE>Simple PHP Shopping Cart</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
<link href="styles.css" rel="stylesheet">

<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase-firestore.js"></script>
</HEAD>
<BODY>

<nav class="navbar navbar-dark navbar-expand-sm fixed-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar">
            <span class="navbar-toggler-icon"></span>
        </button>           
        <a class="navbar-brand mr-auto" href="#"><img src="product-images/logo.png" height="30" width="41"></a>
        <div class="collapse navbar-collapse" id="Navbar"> 
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.html"><span class="fa fa-home fa-lg"></span> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../aboutus.html"><span class="fa fa-info fa-lg"></span> About</a></li>
                    <li class="nav-item"><a class="nav-link" href="../3DRestaurantMenu/index.html"><span class="fa fa-list fa-lg"></span> Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contactus.html"><span class="fa fa-address-card fa-lg"></span> Contact</a></li>
                    <li class="nav-item active"><a class="nav-link" href="#"><span class="fa fa-shopping-cart fa-lg"></span> Order Online</a></li>
                </ul>  
        </div>         
    </div>
</nav>

<div class="container">
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>
<!--
<div class="row">
<div class="col-12 col-sm-8">
<div></div> 
</div>  
<div class="col-12 col-sm-2">
<button type="button" id="btndeliver">Deliver Food</button>
</div>
<div class="col-12 col-sm-2">
<a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
</div>
</div>
-->
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>  
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>   
<?php       
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
        ?>
            <tr>
            <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
            <td><?php echo $item["code"]; ?></td>
            <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
            <td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
            <td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
            <td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
            </tr>
            <?php
            $total_quantity += $item["quantity"];
            $total_price += ($item["price"]*$item["quantity"]);
    }
        ?>

    <tr>
    <td colspan="2" align="right">Total:</td>
    <td align="right"><?php echo $total_quantity; ?></td>
    <td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
    <td></td>
    </tr>
    </tbody>
    </table>

    <div class="row">
        <div class="col-12 col-sm-8">
            <textarea type="text" class="form-control" id="deliveryAdd" name="delAdd" rows="2" placeholder="Delivery Address Here..."></textarea>   
        </div>  
            <div class="col-12 col-sm-2">
            <button type="button" id="btndeliver">Deliver Food</button>
            </div>
        <div class="col-12 col-sm-2">
        <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>
        </div>
    </div>  

    <?php
    } else {
    ?>
    <div class="no-records">Your Cart is Empty</div>
    <?php 
    }
    ?>
    </div>

<div class="row">
<div id="product-grid">
    <div class="txt-heading">Products</div>
    <?php
    $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
    if (!empty($product_array)) { 
        foreach($product_array as $key=>$value){
    ?>
        <div class="product-item">
            <form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
            <div class="product-image img-thumbnail align-self-center"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
            <div class="product-tile-footer">
             <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
             <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
             <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
            </div>
            </form>
        </div>
    <?php
        }
    }
    ?>
</div>
</div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">             
            <div class="col-4 offset-1 col-sm-2">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="../index.html">Home</a></li>
                    <li><a href="../aboutus.html">About</a></li>
                    <li><a href="../3DRestaurantMenu/index.html">Menu</a></li>
                    <li><a href="../contactus.html">Contact</a></li>
                </ul>
            </div>
            <div class="col-7 col-sm-5">
                <h5>Our Address</h5>
                <address>
                    Morena Link Rd,<br>   
                    IIITM Campus,<br>
                    Gwalior, Madhya Pradesh<br>
                    <i class="fa fa-phone fa-lg"></i>: +852 1234 5678<br>
                    <i class="fa fa-fax fa-lg"></i>: +852 8765 4321<br>
                    <i class="fa fa-envelope fa-lg"></i>: 
                    <a href="mailto:confusion@food.net">confusion@food.net</a>
                </address>
            </div>
            <div class="col-12 col-sm-4 align-self-center">
                <div class="text-center">
                    <a class="btn btn-social-icon btn-google" href="http://google.com/+"><i class="fa fa-google-plus"></i></a>
                    <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class="fa fa-facebook"></i></a>
                    <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/"><i class="fa fa-linkedin"></i></a>
                    <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-social-icon btn-google" href="http://youtube.com/"><i class="fa fa-youtube"></i></a>
                    <a class="btn btn-social-icon" href="mailto:"><i class="fa fa-envelope-o"></i></a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">             
            <div class="col-auto">
                <p>© Copyright 2018 Ristorante Con Fusion</p>
            </div>
        </div>
    </div>
</footer>

<script src="../node_modules/jquery/dist/jquery.slim.min.js"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript"> 
var config = {
                        apiKey: "#copy apiKey from your account",
                        authDomain: "#use your value",
                        databaseURL: "use yours",
                        projectId: "use yours",
                        storageBucket: "use yours",
                        messagingSenderId: "use yours"

                };
        firebase.initializeApp(config);
        const db = firebase.firestore();
        db.settings( { timestampsInSnapshots: true });

        var item1 = <?php echo json_encode($_SESSION["cart_item"]); ?>; 
        //console.log(item1);
        var namearr = new Array();
        var quantityarr = new Array();
        for(var index in item1){
        namearr.push(item1[index]["name"]);
        quantityarr.push(item1[index]["quantity"])
        }   
        var totalquan=<?php echo $total_quantity; ?>;
        var totalprice=<?php echo $total_price; ?>;
        //console.log(totalprice);
        $(document).ready(function() {
            //console.log("abc");
            $('#btndeliver').click(function(e) {
            //alert("Order Placed");
            e.preventDefault();
            $(".error").remove();
            //console.log("xyz");
            var name = $('#deliveryAdd').val();
            var c =0;
            if (name.length < 1) 
            {
                $('#deliveryAdd').after('<span class="error">This field is required</span>');
                c=1;
            }
            if(c==0)
            {
                console.log("eventListener");
                db.collection('orders').add({
                    itemName: namearr,
                    itemQuantity: quantityarr,
                    totalQuantity: totalquan,
                    totalPrice: totalprice,
					deliveryAddress: name
                }).then(function(){
                    console.log("Status saved");
                    alert("Your Order is Placed!!! If You Want You Can Continue Shopping Or To Exit From Cart, Press \"Empty Cart\" Button");
					//<a href="index.php?action=empty"></a>
                }).catch(function(error){
                        console.log("error...error", error);
                                });
            }
            });
        });
</script>  
</BODY>
</HTML>

