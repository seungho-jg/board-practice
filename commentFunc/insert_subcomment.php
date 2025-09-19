<?php
    include "../global/session.php";
    include "../DB/comment.php";
    $commentDB =new commentDB();

    $board_num = $_GET["board_num"];
    $content = $_POST["content"];
    $depth = $_POST["parent_depth"];
    $parent_num = $_POST["parent_num"]; // 부모로 등록할 댓글 아이디값


    header("Content-Type: application/json");

    if(!$userid) {
        $data = [
            "status" => "fail",
            "message" => "댓글은 로그인 이후 사용해 주세요"
        ];

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    $result_1 = $commentDB->insert_subcomment($board_num, $usernum, $content, $depth+1, $parent_num, 0);
    $result_2 = $commentDB->add_child_comment($parent_num); // 부모의 자식댓글 수 1증가

    if($result_1 && $result_2) {
        $data = [
            "status" => "success",
            "message" => "댓글 작성에 성공하였습니다."
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    } else {
        $data = [
            "status" => "fail",
            "message" => "댓글 작성에 실패했습니다."
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
?>
