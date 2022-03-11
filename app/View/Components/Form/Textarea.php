<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $name;
    public string $value;
    public string $placeholder;
    public string $label;
    public bool $isEdit;
    public string $error;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $placeholder, string $label = '', string $error = '', string $name = '',  bool $isEdit = true, string $value = "",)
    {
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->isEdit = $isEdit;
        $this->error = $error;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.textarea');
    }
}
