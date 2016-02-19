<?php

require_once ROOT.DS.LIBRARY.DS.'security.php';
require_once ROOT.DS.CONFIG.DS.'config.php';

if (!class_exists('api')) {
    class api extends security
    {
        private $pdo;
        /**
         * [api description].
         *
         * @param  [type] $config [description]
         *
         * @return [type]         [description]
         */
        public function api(array $config)
        {
            // Create a connection to the database.
            $this->pdo = new PDO(
                'mysql:host='.$config[APPLICATION_ENV]['db']['host'].';dbname='.parent::decode($config[APPLICATION_ENV]['db']['dbname']),
                parent::decode($config[APPLICATION_ENV]['db']['username']),
                parent::decode($config[APPLICATION_ENV]['db']['password']),
                array());

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->query('SET NAMES utf8');
        }
        /**
         * [login description].
         *
         * @return [type] [description]
         */
        public function login()
        {
            $username = $_POST['username'];           //    'testone';
            $password = md5($_POST['password']);     //    'dea404003c3a80819f73187842f5d1de';

            $query = 'SELECT log.id, log.username, usr.email, usr.first_name, usr.last_name,
						usr.contact, usr.state,usr.city, usr.address_one, usr.address_two
						FROM logins as log
						JOIN users as usr ON log.id = usr.logins_id
						WHERE true
						AND (log.username = ? OR usr.email = ?)
						AND log.password = ?';
            $conn = $this->pdo->prepare($query);
            $conn->bindParam(1, $username, 2);
            $conn->bindParam(2, $username, 2);
            $conn->bindParam(3, $password, 2);
            $conn->execute();
            $result = $conn->fetchAll(2);
            if (count($result) > 0) {
                // echo "<pre>".print_r($result[0],1)."</pre>";
                echo json_encode($result[0]);
            } else {
                echo 'Invalid username or password';
            }
        }
        /**
         * [register description].
         *
         * @return [type] [description]
         */
        public function customerRegister()
        {
            echo 'From customer register';
        }

        public function customerSearch()
        {
            $keyword = $_POST['keyword'];
            $query = "SELECT cus.name, cus.address_one, cus.address_two, cus.state, cus.city,
                        cus.ticket_no, cus.entry_time, cus.initiated_by, cus.meeting_trigger,
                        cus.meeting_type, cus.duration, cus.req_created
                        FROM customers as cus
                        WHERE true
                        AND cus.status = 't' AND cus.is_delete IS true AND cus.name like ?";
            $conn = $this->pdo->prepare($query);
            $conn->bindParam(1, $keyword, 2);
            $conn->execute();
            $result = $conn->fetchAll(2);
            if (count($result) > 0) {
                echo json_encode($result[0]);
            } else {
                echo 'Invalid search keyword';
            }
        }
    }
    $api = new api($config);
}
