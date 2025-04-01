<?php
    namespace App\Services;
    use App\Models\User;



    class UserService
    {
        public function getAllUsers()
        {
            return User::all();
        }

        // Function to get all users with a specific role
        public function getUsersByRole($roleName)
        {
            return User::whereHas('roles', function ($query) use ($roleName) {
                $query->where('name', $roleName);
            })->get();
        }

        public function getUsers(...$roles)
        {
            return User::whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            })->get();
        }

        
        public function getUsersForOrderDetail(...$roles)
        {
            // return User::whereHas('roles', function ($query) use ($roles) {
            //     $query->whereIn('name', $roles);
            // })->get();

            return User::all();

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