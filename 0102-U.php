<?php

$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);
if (isset($mydata["id"]) && isset($mydata["price"]) && isset($mydata["total"]) && isset($mydata["photo"]) && isset($mydata["remark"])) {
    if ($mydata["id"] != "" && $mydata["price"] != "" && $mydata["total"] != "" && $mydata["photo"] != "" && $mydata["remark"] != "") {
        $p_id = $mydata["id"];
        $p_price = $mydata["price"];
        $p_total = $mydata["total"];
        $p_photo = $mydata["photo"];
        $p_remark = $mydata["remark"];

        require_once("dbtool.php");
        $link = create_connection();

        $sql = "UPDATE product SET Price = '$p_price', Total = '$p_total', Photo = '$p_photo', Remark = '$p_remark' WHERE ID = '$p_id'";

        if (execute_sql($link, "testdb", $sql)) {
            if(mysqli_affected_rows($link) == 1){
                echo '{"state" : true, "message" : "更新成功"}';
            }else{
                echo '{"state" : true, "message" : "無資料被更新"}';
            }
        } else {
            echo '{"state" : false, "message" : "更新失敗與相關錯誤訊息"}';
        }
        mysqli_close($link);
    } else {
        echo '{"state" : false, "message" : "欄位不得為空白"}';
    }
} else {
    echo '{"state" : false, "message" : "欄位錯誤"}';
}
?>