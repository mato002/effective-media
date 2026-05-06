<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(): View
    {
        $query = QuoteRequest::query()->latest();

        $search = trim((string) request('search'));
        if ($search !== '') {
            $query->where(function ($q) use ($search): void {
                $like = '%' . $search . '%';
                $q->where('full_name', 'like', $like)
                    ->orWhere('company_name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('county', 'like', $like)
                    ->orWhere('location', 'like', $like)
                    ->orWhere('media_type', 'like', $like);
            });
        }

        return view('admin.quotes.index', [
            'quotes' => $query->paginate(20)->withQueryString(),
        ]);
    }

    public function show(QuoteRequest $quote): View
    {
        return view('admin.quotes.show', [
            'quote' => $quote,
        ]);
    }

    public function destroy(QuoteRequest $quote): RedirectResponse
    {
        $quote->delete();

        return redirect()
            ->route('admin.quotes.index')
            ->with('status', 'Quote request deleted.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'quote-requests-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, [
                'id',
                'full_name',
                'company_name',
                'phone',
                'email',
                'county',
                'location',
                'industry',
                'campaign_objective',
                'target_audience',
                'media_type',
                'campaign_duration',
                'budget_range',
                'campaign_slug',
                'message',
                'source',
                'created_at',
            ]);

            QuoteRequest::query()
                ->latest('id')
                ->chunk(200, static function ($quotes) use ($output): void {
                    foreach ($quotes as $quote) {
                        fputcsv($output, [
                            $quote->id,
                            $quote->full_name,
                            $quote->company_name,
                            $quote->phone,
                            $quote->email,
                            $quote->county,
                            $quote->location,
                            $quote->industry,
                            $quote->campaign_objective,
                            $quote->target_audience,
                            $quote->media_type,
                            $quote->campaign_duration,
                            $quote->budget_range,
                            $quote->campaign_slug,
                            $quote->message,
                            $quote->source,
                            optional($quote->created_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
