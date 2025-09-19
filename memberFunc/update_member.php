<?php

    include "../DB/member.php";
    $memberDB = new memberDB();

    $id = $_GET["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $result = $memberDB->update($id, $name, $pass, $email);

    if($result) {
//        echo "id: $id, name: $name, pass: $pass, email: $email";
        session_start();
        $_SESSION["username"] = $name;
        echo "<script>location.href='../index.php'</script>";
    } else {
        echo "<script>
                window.alert('업데이트 실패');
                history.go(-1);
              </script>";
    }
    ?>

