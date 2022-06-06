<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
  public string $name;
  public bool $required;
  public string $type;
  public string $label;
  public string $placeholder;
  public mixed $value;
  public bool $date;
  public bool $money;
  public bool $disabled;

  public function __construct($name, $value = "", $label = "", $placeholder = "", $type = "text", $required = false, $date = false, $money = false, $disabled = false)
  {
    $this->name = $name;
    $this->type = $type;
    $this->value = $value;
    $this->label = $label;
    $this->placeholder = $placeholder;
    $this->required = $required;
    $this->date = $date;
    $this->money = $money;
    $this->disabled = $disabled;
  }

  public function render()
  {
    return view('components.form.input');
  }
}
