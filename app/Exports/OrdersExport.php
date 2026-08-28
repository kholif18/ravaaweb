<?php

namespace App\Exports;

use App\Models\OrderSubmission;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $orders;

    public function __construct($orders = null)
    {
        $this->orders = $orders;
    }

    public function collection(): Enumerable
    {
        if ($this->orders) {
            return $this->orders instanceof Enumerable
                ? $this->orders
                : collect($this->orders);
        }

        return OrderSubmission::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipe',
            'Nama Pemesan',
            'WhatsApp',
            'Email',
            'Status',
            // Wedding
            'Nama Mempelai Wanita',
            'Nama Mempelai Pria',
            'Akad Hari/Tanggal',
            'Akad Waktu',
            'Akad Tempat',
            'Resepsi Hari/Tanggal',
            'Resepsi Waktu',
            'Resepsi Tempat',
            // Khitan
            'Nama Anak',
            // Baby Name
            'Nama Lengkap Bayi',
            'Nama Panggilan',
            'Jenis Kelamin',
            'Berat',
            'Panjang',
            'Anak ke-',
            'Tanggal Lahir',
            'Jam Lahir',
            'Orang Tua',
            // Birthday
            'Nama Ulang Tahun',
            'Umur ke-',
            'Tema',
            // Common
            'Catatan',
            'Tanggal Submit',
        ];
    }

    public function map($order): array
    {
        $data = $order->data ?? [];

        return match ($order->type) {
            'wedding' => $this->mapWedding($order, $data),
            'khitan' => $this->mapKhitan($order, $data),
            'baby_name' => $this->mapBabyName($order, $data),
            'birthday' => $this->mapBirthday($order, $data),
            default => $this->mapDefault($order, $data),
        };
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
        ];
    }

    private function baseRow(OrderSubmission $order): array
    {
        return [
            $order->id,
            $order->type_label,
            $order->customer_name,
            $order->whatsapp,
            $order->email ?? '-',
            $order->status_label,
        ];
    }

    private function tailRow(OrderSubmission $order, array $data): array
    {
        return [
            $data['notes'] ?? $order->admin_notes ?? '-',
            \Carbon\Carbon::parse($order->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
        ];
    }

    private function mapWedding(OrderSubmission $order, array $data): array
    {
        return array_merge(
            $this->baseRow($order),
            [
                $data['bride']['full_name'] ?? '-',
                $data['groom']['full_name'] ?? '-',
                ($data['akad']['day'] ?? '') . ', ' . ($data['akad']['date'] ?? '-'),
                $data['akad']['time'] ?? '-',
                $data['akad']['venue'] ?? '-',
                ($data['resepsi']['day'] ?? '') . ', ' . ($data['resepsi']['date'] ?? '-'),
                $data['resepsi']['time'] ?? '-',
                $data['resepsi']['venue'] ?? '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
            ],
            $this->tailRow($order, $data)
        );
    }

    private function mapKhitan(OrderSubmission $order, array $data): array
    {
        return array_merge(
            $this->baseRow($order),
            [
                '-',
                '-',
                '-',
                '-',
                '-',
                ($data['resepsi']['day'] ?? '') . ', ' . ($data['resepsi']['date'] ?? '-'),
                '-',
                $data['resepsi']['venue'] ?? '-',
                $data['child_name'] ?? '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
            ],
            $this->tailRow($order, $data)
        );
    }

    private function mapBabyName(OrderSubmission $order, array $data): array
    {
        return array_merge(
            $this->baseRow($order),
            [
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                $data['full_name'] ?? '-',
                $data['nickname'] ?? '-',
                $data['gender'] ?? '-',
                $data['weight'] ?? '-',
                $data['height'] ?? '-',
                $data['birth_order'] ?? '-',
                $data['birth_date'] ?? '-',
                $data['birth_time'] ?? '-',
                $data['parent_names'] ?? '-',
                '-',
                '-',
                '-',
            ],
            $this->tailRow($order, $data)
        );
    }

    private function mapBirthday(OrderSubmission $order, array $data): array
    {
        return array_merge(
            $this->baseRow($order),
            [
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                '-',
                $data['person_name'] ?? '-',
                $data['age'] ?? '-',
                $data['theme'] ?? '-',
                '-',
            ],
            $this->tailRow($order, $data)
        );
    }

    private function mapDefault(OrderSubmission $order, array $data): array
    {
        return array_merge(
            $this->baseRow($order),
            array_fill(0, 21, '-'),
            $this->tailRow($order, $data)
        );
    }
}
