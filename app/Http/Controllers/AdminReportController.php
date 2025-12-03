<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    /**
    * Export consultations report as CSV (generic)
    */
    public function exportCsv(Request $request): StreamedResponse
    {
        $consultations = $this->getConsultations();

        $filename = 'consultations_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($consultations) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'ID',
                'Consultant',
                'Customer',
                'Topic',
                'Status',
                'Created At',
            ]);

            foreach ($consultations as $consultation) {
                fputcsv($handle, [
                    $consultation->id,
                    optional($consultation->consultantProfile?->user)->name ?? 'N/A',
                    optional($consultation->customer)->name ?? 'N/A',
                    $consultation->topic ?? 'N/A',
                    $consultation->status ?? 'N/A',
                    optional($consultation->created_at)?->format('Y-m-d H:i') ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    /**
    * Export consultations report as "Excel" (CSV with .xlsx-friendly headers)
    */
    public function exportExcel(Request $request): StreamedResponse
    {
        $consultations = $this->getConsultations();

        $filename = 'consultations_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($consultations) {
            $handle = fopen('php://output', 'w');

            // Excel-friendly UTF-8 BOM
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Consultant',
                'Customer',
                'Topic',
                'Status',
                'Created At',
            ]);

            foreach ($consultations as $consultation) {
                fputcsv($handle, [
                    $consultation->id,
                    optional($consultation->consultantProfile?->user)->name ?? 'N/A',
                    optional($consultation->customer)->name ?? 'N/A',
                    $consultation->topic ?? 'N/A',
                    $consultation->status ?? 'N/A',
                    optional($consultation->created_at)?->format('Y-m-d H:i') ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    /**
    * Show a printable HTML summary that can be saved as PDF via browser print.
    */
    public function exportPdf(Request $request)
    {
        $consultations = $this->getConsultations();

        return view('admin-folder.reports-pdf', [
            'consultations' => $consultations,
        ]);
    }

    /**
    * Common query for consultations used by all exports.
    */
    protected function getConsultations()
    {
        return Consultation::with(['consultantProfile.user', 'customer'])
            ->orderByDesc('created_at')
            ->get();
    }
}


