<?php
    //input: {"pname" : "XXX", "price" : "XXX", "total" : "XXX",  "photo" : "XXX", "remark" : "XXX"}

    $data = file_get_contents("php://input", "r");
    // echo $data;
    $mydata = array();
    $mydata = json_decode($data, true);
    // echo $mydata["pname"]."<BR>";
    // echo $mydata["price"]."<BR>";
    // echo $mydata["total"]."<BR>";
    // echo $mydata["photo"]."<BR>";
    // echo $mydata["remark"]."<BR>";

    if(isset($mydata["pname"]) && isset($mydata["price"]) && isset($mydata["total"]) && isset($mydata["photo"]) && isset($mydata["remark"])){
        if($mydata["pname"] != "" && $mydata["price"] != "" && $mydata["total"] != "" && $mydata["photo"] != "" && $mydata["remark"] != ""){

    $p_pname  = $mydata["pname"];
    $p_price  = $mydata["price"];
    $p_total  = $mydata["total"];
    $p_photo  = $mydata["photo"];
    $p_remark = $mydata["remark"];
    

    $servsername = "localhost";
    $username = "owner01";
    $password = "123456";
    $dbname = "testdb";

    //建立連線
    $conn = mysqli_connect($servsername, $username, $password, $dbname);
    //確認連線
    if(!$conn){
        die("連線錯誤" . mysqli_connect_error());
    }

    $sql = "INSERT INTO product(Pname, Price, Total, Photo, Remark) VALUES('$p_pname', '$p_price', '$p_total', '$p_photo', '$p_remark')";
    if(mysqli_query($conn, $sql)){
        echo '{"state" : true, "message" : "新增成功"}';
    }else{
        echo '{"state" : false, "message" : "新增失敗'.$sql.' <br>錯誤訊息: '. mysqli_error($conn).'"}';
    }
    mysqli_close($conn);  

    }else{ 
        echo '{"state" : false, "message" : "欄位不得為空白"}';
    }
    }else{
        echo '{"state" : false, "message" : "欄位錯誤"}';
    }

    
?>
