<?php
    include "../global/session.php";
    include "../DB/board.php";
    $boardDB = new boardDB();

    if(!$userid) {
        echo "<script>
                alert('게시판 글쓰기는 로그인 후 이용해 주세요');
                history.go(-1);
              </script>";
        exit;
    }
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    $subject = htmlspecialchars($subject, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);

    $upload_dir = '../data/';

    $upfile_name = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type = $_FILES["upfile"]["type"];
    $upfile_size = $_FILES["upfile"]["size"];
    $upfile_error = $_FILES["upfile"]["error"];

    if($upfile_name&&!$upfile_error) {
        $file = explode(".", $upfile_name);
        $file_name = $file[0];
        $file_ext = $file[1];

        $copied_file_name = date("Y_m_d_H_i_s");
        $copied_file_name .= ".".$file_ext;
        $uploaded_file = $upload_dir.$copied_file_name;

        if ($upfile_size > 10000000) {
            echo "
                <script>
                    alert('업로드 파일 크기가 지정된 용량(10MB)을 초과합니다.<br>파일 크기를 체크해주세요!');
                    history.go(-1);
                </script>
            ";
            exit;
        }
        if(!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            echo "
                <script>
                    alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                    history.go(-1);
                </script>
            ";
            exit;
        }
    }
    else
    {
        $upfile_name = "";
        $upfile_type = "";
        $copied_file_name = "";
    }
    $result = $boardDB->insert($userid, $subject, $content, $upfile_name, $upfile_type, $copied_file_name);

    if ($result) {
        echo "<script>location.href='../page/board_list.php'</script>";
    }
    else
    {
        echo "
                <script>
                    window.alert('비밀번호가 틀립니다!');
                    history.go(-1);
                </script>
            ";
        exit;

    }
?>