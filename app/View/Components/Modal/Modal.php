<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class Modal extends Component
{
  public string $id;
  public string $size;

  public function __construct($id = "", $size = "")
  {
    $this->id = $id;
    $this->size = $size;
  }

  public function render()
  {
    return view('components.modal.modal');
  }
}
