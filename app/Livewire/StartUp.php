<?php

namespace App\Livewire;

use Livewire\Component;

class StartUp extends Component
{
    public function gotoLoginPage() 
    {
        return redirect()->route('mode');
    }

    public function render()
    {
        return view('livewire.start-up');
    }
}
