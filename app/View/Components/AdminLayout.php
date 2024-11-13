<?php

namespace App\View\Components;

use Gate;
use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }
        return view('layouts.admin');
    }
}
