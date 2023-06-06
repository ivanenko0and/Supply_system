<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="http://fonts.cdnfonts.com/css/open-sans" rel="stylesheet">
    <link href="http://fonts.cdnfonts.com/css/lato" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <?php
    require "modules\\registrationModule.php";
    ?>
    <title>Supply.ua</title>
</head>
<body>
    <header>
        <div id="logo">supply.ua</div>
        <div id="blank"></div>
        <nav></nav>
    </header>
    <main>
        <div class="container">
            <div class="authorization_block">
                <form action="index.php" method="post">
                    <input type="submit" id="return_button" value="< Назад">
                </form>

                <?php 
                $name = $_POST["name"];
                $contact = $_POST["contact"];
                $address = $_POST["address"];
                $login = $_POST["login"];
                $pass = $_POST["pass"];
                $company_type = $_POST["company_type"];

                $error = register(); 
                ?>
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" name="registerForm" method="post">
                    <h4 align=center>Реєстрація</h4>
                    <input type="text" placeholder="Назва" name="name" value="<?php echo $name;?>" required><span class="required1">*</span>
                    <input type="text" placeholder="Контакти" name="contact" value="<?php echo $contact;?>" required><span class="required1">*</span>
                    <input type="text" placeholder="Адреса головного офісу" name="address" value="<?php echo $address;?>" required><span class="required1">*</span>
                    <input type="text" placeholder="Логін" name="login" value="<?php echo $login;?>" required><span class="required1">*</span>
                    <input type="password" placeholder="Пароль" name="pass" value="<?php echo $pass;?>" required><span class="required1">*</span>

                    <p>Тип підприємства:<span class="required2">*</span></p>
                    <div>
                        <input type="radio" id="company_type1" name="company_type" value="Purchaser" required>
                        <label for="company_type1">Замовник</label>
                        <input type="radio" id="company_type2" name="company_type" value="Provider" required>
                        <label for="company_type2">Постачальник</label>
                        <input type="radio" id="company_type3" name="company_type" value="Transport" required>
                        <label for="company_type3" style="width:15px;">Доставник</label>
                    </div>

                    <p class="error_text"><?php 
                        if($error == "accountExistsError")
                        echo "Акаунт з таким логіном вже існує";?></p>

                    <input type="submit" class="input_text" value="Зареєструватись">
                </form>
            </div>
        </div>
    </main>
</body>
</html>