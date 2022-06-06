<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
  public string $label;
  public string $name;
  public string $hint;
  public bool $checked;
  public bool $required;

  public function __construct($label, $name, $hint = "", $checked = false, $required = false)
  {
    $this->label = $label;
    $this->name = $name;
    $this->hint = $hint;
    $this->checked = $checked;
    $this->required = $required;
  }

  public function render()
  {
    return view('components.form.checkbox');
  }
}
