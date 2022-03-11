<?php

namespace App\View\Components\SideBar;

use Illuminate\View\Component;

class DropdownContainer extends Component
{
    public string $icon;
    public string $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $icon)
    {
        $this->icon = $icon;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.side-bar.dropdown-container');
    }
}
