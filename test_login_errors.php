<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "========================================\n";
echo "Testing Login Error Handling\n";
echo "========================================\n\n";

// Clean up and create test user
User::where('email', 'test@login.com')->delete();

$user = User::create([
    'name' => 'Test Login',
    'first_name' => 'Test',
    'last_name' => 'Login',
    'email' => 'test@login.com',
    'username' => 'testlogin',
    'password' => Hash::make('correctpassword123')
]);

echo "Created test user:\n";
echo "  Email: test@login.com\n";
echo "  Password: correctpassword123\n\n";

// Test 1: Correct password
echo "Test 1: Login dengan password yang BENAR\n";
$credentials = ['email' => 'test@login.com', 'password' => 'correctpassword123'];
if (auth()->attempt($credentials)) {
    echo "  ✓ Login berhasil dengan password yang benar!\n";
    auth()->logout();
} else {
    echo "  ✗ Login gagal (tidak seharusnya)\n";
}
echo "\n";

// Test 2: Wrong password
echo "Test 2: Login dengan password yang SALAH\n";
$credentials = ['email' => 'test@login.com', 'password' => 'wrongpassword123'];
if (auth()->attempt($credentials)) {
    echo "  ✗ Login berhasil (tidak seharusnya)\n";
    auth()->logout();
} else {
    echo "  ✓ Login gagal seperti yang diharapkan!\n";
    echo "  Pesan error akan ditampilkan di form\n";
}
echo "\n";

// Test 3: Non-existent email
echo "Test 3: Login dengan email yang TIDAK TERDAFTAR\n";
$credentials = ['email' => 'nonexistent@email.com', 'password' => 'anypassword123'];
if (auth()->attempt($credentials)) {
    echo "  ✗ Login berhasil (tidak seharusnya)\n";
    auth()->logout();
} else {
    echo "  ✓ Login gagal seperti yang diharapkan!\n";
    echo "  Pesan error akan ditampilkan di form\n";
}
echo "\n";

echo "========================================\n";
echo "Semua test error handling selesai!\n";
echo "Sekarang coba buka http://127.0.0.1:8000/login\n";
echo "dan coba login dengan password salah untuk melihat notifikasi error\n";
echo "========================================\n";
