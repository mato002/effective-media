<?php

use App\Http\Controllers\Admin\Cms\HomepageController;
use App\Http\Controllers\Admin\Cms\PortfolioItemController;
use App\Http\Controllers\Admin\Cms\ServiceController;
use App\Http\Controllers\Admin\Cms\StatisticController;
use App\Http\Controllers\Admin\Cms\TestimonialController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileDownloadRequestController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/who-we-are', [PageController::class, 'whoWeAre'])->name('who-we-are');
Route::get('/what-we-do', [PageController::class, 'whatWeDo'])->name('what-we-do');
Route::get('/services/{serviceSlug}', [PageController::class, 'serviceShowcase'])->name('services.show');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/smart-campaign-planner', [PageController::class, 'campaignPlanner'])->name('smart-campaign-planner');
Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('contact-us');
Route::get('/contact', [PageController::class, 'contactUs'])->name('contact');
Route::get('/quote', [PageController::class, 'quote'])->name('quote');
Route::post('/quote', [PageController::class, 'storeQuote'])->name('quote.store');
Route::get('/quote/success', [PageController::class, 'quoteSuccess'])->name('quote.success');
Route::get('/company-profiles/{filename}', [PageController::class, 'viewCompanyProfile'])
    ->where('filename', '.*\.pdf')
    ->name('company-profile.view');
Route::get('/company-profiles-download/{filename}', [PageController::class, 'downloadCompanyProfile'])
    ->where('filename', '.*\.pdf')
    ->name('company-profile.download');
Route::post('/company-profiles/download-request', [PageController::class, 'captureProfileDownload'])->name('company-profile.capture-download');
Route::get('/brand-assets/{filename}', [PageController::class, 'viewBrandAsset'])
    ->where('filename', '.*\.(jpg|jpeg|png|webp|gif|svg)')
    ->name('brand-asset.view');
Route::get('/advertise-in/{town}', [PageController::class, 'townLanding'])
    ->defaults('type', 'advertise-in')
    ->name('landing.advertise-in');
Route::get('/street-light-ads/{town}', [PageController::class, 'townLanding'])
    ->defaults('type', 'street-light-ads')
    ->name('landing.street-light-ads');
Route::get('/billboard-advertising/{town}', [PageController::class, 'townLanding'])
    ->defaults('type', 'billboard-advertising')
    ->name('landing.billboard-advertising');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->middleware('permission:admin.dashboard.view')
            ->name('dashboard');

        Route::resource('/quotes', QuoteRequestController::class)
            ->middleware('permission:quotes.manage')
            ->only(['index', 'show', 'destroy']);
        Route::get('/quotes-export', [QuoteRequestController::class, 'export'])
            ->middleware('permission:quotes.manage')
            ->name('quotes.export');

        Route::resource('/profile-downloads', ProfileDownloadRequestController::class)
            ->middleware('permission:documents.manage')
            ->parameters(['profile-downloads' => 'profileDownload'])
            ->only(['index', 'show', 'destroy']);
        Route::get('/profile-downloads-export', [ProfileDownloadRequestController::class, 'export'])
            ->middleware('permission:documents.manage')
            ->name('profile-downloads.export');

        Route::prefix('cms')->name('cms.')->group(function (): void {
            Route::get('/homepage', [HomepageController::class, 'edit'])
                ->middleware('permission:cms.homepage.manage')
                ->name('homepage.edit');
            Route::put('/homepage', [HomepageController::class, 'update'])
                ->middleware('permission:cms.homepage.manage')
                ->name('homepage.update');
            Route::resource('/services', ServiceController::class)
                ->middleware('permission:cms.services.manage')
                ->except(['show']);
            Route::resource('/portfolio', PortfolioItemController::class)
                ->middleware('permission:cms.portfolio.manage')
                ->except(['show']);
            Route::resource('/testimonials', TestimonialController::class)
                ->middleware('permission:cms.testimonials.manage')
                ->except(['show']);
            Route::resource('/statistics', StatisticController::class)
                ->middleware('permission:cms.statistics.manage')
                ->except(['show']);
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
