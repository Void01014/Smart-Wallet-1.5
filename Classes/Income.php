<?php 
    class income extends transaction{

        public function __construct($pdo, $category, $amount, $description, $date)
        {
            $this->user_id = $_SESSION['login_id'];
            $this->pdo = $pdo;
            $this->category = $category;
            $this->amount = $amount;
            $this->description = $description;
            $this->date = $date;
        }

        ////////////////////////////////////////////
        
        private function validateAmount(){
            return is_numeric($this->amount) && $this->amount >= 0;
        }
        private function validateDescription(): bool{
            if (!is_string($this->description)) {
                return false;
            }
            
            $description = trim($this->description);

            return $description !== '';
        }
        private function validateDate(){
            $today = date("Y-m-d");
            return $this->date <= $today;
        }

        public function validateALL(){
            return $this->validateAmount()
                   && $this->validateDescription()
                   && $this->validateDate();
        }
        ////////////////////////////////////////////

        public function push(){
            $sql = "INSERT INTO income (user_id, category, amount, date, description)
                    VALUES (:user_id, :category, :amount, :date, :desc)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                    ':user_id'  => $this->user_id,
                    ':category' => $this->category,
                    ':amount'   => $this->amount,
                    ':date'     => $this->date,
                    ':desc'     => $this->description,
            ]);
        }

        
        public function getAmount(){
            return $this->amount;
        }
    }