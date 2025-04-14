<?php
    //時間戳記
    echo "************時間戳記***********"."<br>";
    echo time();
    echo "<br>";
    echo date("Ymdhis");
    echo "<br>";

    //密碼加密解密
    echo "************密碼加密解密***********"."<br>";
    echo password_hash("123456", PASSWORD_DEFAULT);
    echo "<br>";
    echo password_hash("123456", PASSWORD_BCRYPT);
    echo "<br>";
    $hashstr = '$2y$10$h95mn0i7wKVSx/ra8PtE9.7RV9Wv/HWhLqrdtjmKPH0jgZG';
    if(password_verify('123456', $hashstr)){
        echo '密碼正確!<BR>';
    }else{
        echo '密碼錯誤!<BR>';
    }

    //UID 登入簽證產生
    echo "************登入簽證產生***********"."<br>";
    echo "uniqid()"."<be>";
    echo uniqid();
    echo "<br>";
    echo "uniqid(time())"."<be>";
    echo uniqid(time());
    echo "<br>";
    echo "hash_md5:" . hash('md5', time());
    echo "<br>";
    echo "hash_sha256:" . hash('sha256', time());
    echo "<br>";
    echo "hash_sha512:" . hash('sha512', time());
    echo "<br>";
    echo "bin2Zhex(random_bytes(4)):" . bin2hex(random_bytes(4));
    echo "<br>";
    //自行設計
    echo "自行設計UID 登入簽證產生 從第13個字 8個字元"."<br>";
    echo substr(hash('sha256', time()), 12 , 4) . substr(bin2hex(random_bytes(8)), 4, 6);
?>