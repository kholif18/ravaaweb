<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoftwareHouseBuilderController extends Controller
{
    /**
     * Show the software house builder page.
     */
    public function index()
    {
        $defaultContent = [
            'hero' => [
                'title' => 'Software House',
                'description' => 'Kami mengembangkan solusi digital custom untuk bisnis Anda — dari website hingga aplikasi mobile dan IoT.',
            ],
            'layanan' => [
                'title' => 'Layanan Pengembangan Software',
                'subtitle' => 'Kami menyediakan layanan pengembangan software end-to-end yang disesuaikan dengan kebutuhan bisnis Anda.',
            ],
            'proses' => [
                'title' => 'Bagaimana Kami Bekerja',
                'subtitle' => 'Langkah-langkah sistematis untuk menghadirkan solusi software terbaik bagi bisnis Anda.',
                'steps' => [
                    [
                        'title' => 'Konsultasi',
                        'description' => 'Diskusi kebutuhan dan tujuan bisnis Anda untuk menentukan solusi yang tepat.',
                    ],
                    [
                        'title' => 'Desain',
                        'description' => 'Perancangan arsitektur sistem dan antarmuka pengguna yang intuitif.',
                    ],
                    [
                        'title' => 'Development',
                        'description' => 'Proses pengembangan menggunakan teknologi terkini dengan standar kualitas tinggi.',
                    ],
                    [
                        'title' => 'Launch',
                        'description' => 'Deployment ke production dan pendampingan hingga sistem berjalan lancar.',
                    ],
                ]
            ],
            'portfolio' => [
                'title' => 'Proyek Software Kami',
                'subtitle' => 'Beberapa proyek pengembangan software yang telah kami selesaikan.',
                'categories' => ['Web App', 'Mobile App', 'IoT & Embedded'],
            ]
        ];

        $page = Page::getBySlug('software-house', $defaultContent);
        
        $dbContent = $page->content ?? [];
        $content = array_replace_recursive($defaultContent, $dbContent);

        // Get unique categories from PortfolioItems for filtering choice
        $availableCategories = PortfolioItem::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->toArray();

        // Ensure defaults are present in available categories list
        $availableCategories = array_unique(array_merge($availableCategories, ['Web App', 'Mobile App', 'IoT & Embedded']));

        // Get Software House Service
        $service = Service::where('name', 'Software House')->first();

        // Get filtered portfolio items belonging to the software categories
        $softwareCategories = $content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded'];
        $portfolioItems = PortfolioItem::whereIn('category', $softwareCategories)
            ->orderBy('order')
            ->orderBy('title')
            ->get();

        return view('admin.software-house.index', compact('page', 'content', 'availableCategories', 'service', 'portfolioItems'));
    }

    /**
     * Store the software house builder page content (Tab 1).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hero.title' => 'required|string|max:255',
            'hero.description' => 'required|string',
            
            'layanan.title' => 'required|string|max:255',
            'layanan.subtitle' => 'required|string',
            
            'proses.title' => 'required|string|max:255',
            'proses.subtitle' => 'required|string',
            'proses.steps' => 'required|array|min:1',
            'proses.steps.*.title' => 'required|string|max:255',
            'proses.steps.*.description' => 'required|string',
            
            'portfolio.title' => 'required|string|max:255',
            'portfolio.subtitle' => 'required|string',
            'portfolio.categories' => 'required|array',
            'portfolio.categories.*' => 'string|max:255',
            
            // Service model parameters (configured in Tab 1 now)
            'service.icon' => 'nullable|string|max:100',
            'service.description' => 'nullable|string',
            'service.status' => 'required|in:active,inactive',
        ]);

        // Update Software House main service model
        $service = Service::where('name', 'Software House')->first();
        if ($service) {
            $service->update([
                'icon' => $validated['service']['icon'] ?? 'fa-solid fa-laptop-code',
                'description' => $validated['service']['description'] ?? '',
                'status' => $validated['service']['status'] ?? 'active',
            ]);
        }

        // Remove service payload from page configuration JSON
        $pageContent = $validated;
        unset($pageContent['service']);

        $page = Page::getBySlug('software-house');
        $page->update([
            'content' => $pageContent
        ]);

        return redirect()->route('admin.software-house.index', ['tab' => 'settings'])
            ->with('success', 'Konfigurasi Halaman & Detail Layanan berhasil diperbarui!');
    }

    /**
     * No longer needed as updateService is integrated into store().
     * We keep it to prevent routing exceptions or define it as empty.
     */
    public function updateService(Request $request, $id)
    {
        return redirect()->route('admin.software-house.index', ['tab' => 'settings']);
    }

    /**
     * Store a sub-feature in the Software House service features JSON array.
     */
    public function storeFeature(Request $request)
    {
        $service = Service::where('name', 'Software House')->firstOrFail();
        $features = $service->features ?? [];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'steps_text' => 'nullable|string',
        ]);

        $steps = array_values(array_filter(array_map('trim', explode("\n", $validated['steps_text'] ?? '')), fn($s) => !empty($s)));

        $features[] = [
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'steps' => $steps,
        ];

        $service->update(['features' => $features]);

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Sub-fitur layanan baru berhasil ditambahkan!');
    }

    /**
     * Update a sub-feature in the Software House service features JSON array.
     */
    public function updateFeature(Request $request, $index)
    {
        $service = Service::where('name', 'Software House')->firstOrFail();
        $features = $service->features ?? [];

        if (!isset($features[$index])) {
            return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
                ->with('error', 'Sub-fitur tidak ditemukan.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'steps_text' => 'nullable|string',
        ]);

        $steps = array_values(array_filter(array_map('trim', explode("\n", $validated['steps_text'] ?? '')), fn($s) => !empty($s)));

        $features[$index] = [
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'steps' => $steps,
        ];

        $service->update(['features' => $features]);

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Sub-fitur layanan berhasil diperbarui!');
    }

    /**
     * Delete a sub-feature from the Software House service features JSON array.
     */
    public function deleteFeature($index)
    {
        $service = Service::where('name', 'Software House')->firstOrFail();
        $features = $service->features ?? [];

        if (isset($features[$index])) {
            unset($features[$index]);
            $features = array_values($features); // Re-index keys
            $service->update(['features' => $features]);
        }

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Sub-fitur layanan berhasil dihapus!');
    }

    /**
     * Reorder the sub-features of Software House service.
     */
    public function reorderFeatures(Request $request)
    {
        $service = Service::where('name', 'Software House')->firstOrFail();
        $features = $service->features ?? [];

        $validated = $request->validate([
            'indexes' => 'required|array',
            'indexes.*' => 'required|integer',
        ]);

        $reordered = [];
        foreach ($validated['indexes'] as $idx) {
            if (isset($features[$idx])) {
                $reordered[] = $features[$idx];
            }
        }

        $service->update(['features' => $reordered]);

        return response()->json(['success' => true, 'message' => 'Urutan layanan berhasil diperbarui!']);
    }
}
