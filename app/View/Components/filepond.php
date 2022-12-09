<?php

namespace App\View\Components;

use Illuminate\View\Component;

class filepond extends Component
{
   public $id;
   public $label;
   public $max;
   public $required;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct($id, $label, $max, $required)
   {
      //
      $this->id = $id;
      $this->label = $label;
      $this->max = $max;
      $this->required = $required;
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|\Closure|string
    */
   public function render()
   {
      return view('components.filepond');
   }
}
