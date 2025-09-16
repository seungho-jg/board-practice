<?php
    session_start();
    if(isset($_SESSION["userid"]))
        $userid = $_SESSION["userid"];
    else
        $userid = "";
    if(isset($_SESSION["username"]))
        $username = $_SESSION["username"];
    else
        $username = "";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 홈</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="header">
    <h3 class="logo">
        <a href="index.php">게시판</a>
    </h3>
    <div class="top">
        <?php
            if(!$userid) {
                echo "<span><a href='page/register_form.php'>회원가입</a></span>";
                echo "<span> | </span>";
                echo "<span><a href='page/login_form.php'>로그인</a></span>";
            } else {
                $logged = $username."(".$userid.")";
                echo "<span> $logged </span>";
                echo "<span> | </span>";
                echo "<span><a href='func/logout.php'>로그아웃</a></span>";
                echo "<span> | </span>";
                echo "<span><a href='page/modify_form.php'>정보수정</a></span>";
            }
        ?>
    </div>

</div>
</body>
</html>