<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AuthenticateMail;
use App\Mail\ForgotMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgot']]);
    }

    // ----------------------------- Authenticate ---------------------------------//

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $userCheck = User::where('email', $request->email)->first();
            if (!$userCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun belum terdaftar'
                ]);
            }

            $credentials = $request->only('email', 'password');


            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'email atau password salah ',
                ], 200);
            }

            if ($userCheck->is_verified_register == 1) {
                $initVerified = true;
            } else {
                $initVerified = false;
            }


            $mappedDataUser = [
                'name' => $userCheck ? $userCheck->name : null,
                'email' => $userCheck ? $userCheck->email : null,
                'is_verified_register' => $initVerified,
                'email_verified_at' => $userCheck ? $userCheck->email_verified_at : null,
                'token' => $token
            ];

            if ($userCheck['is_verified_register'] == false) {

                $validTokenRegister = rand(1000, 9999);

                $now = now();  // Waktu saat ini
                $expiredAt = $now->copy()->addHour()->toDateTimeString();

                // send new otp email notification
                $get_user_email = $userCheck['email'];
                $get_user_name = $userCheck['name'];
                Mail::to($userCheck['email'])->send(new AuthenticateMail($get_user_email, $get_user_name, $validTokenRegister));

                $updateOtp = $userCheck->update([
                    'otp_register' => $validTokenRegister,
                    'otp_register_expired_at' => $expiredAt
                ]);

                if ($updateOtp) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Akun belum terverifikasi, silahkan check email untuk verifikasi akun, (arah page ke verifikasi OTP)',
                        'data' => $mappedDataUser, // lek false (column isverified e) ngarah ke kode otp, ws dikirim ho
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal send otp baru'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sukses login',
                'data' => $mappedDataUser,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:15',
            'institusi' => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $validTokenRegister = rand(1000, 9999);

            // set state 1 jam expired
            $validTokenRegisterExpired = now()->addHours(1);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'institusi' => $request->institusi,
                'otp_register' => $validTokenRegister,
                'otp_register_expired_at' => $validTokenRegisterExpired
            ]);

            $token = Auth::guard('api')->login($user);

            // send email notification
            $get_user_email = $user['email'];
            $get_user_name = $user['name'];
            Mail::to($user['email'])->send(new AuthenticateMail($get_user_email, $get_user_name, $validTokenRegister));

            if ($user->is_verified_register == 0) {
                $user['is_verified_register'] = false;
            } else {
                $user['is_verified_register'] = true;
            }

            $mappedDataUser = [
                'name' => $user ? $user->name : null,
                'email' => $user ? $user->email : null,
                'is_verified_register' => $user ? $user->is_verified_register : null,
                'email_verified_at' => $user ? $user->email_verified_at : null,
                'token' => $token
            ];

            return response()->json([
                'success' => true,
                'message' => 'Berhasil membuat akun, cek email untuk OTP verifikasi',
                'data' => $mappedDataUser
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function newOtp()
    {
        $user = User::where('id', auth()->user()->id)->first();

        try {
            $validTokenRegister = rand(1000, 9999);

            // send new otp email notification
            $get_user_email = $user['email'];
            $get_user_name = $user['name'];
            Mail::to($user['email'])->send(new AuthenticateMail($get_user_email, $get_user_name, $validTokenRegister));

            $updateOtp = $user->update([
                'otp_register' => $validTokenRegister,
                'otp_register_expired_at' => now()->addHours(1)
            ]);

            if ($updateOtp) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP Baru berhasil dikirim'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal kirim otp baru'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // -------------------------- FORGOT PASSWORD -------------------------------------//

    public function forgot(Request $request)
    {
        $validate = Validator::make(request()->all(), [
            'email' => 'required|email'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()
            ], 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar'
                ]);
            }

            // create token jwt auth bisa tidak login
            $token = JWTAuth::fromUser($user);

            $validTokenForgot = rand(1000, 9999);

            // set state 1 jam expired
            $validTokenForgotExpired = now()->addHours(1);

            $user->update([
                'otp_forgot' => $validTokenForgot,
                'otp_forgot_expired_at' => $validTokenForgotExpired
            ]);

            // send email notification
            $get_user_email = $user['email'];
            $get_user_name = $user['name'];
            Mail::to($user['email'])->send(new ForgotMail($get_user_email, $get_user_name, $validTokenForgot));

            return response()->json([
                'success' => true,
                'message' => 'OTP lupa password berhasil dikirim, silahkan cek. (arah nak OTP Page)',
                'data' => [
                    'token' => $token,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'otp_forgot' => 'nullable',
            'otp_register' => 'nullable'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $initUser = User::where('id', auth()->user()->id)->first();
            if ($request->otp_register) {
                $token = $initUser->otp_register;
                if ($token != $request->otp_register) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP salah, cek kembali email anda untuk memastikan memasukkan OTP dengan benar'
                    ]);
                }

                if ($initUser->otp_register_expired_at < now()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP expired, silahkan tekan Resend OTP untuk mendapatkan OTP baru'
                    ]);
                }

                User::where('id', auth()->user()->id)->update([
                    'is_verified_register' => true,
                    'email_verified_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi berhasil (Arah login page)',
                ]);
            } else {
                $token = $initUser->otp_forgot;
                if ($token != $request->otp_forgot) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP salah, cek kembali email anda untuk memastikan memasukkan OTP dengan benar'
                    ]);
                }

                if ($initUser->otp_forgot_expired_at < now()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'OTP expired, silahkan tekan Resend OTP untuk mendapatkan OTP baru'
                    ]);
                }

                User::where('id', auth()->user()->id)->update([
                    'is_verified_forgot' => true,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi berhasil (Arah reset password page)',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // the point changes password service
    public function reset(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $user = User::where('id', auth()->user()->id)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terdaftar'
                ]);
            }

            $user->update([
                'password' => Hash::make($request->password),
                'is_verified_forgot' => false,
                'otp_forgot' => null,
                'otp_forgot_expired_at' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password Berhasil Dirubah, silahkan login dengan password baru',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ------------------------------------- LOGOUT ---------------------------------- //

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Success Logout',
        ]);
    }
}
