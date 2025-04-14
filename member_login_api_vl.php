<?php
//{"username" : "user1", "password" : "123"}
// {"state" : true, "message" : "登入成功", "data":"使用者資訊"}
// {"state" : false, "message" : "登入失敗與相關錯誤訊息"}
// {"state" : false, "message" : "欄位錯誤"}
// {"state" : false, "message" : "欄位不得為空白"}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("php://input");
    $input = json_decode($data, true);
    if (isset($input["username"], $input["password"])) {
        $p_username = trim($input["username"]);
        $p_password = trim($input["password"]);
        if ($p_username && $p_password) {
            $conn = mysqli_connect('localhost', 'owner01', '123456', 'testdb');
            if (!$conn) {
                echo json_encode(["state" => false, "message" => "連線失敗!"]);
                exit;
            }

            $stmt = $conn->prepare("SELECT * FROM  member WHERE Username = ?");
            $stmt->bind_param("s", $p_username); //一定要傳遞變數
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                //抓取密碼執行password_verify比對
                $row = $result->fetch_assoc();
                if(password_verify($p_password, $row["Password"])){
                    //比對成功
                    //產生UID並更新資料庫
                    $uid01 = substr(hash('sha256', time()), 12 , 4) . substr(bin2hex(random_bytes(8)), 4, 6);
                    $update_stmt = $conn->prepare("UPDATE member SET Uid01 = ? WHERE Username = ?");
                    $update_stmt->bind_param('ss', $uid01, $p_username);
                    if($update_stmt->execute()){
                        // unset($row["Password]);
                        //取得登入時的使用者資訊
                        $user_stmt = $conn->
                        prepare("SELECT Username, Email, Uid01, Created_at FROM member WHERE Username = ?");
                        $user_stmt->bind_param("s", $p_username);//一定要傳遞變數
                        $user_stmt->execute();
                        $user_data = $user_stmt->get_result()->fetch_assoc();

                        echo json_encode(["state" => true, "message" => "登入成功", "data" => $user_data]);
                    }else{
                        echo json_encode(["state" => false, "message" => "登入失敗,UID更新失敗"]);
                    }

                }else{
                    //比對失敗
                    echo json_encode(["state" => false, "message" => "登入失敗,密碼錯誤"]);
                }
                
            } else {
                echo json_encode(["state" => false, "message" => "登入失敗,該帳號不存在"]);
            }
            $stmt->close();
            $conn->close();
        } else {
            echo json_encode(["state" => false, "message" => "欄位不得為空白!"]);
        }
    } else {
        echo json_encode(["state" => false, "message" => "欄位錯誤!"]);
    }
} else {
    echo json_encode(["state" => false, "message" => "無效的請求方法!"]);
}
