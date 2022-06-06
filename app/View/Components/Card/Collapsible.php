<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Collapsible extends Component
{
  public string $target;
  public string $class;
  public function __construct($target, $class = "")
  {
    $this->target = $target;
    $this->class = $class;
  }
  public function render()
  {
    return view('components.card.collapsible');
  }
}
