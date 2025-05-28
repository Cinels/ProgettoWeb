<!DOCTYPE html>
<html lang="it">
    <head>
        <title><?php echo $templateParams["titolo"]; ?></title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css" />
    </head>
    <body>
        <header>
            <a href="../pages/index.php"><img src="../../resources/logo.png" alt="Home Page"/></a>

            <label>
                <img src="../../resources/search.png" alt="Search"/>
                <input type="text" name="search"/>
            </label>

            <!-- varie opzioni in base al login -->
            <?php if(false/* no login */): ?>
                <a href="../pages/login.php"><img src="../../resources/favourite.png" alt="Favourite List"/></a>
                <a href="../pages/login.php"><img src="../../resources/cart.png" alt="Shopping Cart"/></a>
                <a href="../pages/login.php"><img src="../../resources/orders.png" alt="My Orders"/></a>
                <a href="../pages/login.php"><img src="../../resources/profile.png" alt="My Profile"/></a>
            <?php else: ?>
                <?php if(true/* login cliente */): ?>
                    <a href="../pages/favourite.php"><img src="../../resources/favourite.png" alt="Favourite List"/></a>
                    <a href="../pages/cart.php"><img src="../../resources/cart.png" alt="Shopping Cart"/></a>
                <?php else: ?>
                    <a href="../pages/add_product.php"><img src="../../resources/add.png" alt="Add Product"/></a>
                <?php endif; ?>
                <a href="../pages/orders.php"><img src="../../resources/orders.png" alt="My Orders"/></a>
                <a href="../pages/profile.php"><img src="../../resources/profile.png" alt="My Profile"/></a>
            <?php endif; ?>
        </header>
        
        <footer>
            <p>Tecnologie Web - A.A. 2024/2025</p>
        </footer>

    </body>
</html>