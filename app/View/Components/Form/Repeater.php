<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Repeater extends Component
{

  public string $id;
  public string $buttonText;
  public string $template;
  public function __construct($id = "", $buttonText = "Ekle", $template = false)
  {
    $this->id = $id;
    $this->buttonText = $buttonText;
    $this->template = $template;
  }

  public function render()
  {
    return view('components.form.repeater');
  }
}
