<?php
    include "../global/session.php";

    $id = $_GET["id"];
    $num = $_GET["num"];
    $page = $_GET["page"];
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    include "../DB/board.php";
    $boardDB = new boardDB();


    if ($userid == $id){
        $result = $boardDB->update($num, $subject, $content);
        if($result){
            echo "<script>location.href='/board/page/board_list.php?page=$page'</script>";
        } else {
            echo "<script>alert('게시글을 수정에 실패했습니다.'); history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('게시글을 수정할 권한이 없습니다.!'); history.go(-1);</script>";
    }
