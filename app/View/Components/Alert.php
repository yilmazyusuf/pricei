<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    const MESSAGE_SUCCESS = 'success';
    const MESSAGE_WARNING = 'warning';
    const MESSAGE_INFO = 'info';
    const MESSAGE_DANGER = 'danger';

    /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * Create the component instance.
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.alert');
    }

    public static function flashAlert(string $type, $message)
    {
        session()->flash('alertType', $type);
        session()->flash('alert', $message);
    }
}
