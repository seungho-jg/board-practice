<?php
    include "../global/session.php";
    $num = $_GET["num"];
    $page = $_GET["page"];
    include "../DB/board.php";
    $boardDB = new boardDB();
    $result = $boardDB->findById($num);

    $row = mysqli_fetch_assoc($result);

    $id = $row["id"];
    $subject = $row["subject"];
    $content = $row["content"];
    $file_name = $row["file_name"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 메인게시판</title>
    <link rel="stylesheet" href="../css/style.css">
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
<h2>글쓰기</h2>
<form name="board" method="post" action="../boardFunc/update_board.php?id=<?=$id?>&num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
    <ul class="board_form">
        <li>
            <span class="col1">이름 : </span>
            <span class="col2"><?=$username?></span>
        </li>
        <li>
            <span class="col1">제목 : </span>
            <span class="col2"><input name="subject" type="text" value="<?=$subject?>"/></span>
        </li>
        <li class="area">
            <span class="col1">내용 : </span>
            <span class="col2"><textarea name="content"><?=$content?></textarea></span>
        </li>
        <li>
            <span class="col1">첨부파일</span>
            <span class="col2"><?=$file_name?></span>
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
</body>
</html>
