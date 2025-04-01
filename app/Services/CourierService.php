<?php
    namespace App\Services;
    use App\Models\Courier;



    class CourierService
    {
        public function getAll()
        {
            return Courier::orderBy('is_featured', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
        }

    }
?>


<!-- use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $customers = $this->userService->getCustomers();
        return view('users.index', compact('customers'));
    }
}
-->