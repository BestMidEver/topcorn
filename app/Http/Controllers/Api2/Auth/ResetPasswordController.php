<?php

namespace App\Http\Controllers\Api2\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function sendResetPasswordEmail(Request $request)
    {
        $this->validateEmail($request);
        
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? 1/* $this->sendResetLinkResponse($response) */
                    : 0/* $this->sendResetLinkFailedResponse($request, $response) */;
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    public function broker()
    {
        return Password::broker();
    }

    public function resetPassword(Request $request)
    {
        $validator = $this->validate($request, $this->rules(), $this->validationErrorMessages());

        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }
        
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->changePassword($user, $password);
            }
        );
        
        return $response == Password::PASSWORD_RESET
                    ? 1
                    : 0;
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    
    protected function validationErrorMessages()
    {
        return [];
    }
    
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    
    protected function changePassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return 1;
    }
    
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }
    
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
    }
}
