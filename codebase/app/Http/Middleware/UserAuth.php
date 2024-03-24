<?php

namespace App\Http\Middleware;

use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Models\UserContact;
use App\Models\UserDocument;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{

    protected $except = [
        '/',
        'register',
        'home',
        'login',
        'logout',
        'terms-of-service',
        'privacy-policy',
        'forgot-password',
        'forgot-password-otp'
    ];

      
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->user()){
            return $next($request);
        }

        if (in_array(Route::current()->uri(), $this->except)) {
            return $next($request);
        }

        $authUser = auth()->user();
        $routerName = $request->route()->getName();
        $ignoreRoutes = config('exceptions')['ignore.routes'];

        if ($authUser->type !== 'ADMIN') {
            $contact = UserContact::query()->where('user_id', $authUser->id)->get();
            $address = UserAddress::where('user_id', $authUser->id)->first();
            $company = UserCompany::where('user_id', $authUser->id)->first();
            $documents = UserDocument::where('user_id', $authUser->id)->first();

            $emailFound = $contact->where('type', 'email')->count();
            $cellPhoneFound = $contact->where('type', 'cell_phone')->count();

            $redirect = false;
            if ($emailFound < 1 || $cellPhoneFound < 1) {
                $redirect = redirect(route('account.registerContactData'));
            }else if (!$address) {
                $redirect = redirect(route('account.registerAddress'));
            }else if (!$company) {
                $redirect = redirect(route('account.registerCompanyData'));
            }else if (!$documents) {
                $redirect = redirect(route('account.sendDocuments'));
            }else if ($authUser->status === 'pending') {
                $redirect = redirect(route('account.pending'));
            }else if($authUser->status === 'rejected'){
                $redirect = redirect(route('account.pending'));
            }else if($authUser->status === 'blocked' || $authUser->status === 'banned'){
                $redirect = redirect(route('account.banned'));
            }else if($authUser->status === 'inactive'){
                $redirect = redirect(route('account.inactive'));
            }

            if($redirect){
                if(route($routerName) === $redirect->getTargetUrl()){
                    return $next($request);
                }
            }
            if (!in_array($routerName, $ignoreRoutes) && $redirect) {
                return $redirect;
            }else{
                if(in_array($routerName, $ignoreRoutes)){
                    return redirect(route('dashboard'));
                }
            }
        }

        return $next($request);
    }
}
