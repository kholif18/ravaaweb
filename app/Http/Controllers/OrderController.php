<?php

namespace App\Http\Controllers;

use App\Models\OrderSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Show wedding form
     */
    public function weddingForm()
    {
        return view('orders.wedding');
    }

    /**
     * Show khitan form
     */
    public function khitanForm()
    {
        return view('orders.khitan');
    }

    /**
     * Show baby name form
     */
    public function babyNameForm()
    {
        return view('orders.baby-name');
    }

    /**
     * Show birthday form
     */
    public function birthdayForm()
    {
        return view('orders.birthday');
    }

    /**
     * Submit order
     */
    public function submit(Request $request)
    {
        $type = $request->input('order_type');

        // Validation rules per type
        $rules = [
            'customer_name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'order_type' => 'required|in:wedding,khitan,baby_name,birthday',
            'notes' => 'nullable|string|max:1000',
            'file' => 'nullable|array|max:5', // max 5 files
            'file.*' => 'file|max:5120', // each file max 5MB
        ];

        // Type-specific validation
        $rules = match ($type) {
            'wedding' => array_merge($rules, [
                'bride_full_name' => 'required|string|max:255',
                'bride_nickname' => 'required|string|max:100',
                'bride_father' => 'required|string|max:255',
                'bride_mother' => 'required|string|max:255',
                'bride_address' => 'required|string|max:500',
                'groom_full_name' => 'required|string|max:255',
                'groom_nickname' => 'required|string|max:100',
                'groom_father' => 'required|string|max:255',
                'groom_mother' => 'required|string|max:255',
                'groom_address' => 'required|string|max:500',
                'resepsi_day' => 'required|string|max:20',
                'resepsi_date' => 'required|date',
                'resepsi_venue' => 'required|string|max:255',
                'akad_day' => 'nullable|string|max:20',
                'akad_date' => 'nullable|date',
                'akad_time' => 'nullable|string|max:20',
                'akad_venue' => 'nullable|string|max:255',
                'resepsi_time' => 'nullable|string|max:20',
                'entertainment' => 'nullable|string|max:500',
            ]),
            'khitan' => array_merge($rules, [
                'child_name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'mother_name' => 'required|string|max:255',
                'address' => 'required|string|max:500',
                'resepsi_day' => 'required|string|max:20',
                'resepsi_date' => 'required|date',
                'resepsi_venue' => 'required|string|max:255',
                'entertainment' => 'nullable|string|max:500',
            ]),
            'baby_name' => array_merge($rules, [
                'baby_full_name' => 'required|string|max:255',
                'baby_nickname' => 'nullable|string|max:100',
                'birth_day' => 'nullable|string|max:50',
                'birth_date' => 'required|date',
                'birth_order' => 'nullable|integer|min:1',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'weight' => 'nullable|string|max:20',
                'height' => 'nullable|string|max:20',
                'birth_time' => 'nullable|string|max:20',
                'parent_names' => 'required|string|max:255',
            ]),
            'birthday' => array_merge($rules, [
                'person_name' => 'required|string|max:255',
                'age' => 'required|integer|min:1|max:150',
                'event_day' => 'required|string|max:20',
                'event_date' => 'required|date',
                'theme' => 'nullable|string|max:255',
            ]),
            default => $rules,
        };

        $validated = $request->validate($rules);

        // Build data array (form-specific fields)
        $data = match ($type) {
            'wedding' => [
                'bride' => [
                    'full_name' => $validated['bride_full_name'],
                    'nickname' => $validated['bride_nickname'],
                    'father' => $validated['bride_father'],
                    'mother' => $validated['bride_mother'],
                    'address' => $validated['bride_address'],
                ],
                'groom' => [
                    'full_name' => $validated['groom_full_name'],
                    'nickname' => $validated['groom_nickname'],
                    'father' => $validated['groom_father'],
                    'mother' => $validated['groom_mother'],
                    'address' => $validated['groom_address'],
                ],
                'akad' => [
                    'day' => $validated['akad_day'] ?? null,
                    'date' => $validated['akad_date'] ?? null,
                    'time' => $validated['akad_time'] ?? null,
                    'venue' => $validated['akad_venue'] ?? null,
                ],
                'resepsi' => [
                    'day' => $validated['resepsi_day'],
                    'date' => $validated['resepsi_date'],
                    'time' => $validated['resepsi_time'] ?? null,
                    'venue' => $validated['resepsi_venue'],
                ],
                'entertainment' => $validated['entertainment'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ],
            'khitan' => [
                'child_name' => $validated['child_name'],
                'father_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'address' => $validated['address'],
                'resepsi' => [
                    'day' => $validated['resepsi_day'],
                    'date' => $validated['resepsi_date'],
                    'venue' => $validated['resepsi_venue'],
                ],
                'entertainment' => $validated['entertainment'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ],
            'baby_name' => [
                'full_name' => $validated['baby_full_name'],
                'nickname' => $validated['baby_nickname'] ?? null,
                'birth_day' => $validated['birth_day'] ?? null,
                'birth_date' => $validated['birth_date'],
                'birth_order' => $validated['birth_order'] ?? null,
                'gender' => $validated['gender'],
                'weight' => $validated['weight'] ?? null,
                'height' => $validated['height'] ?? null,
                'birth_time' => $validated['birth_time'] ?? null,
                'parent_names' => $validated['parent_names'],
                'notes' => $validated['notes'] ?? null,
            ],
            'birthday' => [
                'person_name' => $validated['person_name'],
                'age' => $validated['age'],
                'event_day' => $validated['event_day'],
                'event_date' => $validated['event_date'],
                'theme' => $validated['theme'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ],
        };

        // Handle file upload (multiple)
        $filePaths = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $filePaths[] = $file->store('order-submissions', 'public');
            }
        }

        // Create submission
        $submission = OrderSubmission::create([
            'type' => $type,
            'customer_name' => $validated['customer_name'],
            'whatsapp' => $validated['whatsapp'],
            'email' => $validated['email'] ?? null,
            'data' => $data,
            'file_path' => !empty($filePaths) ? $filePaths : null,
            'status' => 'pending',
        ]);

        // Redirect to thank you page with WhatsApp link
        $whatsappNumber = $this->getWhatsAppNumber();
        $message = $this->buildWhatsAppMessage($submission);
        $waUrl = $whatsappNumber
            ? "https://wa.me/{$whatsappNumber}?text=" . urlencode($message)
            : '#';

        return redirect()->route('order.thankyou', ['type' => $type])
            ->with('order_id', $submission->id)
            ->with('wa_url', $waUrl);
    }

    /**
     * Thank you page
     */
    public function thankyou(string $type)
    {
        $typeLabel = OrderSubmission::TYPE_LABELS[$type] ?? $type;
        return view('orders.thankyou', compact('type', 'typeLabel'));
    }

    /**
     * Get WhatsApp number from settings
     */
    private function getWhatsAppNumber(): ?string
    {
        $setting = \App\Models\Setting::where('key', 'whatsapp')->first();
        return $setting?->value;
    }

    /**
     * Build WhatsApp message from order
     */
    private function buildWhatsAppMessage(OrderSubmission $order): string
    {
        $typeLabel = $order->type_label;
        $lines = [
            "Halo, saya {$order->customer_name}",
            "Ingin memesan {$typeLabel}:",
            "",
        ];

        // Add type-specific details
        if ($order->type === 'wedding') {
            $bride = $order->getDataField('bride');
            $groom = $order->getDataField('groom');
            $resepsi = $order->getDataField('resepsi');
            $lines[] = "Mempelai Wanita: {$bride['full_name']} ({$bride['nickname']})";
            $lines[] = "Mempelai Pria: {$groom['full_name']} ({$groom['nickname']})";
            $lines[] = "Resepsi: {$resepsi['day']}, {$resepsi['date']}";
            $lines[] = "Lokasi: {$resepsi['venue']}";
        } elseif ($order->type === 'khitan') {
            $lines[] = "Nama Anak: {$order->getDataField('child_name')}";
            $resepsi = $order->getDataField('resepsi');
            $lines[] = "Resepsi: {$resepsi['day']}, {$resepsi['date']}";
            $lines[] = "Lokasi: {$resepsi['venue']}";
        } elseif ($order->type === 'baby_name') {
            $lines[] = "Nama Bayi: {$order->getDataField('full_name')}";
            $lines[] = "Tanggal Lahir: {$order->getDataField('birth_date')}";
            $lines[] = "Jenis Kelamin: {$order->getDataField('gender')}";
            $lines[] = "Orang Tua: {$order->getDataField('parent_names')}";
        } elseif ($order->type === 'birthday') {
            $lines[] = "Nama: {$order->getDataField('person_name')}";
            $lines[] = "Umur: {$order->getDataField('age')} tahun";
            $lines[] = "Hari: {$order->getDataField('event_day')}";
            $lines[] = "Tanggal: {$order->getDataField('event_date')}";
            $lines[] = "Tema: {$order->getDataField('theme')}";
        }

        return implode("\n", $lines);
    }
}
