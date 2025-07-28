<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public function gotoModePage()
    {
        return redirect()->route('mode');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
