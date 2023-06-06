<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="http://fonts.cdnfonts.com/css/open-sans" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/lato" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <?php
    require "modules\\menuModule.php";
    require "modules\\orderingModule.php";
    ?>
    <title>Supply.ua</title>
</head>
<body>
    <header>
        <?php menu(); ?>
    </header>
    <main>
        <div class="container">
            <div class="content_block">
                <form action="orders.php" method="post">
                    <input type="hidden" name="login" value="<?php echo $_POST["login"] ?>">
                    <input type="submit" id="return_button2" value="< Назад">
                </form>
                <h4 align="center"> Оформлення замовлення: </h4>
                <?php ordering(); ?>
            </div>
        </div>
    </main>
</body>
</html>