<?php
    include('../DB/member.php');
    $memberDB = new memberDB();

    $id = $_POST["id"];
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    $regist_day = date("Y-m-d (H:i)");

    $memberDB->insert($id, $pass, $name, $email);

    echo "
      <script>location.href='../page/login_form.php'</script>
    ";
