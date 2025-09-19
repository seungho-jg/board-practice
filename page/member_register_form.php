<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판  | 회원가입</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        let checked_state = false;

        function check_input() {
            if (!checked_state) {
                alert("아이디를 중복검사를 해주세요!");
                return;
            }
            if (!document.member.id.value) {
                alert("아이디를 입력하세요!");
                document.member.id.focus();
                return;
            }
            if (!document.member.pass.value) {
                alert("비밀번호를 입력하세요!");
                document.member.pass.focus();
                return;
            }
            if (!document.member.pass_confirm.value) {
                alert("비밀번호확인을 입력하세요!");
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
                alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
                document.member.pass.focus();
                document.member.pass.select();
                return;
            }
            document.member.id.disabled = false;
            document.member.submit();
        }
        function reset_form() {
            document.member.id.value = "";
            document.member.pass.value = "";
            document.member.pass_confirm.value = "";
            document.member.name.value = "";
            document.member.email.value = "";
            document.member.id.focus();
            window.location.href = "/board";
            return;
        }
        function reset_id() {
            checked_state = false;
            document.member.id.disabled = false;
            document.member.check.innerHTML = "중복체크";
            document.member.check.onclick = check_id;
        }
        async function check_id() {
            const url = "../memberFunc/check_id_api.php?id=" + document.member.id.value;
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    alert("아이디를 입력해주세요.");
                    throw new Error(`Response status: ${response.status}`);
                }
                const result = await response.json();
                console.log(result);
                if (result.status === "success") {
                    checked_state = true;
                    document.member.id.disabled = true;
                    document.member.check.innerHTML = "새아이디";
                    document.member.check.onclick = reset_id;
                    alert("아이디가 사용가능합니다.");
                } else {
                    alert(result.message);
                }

            } catch (error) {
                console.error(error.message);
            }
        }
    </script>
</head>
<body>
    <h2>회원 가입</h2>
    <form name="member" action="../memberFunc/insert_member.php" method="post">
        <ul class="join_form">
            <li>
                <span class="col1">아이디</span>
                <span class="col2"><input type="text" name="id"></span>
                <span class="col3"><button type="button" onclick="check_id()" name="check">중복체크</button></span>
            </li>
            <li>
                <span class="col1">비밀번호</span>
                <span class="col2"><input type="password" name="pass"></span>
            </li>
            <li>
                <span class="col1">비밀번호 확인</span>
                <span class="col2"><input type="password" name="pass_confirm"></span>
            </li>
            <li>
                <span class="col1">이름</span>
                <span class="col2"><input type="text" name="name"></span>
            </li>
            <li>
                <span class="col1">이메일</span>
                <span class="col2"><input type="text" name="email"></span>
            </li>
        </ul>
        <ul class="buttons">
            <li><button type="button" onclick="check_input()">저장하기</button></li>
            <li><button type="button" onclick="reset_form()">취소하기</button></li>
        </ul>
    </form>
</body>
</html>