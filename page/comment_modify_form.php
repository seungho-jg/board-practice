<?php
    include "../global/session.php";
    $num = $_GET["num"];
    $page = $_GET["page"];
    $cnum = $_GET["cnum"];
    $content = $_GET["content"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판  | 댓글수정</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function checkComment() {
            const comment = document.comment;
            if (!comment.content.value) {
                alert("내용을 입력하세요");
                comment.focus();
                return;
            }
            comment.submit();
        }
    </script>
</head>
<body>
    <div class="mt-10">
        <form name="comment" action="../commentFunc/update_comment.php?board_num=<?=$num?>&page=<?=$page?>&cnum=<?=$cnum?>" method="post">
            <div class="w-full flex flex-row px-10 gap-5">
                <div>
                    <b><?=$username?></b>
                    <input value="<?=$content?>" type="text" name="content" class="bg-gray-100 border border-1 w-[500px] px-2 py-1"/>
                </div>
                <button onclick="checkComment()" class="bg-slate-200 px-5 rounded-lg">전송</button>
            </div>
        </form>
    </div>
</body>
</html>