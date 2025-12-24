<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

$email = 'mahasiswa@example.com';
$password = 'password123';

if (!Auth::attempt(['email' => $email, 'password' => $password])){
    echo "Login failed for $email\n";
    exit(1);
}

$u = Auth::user();
echo "Logged in: $u->email (role: $u->role)\n";

Auth::logout();
