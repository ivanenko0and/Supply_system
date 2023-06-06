<?php

function ordersList(){

    require "dataBaseModule.php";

    $results = $conn->query('SELECT Id, Type FROM account WHERE Login="'. $_POST["login"].'"');
    $row = $results->fetch_assoc();
    $company_id = $row["Id"];
    $company_type = $row["Type"];

    if($company_type == "Purchaser"){
        echo '<h4 align="center"> Ваші замовлення: </h4>';
        $results = $conn->query('SELECT * FROM purchase_order WHERE Purchaser_Id="'. $company_id.'";');
    }
    if($company_type == "Provider"){
        echo '<h4 align="center"> Клієнтські замовлення: </h4>';
        $results = $conn->query('SELECT * FROM purchase_order WHERE Provider_Id="'. $company_id.'";');
    }
    if($company_type == "Transport"){
        echo '<h4 align="center"> Клієнтські замовлення: </h4>';
        $results = $conn->query('SELECT * FROM purchase_order WHERE Transport_Id="'. $company_id.'";');
    }
    
    while ($row = $results->fetch_assoc()) {

        $results2 = $conn->query('SELECT Name FROM account WHERE Id="'. $row["Purchaser_Id"].'"');
        $row2 = $results2->fetch_assoc();
        $purchaser = $row2["Name"];

        $results2 = $conn->query('SELECT Name FROM account WHERE Id="'. $row["Provider_Id"].'"');
        $row2 = $results2->fetch_assoc();
        $provider = $row2["Name"];

        $results2 = $conn->query('SELECT Name FROM account WHERE Id="'. $row["Transport_Id"].'"');
        $row2 = $results2->fetch_assoc();
        $transport = $row2["Name"];

        $results2 = $conn->query('SELECT Address FROM affiliate WHERE Id="'. $row["Delivery_place_Id"].'"');
        $row2 = $results2->fetch_assoc();
        $address = $row2["Address"];

        echo '
        <div class="order_content_block">
            <p>Замовник: '. $purchaser.'</p>
            <p>Постачальник: '. $provider.'</p>
            <p>Доставщик: '. $transport.'</p>
            <p>Адреса доставки: '. $address.'</p>
            <p>Дата оформлення замовлення: '. $row["Ordering_date"].'</p>
            <p>Крайній термін доставки: '. $row["Delivery_date"].'</p>
            <p>Замовлені товари: </p>
        ';

        $results2 = $conn->query('SELECT * FROM order_product WHERE Order_Id="'. $row["Id"].'" AND Type="Product"');
        while ($row2 = $results2->fetch_assoc()) {
            $results3 = $conn->query('SELECT * FROM commodity WHERE Id="'. $row2["Commodity_Id"].'";');
            $row3 = $results3->fetch_assoc();
            echo '
            <div class="order_row_block row">
                <p> Товар: '.$row3["Name"].'</p>
                <p> Кількість: '.$row2["Number"].'</p>
            </div>
            ';
        }
        
        echo '
        </div><br>
        ';
    }

    
    if($company_type == "Purchaser"){
        echo '
        <form action="ordering.php" method="post">
            <input type="hidden" name="login" value="'. $_POST["login"].'">
            <input type="submit" value="Оформлення замовлень">
        </form>
        ';
    }

    $conn->close();

}

?>