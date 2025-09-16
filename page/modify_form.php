<?php
    include('../DB/member.php');
    $memberDB = new memberDB();

    session_start();
    if (isset($_SESSION["userid"])) {
        $row = $memberDB->findById($_SESSION["userid"]);
        $id = $row["id"];
        $name = $row["name"];
        $email = $row["email"];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 정보수정</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        function check_input() {
            if(!document.member.pass.value) {
                alert("비밀번호를 입력하세요!");
                document.member.pass.focus();
                return;
            }
            if(!document.member.pass_confirm.value) {
                alert("비밀번호 확인을 입력하세요!");
                document.member.pass_confirm.focus();
                return;
            }
            if (!document.member.name.value) {
                alert("이름을 입력하세요!");
                document.member.name.focus();
                return;
            }
            if (!document.member.email.value) {
                alert("이메일 주소를 입력하세요!");
                document.member.email.focus();
                return;
            }
            if (document.member.pass.value !== document.member.pass_confirm.value) {
                alert("비밀번호가 일치하지 않습니다.\n 다시 입력해 주세요");
                document.member.pass.focus();
                document.member.pass.select();
                return;
            }
            document.member.submit();
        }
        function reset_form() {
            document.member.pass.value = "";
            document.member.pass_confirm.value = "";
            document.member.name.value = "";
            document.member.email.value = "";
        }
    </script>
</head>
<body>
    <h2>회원 정보 수정</h2>
    <form name="member" action="../func/update_member.php?id=<?=$id?>" method="post">
        <ul class="update_form">
            <li>
                <span class="col1">아이디</span>
                <span class="col2"><?=$id?></span>
            </li>
            <li>
                <span class="col1">비밀번호</span>
                <span class="col2"><input type="password" name="pass"/></span>
            </li>
            <li>
                <span class="col1">비밀번호 확인</span>
                <span class="col2"><input type="password" name="pass_confirm"/></span>
            </li>
            <li>
                <span class="col1">이름</span>
                <span class="col2"><input type="text" name="name" placeholder="<?=$name?>"/></span>
            </li>
            <li>
                <span class="col1">이메일</span>
                <span class="col2"><input type="text" name="email" placeholder="<?=$email?>"/></span>
            </li>
        </ul>
        <ul class="buttons">
            <li><button type="button" onclick="check_input()">저장하기</button></li>
            <li><button type="button" onclick="reset_form()">취소하기</button></li>
        </ul>
    </form>
</body>
</html>