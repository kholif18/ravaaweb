<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FrontendController extends Controller
{
    private function dummyProducts(): array
    {
        return [
            ['id' => 1, 'name' => 'Paket Desain Logo Profesional', 'slug' => 'desain-logo-profesional', 'category' => 'Desain Grafis', 'price' => 'Rp 499.000', 'image' => 'https://images.unsplash.com/photo-1545235617-9465d2a55698?w=800&q=80', 'badge' => 'Baru', 'type' => 'service', 'description' => 'Paket desain logo profesional dengan 3 konsep alternatif, revisi tanpa batas, dan file siap cetak. Cocok untuk branding bisnis Anda.'],
            ['id' => 2, 'name' => 'Cetak Brosur A4 Full Color', 'slug' => 'cetak-brosur-a4', 'category' => 'Percetakan', 'price' => 'Rp 1.200/lembar', 'original_price' => 'Rp 1.400/lembar', 'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800&q=80', 'badge' => 'Diskon 15%', 'type' => 'product', 'description' => 'Cetak brosur A4 full color dengan kertas art paper 150gsm. Hasil tajam dan warna akurat. Minimum order 100 lembar.'],
            ['id' => 3, 'name' => 'Sablon Kaos Polo Custom', 'slug' => 'sablon-kaos-polo', 'category' => 'Sablon & Merchandise', 'price' => 'Rp 85.000/pcs', 'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800&q=80', 'badge' => '', 'type' => 'product', 'description' => 'Sablon kaos polo custom dengan logo perusahaan. Tersedia berbagai warna, bahan premium combed 30s. Minimum 12 pcs.'],
            ['id' => 4, 'name' => 'Notebook Custom Logo', 'slug' => 'notebook-custom-logo', 'category' => 'ATK', 'price' => 'Rp 25.000/buku', 'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80', 'badge' => 'Terlaris', 'type' => 'product', 'description' => 'Notebook custom dengan logo perusahaan. Cover hardcover, isi kertas HVS 80gsm, 100 halaman. Pilihan warna cover.'],
            ['id' => 5, 'name' => 'Pembuatan Aplikasi Web', 'slug' => 'pembuatan-aplikasi-web', 'category' => 'Software House', 'price' => 'Mulai Rp 5.000.000', 'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&q=80', 'badge' => '', 'type' => 'service', 'description' => 'Jasa pembuatan aplikasi web custom sesuai kebutuhan bisnis Anda. Mulai dari company profile, e-commerce, hingga sistem informasi manajemen.'],
            ['id' => 6, 'name' => 'Paket Undangan Pernikahan', 'slug' => 'undangan-pernikahan', 'category' => 'Custom Invitations', 'price' => 'Mulai Rp 350.000', 'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&q=80', 'badge' => 'Popular', 'type' => 'service', 'description' => 'Paket undangan pernikahan exclusive dengan desain custom, pilihan bahan premium, dan finishing eksklusif. Termasuk amplop dan kartu ucapan.'],
        ];
    }

    private function dummyCategories(): array
    {
        return [
            ['id' => 1, 'name' => 'ATK & Stationery', 'slug' => 'atk-stationery', 'icon' => 'fa-solid fa-pen-fancy', 'description' => 'Perlengkapan alat tulis kantor dan stationery estetik berkualitas.'],
            ['id' => 2, 'name' => 'Percetakan', 'slug' => 'percetakan', 'icon' => 'fa-solid fa-print', 'description' => 'Layanan percetakan digital & offset dengan hasil premium.'],
            ['id' => 3, 'name' => 'Desain Grafis', 'slug' => 'desain-grafis', 'icon' => 'fa-solid fa-paint-brush', 'description' => 'Desain grafis profesional untuk logo, branding, dan materi promosi.'],
            ['id' => 4, 'name' => 'Custom Invitations', 'slug' => 'undangan', 'icon' => 'fa-solid fa-envelope-open-text', 'description' => 'Undangan custom untuk pernikahan, event, dan acara spesial.'],
            ['id' => 5, 'name' => 'Sablon & Merchandise', 'slug' => 'sablon-merchandise', 'icon' => 'fa-solid fa-tshirt', 'description' => 'Sablon kaos, mug, dan merchandise custom untuk branding.'],
            ['id' => 6, 'name' => 'Software House', 'slug' => 'software-house', 'icon' => 'fa-solid fa-laptop-code', 'description' => 'Jasa pembuatan website dan aplikasi custom.'],
        ];
    }

    private function dummyPortfolio(): array
    {
        return [
            ['id' => 1, 'title' => 'Sistem Informasi Sekolah', 'category' => 'Web App', 'client' => 'SMK Nusantara', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80', 'tech' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind'], 'description' => 'Sistem informasi manajemen sekolah berbasis web yang mencakup manajemen siswa, jadwal, nilai, dan rapor online.'],
            ['id' => 2, 'title' => 'E-Commerce Dekranasda', 'category' => 'Web App', 'client' => 'Dekranasda Jogja', 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80', 'tech' => ['React', 'Node.js', 'MongoDB', 'Redis'], 'description' => 'Platform e-commerce untuk produk UMKM dengan fitur marketplace, payment gateway, dan dashboard penjual.'],
            ['id' => 3, 'title' => 'Brand Identity Ravaa', 'category' => 'Desain Grafis', 'client' => 'Internal', 'image' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&q=80', 'tech' => ['Figma', 'Illustrator', 'Photoshop'], 'description' => 'Perancangan brand identity lengkap termasuk logo, stationery set, dan brand guidelines.'],
            ['id' => 4, 'title' => 'Aplikasi Mobile Laundry', 'category' => 'Mobile App', 'client' => 'CleanPro', 'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80', 'tech' => ['Flutter', 'Firebase', 'Laravel'], 'description' => 'Aplikasi mobile pemesanan laundry dengan fitur tracking real-time, payment digital, dan manajemen outlet.'],
            ['id' => 5, 'title' => 'Company Profile PT Maju', 'category' => 'Web Design', 'client' => 'PT Maju Jaya', 'image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&q=80', 'tech' => ['WordPress', 'Elementor', 'Custom CSS'], 'description' => 'Website company profile modern dengan animasi interaktif, galeri portofolio, dan form inquiry terintegrasi.'],
            ['id' => 6, 'title' => 'IoT Smart Farming', 'category' => 'IoT & Embedded', 'client' => 'AgriTech Corp', 'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&q=80', 'tech' => ['ESP32', 'Python', 'React', 'MongoDB'], 'description' => 'Sistem monitoring pertanian pintar berbasis IoT dengan sensor suhu, kelembaban, dan kontrol irigasi otomatis.'],
        ];
    }

    private function dummyServices(): array
    {
        return [
            [
                'name' => 'Desain Grafis', 'slug' => 'desain-grafis', 'icon' => 'fa-solid fa-paint-brush',
                'description' => 'Layanan desain grafis profesional untuk kebutuhan branding dan promosi bisnis Anda.',
                'features' => ['Logo & Brand Identity', 'Brosur & Flyer', 'Banner & Billboard', 'Kartu Nama & Stationery', 'Social Media Design', 'Packaging Design'],
            ],
            [
                'name' => 'Percetakan', 'slug' => 'percetakan', 'icon' => 'fa-solid fa-print',
                'description' => 'Layanan percetakan digital dan offset dengan kualitas premium dan harga kompetitif.',
                'features' => ['Cetak Brosur & Flyer', 'Cetak Banner & Spanduk', 'Cetak Buku & Majalah', 'Cetak Stiker & Label', 'Cetak Kardus & Packaging', 'Cetak Foto & Kanvas'],
            ],
            [
                'name' => 'Custom Invitations', 'slug' => 'undangan', 'icon' => 'fa-solid fa-envelope-open-text',
                'description' => 'Undangan custom eksklusif untuk momen spesial Anda dengan desain personalized.',
                'features' => ['Undangan Pernikahan', 'Undangan Khitanan', 'Undangan Akikah', 'Undangan Event Corporate', 'Cetak Amplop & Kartu', 'Desain Custom Eksklusif'],
            ],
            [
                'name' => 'ATK & Stationery', 'slug' => 'atk-stationery', 'icon' => 'fa-solid fa-pen-fancy',
                'description' => 'Perlengkapan ATK dan stationery estetik untuk menunjang produktivitas kantor Anda.',
                'features' => ['Notebook Custom', 'Pulpen & Pensil', 'Map & Amplop', 'Stempel & Name Tag', 'Meja & Kursi Kantor', 'Perlengkapan Meeting'],
            ],
            [
                'name' => 'Sablon & Merchandise', 'slug' => 'sablon-merchandise', 'icon' => 'fa-solid fa-tshirt',
                'description' => 'Layanan sablon dan pembuatan merchandise custom untuk branding perusahaan dan komunitas.',
                'features' => ['Sablon Kaos & Polo', 'Sablon Mug & Tumbler', 'Topi & Tas Custom', 'Gantungan Kunci', 'PIN & Lanyard', 'Goodie Bag'],
            ],
            [
                'name' => 'Software House', 'slug' => 'software-house', 'icon' => 'fa-solid fa-laptop-code',
                'description' => 'Jasa pengembangan software custom untuk solusi digital bisnis Anda.',
                'features' => ['Website Company Profile', 'Aplikasi Web Custom', 'Mobile App (Android/iOS)', 'Sistem Informasi', 'API Integration', 'Maintenance & Support'],
            ],
        ];
    }

    public function home()
    {
        $categories = array_map(fn($c) => (object) $c, $this->dummyCategories());
        $products = array_map(fn($p) => (object) $p, $this->dummyProducts());
        return view('frontend.home', compact('categories', 'products'));
    }

    public function layanan()
    {
        $services = array_map(fn($s) => (object) $s, $this->dummyServices());
        return view('frontend.layanan', compact('services'));
    }

    public function product(Request $request)
    {
        $categories = array_map(fn($c) => (object) $c, $this->dummyCategories());
        $products = array_map(fn($p) => (object) $p, $this->dummyProducts());

        // Filter by category
        if ($request->filled('category')) {
            $products = array_filter($products, fn($p) => $p->category === $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $products = array_filter($products, fn($p) => str_contains(strtolower($p->name), $search) || str_contains(strtolower($p->description), $search));
        }

        // Filter by type
        if ($request->filled('type')) {
            $products = array_filter($products, fn($p) => $p->type === $request->type);
        }

        $products = array_values($products);

        return view('frontend.product', compact('categories', 'products'));
    }

    public function detailProduct($slug)
    {
        $products = array_map(fn($p) => (object) $p, $this->dummyProducts());
        $product = collect($products)->firstWhere('slug', $slug);

        if (!$product) {
            abort(404);
        }

        $relatedProducts = collect($products)->where('category', $product->category)->where('id', '!=', $product->id)->take(4)->values()->all();

        return view('frontend.detail-product', compact('product', 'relatedProducts'));
    }

    public function portofolio()
    {
        $portfolioItems = array_map(fn($p) => (object) $p, $this->dummyPortfolio());
        return view('frontend.portofolio', compact('portfolioItems'));
    }

    public function softwareHouse()
    {
        $portfolioItems = array_map(fn($p) => (object) $p, $this->dummyPortfolio());
        $services = (object) collect($this->dummyServices())->firstWhere('slug', 'software-house');
        return view('frontend.software-house', compact('portfolioItems', 'services'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
