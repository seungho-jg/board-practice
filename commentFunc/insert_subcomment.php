<?php
    include "../global/session.php";
    include "../DB/comment.php";
    $commentDB =new commentDB();

    if(!$userid) {
        echo "<script>
                    alert('댓글은 로그인 이후 사용해 주세요');
                    history.go(-1);
                  </script>";
        exit;
    }

    $content = $_POST["content"];
    $board_num = $_GET["board_num"];
    $page = $_GET["page"];

    echo "subcomment";
?>
