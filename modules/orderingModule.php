<?php

function ordering(){

    require "dataBaseModule.php";

    $results = $conn->query('SELECT Id FROM account WHERE Login="'. $_POST["login"].'"');
    $row = $results->fetch_assoc();
    $company_id = $row["Id"];

    $results = $conn->query('SELECT Id FROM account WHERE Name="'. $_POST["provider"].'"');
    $row = $results->fetch_assoc();
    $provider_id = $row["Id"];

    $results = $conn->query('SELECT Id FROM account WHERE Name="'. $_POST["transport"].'"');
    $row = $results->fetch_assoc();
    $transport_id = $row["Id"];

    $results = $conn->query('SELECT Id FROM commodity WHERE Name="'. $_POST["transportation_type"].'" AND Owner_Id="'. $transport_id.'"; ');
    $row = $results->fetch_assoc();
    $transportation_type_id = $row["Id"];

    $order_id = $_POST["order_id"];
    if($provider==""){
        $results = $conn->query('SELECT Id FROM purchase_order;');
        while ($row = $results->fetch_assoc()) {
            $order_id = $row["Id"]+1;
        }
    }

    $results = $conn->query('SELECT * FROM account WHERE Type="Provider" AND NOT Id="'. $company_id.'";');
    echo '<datalist id="companies-providers">';
    while ($row = $results->fetch_assoc()) {
        echo '<option value="'. $row["Name"].'">';
    }
    echo '</datalist>';

    $results = $conn->query('SELECT * FROM account WHERE Type="Transport" AND NOT Id="'. $company_id.'";');
    echo '<datalist id="transport-companies">';
    while ($row = $results->fetch_assoc()) {
        echo '<option value="'. $row["Name"].'">';
    }
    echo '</datalist>';

    $results = $conn->query('SELECT * FROM affiliate WHERE Company_Id="'. $company_id.'"');
    echo '<datalist id="affiliates">';
    while ($row = $results->fetch_assoc()) {
        echo '<option value="'. $row["Address"].'">';
    }
    echo '</datalist>';

    $provider = $_POST["provider"];
    $transport = $_POST["transport"];
    $address = $_POST["address"];
    $date =  $_POST["date"];

    $product = $_POST["product"];
    $number = $_POST["number"];

    $transportation_type = $_POST["transportation_type"];

    $commentary = $_POST["commentary"];


    echo '
    <form action="'. htmlentities($_SERVER["PHP_SELF"]).'" method="post">
        <div class="order_block">
            <div class="order_text_block"> <p>Підприємство-постачальник: </p></div>
            <div><input type="text" list="companies-providers" name="provider" value="'. $provider.'"><span class="required2">*</span></div>
            <div> <input type="submit" value="Обрати"></div>
        </div>
    ';

    if($provider_id!=""){
        $results = $conn->query('SELECT * FROM affiliate WHERE Company_Id="'. $provider_id.'"');

        echo '<datalist id="products">';
        while ($row = $results->fetch_assoc()) {
            $affiliate_id = $row["Id"];

            $results2 = $conn->query('SELECT * FROM commodity WHERE Owner_Id="'. $row["Id"].'"');
            while ($row2 = $results2->fetch_assoc()) {
                echo '<option value="'. $row2["Name"].'">';
            }
        }
        echo '</datalist>';

        echo '
        <div class="order_content_block">
        <div class="order_row_block">
            <div><p>Товар: </p><input type="text" list="products" name="product"><span class="required2">*</span></div>
            <div><p>Кількість: </p><input type="text" name="number"><span class="required2">*</span></div>
            <div> <input type="submit" value="Додати"></div>
        </div>
        ';

        if($product!="" && $number!=""){

            try{
                $number = (int) $number;
                if($number <= 0){
                    throw new Exception();
                }

                $results = $conn->query('SELECT Id FROM commodity WHERE Name="'. $_POST["product"].'"');
                if($results->num_rows < 1){
                    echo '<p class="error_text"> Введений вами товар відсутній!</p>';
                }else{
                    $row = $results->fetch_assoc();
                    $commodity_id = $row["Id"];
        
                    $conn->query('INSERT INTO order_product(Order_Id, Commodity_Id, Number, Type) VALUES ("'. $order_id. '", "'. $commodity_id.'", "'. $number.'", "Product")');
                }
            }catch(Exception $ex){
                echo '<p class="error_text"> Введіть коректну кількість товару!</p>';
            }
            
        }

        echo '<h5> Список товарів для замовлення: </h5>';
        $results = $conn->query('SELECT * FROM order_product WHERE Order_Id="'. $order_id.'" AND Type="Product";');
        if($results->num_rows > 0){
            
            while ($row = $results->fetch_assoc()) {
                $results2 = $conn->query('SELECT * FROM commodity WHERE Id="'. $row["Commodity_Id"].'"');
                $row2 = $results2->fetch_assoc();
    
                echo '
                <div class="order_row_block row">
                    <div class="order_text_block"><p> Назва: '. $row2["Name"].'</p></div>
                    <div><p> Кількість: '. $row["Number"].'</p></div>
                    <div><p> Вартість: '. $row["Number"]*$row2["Cost"].' грн. </p></div>
                </div>
                ';
            }
            
        }
        echo '<br></div>';
    }

    echo '
        <div class="order_block">
            <div class="order_text_block"> <p>Транспортна компанія: </p></div>
            <div><input type="text" list="transport-companies" name="transport" value="'. $transport.'"><span class="required2">*</span></div>
            <div> <input type="submit" value="Обрати"></div>
        </div>
    ';

    if($transport_id!=""){
        $results = $conn->query('SELECT * FROM affiliate WHERE Company_Id="'. $transport_id.'"');

        echo '<datalist id="transportation_type">';
        while ($row = $results->fetch_assoc()) {
            $affiliate_id = $row["Id"];

            $results2 = $conn->query('SELECT * FROM commodity WHERE Owner_Id="'. $row["Id"].'"');
            while ($row2 = $results2->fetch_assoc()) {
                echo '<option value="'. $row2["Name"].'">';
            }
        }
        echo '</datalist>';

        echo '
        <div class="order_block">
            <div class="order_text_block"> <p>Тип транспорту: </p></div>
            <div><input type="text" list="transportation_type" name="transportation_type" value="'. $transportation_type.'"><span class="required2">*</span></div>
            <div style="width:100px"> </div>
        </div>
    ';
    }

    echo '
        <div class="order_block">
            <div class="order_text_block"> <p>Місце доставки (адреса філії): </p></div>
            <div><input type="text" list="affiliates" name="address" value="'. $address.'"><span class="required2">*</span></div>
            <div style="width:100px"> </div>
        </div>
        <div class="order_block">
            <div class="order_text_block"> <p>Крайній термін доставки: </p></div>
            <div><input type="date" name="date" min="'. date("Y-m-d").'" value="'. $date.'"><span class="required2">*</span></div>
            <div style="width:100px"> </div>
        </div>
        <br>

        <input type="hidden" name="login" value="'. $_POST["login"].'">
        <p><input type="submit" name="submit_order" value="Оформити замовлення"></p>
    </form>
    ';

    if(isset($_POST['submit_order'])){

        $results = $conn->query('SELECT Id FROM affiliate WHERE Address="'. $_POST["address"].'"');
        $row = $results->fetch_assoc();
        $address_id = $row["Id"];

        $results = $conn->query('SELECT * FROM order_product WHERE Order_Id="'. $order_id. '"');

        if($company_id != "" && $provider_id !="" && $transport_id !="" && $address_id !="" && $date !="" && $_POST["transportation_type"]!="" && $results->num_rows > 0){
            $conn->query('INSERT INTO purchase_order(Purchaser_Id, Provider_Id, Transport_Id, Delivery_place_Id, Ordering_date, Delivery_date) 
            VALUES ("'. $company_id. '", "'. $provider_id.'", "'. $transport_id.'", "'. $address_id.'", "'. date("Y-m-d").'", "'. $date.'")');
    
            $conn->query('INSERT INTO order_product(Order_Id, Commodity_Id, Number, Type) VALUES ("'. $order_id. '", "'. $transportation_type_id.'", "0", "Transport")');
    
            echo'
            <form name="authPost" id="authPost" action="orders.php" method="post">
            <input type="hidden" name="login" value="'. $_POST["login"].'">
            <script>
                document.authPost.submit();
            </script>
            </form>
            ';
        }else{
            echo '<p class="error_text">Ви ввели не всі параметри замовлення!</p>';
        }
    }

    $conn->close();

}

?>