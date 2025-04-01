<?php

    namespace App\Services;
    use App\Models\User;
    use App\Models\Order;
    use App\Models\Product;


    class DashboardService
    {
        public function userCount()
        {
            return User::count();
        }
        public function productCount()
        {
            return Product::count();
        }
        
        public function orderCount()
        {
            return Order::count();
        }

        public function topProducts(){
            
        }

        

    }

?>
