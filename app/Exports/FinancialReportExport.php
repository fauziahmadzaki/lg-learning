<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Removed
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FinancialReportExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithColumnFormatting, WithEvents
{
    protected $transactions;
    protected $title;

    public function __construct($transactions, $title = 'LAPORAN KEUANGAN')
    {
        $this->transactions = $transactions;
        $this->title = $title;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            [$this->title], // Row 1: Title
            [ // Row 2: Headers
                'Tanggal',
                'No. Invoice',
                'Nama Siswa',
                'Cabang',
                'Paket',
                'Nominal (Rp)',
                'Metode Pembayaran',
                'Waktu Pembayaran',
            ]
        ];
    }

    public function map($transaction): array
    {
        // Format Payment Method
        $paymentMethod = $transaction->payment_method;
        if ($paymentMethod === 'CASH') {
            $paymentMethod = 'Tunai';
        } elseif ($paymentMethod) {
            $paymentMethod = 'Online (' . $paymentMethod . ')';
        } else {
            $paymentMethod = '-';
        }

        return [
            $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->translatedFormat('Y-m-d') : $transaction->created_at->translatedFormat('Y-m-d'),
            $transaction->invoice_code,
            $transaction->student?->name ?? 'Siswa Terhapus',
            $transaction->student?->branch?->name ?? 'Tanpa Cabang',
            $transaction->student?->package?->name ?? 'Paket Terhapus',
            $transaction->total_amount,
            $paymentMethod,
            $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('H:i:s') : '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"_);_(@_)', // Accounting format for "Nominal (Rp)"
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Tanggal
            'B' => 18, // No. Invoice
            'C' => 25, // Nama Siswa
            'D' => 15, // Cabang
            'E' => 23, // Paket
            'F' => 18, // Nominal
            'G' => 20, // Metode Pembayaran
            'H' => 15, // Waktu Pembayaran
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        // Data Range starts from Row 3 (Row 1 Title, Row 2 Header, Row 3 Data)
        $dataRange = 'A2:' . $highestColumn . $highestRow;
        
        return [
            // Style Title (Row 1)
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Style Header (Row 2)
            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4B5563'], // Gray-600
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true, // Headers might wrap if too narrow
                ],
            ],
            // Style Table Borders (From Row 2 to Bottom)
            $dataRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
                'alignment' => [
                     'vertical' => Alignment::VERTICAL_CENTER,
                     'wrapText' => true, // Data wraps if it exceeds width
                ],
            ],
            // Center align specific columns
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Tanggal
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // No. Invoice
            'G' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Metode Pembayaran
            'H' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Waktu Pembayaran
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow(); // Last data row
                $highestColumn = $sheet->getHighestColumn();

                // --- PRINT SETTINGS ---
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0); // 0 means unlimited height

                // Merge Title Row (A1:H1)
                $sheet->mergeCells('A1:H1');
                
                // --- TOTAL INCOME ROW ---
                $totalRow = $highestRow + 1;
                $sheet->setCellValue('E' . $totalRow, 'TOTAL PENDAPATAN');
                $sheet->setCellValue('F' . $totalRow, '=SUM(F3:F' . $highestRow . ')'); // Sum Column F (Nominal)
                
                // Style Total Row
                $sheet->getStyle('E' . $totalRow . ':H' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('F' . $totalRow)->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"_);_(@_)');
                $sheet->getStyle('A' . $totalRow . ':H' . $totalRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // --- SIGNATURE SECTION ---
                $signatureStartRow = $totalRow + 3; // Leave 2 empty rows after Total

                // Add "Dibuat Oleh" and "Disetujui Oleh"
                $sheet->setCellValue('B' . $signatureStartRow, 'Dibuat Oleh,');
                $sheet->setCellValue('F' . $signatureStartRow, 'Disetujui Oleh,'); 

                // Center align signature titles
                $sheet->getStyle('B' . $signatureStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $signatureStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Add lines for signature
                $sheet->setCellValue('B' . ($signatureStartRow + 4), '( .............................. )');
                $sheet->setCellValue('F' . ($signatureStartRow + 4), '( .............................. )');

                // Center align signature lines
                $sheet->getStyle('B' . ($signatureStartRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . ($signatureStartRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
