<?php

// app/Http/Livewire/ExportButton.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportButton extends Component
{
    public bool $isExporting = false;

    public function export()
    {
        $this->isExporting = true;
        
        return new StreamedResponse(
            callback: $this->streamCSV(),
            status: 200,
            headers: [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export_'.now()->format('Y-m-d').'.csv"',
            ]
        );
    }

    private function streamCSV()
    {
        return function() {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'ID', 'Name', 'Email', 'Created At'
            ]);

            // Stream data in chunks
            User::query()
                ->chunk(1000, function ($records) use ($handle) {
                    foreach ($records as $record) {
                        fputcsv($handle, [
                            $record->id,
                            $record->name,
                            $record->email,
                            $record->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($handle);
        };
    }

    public function render()
    {
        return view('livewire.export-button');
    }
}
