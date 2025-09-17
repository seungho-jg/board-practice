
<?php
    $id = $_GET["id"];
    header("Content-Type: application/json");

    if(!$id) {
        $data = [
                "status" => "fail",
                "message" => "아이디를 입력해주세요"
        ];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    } else {
        try{
            $conn = mysqli_connect("localhost", "user", "12345", "board");
        } catch(Exception $e) {
            echo "연결오류: ".mysqli_connect_error();
        }
        $sql = "select * from members where id='$id'";
        $result = mysqli_query($conn, $sql);


        $num_record = mysqli_num_rows($result);

        if($num_record == 0){
            $data = [
                "status" => "success",
                "message" => "아이디가 사용가능합니다."
            ];
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        else {
            $data = [
                "status" => "fail",
                "message" => "아이디가 사용 불가능합니다."
            ];
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>
