<?php

function menu(){
    echo '
    <div id="logo">supply.ua</div>
    <div id="blank"></div>
    ';
    if ($_POST["login"] == NULL){
        if(htmlentities($_SERVER["PHP_SELF"])=="/profile.php" || htmlentities($_SERVER["PHP_SELF"])=="/commodity.php" || 
        htmlentities($_SERVER["PHP_SELF"])=="/orders.php" || htmlentities($_SERVER["PHP_SELF"])=="/ordering.php"){
            echo '
            <form name="authPost" id="authPost" action="index.php" method="post"></form>
            <script>
                document.authPost.submit();
            </script>
            ';
        }else{
            echo '
            <nav>
                <form action="partners.php" class="nav_item"><input class="nav_item" type="submit" value="Наші партнери"></form>
                <form action="authorization.php" class="nav_item"><input class="nav_item" type="submit" value="Увійти"></form>
                <form action="registration.php" class="nav_item"><input class="nav_item" type="submit" value="Зареєструватись"></form>
            </nav>
            ';
        }
    }else{
        echo '
        <nav>
            <form action="partners.php" class="nav_item" method="post">
                <input type="hidden" name="login" value="'.$_POST["login"] .'">
                <input class="nav_item" type="submit" value="Наші партнери">
            </form>
            <form action="orders.php" class="nav_item" method="post">
                <input type="hidden" name="login" value="'.$_POST["login"] .'">
                <input class="nav_item" type="submit" value="Замовлення">
            </form>
            <form action="commodity.php" class="nav_item" method="post">
                <input type="hidden" name="login" value="'.$_POST["login"] .'">
                <input class="nav_item" type="submit" value="Облік майна">
            </form>
            <form action="profile.php" class="nav_item" method="post">
                <input type="hidden" name="login" value="'.$_POST["login"] .'">
                <input class="nav_item" type="submit" value="Профіль">
            </form>
            <form action="index.php" class="nav_item">
                <input class="nav_item" type="submit" value="Вийти">
            </form>
        </nav>
        ';
    }
}

?>