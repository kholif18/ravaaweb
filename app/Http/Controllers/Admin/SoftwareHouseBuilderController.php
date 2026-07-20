<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PortfolioItem;
use App\Models\SoftwareHouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        // Get Software House Services (independent from general services)
        // Defensive check: ensure table exists before querying
        $softwareServices = Schema::hasTable('software_house_services')
            ? SoftwareHouseService::ordered()->get()
            : collect();

        // Get filtered portfolio items belonging to the software categories
        $softwareCategories = $content['portfolio']['categories'] ?? ['Web App', 'Mobile App', 'IoT & Embedded'];
        $portfolioItems = PortfolioItem::whereIn('category', $softwareCategories)
            ->orderBy('order')
            ->orderBy('title')
            ->get();

        return view('admin.software-house.index', compact('page', 'content', 'availableCategories', 'softwareServices', 'portfolioItems'));
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
        ]);

        $page = Page::getBySlug('software-house');
        $page->update([
            'content' => $validated
        ]);

        return redirect()->route('admin.software-house.index', ['tab' => 'settings'])
            ->with('success', 'Konfigurasi Halaman Software House berhasil diperbarui!');
    }

    /**
     * Store a new software house service (independent from general services).
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'steps_text' => 'nullable|string',
        ]);

        $steps = array_values(array_filter(array_map('trim', explode("\n", $validated['steps_text'] ?? '')), fn($s) => !empty($s)));

        SoftwareHouseService::create([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'steps' => $steps,
        ]);

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan software baru berhasil ditambahkan!');
    }

    /**
     * Update a software house service.
     */
    public function updateService(Request $request, $id)
    {
        $shService = SoftwareHouseService::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'steps_text' => 'nullable|string',
        ]);

        $steps = array_values(array_filter(array_map('trim', explode("\n", $validated['steps_text'] ?? '')), fn($s) => !empty($s)));

        $shService->update([
            'title' => $validated['title'],
            'icon' => $validated['icon'],
            'steps' => $steps,
        ]);

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan software berhasil diperbarui!');
    }

    /**
     * Delete a software house service.
     */
    public function deleteService($id)
    {
        $shService = SoftwareHouseService::findOrFail($id);
        $shService->delete();

        return redirect()->route('admin.software-house.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan software berhasil dihapus!');
    }

    /**
     * Reorder software house services.
     */
    public function reorderServices(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:software_house_services,id',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['ids'] as $index => $id) {
                SoftwareHouseService::where('id', $id)->update(['order' => $index]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Urutan layanan berhasil diperbarui!']);
    }
}
