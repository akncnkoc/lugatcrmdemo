<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class RepeaterSelect extends Component
{
  public string $name;
  public string $class;
  public string $asyncload;
  public string $label;
  public string $parent;
  public string $hint;
  public bool $required;
  public bool $multiple;
  public bool $editing;
  public bool $disabled;

  public function __construct($name = "", $class = "", $asyncload = "", $label = "", $parent = "", $multiple = false, $required = false, $hint = "", $editing = false, $disabled = false)
  {
    $this->name = $name;
    $this->class = $class;
    $this->asyncload = $asyncload;
    $this->label = $label;
    $this->parent = $parent;
    $this->required = $required;
    $this->multiple = $multiple;
    $this->hint = $hint;
    $this->editing = $editing;
    $this->disabled = $disabled;
  }

  public function render()
  {
    return view('components.form.repeater-select');
  }
}
