<?php

namespace App\View\Components\Tab;

use Illuminate\View\Component;

class NavLink extends Component
{
  public string $id;
  public bool $active;
  public function __construct($id, $active = false)
  {
    $this->id = $id;
    $this->active = $active;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.tab.nav-link');
  }
}
