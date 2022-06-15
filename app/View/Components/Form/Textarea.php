<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
  public string $name;
  public string $label;
  public string|null $placeholder;

  public function __construct($name, $label, $placeholder = null)
  {
    $this->name = $name;
    $this->label = $label;
    $this->placeholder = $placeholder;
  }

  public function render()
  {
    return view('components.form.textarea');
  }
}
