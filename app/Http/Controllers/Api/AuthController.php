<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserRegistration;

class AuthController extends Controller
{
    // ✅ 1. User Sign Up (basic)
    public function signUp(Request $request)
    {
        $request->merge([
        'password_confirmation' => $request->confirmPassword
    ]);
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'reseller_customer_id' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'token'   => $user->createToken('api_token')->plainTextToken,
            'user'    => $user,
        ]);
    }

    // ✅ 2. User Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        return response()->json([
            'success' => true,
            'token'   => $user->createToken('api_token')->plainTextToken,
            'user'    => $user,
        ]);
    }

    // ✅ 3. Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    // ✅ 4. Get Authenticated User
    

    // ✅ 5. Extended Registration and Reseller Signup
    public function storeFullRegistrationData(Request $request)
    {
        $request->validate([
            'address'     => 'required|string',
            'city'        => 'required|string',
            'state'       => 'required|string',
            'country'     => 'required|string',
            'zipcode'     => 'required|string',
            'phone'       => 'required|string',
            'phone_cc'    => 'required|string',
            'company'     => 'nullable|string',
        ]);

        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        // Save to user_registrations table
        $userRegistration = UserRegistration::create([
            'user_id'        => $user->id,
            'name'           => $user->name,
            'email'          => $user->email,
            'address'        => $request->address,
            'city'           => $request->city,
            'state'          => $request->state,
            'country'        => $request->country,
            'zipcode'        => $request->zipcode,
            'phone'          => $request->phone,
            'phone_cc'       => $request->phone_cc,
            'payment_status' => 'pending',
        ]);

        // Register on ResellerClub
        $resellerResponse = Http::asForm()->post('https://httpapi.com/api/customers/signup.json', [
            'auth-userid'    => '1257116',
            'api-key'        => 'IKe6WPxUtPR0U08HVHxitOdtk1aA0Heo',
            'username'       => $user->email,
            'passwd'         => 'User@12345',  // You may generate or store securely
            'name'           => $user->name,
            'company'        => $request->company ?? '',  // ✅ ensure it's sent
            'address' => $request->address,
            'city'           => $request->city,
            'state'          => $request->state,
            'country'        => $request->country,
            'zipcode'        => $request->zipcode,
            'phone_cc'       => $request->phone_cc,
            'phone'          => $request->phone,
            'lang-pref'      => 'en',
        ]);

        if (! $resellerResponse->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'ResellerClub customer creation failed',
                'details' => $resellerResponse->json(),
            ], 400);
        }

        $resellerCustomerId = $resellerResponse->json();
        $user->reseller_customer_id = $resellerCustomerId;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User registration data saved and ResellerClub account created.',
            'user_registration' => $userRegistration,
            'reseller_customer_id' => $resellerCustomerId,
        ]);
    }

    public function testUsers(Request $request)
    {
        return response()->json(User::all(),200);
    }
}
