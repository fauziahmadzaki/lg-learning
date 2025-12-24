<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
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
                'Kategori', // New
                'Keterangan', // New
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

        // Format Type
        $type = match($transaction->type) {
            'TUITION' => 'Pemasukan Bimbel',
            'SAVINGS_DEPOSIT' => 'Tabungan Masuk',
            'SAVINGS_WITHDRAWAL' => 'Penarikan Tabungan',
            default => $transaction->type,
        };

        return [
            $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->translatedFormat('Y-m-d') : $transaction->created_at->translatedFormat('Y-m-d'),
            $transaction->invoice_code,
            $type,
            $transaction->description ?? '-',
            $transaction->student?->name ?? 'Siswa Terhapus',
            $transaction->student?->branch?->name ?? 'Tanpa Cabang',
            $transaction->student?->package?->name ?? '-',
            $transaction->total_amount,
            $paymentMethod,
            $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('H:i:s') : '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"_);_(@_)', // Accounting format for "Nominal (Rp)" (Column H)
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Tanggal
            'B' => 18, // No. Invoice
            'C' => 20, // Kategori
            'D' => 25, // Keterangan
            'E' => 25, // Nama Siswa
            'F' => 15, // Cabang
            'G' => 20, // Paket
            'H' => 18, // Nominal
            'I' => 20, // Metode Pembayaran
            'J' => 15, // Waktu Pembayaran
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
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Invoice
            'C' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Kategori
            // D Left (Deskripsi)
            // E Left (Siswa)
            // F Left (Cabang)
            'G' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Paket
            // H Right (Nominal) is default for numbers
            'I' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Metode
            'J' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Waktu
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
                $sheet->getPageSetup()->setFitToHeight(0); 

                // Merge Title Row (A1:J1)
                $sheet->mergeCells('A1:J1');
                
                // --- SUMMARY SECTION ---
                $summaryStartRow = $highestRow + 2;

                // 1. Total Cash Masuk (Tuition + Savings Deposit)
                $sheet->setCellValue('G' . $summaryStartRow, 'TOTAL CASH MASUK');
                $sheet->setCellValue('H' . $summaryStartRow, '=SUMIF(C3:C'.$highestRow.', "Pemasukan Bimbel", H3:H'.$highestRow.') + SUMIF(C3:C'.$highestRow.', "Tabungan Masuk", H3:H'.$highestRow.')');
                
                // 2. Pemasukan Bimbel
                $sheet->setCellValue('G' . ($summaryStartRow + 1), 'Pemasukan Bimbel');
                $sheet->setCellValue('H' . ($summaryStartRow + 1), '=SUMIF(C3:C'.$highestRow.', "Pemasukan Bimbel", H3:H'.$highestRow.')');

                // 3. Tabungan Masuk
                $sheet->setCellValue('G' . ($summaryStartRow + 2), 'Tabungan Masuk');
                $sheet->setCellValue('H' . ($summaryStartRow + 2), '=SUMIF(C3:C'.$highestRow.', "Tabungan Masuk", H3:H'.$highestRow.')');

                // 4. Penarikan Tabungan
                $sheet->setCellValue('G' . ($summaryStartRow + 3), 'Total Penarikan');
                $sheet->setCellValue('H' . ($summaryStartRow + 3), '=SUMIF(C3:C'.$highestRow.', "Penarikan Tabungan", H3:H'.$highestRow.')');
                $sheet->getStyle('H' . ($summaryStartRow + 3))->getFont()->getColor()->setARGB('FFFF0000'); // Red for withdrawal

                // Style Summary
                $summaryRange = 'G' . $summaryStartRow . ':H' . ($summaryStartRow + 3);
                $sheet->getStyle($summaryRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('G' . $summaryStartRow . ':G' . ($summaryStartRow + 3))->getFont()->setBold(true);
                $sheet->getStyle('H' . $summaryStartRow . ':H' . ($summaryStartRow + 3))->getNumberFormat()->setFormatCode('_("Rp"* #,##0_);_("Rp"* (#,##0);_("Rp"* "-"_);_(@_)');

                // --- SIGNATURE SECTION ---
                $signatureStartRow = $summaryStartRow + 6; 

                // Add "Dibuat Oleh" and "Disetujui Oleh"
                $sheet->setCellValue('B' . $signatureStartRow, 'Dibuat Oleh,');
                $sheet->setCellValue('H' . $signatureStartRow, 'Disetujui Oleh,'); 

                // Center align signature titles
                $sheet->getStyle('B' . $signatureStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . $signatureStartRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Add lines for signature
                $sheet->setCellValue('B' . ($signatureStartRow + 4), '( .............................. )');
                $sheet->setCellValue('H' . ($signatureStartRow + 4), '( .............................. )');

                // Center align signature lines
                $sheet->getStyle('B' . ($signatureStartRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H' . ($signatureStartRow + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
