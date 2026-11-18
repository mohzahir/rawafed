<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class CandidateOriginalCvController extends Controller
{
    public function __invoke(Candidate $candidate)
    {
        abort_unless($candidate->original_cv_path, 404);

        $disk = Storage::disk('local');
        if (!$disk->exists($candidate->original_cv_path)) {
            $disk = Storage::disk('public');
        }
        abort_unless($disk->exists($candidate->original_cv_path), 404);

        return response($disk->get($candidate->original_cv_path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="candidate-' . $candidate->id . '.pdf"',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}