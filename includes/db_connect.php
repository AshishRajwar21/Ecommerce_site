<?php
    //host,username,password,databasename
    $conn = mysqli_connect("sql111.infinityfree.com","if0_34952357","4HV7Jy6dQVeS6","if0_34952357_ecomcart");
    if (mysqli_connect_errno()){
        echo "Connection Failed! ";
        return;
    }