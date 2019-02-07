<?php

namespace Illuminate\Foundation\Auth;

trait RedirectsUsers
{
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        /*if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }*/

        //return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
        $return_to = session()->has('links') ? session('links') : '/recommendations';
        Session::forget('links');
        
        return $return_to;
    }
}
