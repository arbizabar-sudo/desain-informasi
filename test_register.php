<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

try {
    // Clear previous test user
    User::where('email', 'test@example.com')->delete();
    
    // Test create user
    $user = User::create([
        'name' => 'Test User',
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'username' => 'testuser123',
        'password' => Hash::make('password123'),
        'category' => 'graphic'
    ]);
    
    echo "✓ User created successfully with ID: " . $user->id . "\n";
    echo "  Name: " . $user->name . "\n";
    echo "  Email: " . $user->email . "\n";
    echo "  Username: " . $user->username . "\n\n";
    
    // Test login
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'password123'
    ];
    
    if (Auth::attempt($credentials)) {
        echo "✓ Login successful!\n";
        echo "  Authenticated user: " . Auth::user()->name . "\n";
    } else {
        echo "✗ Login failed!\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
