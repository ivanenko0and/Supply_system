<?php

function register(){
    require "dataBaseModule.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST["name"];
        $contact = $_POST["contact"];
        $address = $_POST["address"];
        $login = $_POST["login"];
        $pass = $_POST["pass"];
        $company_type = $_POST["company_type"];

        $results = $conn->query('SELECT * FROM account WHERE Login="'. $login. '"');
        
        if($results->num_rows < 1){
            $conn->query('INSERT INTO account(Name, Login, Password, Head_office_address, Contact, Description, Type) 
            VALUES ("'. $name. '", "'. $login. '", "'. $pass. '", "'. $address. '", "'. $contact. '", "", "'. $company_type. '" );');

            echo'
            <form name="authPost" id="authPost" action="profile.php" method="post">
            <input type="hidden" name="login" value="'.$login .'">
            </form>
            <script>
                document.authPost.submit();
            </script>
            ';
        }else{
            return "accountExistsError";
        }

    }    
}

?>