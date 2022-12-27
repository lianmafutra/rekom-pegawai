<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    

   public $required;
 

   public $id;

   public $label;

   public $placeholder;

    public function __construct($required, $id, $label, $placeholder='')
    {
    
      $this->required = $required;
    
      $this->id = $id;
      $this->label = $label;
      $this->placeholder = $placeholder;
   }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select2');
    }
}
