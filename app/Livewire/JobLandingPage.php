<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class JobLandingPage extends Component
{
    public $job;

    public function mount($slug)
    {
        // جلب الوظيفة بناءً على الرابط المخصص، وإذا كانت غير مفعلة يعطي 404
        $this->job = Job::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function render()
    {
        return view('components.job-landing-page')->layout('components.layouts.app', [
            'title' => $this->job->title . ' | روافد للتوظيف الطبي'
        ]);
    }
}