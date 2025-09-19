<?php
    include "../global/session.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 메인게시판</title>
    <link rel="stylesheet" href="../css/board_form.css">
    <script>
        function check_input() {
            const board = document.board;
            if (!board.subject.value) {
                alert("제목이 없습니다!");
                board.focus();
                return;
            }
            if (!board.content.value) {
                alert("내용이 없습니다!");
                board.focus();
                return;
            }
            board.submit();
        }
    </script>
</head>
<body>
    <h4 class="title">글쓰기</h4>
    <div class="container">
        <form name="board" method="post" action="../boardFunc/insert_board.php" enctype="multipart/form-data">
            <ul class="board_form">
                <li>
                    <span class="col1">이름</span>
                    <span class="col2"><?=$username?></span>
                </li>
                <li>
                    <span class="col1">제목</span>
                    <span class="col2"><input name="subject" type="text"/></span>
                </li>
                <li class="area">
                    <span class="col1">내용</span>
                    <span class="col2"><textarea name="content"></textarea></span>
                </li>
                <li>
                    <span class="col1">첨부파일</span>
                    <span class="col2"><input type="file" name="upfile" /></span>
                </li>
            </ul>
            <ul class="buttons">
                <li>
                    <button type="button" onclick="check_input()">저장하기</button>
                </li>
                <li>
                    <button type="button" onclick="javascript:location.href='/board/page/board_list.php'">목록보기</button>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
