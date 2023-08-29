<?php
    $conn = mysqli_connect("127.0.0.1","root","","ecommerce");
    if (mysqli_connect_errno()){
        echo "Connection Failed! ";
        return;
    }