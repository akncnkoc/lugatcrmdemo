<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class Card extends Component
{
  public string $cardscroll;
  public string $target;

  public function __construct($cardscroll = "", $target = "")
  {
    $this->cardscroll = $cardscroll;
    $this->target = $target;
  }

  public function render()
  {
    return view('components.card.card');
  }
}
