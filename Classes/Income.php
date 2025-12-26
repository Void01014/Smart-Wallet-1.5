<?php 
    class income extends transaction{
        private $id;
        private $user_id;
        private $category;
        private $description;
        private $date;

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
            return $this->validateDescription() 
                    && $this->validateDate();
        }
        public function calc_balance(){
            
        }
    }