<?php
    class TransactionRepositorie{
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        /////////////////////////////////////////

        public function getAllByUser($user_id){
            $sql3 = "SELECT 'income' AS mode, id, category, amount, date, description
                        FROM income
                        UNION ALL
                        SELECT 'expense' AS mode, id, category, amount, date, description
                        FROM expense
                        WHERE user_id = $user_id
                        ORDER BY id";

            $results = $this->pdo->query($sql3);
            return $results->fetchAll(PDO::FETCH_ASSOC);
        }
    }