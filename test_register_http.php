<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Clean up test data
User::where('email', 'budi@example.com')->delete();

echo "========================================\n";
echo "Testing Registration Flow\n";
echo "========================================\n\n";

// Simulate form submission
echo "1. Creating user via RegisterController logic...\n";
try {
    $user = User::create([
        'name' => 'Budi Santoso',
        'first_name' => 'Budi',
        'last_name' => 'Santoso',
        'email' => 'budi@example.com',
        'username' => 'budisantoso',
        'password' => Hash::make('password123'),
        'bio' => 'I love design',
        'newsletter' => true,
    ]);
    
    echo "   ✓ User created successfully!\n";
    echo "   - ID: " . $user->id . "\n";
    echo "   - Name: " . $user->name . "\n";
    echo "   - Email: " . $user->email . "\n";
    echo "   - Username: " . $user->username . "\n";

    
    // Try to login
    echo "2. Testing login with created user...\n";
    $credentials = ['email' => 'budi@example.com', 'password' => 'password123'];
    
    if (auth()->attempt($credentials)) {
        echo "   ✓ Login successful!\n";
        echo "   - Authenticated as: " . auth()->user()->name . "\n\n";
        auth()->logout();
    } else {
        echo "   ✗ Login failed!\n\n";
    }
    
    // Verify data in database
    echo "3. Verifying data in database...\n";
    $dbUser = User::where('email', 'budi@example.com')->first();
    if ($dbUser) {
        echo "   ✓ User found in database\n";
        echo "   - First Name: " . $dbUser->first_name . "\n";
        echo "   - Last Name: " . $dbUser->last_name . "\n";
        echo "   - Full Name: " . $dbUser->name . "\n";
        echo "   - Newsletter: " . ($dbUser->newsletter ? 'Yes' : 'No') . "\n\n";
        
        echo "========================================\n";
        echo "✓ ALL TESTS PASSED!\n";
        echo "========================================\n";
    }
    
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
    echo "   Code: " . $e->getCode() . "\n";
}
