<?php
    $num = $_GET["num"];
    $page = $_GET["page"];
    $comment_num = $_GET["comment_num"];
    include "../DB/comment.php";
    $commentDB = new commentDB();

    $result = $commentDB->delete_comment($comment_num);

    if ($result) {
        echo "
            <script>
                location.href = '../page/view.php?num=$num&page=$page'
            </script>
        ";
    } else {
       echo "
        <script>
           alert('댓글 삭제에 실패했습니다.');
           location.href = '../page/view.php?num=$num&page=$page';         
        </script>
        ";
    }
?>
