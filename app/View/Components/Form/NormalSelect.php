<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class NormalSelect extends Component
{
  public bool $editing;
  public string $name;
  public bool $required;
  public string $hint;
  public string $label;

  public function __construct($name, $label, $required = false, $editing = false, $hint = "")
  {
    $this->name = $name;
    $this->label = $label;
    $this->required = $required;
    $this->editing = $editing;
    $this->hint = $hint;
  }

  public function render()
  {
    return view('components.form.normal-select');
  }
}
