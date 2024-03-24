<?php

namespace App\Http\Controllers;

use App\Models\UserAllowedIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllowedIpController extends Controller
{
    function getIps() {
        return UserAllowedIp::get();
    }

    public function saveIp(Request $request) {
        $ipAddress = Validator::make(
            [
                'ip' => $request->ip,
            ],
            [
                'ip' => 'required',
            ],
            [
                'required' => "O :attribute é obrigatório!",
            ],
            [
                'ip' => 'IP',
            ]
        );

        if ($ipAddress->fails()) {
            $errors = $ipAddress->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        } else {
            $ipAddress = $ipAddress->validate();
        }

        foreach ($this->getIps() as $key => $value) {
            if ($ipAddress['ip'] === $value->ip) {
                return redirect(route('allowedIps'))->with('message', 'IP já cadastrado!');
            }
        }

        $data = [
            'ip' => $ipAddress['ip'],
            'user_id' => auth()->user()->id,
        ];

        UserAllowedIp::create($data);

        return redirect(route('allowedIps'));
    }
}
