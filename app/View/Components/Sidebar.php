<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = $this->prepareItems(config('sidebar'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }

    public function prepareItems($items)
    {
        $user = Auth::user();
        foreach ($items as $key=>$item)
        {
            if (isset($item['ability']) && !$user->can($item['ability']))
            {
               unset($item[$key]);
            }

        }
        return $items;
    }
}
