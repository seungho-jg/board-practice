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
    $result = $commentDB->insert_comment($board_num, $usernum, $content);
    if($result) {
        echo "
      <script>location.href='../page/view.php?num=$board_num&page=$page'</script>
    ";
    } else {
        echo "<script>alert('댓글 작성에 실패하였습니다.'); history.go(-1);</script>";
    }
?>