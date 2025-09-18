<?php
    class memberDB {
        private $hostname = "localhost";
        private $username = "user";
        private $password = "12345";
        private $database = "board";
        private function connect() {
            return mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        }
        public function findById($id){
            $sql = "
                select * from members where id='$id';
            ";
            $result = mysqli_query($this->connect(), $sql);
            return mysqli_fetch_assoc($result);
        }

        public function findNameById($id) {
            $sql = "
                select name from members where id='$id';
            ";
            $result = mysqli_query($this->connect(), $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                return $row["name"];
            } else {
                return "삭제된 계정";
            }
        }
        // 사용자 계정 생성
        public function insert($id, $pass, $name, $email) {
            /* 단방향 암호화 ( BCRYPT / ARGON2I / ARGON2ID ) */
            $hashed_pass = password_hash($pass, PASSWORD_ARGON2ID);

            $regist_day = date("Y-m-d (H:i)");

            $sql = "
                insert into members(id, pass, name, email, regist_day, level, point) 
                values('$id', '$hashed_pass', '$name', '$email', '$regist_day', 9, 0)
            ";
            return mysqli_query($this->connect(), $sql);
        }

        // 사용자 계정 업데이트
        public function update($id, $name, $pass, $email) {
            /* 단방향 암호화 */
            $hashed_pass = password_hash($pass, PASSWORD_ARGON2ID);
            $sql = "
                update members SET name = '$name', pass = '$hashed_pass', email = '$email'
                where id='$id'
            ";
            return mysqli_query($this->connect(), $sql);
        }
    }
?>