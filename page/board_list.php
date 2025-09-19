<?php
include "../global/session.php";
$view_list = explode(",",$_SESSION["view"]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시판 | 메인게시판</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<span>게시판 목록(<span id="total_num">0</span>)</span>
    <ul class="board_list">
        <li>
            <span class="col1">번호</span>
            <span class="col2">제목</span>
            <span class="col3">글쓴이</span>
            <span class="col4">첨부</span>
            <span class="col5">등록일</span>
        </li>
        <?php
            if(isset($_GET["page"])){
                $page = $_GET["page"];
            } else {
                $page = 1;
            }
            include "../DB/board.php";
            include "../DB/member.php";
            $boardDB = new boardDB();
            $memberDB= new memberDB();

            $result = $boardDB->findALL();

            $total_record = mysqli_num_rows($result);
            /* 게시글 총 갯수 가져와서 변경*/
            echo "<script>
                    const num = document.getElementById('total_num');
                    num.innerHTML = $total_record;
                  </script>
                  ";
            $scale = 5;

            // 전체 페이지 수 계산
            if ($total_record % $scale == 0){
                $total_page = $total_record/$scale;
            } else {
                $total_page = floor($total_record/$scale) + 1;
            }
            $start = (intval($page) - 1) * $scale;

            $number = $total_record - $start;

            for ($i=$start; $i<$start+$scale && $i < $total_record; $i++) {
                mysqli_data_seek($result, $i);
                $row = mysqli_fetch_assoc($result);

                $num = $row["num"];
                $id = $row["id"];
                $file_name = $row["file_name"];
                $subject = $row["subject"];
                $regist_day = $row["regist_day"];
                $view_count = $row["view_count"];
                $comment_count = $row["comment_count"];

                $name = $memberDB->findNameById($id);

                if($row["file_name"]) {
                    $file_image = "<img width='15' height='15' src='../img/file.png'>";
                } else {
                    $file_image = "";
                }
                // 게시판 리스트
                if (in_array($num, $view_list)) {
                    $board = "<li style='color: rgb(180, 180, 180)'>"
                            ."<sapn class='col1'>$num</sapn>"
                            ."<span class='col2'><a style='color: rgb(180, 180, 180)' href='view.php?num=$num&page=$page'>$subject</a> [👀$view_count/💬$comment_count]</span>"
                            ."<span class='col3'>$name</span>"
                            ."<span class='col4'>$file_name $file_image</span>"
                            ."<span class='col5'>$regist_day</span>"
                            ."</li>";
                } else {
                    $board = "<li>"
                        ."<sapn class='col1'>$num</sapn>"
                        ."<span class='col2'><a href='view.php?num=$num&page=$page'>$subject</a> [👀$view_count/💬$comment_count]</span>"
                        ."<span class='col3'>$name</span>"
                        ."<span class='col4'>$file_name $file_image</span>"
                        ."<span class='col5'>$regist_day</span>"
                        ."</li>";
                }

                echo $board;
    }
        ?>
    </ul>
    <div class="page_btn_container">
        <?php
        // 게시판 페이지
        $page_btn = "";
        for ($i=1; $i<=$total_page; $i++) {
            if($page == $i)
                echo "<div class='page_btn'><b>$i</b></div>";
            else
                echo "<div class='page_btn'><a href='board_list.php?page=$i'>$i</a></div>";
        }
        ?>
    </div>
    <?php
    if ($userid)
        echo "<div class='post_btn'><a href='board_form.php'>+</a></div>"
    ?>

</body>
</html>
