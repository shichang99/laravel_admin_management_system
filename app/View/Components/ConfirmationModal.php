<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConfirmationModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $crud, $title, $description;

    public function __construct( $crud, $title, $description )
    {
        $this->crud = $crud;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.confirmation-modal');
    }
}
