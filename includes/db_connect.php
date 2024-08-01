<?php
    //host,username,password,databasename
    $conn = mysqli_connect("sql312.infinityfree.com","if0_37022636","uX4mPwzoPMcBIW","if0_37022636_ecommerce");
    //$conn = mysqli_connect("localhost","root","","ecommerce");
    if (mysqli_connect_errno()){
        echo "Connection Failed! ";
        return;
    }