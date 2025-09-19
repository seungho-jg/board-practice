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
            $num = random_int(0, 9999999); // 자동증가 인덱스 값을 사용해 적용하는 법을 몰라서 임시로 랜덤값 인트사용
            $sql = "
                insert into comments(num, board_num, member_num, comment, parent_num) values($num, $board_num, $member_num, '$comment', $num)
            ";
            return mysqli_query($this->connect(), $sql);
        }
        // 대댓글 작성
        public function insert_subcomment($board_num, $member_num, $comment, $depth, $parent_num, $child_count){
            $sql = "
                insert into comments(board_num, member_num, comment, depth, parent_num, child_count) 
                values($board_num, $member_num, '$comment', $depth, $parent_num, $child_count)
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
        public function add_child_comment($comment_num){
            $sql = "
                update comments set child_count=comments.child_count+1 where num=$comment_num;
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
                select c.num as cnum, c.depth, c.child_count, c.modify_count, c.comment, c.timestamp, m.name, m.id, m.num
                from comments as c
                left join members as m on c.member_num = m.num
                where c.board_num=$board_num
                order by c.parent_num
            ";
            return mysqli_query($this->connect(), $sql);
        }
        public function find_all_subcomment($board_num, $parent_num, $depth) {
            $sql = "
                select c.num as cnum, c.parent_num, c.depth, c.child_count, c.modify_count, c.comment, c.timestamp, m.name, m.id, m.num
                from comments as c
                left join members as m on c.member_num = m.num
                where c.board_num=$board_num and c.parent_num=$parent_num and c.depth = $depth
            ";
            return mysqli_query($this->connect(), $sql);
        }
    }
?>