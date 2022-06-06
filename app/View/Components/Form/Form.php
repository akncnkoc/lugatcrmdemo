<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Form extends Component
{
  public string $id;
  public string $class;
  public string $action;

  public function __construct($id = "", $class = "", $action = "")
  {
    $this->id = $id;
    $this->class = $class;
    $this->action = $action;
  }

  public function render()
  {
    return view('components.form.form');
  }
}
