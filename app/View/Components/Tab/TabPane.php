<?php

namespace App\View\Components\Tab;

use Illuminate\View\Component;

class TabPane extends Component
{
  public bool $active;
  public string $id;

  public function __construct($id, $active = false)
  {
    $this->active = $active;
    $this->id = $id;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.tab.tab-pane');
  }
}
