<?php
    class viewDB {
        private $hostname = "localhost";
        private $username = "user";
        private $password = "12345";
        private $database = "board";

        private function connect() {
            return mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        }

        public function findViewByToken($board_num, $token) {
            $sql = "
                select * from views where board_num=$board_num and non_member_token='$token'
            ";
            $result = mysqli_query($this->connect(), $sql);

            return mysqli_num_rows($result);
        }

        public function findViewByMemberNum($board_num, $member_num) {
            $sql = "
                select * from views where board_num=$board_num and member_num=$member_num
            ";
            $result = mysqli_query($this->connect(), $sql);

            return mysqli_num_rows($result);
        }

        public function non_member_view_insert($board_num, $token) {
            $sql = "
                insert into views(non_member_token, board_num) values('$token', '$board_num')
            ";
            try {
                mysqli_query($this->connect(), $sql);
                return true;
            } catch(Exception $e) {
                echo "<script>console.log('".mysqli_error($this->connect()).")'</script>";
                return false;
            }
        }

        public function member_view_insert($board_num, $member_num) {
            $sql = "
                insert into views(member_num, board_num) values('$member_num', '$board_num')
            ";
            try {
                mysqli_query($this->connect(), $sql);
                return true;
            } catch(Exception $e) {
                echo "<script>console.log('".mysqli_error($this->connect()).")'</script>";
                return false;
            }
        }

    }
?>