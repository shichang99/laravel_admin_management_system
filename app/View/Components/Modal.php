<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title, $subtitle, $crud, $contents;

    public function __construct( $crud, $title, $subtitle = '', $contents = '' )
    {
        $this->crud = $crud;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->contents = $contents;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
