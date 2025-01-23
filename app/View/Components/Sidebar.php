<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $dataSidebar = [
            [
                "title" => "Produk",
                "assets" => "Package.png",
            ],
            [
                "title" => "Profile",
                "assets" => "User.png",
            ],
            [
                "title" => "Logout",
                "assets" => "SignOut.png",
            ]
        ];

        return view('components.sidebar')
            ->with([
                'dataSidebar' => $dataSidebar
            ]);
    }
}
