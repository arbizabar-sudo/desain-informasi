<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// prepare fake file
$source = __DIR__ . '/public/images/image-3-148.png';
$targetDir = __DIR__ . '/storage/app/public/proofs';
@mkdir($targetDir, 0755, true);
$targetFile = $targetDir . '/proof_test_'.time().'.png';
if (file_exists($source)) {
    copy($source, $targetFile);
    echo "Copied sample image to: $targetFile\n";
}

// create mahasiswa user
User::where('email', 'mahasiswa@example.com')->delete();
$user = User::create([
    'name' => 'Mahasiswa User',
    'first_name' => 'Mahasiswa',
    'last_name' => 'User',
    'email' => 'mahasiswa@example.com',
    'username' => 'mahasiswa1',
    'password' => Hash::make('password123'),
    'role' => 'mahasiswa',
    'proof_image' => 'proofs/'.basename($targetFile)
]);

echo "Created user with role: " . $user->role . " and proof: " . $user->proof_image . "\n";

// create dosen user without file should fail - but we will create with file
User::where('email', 'dosen@example.com')->delete();
$user2 = User::create([
    'name' => 'Dosen User',
    'first_name' => 'Dosen',
    'last_name' => 'User',
    'email' => 'dosen@example.com',
    'username' => 'dosen1',
    'password' => Hash::make('password123'),
    'role' => 'dosen',
    'proof_image' => 'proofs/'.basename($targetFile)
]);

echo "Created user 2 with role: " . $user2->role . " and proof: " . $user2->proof_image . "\n";

// create client user
User::where('email', 'client@example.com')->delete();
$user3 = User::create([
    'name' => 'Client User',
    'first_name' => 'Client',
    'last_name' => 'User',
    'email' => 'client@example.com',
    'username' => 'client1',
    'password' => Hash::make('password123'),
    'role' => 'client',
    'proof_image' => null
]);

echo "Created user 3 with role: " . $user3->role . " and proof: " . var_export($user3->proof_image, true) . "\n";

// Verify DB
$users = User::whereIn('email', ['mahasiswa@example.com','dosen@example.com','client@example.com'])->get();
foreach ($users as $u) {
    echo "- $u->email => role=$u->role, proof=$u->proof_image\n";
}
