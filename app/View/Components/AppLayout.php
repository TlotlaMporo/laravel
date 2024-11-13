<?php

namespace App\View\Components;

use Gate;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render():View
    {
        if (Gate::denies('not-admin')) {
            abort(403);
        }
        return view('layouts.app') ;
        
    }
}
