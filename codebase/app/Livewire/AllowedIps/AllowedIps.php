<?php

namespace App\Livewire\AllowedIps;

use App\Models\UserAllowedIp;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class AllowedIps extends Component
{
    public $allowedIps;
    public $registerIpAddress;
    // public $deleteIpAddress;

    public function saveIp() {
        // dd($this->registerIpAddress);
        // $ipAddress = Validator::make(
        //     [
        //         'ip' => $this->registerIpAddress,
        //     ],
        //     [
        //         'ip' => 'required',
        //     ],
        //     [
        //         'required' => "O :attribute é obrigatório!",
        //     ],
        //     [
        //         'ip' => 'IP',
        //     ]
        // );

        foreach ($this->allowedIps as $key => $value) {
            if ($this->registerIpAddress === $value->ip) {
                return redirect(route('allowedIps'))->with('message', 'IP já cadastrado!');
            }
        }

        $data = [
            'ip' => $this->registerIpAddress,
            'user_id' => auth()->user()->id,
        ];

        UserAllowedIp::create($data);

        return redirect(route('allowedIps'));
    }

    public function deleteIpAddress($id) {
        UserAllowedIp::destroy($id);
        return redirect(route('allowedIps'));
    }

    public function render()
    {
        return view('allowedIps.allowed-ips');
    }
}
