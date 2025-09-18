<?php
    include "../global/session.php";
    $num = $_GET["num"];
    $page = $_GET["page"];

    /* 뷰 카운트 로직 구현 */
    include "../DB/view.php";
    $viewDB = new viewDB();
    $_SESSION["view"] = $_SESSION["view"].",".$num; // 세션에 저장

    if ($userid == "") {
        // 비회원일경우
        echo "<script>console.log('비회원입니다.')</script>";
        $result_num = $viewDB->findViewByToken($num, $non_member_cookie);
        if($result_num == 0) {
           $result = $viewDB->non_member_view_insert($num, $non_member_cookie);
           if(!$result) {
               echo "실패";
           }
        }
    } else {
        // 회원일 경우
        echo "<script>console.log('회원입니다.')</script>";
        $result_num = $viewDB->findViewByMemberNum($num, $usernum);
        if($result_num == 0) {
            $result = $viewDB->member_view_insert($num, $usernum);
            if(!$result) {
                echo "실패";
            }
        }
    }

    include "../DB/board.php";
    $boardDB = new boardDB();

    $result = $boardDB->findJoinViewById($num);

    $row = mysqli_fetch_assoc($result);

    $id = $row["id"];
    $name = $row["name"];
    $subject = $row["subject"];
    $regist_day = $row["regist_day"];

    $content = $row["content"];
    $content = str_replace(" ", "&nbsp", $content);
    $content = str_replace("\n", "<br>", $content);

    $file_name = $row["file_name"];
    $file_type = $row["file_type"];
    $file_copied = $row["file_copied"];

    $view_count = $row["view_count"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판  | <?=$subject?></title>
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
<div class="flex flex-col gap-3 px-5 pt-3 w-full">
    <h3>게시판 > 내용보기</h3>
    <ul class="flex justify-between bg-blue-100 p-1 px-3 rounded-xl">
        <li class="flex flex-row gap-5"><b>제목 : </b><?=$subject?> <b>[👀 <?=$view_count?>]</b></li>
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

    <!-- 댓글 -->
    <?php
        include "../DB/comment.php";
        $commentDB = new commentDB();

        $result = $commentDB->find_all_comment($num);
        echo "댓글>";
        while($row = mysqli_fetch_assoc($result)) {
            $comment_num = $row["cnum"];
            $comment_content = $row["comment"];
            $comment_name = $row["name"];
            $comment_id = $row["id"];
            $timestamp = $row["timestamp"];
            $member_num = $row["num"];
            $modify_count = $row["modify_count"];

            $cmt = "<div class='flex flex-row rounded-lg shadow-sm w-ful bg-zinc-100 p-2 gap-4'>"
                    ."<div class='font-bold px-4'>".$comment_name."(".$comment_id.")"."</div>"
                    ."<div class='w-1/3'>".$comment_content."</div>";
//            if ($modify_count > 0) {
//                $cmt.="[수정됨]";
//            }

            // 작성자 본인만 수정 삭제가능
            if ($usernum === $member_num) {
                $cmt .= "<div id='comment' onclick='location.href=\"../page/comment_modify_form.php?num=$num&page=$page&cnum=$comment_num&content=$comment_content\"' class='px-2 bg-blue-100 rounded-md hover:cursor-pointer'>수정</div>"
                        ."<div onclick='location.href=\"../commentFunc/delete_comment.php?num=$num&page=$page&comment_num=$comment_num\"' class='px-2 bg-red-100 rounded-md hover:cursor-pointer'>삭제</div>";
            }

            $cmt.="<div class='font-thin text-sm text-gray-500 fixed right-10'>".$timestamp."</div>"
            ."</div>";

            echo $cmt;
        }
    ?>
    <!-- 댓글 작성폼 -->
    <div>
        <form name="comment" action="../commentFunc/insert_comment.php?board_num=<?=$num?>&page=<?=$page?>" method="post">
            <div class="w-full flex flex-row px-10 gap-5">
                <div>
                    <b><?=$username?></b>
                    <input type="text" name="content" class="bg-gray-100 border border-1 w-[500px] px-2 py-1"/>
                </div>
                <button onclick="checkComment()" class="bg-slate-200 px-5 rounded-lg">전송</button>
            </div>
        </form>

    </div>
</div>
</body>
</html>