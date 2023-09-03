<?php

namespace App\Livewire\Helper;

use Carbon\Carbon;
use Livewire\Component;

class Clock extends Component
{
    public function render()
    {
        return view('livewire.helper.clock', [
            'clock' => Carbon::now()->format('d.m.y H:i'),
        ]);
    }
}
