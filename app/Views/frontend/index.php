<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katalog Produk</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">

  <!-- Navbar -->
  <nav class="bg-white/30 backdrop-blur-lg shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-3">
      <h1 class="text-xl font-bold">📦 KatalogKu</h1>
      <ul class="flex gap-6">
        <li><a href="#" class="hover:text-blue-600">Semua</a></li>
        <li><a href="#" class="hover:text-blue-600">ATK</a></li>
        <li><a href="#" class="hover:text-blue-600">Percetakan</a></li>
        <li><a href="#" class="hover:text-blue-600">Desain</a></li>
      </ul>
    </div>
  </nav>

  <!-- Catalog Grid -->
  <section class="max-w-7xl mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold mb-6">Produk Kami</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

      <!-- Card Produk -->
      <div class="rounded-2xl shadow-lg p-4 bg-white/30 backdrop-blur-md border border-white/20 hover:scale-105 transition-transform cursor-pointer">
        <img src="https://via.placeholder.com/300x200" alt="Produk 1" class="rounded-lg mb-3">
        <h3 class="font-semibold text-lg">Produk 1</h3>
        <p class="text-sm text-gray-700">Deskripsi singkat produk.</p>
        <p class="mt-2 font-bold text-blue-600">Rp 25.000</p>
        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20mau%20pesan%20Produk%201" 
           target="_blank"
           class="mt-3 block text-center bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
          Pesan via WhatsApp
        </a>
      </div>

      <!-- Ulangi card produk lain -->
      <div class="rounded-2xl shadow-lg p-4 bg-white/30 backdrop-blur-md border border-white/20 hover:scale-105 transition-transform cursor-pointer">
        <img src="https://via.placeholder.com/300x200" alt="Produk 2" class="rounded-lg mb-3">
        <h3 class="font-semibold text-lg">Produk 2</h3>
        <p class="text-sm text-gray-700">Deskripsi singkat produk.</p>
        <p class="mt-2 font-bold text-blue-600">Rp 50.000</p>
        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20mau%20pesan%20Produk%202" 
           target="_blank"
           class="mt-3 block text-center bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600">
          Pesan via WhatsApp
        </a>
      </div>

      <!-- Tambahkan produk sesuai kebutuhan -->
    </div>
  </section>

</body>
</html>
