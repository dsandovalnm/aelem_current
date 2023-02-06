<?php
    include_once('includes/header.php');    

    $total = 0;

    if(isset($_SESSION['cart']['transaction_key'])){
        $money = $_SESSION['cart']['country'];
    }else{
        $money = $country === 'Argentina' ? 'ARS' : 'USD';
    }

    $total = isset($_SESSION['cart']['price']) ? $_SESSION['cart']['price'] : '0';

?>
<body>

    <?php include('includes/nav-bar.php'); 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : '';
    ?>

    <section class="section-cart">
        <h1 class="title text-center">Carrito de Compra</h1>
        <div class="container cart-content">
            <?php if(isset($_SESSION['cart'])) : ?>
                <div class="cart-susbcription cart-box d-flex">
                    <div class="subscription-box py-2">
                        <div class="subscription-image no-mobile">
                            <img src="/img/subscription-img/<?php echo $cart['image'] ?>" alt="Image Subscription Aelem">
                        </div>
                        <div class="subscription-description col-6">
                            <h6><?php echo $cart['name'] ?></h6>
                            <p>Descripción del tipo de curso o suscripción</p>
                        </div>
                        <div class="subscription-price">
                            <p class="title">$ <?php echo $cart['price'] . ' ' .$money ?> </p>
                        </div>
                        <div class="subscription-remove">
                            <form action="cart.php" method="post">
                                <button style="padding: 5px" class="btn btn-danger rounded" type="submit" name="submit_form" id="submit_form" value="remove_course">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="cart-payment-info cart-box">
                    <div class="subscription-payment">
                        <h6 class="title">Resumen de Compra</h6>
                        <hr>
                        <div class="summary-payment">
                            <p>Subtotal</p>
                            <p>$ <?php echo $total . ' ' . $money ?></p>
                        </div>
                        <hr>
                        <div class="total-payment">
                            <p class="title">Total</p>
                            <p class="title">$ <?php echo $total . ' ' . $money ?></p>
                        </div>
                        <div class="pay-btn">
                            <form action="pagar.php?load=verifyData" method="post">
                                <input type="hidden" id="money" name="money" value="<?php echo $money ?>">
                                <input type="hidden" id="email" name="email" value="<?php echo isset($_SESSION['auth_user']) ? $_SESSION['auth_user']['email'] : '' ?>">
                                <button type="submit" class="btn btn-info btn-block btn-rounded" name="submitPayment" id="submitPayment" value="payment">Pagar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <h6 class="title">No hay suscripciones agregadas</h6>
                <a href="/cursos" class="btn btn-info btn-rounded">Agregar Suscripción</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer_3.php');?>
    <!-- ***** Footer Area End ***** -->
</body>

</html>