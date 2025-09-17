<?php
    $num = $_GET["num"];
    $page = $_GET["page"];
    include "../DB/board.php";
    $boardDB = new boardDB();

    // 게시글 정보 가져와 저장된 파일이름 변경
    $row = mysqli_fetch_assoc($boardDB->findById($num));

    $file_copied = $row["file_copied"];
    $file_path = "../data/".$file_copied;
    $del_file_path = "../del_data/".$file_copied;
    rename($file_path, $del_file_path);

    $result = $boardDB->deleteById($num);

    if ($result) {
        echo "<script>
                location.href = '../page/board_list.php?page=$page';
              </script>";
    } else {
        echo "<script>
                alert('게시글 삭제에 실패했습니다.');
                location.href = '../page/board_list.php?page=$page';
              </script>";
    }
?>