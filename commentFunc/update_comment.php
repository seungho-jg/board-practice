<?php
    include "../global/session.php";
    include "../DB/comment.php";
    $commentDB = new commentDB();

    $board_num = $_GET["board_num"];

    $content = $_POST["content"];
    $comment_num = $_POST["comment_num"];
    header("Content-Type: application/json");

    if(!$userid) {
        $data = [
            "status" => "fail",
            "message" => "댓글은 로그인 이후 사용해 주세요"
        ];

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    $modify_count = $commentDB->findById($comment_num)["modify_count"];

    $result = $commentDB->update_comment($comment_num, $content, $modify_count+1);
    if($result) {
        $data = [
            "status" => "success",
            "message" => "댓글 수정에 성공하였습니다."
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    } else {
        $data = [
            "status" => "fail",
            "message" => "댓글 수정에 실패했습니다."
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
?>