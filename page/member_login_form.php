<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 로그인</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<script>
    function check_input() {
        if (!document.login.id.value) {
            alert("아이디를 입력하세요");
            document.login.id.focus();
            return;
        }
        if (!document.login.pass.value) {
            alert("비밀번호를 입력하세요");
            document.login.pass.focus();
            return;
        }
        document.login.submit();
    }
</script>
<body>
    <h2>로그인</h2>
    <form name="login" action="../memberFunc/login.php" method="post">
        <ul class="login_form">
            <li>
                <span class="col1">아이디</span>
                <span class="col2"><input type="text" name="id"></span>
            </li>
            <li>
                <span class="col1">비밀번호</span>
                <span class="col2"><input type="password" name="pass"></span>
            </li>
            <li>
                <button type="button" onclick="check_input()">로그인</button>
            </li>
        </ul>
    </form>
</body>
</html>