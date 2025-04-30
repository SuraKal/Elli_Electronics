<?php
    namespace App\Services;
    use App\Models\Guest;
use App\Models\User;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


    class UserService
    {




public function getOrCreateCartCookie()
{
    // Check if the user is authenticated
    if (Auth::check()) {
        // If user is authenticated, return null (no cookie for authenticated users)
        return null;
    }

    $guest_id = null; // Initialize guest_id
    // Check if cookie exists for a guest user
    $guest_identifier = Cookie::get('guest_identifier');

    // If the guest ID cookie doesn't exist, generate a new one
    if (!$guest_identifier) {
        $guest_identifier = 'guest_' . Str::uuid(); // or Str::random(16)
        $guest = Guest::create([
            'identifier' => $guest_identifier,
        ]);
        if($guest) {
            $guest_id = $guest->id; // Get the ID of the newly created guest
            Cookie::queue('guest_identifier', $guest_identifier, 60 * 24 * 7); // Store for 7 days

        } else {
            // Handle error if guest creation fails
            return null;
        }
    }else{
        // If the cookie exists, retrieve the guest ID from the database
        $guest = Guest::where('identifier', $guest_identifier)->first();
        if ($guest) {
            $guest_id = $guest->id; // Get the ID of the existing guest
        } else {
            // Handle error if guest not found in the database
            return null;
        }
    }

    // Return the guest_id, either existing or newly created
    return $guest_id;
}



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