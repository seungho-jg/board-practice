<?php
    include "../DB/member.php";
    $memberDB = new memberDB();

    $id = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $regist_day = date("Y-m-d (H:i)");

    $result = $memberDB->findById($id);
    if(!$result) {
        $memberDB->insert($id, $pass, $name, $email);
        echo "
      <script>location.href='../page/member_login_form.php'</script>
    ";
    } else {
        echo "<script>alert('이미 존재하는 아이디입니다.'); history.go(-1);</script>";
    }
?>