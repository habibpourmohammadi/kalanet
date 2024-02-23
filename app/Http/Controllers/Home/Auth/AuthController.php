<?php

namespace App\Http\Controllers\Home\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Auth\loginRequest;
use App\Http\Requests\Home\Auth\VerifyEmailRequest;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;
use App\Models\Otp;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view("home.auth.login");
    }

    public function login(loginRequest $request)
    {
        $email = $request->email;

        $user = User::firstOrCreate([
            "email" => $email
        ]);

        $otp_code = rand(1111, 9999);
        $token = Str::random(40);

        Otp::create([
            "user_id" => $user->id,
            "token" => $token,
            "otp_code" => $otp_code,
        ]);

        $emailService = new EmailService();
        $details = [
            'title' => 'ایمیل فعال سازی حساب کاربری',
            'body' => "کد فعال سازی شما : $otp_code",
        ];
        $emailService->setDetails($details);
        $emailService->setFrom("noreplay@example.com", "shop");
        $emailService->setSubject("کد احراز هویت");
        $emailService->setTo($user->email);

        $messageService = new MessageService($emailService);
        $messageService->send();

        return to_route("home.auth.verifyEmail.page", $token);
    }

    public function verifyEmailPage($token)
    {
        $otp = Otp::where("token", $token)->first();

        return view("home.auth.verify-email", compact("otp", "token"));
    }

    public function verifyEmail(VerifyEmailRequest $request, $token)
    {
        $otp = Otp::where("token", $token)->first();
        $otp_code = $request->code;


        if ($otp == null) {
            return back()->with("error", "توکن وارد شده متعیر نیست");
        } elseif ($otp->created_at->addMinutes(5) < now()) {
            return back()->with("error", "زمان ارسال کد فعال سازی شما به پایان رسیده است");
        } elseif ($otp->used == 'true') {
            return back()->with("error", "این کد فعال سازی قبلا استفاده شده است");
        } elseif ($otp->otp_code != $otp_code) {
            return back()->with("error", "کد فعال سازی صحیح نمی باشد");
        }

        $user = User::where("id", $otp->user->id)->first();
        if ($user->email_verified_at == null) {
            $user->update([
                "email_verified_at" => now()
            ]);
        }
        $otp->update([
            "used" => "true"
        ]);

        Auth::login($user);
        return to_route("home.index");
    }

    public function logout()
    {
        Auth::logout();
        return back();
    }
}
