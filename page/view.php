<?php
    include "../global/session.php";
    $num = $_GET["num"];
    $page = $_GET["page"];

    include "../DB/board.php";
    include "../DB/member.php";
    $boardDB = new boardDB();
    $memberDB = new memberDB();

    $result = $boardDB->findById($num);

    $row = mysqli_fetch_assoc($result);

    $id = $row["id"];
    $name = $memberDB->findNameById($id);
    $subject = $row["subject"];
    $regist_day = $row["regist_day"];

    $content = $row["content"];
    $content = str_replace(" ", "&nbsp", $content);
    $content = str_replace("\n", "<br>", $content);

    $file_name = $row["file_name"];
    $file_type = $row["file_type"];
    $file_copied = $row["file_copied"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판  | <?=$subject?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="flex flex-col gap-3 px-5 pt-3 w-full">
    <h3>게시판 > 내용보기</h3>
    <ul class="flex justify-between bg-blue-100 p-1 px-3 rounded-xl">
        <li><b>제목 : </b><?=$subject?></li>
        <li><?=$name?> | <?=$regist_day?></li>
    </ul>
    <div class="text-sm flex flex-row ml-4">
        <?php
        if($file_name) {
            $file_path = "../data/".$file_copied;
            $file_size = filesize($file_path);

            echo "첨부파일: $file_name ($file_size Byte)
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href='../boardFunc/download.php?num=$num&file_copied=$file_copied&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>
            ";
        }
        ?>
    </div>
    <div class="-mt-4 w-full bg-blue-100 rounded-xl p-2">
        <?=$content?>
    </div>
    <div class="flex flex-row gap-4">
        <button onclick="location.href='board_list.php?page=<?=$page?>'" class="bg-blue-100 px-4 py-1 rounded-full hover:bg-blue-200">목록보기</button>
        <?php
            if($userid == $id) {
                echo "<button onclick=\"location.href='board_modify_form.php?num=$num&page=$page'\" class=\"bg-blue-100 px-4 py-1 rounded-full hover:bg-blue-200\">수정하기</button>";
                echo "<button onclick=\"location.href='../boardFunc/delete_board.php?num=$num&page=$page'\" class=\"bg-blue-100 px-4 py-1 rounded-full hover:bg-red-200\">삭제하기</button>";
            }
        ?>


    </div>

</div>
</body>
</html>