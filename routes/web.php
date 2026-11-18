<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateSummaryController;
use App\Http\Controllers\Admin\CandidateOriginalCvController;
use App\Http\Controllers\LoginController; 
use App\Livewire\LandingPage;
use App\Livewire\BlindCatalog;
use App\Livewire\Admin\BulkCsvUpload;
use App\Livewire\Admin\Dashboard;
use App\Livewire\CandidateRegistration;
// 🌟 استدعاء المتحكمات الجديدة
use App\Livewire\JobLandingPage;
use App\Livewire\Admin\JobManager;
use App\Livewire\Admin\HospitalRequestsManager;

// ==========================================
// المسارات العامة (متاحة للجميع)
// ==========================================
Route::get('/', LandingPage::class)->name('home');
Route::get('/catalog', BlindCatalog::class)->name('catalog');
Route::get('/join', CandidateRegistration::class)->name('candidate.register');
Route::get('/candidates/{candidate}/summary', CandidateSummaryController::class)
    ->name('candidates.summary');

// 🌟 مسار صفحة الهبوط للوظيفة (SEO Friendly)
Route::get('/jobs/{slug}', JobLandingPage::class)->name('jobs.show');

// ==========================================
// مسارات المصادقة وتسجيل الدخول (ضيف فقط)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// مسارات الإدارة المحمية (تتطلب تسجيل الدخول)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/candidates/{candidate}/original-cv', CandidateOriginalCvController::class)
        ->name('admin.candidates.original-cv');
    Route::get('/admin/import', BulkCsvUpload::class)->name('admin.import');
    Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
    
    // 🌟 مسار إدارة الوظائف
    Route::get('/admin/jobs', JobManager::class)->name('admin.jobs');
    
    // مسار لوحة إدارة طلبات المستشفيات (CRM)
    Route::get('/admin/requests', HospitalRequestsManager::class)->name('admin.requests');
});


Route::get('/keygen/{machine_id}', function ($machine_id) {
    $developerSecret = 'MY_SUPER_ERP_SUDAN_2026'; // يجب أن تتطابق مع الموجودة في كود العميل
    $expectedKeyRaw = strtoupper(substr(md5($machine_id . $developerSecret), 0, 16));
    return implode('-', str_split($expectedKeyRaw, 4));
});