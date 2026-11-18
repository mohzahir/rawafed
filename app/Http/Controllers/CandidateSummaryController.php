<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class CandidateSummaryController extends Controller
{
    public function __invoke(Candidate $candidate)
    {
        abort_unless($candidate->is_active && $candidate->summary_cv_path, 404);

        $disk = Storage::disk('local');
        abort_unless($disk->exists($candidate->summary_cv_path), 404);

        return response($disk->get($candidate->summary_cv_path), 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Security-Policy' => "default-src 'none'; style-src 'unsafe-inline'; base-uri 'none'; form-action 'none'",
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}