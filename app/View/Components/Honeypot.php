<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Honeypot extends Component
{
    public $decoy, $timestamp;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->decoy = config('for-sale.honeypot.decoy_field');
        $this->timestamp = config('for-sale.honeypot.timestamp_field');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
            <input type="text"
                name="{{ $decoy }}"
                style="display: block;">

            <input type="text"
                    name="{{ $timestamp }}"
                    value="{{ microtime(true) }}"
                    style="display: block;">
        blade;
    }
}
