<?php
    include "global/session.php";
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
                echo "<span><a href='page/member_register_form.php'>회원가입</a></span>";
                echo "<span> | </span>";
                echo "<span><a href='page/member_login_form.php'>로그인</a></span>";
            } else {
                $logged = $username."(".$userid.")";
                echo "<span> $logged </span>";
                echo "<span> | </span>";
                echo "<span><a href='memberFunc/logout.php'>로그아웃</a></span>";
                echo "<span> | </span>";
                echo "<span><a href='page/member_modify_form.php'>정보수정</a></span>";
            }
        ?>
    </div>
    <iframe class="frame" src="page/board_list.php" title="board_form"></iframe>

</div>
</body>
</html>