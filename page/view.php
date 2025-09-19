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
        let commentMode = "comment"  /* comment: 일반댓글모드 / subcomment: 대댓글모드 / modify: 댓글수정모드 */
        let current_selected_comment_num = "" // 현재선택된 댓글

        /* 댓글 수정버튼을 눌렀을 때 */
        function handleModifyModeON(event, comment_num, comment_content) {
            event.stopPropagation(); // 버튼 상위 부모에게 이벤트 전달방지
            commentMode = "modify" // 수정모드로 변경
            current_selected_comment_num = comment_num;
            const subcomment_info = document.getElementById("subcomment_info"); // 대댓글모드시 나오게되는 안내글
            const submitBtn = document.getElementById("submitBtn"); // 버튼내용변경을 위해
            const comment = document.getElementById(`comment-${comment_num}`); // 댓글 지우기
            const input = document.getElementById("input");
            input.value = comment_content;
            comment.style.opacity  = 0.2;
            submitBtn.innerText = "수정"; // 버튼내용 "수정"으로 변경
            subcomment_info.innerText = ""; // 대댓글 모드 off
        }

        /* 댓글 수정모드에서 취소버튼을 눌렀을 때 */
        function handleModifyModeOff() {
            location.reload(); // 새로고침(임시)
        }

        /* 대댓글 모드 */
        function handleSubcommentMode(parent_num, parent_name, parent_id, parent_content) {
            const subcomment_info = document.getElementById("subcomment_info");
            const submitBtn = document.getElementById("submitBtn");

            if (parent_num === current_selected_comment_num) {
                /* 같은 댓글 선택 시 선택 해제*/
                commentMode = "comment";
                subcomment_info.innerText = "";
                submitBtn.innerText = "작성";
                current_selected_comment_num = "";
                return;
            }
            commentMode = "subcomment";
            current_selected_comment_num = parent_num;
            submitBtn.innerText = "답장";
            subcomment_info.innerText = `ㄴ ${parent_name}(${parent_id}): ${parent_content}`; // 대댓글모드시 나오게되는 안내글
        }

        /* 전송버튼 시 3가지 모드에 따라 처리(비동기) */
        async function checkComment(depth) {
            const comment = document.comment;
            const formData = new FormData(comment);

            if (!comment.content.value) {
                alert("내용을 입력하세요");
                comment.focus();
                return;
            }

            if (commentMode === "subcomment") {
                formData.append("depth", depth);
                formData.append("parent_num", current_selected_comment_num);
                const response = await fetch("../commentFunc/insert_subcomment.php?board_num=<?=$num?>", {
                    method: "POST",
                    body: formData,
                });
                console.log(await response.json)
            }

            if (commentMode === "comment") {
                const response = await fetch("../commentFunc/insert_comment.php?board_num=<?=$num?>", {
                    method: "POST",
                    body: formData,
                });
                console.log(await response.json)
            }

            if (commentMode === "modify") {
                formData.append("comment_num", current_selected_comment_num);
                const response = await fetch("../commentFunc/update_comment.php?board_num=<?=$num?>", {
                    method: "POST",
                    body: formData,
                });
                console.log(await response.json)
            }

            await location.reload();
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

            $cmt = "<div id='comment-$comment_num' onclick='handleSubcommentMode($comment_num, `$comment_name`, `$comment_id`, `$comment_content`)' class='flex flex-row rounded-lg hover:cursor-pointer hover:translate-x-2 duration-100 shadow-sm w-ful ";
            if($usernum === $member_num)
                $cmt.="bg-yellow-50";
            else
                $cmt.="bg-zinc-100";
            $cmt.= " p-2 gap-4'>"
                    ."<div class='font-bold px-4'>".$comment_name."(".$comment_id.")"."</div>"
                    ."<div class='w-1/3'>".$comment_content."</div>";

            if ($modify_count > 0) {
                $cmt.="[수정됨]";
            }

            // 작성자 본인만 수정 삭제가능
            if ($usernum === $member_num) {
                $cmt .= "<div id='comment' onclick='handleModifyModeON(event, `$comment_num`, `$comment_content`)' class='px-2 bg-blue-100 rounded-md hover:cursor-pointer'>수정</div>"
                        ."<div onclick='location.href=\"../commentFunc/delete_comment.php?num=$num&page=$page&comment_num=$comment_num\"' class='px-2 bg-red-100 rounded-md hover:cursor-pointer'>삭제</div>";
            }

            $cmt.="<div class='font-thin text-sm text-gray-500 absolute right-10'>".$timestamp."</div>"
            ."</div>";

            echo $cmt;
        }
    ?>
    <!-- 댓글 작성폼 -->
    <div>
        <form name="comment" action="../commentFunc/insert_comment.php?board_num=<?=$num?>&page=<?=$page?>" method="post">
            <div id="subcomment_info"></div>
            <div class="w-full flex flex-row px-10 gap-5">
                <div>
                    <b><?=$username?></b>
                    <input id="input" type="text" name="content" class="bg-gray-100 border border-1 w-[500px] px-2 py-1"/>
                </div>
                <button type="button" id="submitBtn" onclick="checkComment()" class="bg-slate-200 px-5 rounded-lg">작성</button>
            </div>
        </form>

    </div>
</div>
</body>
</html>