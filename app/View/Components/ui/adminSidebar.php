<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class adminSidebar extends Component
{
    /**
     * Create a new component instance.
     */

    public $UpperCase;
    public $LowerCase;
    public $Contains;

    public function __construct()
    {
        $this->UpperCase = function ($value) {
            return Str::of($value)->replace('-', ' ')->ucfirst();
        };
        $this->LowerCase = function ($value) {
            return Str::of($value)->replace('-', ' ')->lower();
        };
        $this->Contains = function ($value, $contains) {
            return Str::of($value)->contains($contains);
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.admin-sidebar');
    }
}
