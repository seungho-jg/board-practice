<?php
    session_start();
    if (!isset($_SESSION["view"])){
        $_SESSION["view"] = "";
    }
    if(isset($_SESSION["usernum"]) && isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
        $userid = $_SESSION["userid"];
        $username = $_SESSION["username"];
        $usernum = $_SESSION["usernum"];
    }
    else {
        $userid = "";
        $username = "";
        $usernum = "";

        // 비회원일 경우 쿠키 발급(뷰 카운팅용)
        if(!isSet($_COOKIE["non_member_cookie"])){
            $cookie_random = random_bytes(10);
            setcookie("non_member_cookie", $cookie_random, time() + 24*60*60); // 24시간
        } else {
            $non_member_cookie = urlencode($_COOKIE["non_member_cookie"]);
        }

    }
?>