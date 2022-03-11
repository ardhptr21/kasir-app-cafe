<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Overview extends Component
{
    public string $title;
    public string $value;
    public string $icon;
    public string $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $title, string $value, string $icon, string $color = '')
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.overview');
    }
}
