<?php

namespace App\Livewire;

use Livewire\Component;

class LandingPage extends Component
{
    // لم نعد بحاجة لأي متغيرات أو دوال معالجة هنا 
    // لأن صفحة الهبوط أصبحت مخصصة للعرض والتوجيه فقط

    public function render()
    {
        return view('components.landing-page')->layout('components.layouts.app');
    }
}