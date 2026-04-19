use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'phone' => '01700000000',
    'password' => Hash::make('password123'),
    'role' => 'admin',
    'is_verified' => true,
]);