<?php
    $id = $_POST["id"];
    $pass = $_POST["pass"];
    try {
        $conn = mysqli_connect("localhost", "user", "12345", "board");

    } catch(Exception $e) {
        echo "db 연결 오류: ".mysqli_connect_error();
    }
    $sql = "
                select * from members where id='$id';
            ";
    $result = mysqli_query($conn, $sql);

    $num_match = mysqli_num_rows($result);
    if(!$num_match){
        echo "<script>
                window.alert('등록되지 않은 아이디 입니다.');
                history.go(-1);
            </script>
        ";
    } else {
        $row = mysqli_fetch_assoc($result);
        $db_pass = $row["pass"];
        /* 단방향 암호화 */
        $hashed_pass = password_hash($pass, PASSWORD_ARGON2ID);
        if(password_verify($db_pass,$hashed_pass)){
            echo "
                <script>
                    window.alert('비밀번호가 틀립니다!');
                    history.go(-1);
                </script>
            ";
            exit;
        }
        else {
            session_start();
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $row["name"];

            echo "<script>location.href='../index.php'</script>";
        }
    }


    ?>