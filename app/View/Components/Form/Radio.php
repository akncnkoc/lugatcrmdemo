<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Radio extends Component
{
  public mixed $items;
  public string $checked;
  public string $name;
  public string $hint;
  public string $label;
  public bool $required;

  public function __construct($name, $label, $items = [], $checked = "", $hint = "", $required = false)
  {
    $this->name = $name;
    $this->items = $items;
    $this->checked = $checked;
    $this->hint = $hint;
    $this->label = $label;
    $this->required = $required;
  }

  public function render()
  {
    return view('components.form.radio');
  }
}
