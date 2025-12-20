<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Removed
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StudentExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, WithEvents
{
    protected $students;
    protected $title;

    public function __construct($students, $title = 'LAPORAN DATA SISWA')
    {
        $this->students = $students;
        $this->title = $title;
    }

    public function collection()
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            [$this->title],
            [
                'Nama Siswa',
                'Telepon Orang Tua',
                'Sekolah',
                'Kelas',
                'Cabang',
                'Paket',
                'Status',
                'Tanggal Gabung',
            ]
        ];
    }

    public function map($student): array
    {
        $status = $student->status;
        switch($status) {
            case 'active': $status = 'Aktif'; break;
            case 'inactive': $status = 'Tidak Aktif'; break;
            case 'graduated': $status = 'Lulus'; break;
            case 'stopped': $status = 'Berhenti'; break;
        }

        return [
            $student->name,
            $student->parent_phone,
            $student->school,
            $student->grade,
            $student->branch?->name ?? 'Tanpa Cabang',
            $student->package?->name ?? 'Tanpa Paket',
            ucfirst($status),
            $student->created_at->format('d-m-Y'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25, // Nama Siswa
            'B' => 15, // Telepon
            'C' => 20, // Sekolah
            'D' => 10, // Kelas
            'E' => 15, // Cabang
            'F' => 15, // Paket
            'G' => 12, // Status
            'H' => 15, // Tanggal Gabung
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        // Data Start Row 2 is Header, Row 3 is Data
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
                    'wrapText' => true,
                ],
            ],
            // Style the entire table
            $dataRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
                'alignment' => [
                     'vertical' => Alignment::VERTICAL_CENTER,
                     'wrapText' => true,
                ],
            ],
            // Center align specific columns
            'B' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Telepon Orang Tua
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Kelas
            'G' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Status
            'H' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]], // Tanggal Gabung
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                // --- PRINT SETTINGS ---
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0); // 0 means unlimited height
                
                // Merge Title
                $sheet->mergeCells('A1:H1');

                // Signature Section
                $signatureStartRow = $highestRow + 3; // Leave 2 rows empty

                // Add "Dibuat Oleh" and "Disetujui Oleh"
                $sheet->setCellValue('B' . $signatureStartRow, 'Dibuat Oleh,');
                $sheet->setCellValue('F' . $signatureStartRow, 'Disetujui Oleh,'); // Moved to F for better balance on A4

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
