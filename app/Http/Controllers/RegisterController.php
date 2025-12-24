<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|min:3|max:20',
            'bio' => 'nullable|string|max:100',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,client',
            'proof_image' => 'required_if:role,mahasiswa,dosen|image|max:2048',
            'terms' => 'required|accepted',
        ]);

        // Create new user
        try {
            // Handle proof image if provided and role requires it
            $proofPath = null;
            if ($request->hasFile('proof_image')) {
                $proofPath = $request->file('proof_image')->store('proofs', 'public');
            }

            User::create([
                'role' => $validated['role'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'bio' => $validated['bio'] ?? null,
                'password' => Hash::make($validated['password']),
                // category removed from registration form per design decision
                'newsletter' => $request->has('newsletter'),
                'proof_image' => $proofPath,
                // default avatar: leave null so accessor will return the standard public avatar
                'avatar' => null,
            ]);

            return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }
}
