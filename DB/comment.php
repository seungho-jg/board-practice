<?php
    class commentDB {
        private $hostname = "localhost";
        private $username = "user";
        private $password = "12345";
        private $database = "board";

        private function connect() {
            return mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        }

        public function findById($comment_num) {
            $sql = "
                select * from comments where num=$comment_num
            ";
            $result = mysqli_query($this->connect(), $sql);
            return mysqli_fetch_assoc($result);
        }

        // 댓글 작성
        public function insert_comment($board_num, $member_num, $comment) {
            $sql = "
                insert into comments(board_num, member_num, comment) values($board_num, $member_num, '$comment')
            ";
            return mysqli_query($this->connect(), $sql);
        }
        // 댓글 수정
        public function update_comment($comment_num, $comment, $modify_count) {
            $sql = "
                update comments set comment='$comment', modify_count=$modify_count where num=$comment_num
            ";
            return mysqli_query($this->connect(), $sql);
        }
        // 댓글 삭제
        public function delete_comment($comment_num) {
            $sql = "
                delete from comments where num=$comment_num
            ";
            return mysqli_query($this->connect(), $sql);
        }

        public function find_all_comment($board_num) {
            $sql = "
                select c.num as cnum, c.modify_count, c.comment, c.timestamp, m.name, m.id, m.num
                from comments as c
                left join members as m on c.member_num = m.num
                where c.board_num=$board_num
            ";
            return mysqli_query($this->connect(), $sql);
        }
    }
?>