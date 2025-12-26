<?php 
    abstract class transaction{
        protected $pdo;
        protected $id;
        protected $user_id;
        protected $category;
        protected $amount;
        protected $description;
        protected $date;
        
        public static function validateMode($mode){
            return in_array($mode, ['income', 'expense']);
        }
        public function validateALL(){
            
        }

        ////////////////////////////////////////////
        
        public function push(){

        }
        
        ////////////////////////////////////////////
        public function calc_balance(){
            
        }
    }