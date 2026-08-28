<?php

namespace App\Services;

use App\Models\OrderSubmission;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class OrderOdtService
{
    protected OrderSubmission $order;

    public function __construct(OrderSubmission $order)
    {
        $this->order = $order;
    }

    public function generate(): PhpWord
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->getStyle()->setMarginTop(720);
        $section->getStyle()->setMarginBottom(720);
        $section->getStyle()->setMarginLeft(900);
        $section->getStyle()->setMarginRight(900);

        // Header
        $this->addHeader($section);

        // Info Pesanan
        $this->addOrderInfo($section);

        // Data Pemesan
        $this->addCustomerInfo($section);

        // Data Spesifik Tipe
        $this->addTypeData($section);

        // Catatan
        $this->addNotes($section);

        return $phpWord;
    }

    public function save(string $path): void
    {
        $phpWord = $this->generate();
        $writer = IOFactory::createWriter($phpWord, 'ODText');
        $writer->save($path);
    }

    protected function addHeader($section): void
    {
        $section->addHeading('RAVAANET', 0, Jc::CENTER);
        $section->addText('Detail Pesanan', 11, ['alignment' => Jc::CENTER]);
        $section->addText('');
    }

    protected function addOrderInfo($section): void
    {
        $section->addHeading('Info Pesanan', 1);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(3000)->addText('Tipe Pesanan');
        $table->addCell(5000)->addText(': ' . $this->order->type_label);
        $table->addRow();
        $table->addCell(3000)->addText('Status');
        $table->addCell(5000)->addText(': ' . $this->order->status_label);
        $table->addRow();
        $table->addCell(3000)->addText('Tanggal');
        $table->addCell(5000)->addText(': ' . \Carbon\Carbon::parse($this->order->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm'));
        $table->addRow();
        $table->addCell(3000)->addText('ID Pesanan');
        $table->addCell(5000)->addText(': ' . $this->order->id);

        $section->addText('');
    }

    protected function addCustomerInfo($section): void
    {
        $section->addHeading('Data Pemesan', 1);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(3000)->addText('Nama');
        $table->addCell(5000)->addText(': ' . ($this->order->customer_name ?? '-'));
        $table->addRow();
        $table->addCell(3000)->addText('WhatsApp');
        $table->addCell(5000)->addText(': ' . ($this->order->whatsapp ?? '-'));
        $table->addRow();
        $table->addCell(3000)->addText('Email');
        $table->addCell(5000)->addText(': ' . ($this->order->email ?? '-'));

        $section->addText('');
    }

    protected function addTypeData($section): void
    {
        $data = $this->order->data ?? [];
        $section->addHeading('Data ' . $this->order->type_label, 1);

        match ($this->order->type) {
            'wedding' => $this->addWeddingData($section, $data),
            'khitan' => $this->addKhitanData($section, $data),
            'baby_name' => $this->addBabyNameData($section, $data),
            'birthday' => $this->addBirthdayData($section, $data),
            default => $section->addText('Tidak ada data spesifik'),
        };

        $section->addText('');
    }

    protected function addWeddingData($section, array $data): void
    {
        if (isset($data['bride'])) {
            $section->addHeading('Mempelai Wanita', 2);
            $table = $section->addTable();
            foreach ($data['bride'] as $key => $value) {
                if (is_string($value)) {
                    $table->addRow();
                    $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                    $table->addCell(5000)->addText(': ' . $value);
                }
            }
            $section->addText('');
        }

        if (isset($data['groom'])) {
            $section->addHeading('Mempelai Pria', 2);
            $table = $section->addTable();
            foreach ($data['groom'] as $key => $value) {
                if (is_string($value)) {
                    $table->addRow();
                    $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                    $table->addCell(5000)->addText(': ' . $value);
                }
            }
            $section->addText('');
        }

        if (isset($data['akad'])) {
            $section->addHeading('Akad Nikah', 2);
            $table = $section->addTable();
            foreach ($data['akad'] as $key => $value) {
                if (is_string($value)) {
                    $table->addRow();
                    $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                    $table->addCell(5000)->addText(': ' . $value);
                }
            }
            $section->addText('');
        }

        if (isset($data['resepsi'])) {
            $section->addHeading('Resepsi', 2);
            $table = $section->addTable();
            foreach ($data['resepsi'] as $key => $value) {
                if (is_string($value)) {
                    $table->addRow();
                    $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                    $table->addCell(5000)->addText(': ' . $value);
                }
            }
            $section->addText('');
        }
    }

    protected function addKhitanData($section, array $data): void
    {
        $table = $section->addTable();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $table->addRow();
                $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                $table->addCell(5000)->addText(': ' . $value);
            }
        }

        if (isset($data['resepsi']) && is_array($data['resepsi'])) {
            $section->addHeading('Resepsi', 2);
            $table2 = $section->addTable();
            foreach ($data['resepsi'] as $key => $value) {
                if (is_string($value)) {
                    $table2->addRow();
                    $table2->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                    $table2->addCell(5000)->addText(': ' . $value);
                }
            }
        }
    }

    protected function addBabyNameData($section, array $data): void
    {
        $table = $section->addTable();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $table->addRow();
                $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                $table->addCell(5000)->addText(': ' . $value);
            }
        }
    }

    protected function addBirthdayData($section, array $data): void
    {
        $table = $section->addTable();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $table->addRow();
                $table->addCell(3000)->addText(ucwords(str_replace('_', ' ', $key)));
                $table->addCell(5000)->addText(': ' . $value);
            }
        }
    }

    protected function addNotes($section): void
    {
        $notes = $this->order->admin_notes ?? $this->order->data['notes'] ?? null;

        if ($notes) {
            $section->addHeading('Catatan', 1);
            $section->addText($notes);
        }
    }
}
