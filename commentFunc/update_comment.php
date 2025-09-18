<?php
    include "../global/session.php";
    include "../DB/comment.php";
    $commentDB = new commentDB();

    if(!$userid) {
        echo "<script>
                    alert('게시판 글쓰기는 로그인 후 이용해 주세요');
                    history.go(-1);
                  </script>";
        exit;
    }
    $board_num = $_GET["board_num"];
    $page = $_GET["page"];
    $comment_num = $_GET["cnum"];

    $content = $_POST["content"];

    $modify_count = $commentDB->findById($comment_num)["modify_count"];

    $result = $commentDB->update_comment($comment_num, $content, $modify_count+1);
    if($result) {
        echo "
          <script>location.href='../page/view.php?num=$board_num&page=$page'</script>
        ";
    } else {
        echo "<script>alert('댓글 수정에 실패하였습니다.'); history.go(-1);</script>";
    }
?>