<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{

    /**
     * The alert type.
     *
     * @var string
     */
    public string $type;

    /**
     * The alert message.
     *
     * @var string
     */
    public string $message;

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

    private static function flashAlert(string $type, $message)
    {
        session()->flash('alertType', $type);
        session()->flash('alert', $message);
    }

    public static function success(string $message)
    {
        self::flashAlert('success', $message);
    }

    public static function warning(string $message)
    {
        self::flashAlert('warning', $message);
    }

    public static function info(string $message)
    {
        self::flashAlert('info', $message);
    }

    public static function danger(string $message)
    {
        self::flashAlert('danger', $message);
    }
}
