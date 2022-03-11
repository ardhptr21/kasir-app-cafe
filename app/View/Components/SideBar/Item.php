<?php

namespace App\View\Components\SideBar;

use Illuminate\View\Component;

class Item extends Component
{

    public string $icon;
    public string $name;
    public string $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $icon, string $name, string $link)
    {
        $this->icon = $icon;
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.side-bar.item');
    }
}
