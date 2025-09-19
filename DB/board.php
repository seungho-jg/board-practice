<?php
class boardDB {
    private $hostname = "localhost";
    private $username = "user";
    private $password = "12345";
    private $database = "board";
    private function connect() {
        return mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
    }
    // 사용자 계정 생성
    public function insert($id, $subject, $content, $file_name, $file_type, $file_copied) {


        $regist_day = date("Y-m-d (H:i)");

        $sql = "
                insert into board(id, subject, content, regist_day, file_name, file_type, file_copied) 
                values('$id', '$subject', '$content', '$regist_day','$file_name', '$file_type', '$file_copied')
            ";
        return mysqli_query($this->connect(), $sql);
    }

    public function update($id, $subject, $content){
        $regist_day = date("Y-m-d (H:i)");

        $sql = "
            update board set subject='$subject', content='$content', regist_day ='$regist_day' where num='$id'
        ";

        return mysqli_query($this->connect(),$sql);
    }

    public function findAll() {
        $sql = "
            select b.num, b.id, b.subject, b.content, b.regist_day, b.file_name, b.file_type, b.file_copied, count(DISTINCT c.num) as comment_count, count(DISTINCT v.num) as view_count
            from board as b
            left join views as v on b.num = v.board_num
            left join comments as c on b.num = c.board_num
            group by b.num
            order by b.num desc
        ";
        return mysqli_query($this->connect(), $sql);
    }

    public function findById($num) {
        $sql = "
            select * from board where num='$num'
        ";
        return mysqli_query($this->connect(), $sql);
    }

    public function findJoinViewById($num) {
        $sql = "
            select m.name, b.num, b.id, b.subject, b.content, b.regist_day, b.file_name, b.file_type, b.file_copied, count(v.num) as view_count 
            from board as b
            left join views as v on b.num = v.board_num
            left join members as m on b.id = m.id
            where b.num=$num
        ";
        return mysqli_query($this->connect(), $sql);
    }

    public function deleteById($num) {
        $sql = "
            delete from board where num='$num'
        ";
        return mysqli_query($this->connect(), $sql);
    }
}
?>