<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileDownloadRequest;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class ProfileDownloadRequestController extends Controller
{
    public function index(): View
    {
        return view('admin.profile-downloads.index', [
            'downloads' => ProfileDownloadRequest::query()
                ->latest()
                ->paginate(20),
        ]);
    }

    public function show(ProfileDownloadRequest $profileDownload): View
    {
        return view('admin.profile-downloads.show', [
            'download' => $profileDownload,
        ]);
    }

    public function destroy(ProfileDownloadRequest $profileDownload): RedirectResponse
    {
        $profileDownload->delete();

        return redirect()
            ->route('admin.profile-downloads.index')
            ->with('status', 'Profile download request deleted.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'profile-download-requests-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, [
                'id',
                'full_name',
                'company_name',
                'phone',
                'email',
                'filename',
                'source',
                'created_at',
            ]);

            ProfileDownloadRequest::query()
                ->latest('id')
                ->chunk(200, static function ($downloads) use ($output): void {
                    foreach ($downloads as $download) {
                        fputcsv($output, [
                            $download->id,
                            $download->full_name,
                            $download->company_name,
                            $download->phone,
                            $download->email,
                            $download->filename,
                            $download->source,
                            optional($download->created_at)->toDateTimeString(),
                        ]);
                    }
                });

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
