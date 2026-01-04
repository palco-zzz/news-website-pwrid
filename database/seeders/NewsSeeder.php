<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $newsData = [
            [
                "title" => "Revitalisasi Alun-alun Kutoarjo Mulai Masuki Tahap Akhir",
                "slug" => "revitalisasi-alun-alun-kutoarjo-tahap-akhir",
                "content" => "<p>Proses perbaikan fasilitas publik di Alun-alun Kutoarjo kini mencapai 90%. Pemerintah berharap area ini menjadi pusat ekonomi baru bagi warga Kutoarjo.</p>",
                "image" => "https://images.unsplash.com/photo-1596422846543-75c6fc197f07?q=80&w=2664&auto=format&fit=crop", // Public space/park
                "is_published" => true,
                "is_headline" => true,
                "is_trending" => false,
                "published_at" => "2026-01-04 10:00:00",
                "category" => "Pembangunan"
            ],
            [
                "title" => "Waspada Curah Hujan Tinggi, BPBD Purworejo Siaga Bencana Longsor",
                "slug" => "bpbd-purworejo-siaga-longsor-2026",
                "content" => "<p>BPBD menghimbau warga di area perbukitan Menoreh untuk waspada terhadap potensi tanah longsor menyusul hujan deras yang mengguyur wilayah Purworejo sepekan terakhir.</p>",
                "image" => "https://images.unsplash.com/photo-1519817914152-d2d8ee9bb627?q=80&w=2668&auto=format&fit=crop", // Rain/Moody landscape
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => true,
                "published_at" => "2026-01-04 08:30:00",
                "category" => "Bencana Alam"
            ],
            [
                "title" => "Festival Layang-Layang Internasional Kembali Digelar di Pantai Jatimalang",
                "slug" => "festival-layang-layang-jatimalang-2026",
                "content" => "<p>Ratusan peserta dari mancanegara akan memeriahkan langit Pantai Jatimalang dalam festival tahunan bergengsi bulan depan.</p>",
                "image" => "https://images.unsplash.com/photo-1534685785745-60a2cea0ec34?q=80&w=2525&auto=format&fit=crop", // Kites
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2026-01-03 15:00:00",
                "category" => "Pariwisata"
            ],
            [
                "title" => "Update Pembangunan Bendungan Bener: Target Pengairan Ribuan Hektar Sawah",
                "slug" => "update-pembangunan-bendungan-bener",
                "content" => "<p>Proyek strategis nasional Bendungan Bener terus dikebut untuk memastikan ketersediaan air bagi petani di wilayah Purworejo dan sekitarnya.</p>",
                "image" => "https://images.unsplash.com/photo-1582963321287-9bcbd393a5ee?q=80&w=2669&auto=format&fit=crop", // Dam/Construction
                "is_published" => true,
                "is_headline" => true,
                "is_trending" => true,
                "published_at" => "2026-01-03 09:00:00",
                "category" => "Pembangunan"
            ],
            [
                "title" => "Pasar Kutoarjo Pasca Kebakaran: Pedagang Mulai Tempati Lapak Sementara",
                "slug" => "pedagang-pasar-kutoarjo-lapak-sementara",
                "content" => "<p>Pemerintah daerah memfasilitasi tempat berjualan sementara bagi pedagang yang terdampak musibah kebakaran beberapa waktu lalu.</p>",
                "image" => "https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=2670&auto=format&fit=crop", // Traditional Market
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2026-01-02 11:00:00",
                "category" => "Ekonomi"
            ],
            [
                "title" => "Siswa SMK di Purworejo Ciptakan Inovasi Alat Pertanian Berbasis IoT",
                "slug" => "inovasi-smk-purworejo-iot-pertanian",
                "content" => "<p>Karya anak bangsa dari salah satu SMK di Purworejo ini berhasil meraih penghargaan tingkat provinsi karena efisiensinya bagi petani lokal.</p>",
                "image" => "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2670&auto=format&fit=crop", // Tech/Student
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2026-01-02 14:00:00",
                "category" => "Pendidikan"
            ],
            [
                "title" => "Geliat UMKM Clorot Grabag Tembus Pasar Ekspor",
                "slug" => "umkm-clorot-grabag-ekspor",
                "content" => "<p>Makanan khas Purworejo, Clorot, kini mulai diminati pasar luar negeri berkat kemasan baru yang lebih tahan lama.</p>",
                "image" => "https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=2574&auto=format&fit=crop", // Food
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => true,
                "published_at" => "2026-01-01 16:20:00",
                "category" => "UMKM"
            ],
            [
                "title" => "Dinkes Purworejo Gencarkan Vaksinasi Booster untuk Lansia",
                "slug" => "dinkes-purworejo-vaksinasi-booster",
                "content" => "<p>Upaya menjaga imunitas warga terus dilakukan dengan jemput bola ke desa-desa di wilayah Purworejo.</p>",
                "image" => "https://images.unsplash.com/photo-1584483766114-2cea6fac256d?q=80&w=2670&auto=format&fit=crop", // Health/Vaccine
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2026-01-01 07:00:00",
                "category" => "Kesehatan"
            ],
            [
                "title" => "Event Purworejo Run 2026 Tarik Minat Ribuan Pelari",
                "slug" => "purworejo-run-2026-ribuan-pelari",
                "content" => "<p>Rute lari melewati bangunan bersejarah di pusat kota menjadi daya tarik utama bagi para pelari dari luar kota.</p>",
                "image" => "https://images.unsplash.com/photo-1533560904424-a8c617a36e28?q=80&w=2670&auto=format&fit=crop", // Runner
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-31 06:00:00",
                "category" => "Olahraga"
            ],
            [
                "title" => "Peningkatan Volume Kendaraan di Jalur Daendels Menjelang Libur Panjang",
                "slug" => "jalur-daendels-ramai-lancar",
                "content" => "<p>Satlantas Polres Purworejo siagakan personel di titik-titik rawan kemacetan sepanjang jalur lintas selatan.</p>",
                "image" => "https://images.unsplash.com/photo-1494515843206-f3117d3f51b7?q=80&w=2672&auto=format&fit=crop", // Traffic/Road
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-30 13:00:00",
                "category" => "Lalu Lintas"
            ],
            [
                "title" => "Harga Beras di Pasar Baledono Mulai Mengalami Penurunan",
                "slug" => "harga-beras-baledono-turun",
                "content" => "<p>Hasil panen yang melimpah di tingkat petani lokal membuat pasokan beras di pasar tradisional kembali stabil.</p>",
                "image" => "https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=2574&auto=format&fit=crop", // Market/Rice
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-29 09:45:00",
                "category" => "Ekonomi"
            ],
            [
                "title" => "Komunitas Kreatif Purworejo Gelar Pameran Seni di Galeri Dewa Ruci",
                "slug" => "pameran-seni-dewa-ruci-purworejo",
                "content" => "<p>Ajang unjuk karya seniman muda Purworejo ini menampilkan lukisan, patung, hingga instalasi seni kontemporer.</p>",
                "image" => "https://images.unsplash.com/photo-1563205764-6e929cd43b71?q=80&w=2670&auto=format&fit=crop", // Art gallery
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-28 19:00:00",
                "category" => "Seni & Budaya"
            ],
            [
                "title" => "HUT Purworejo ke-195: Kirab Budaya Berlangsung Meriah",
                "slug" => "hut-purworejo-195-kirab-budaya",
                "content" => "<p>Peringatan hari jadi kabupaten diwarnai dengan arak-arakan gunungan hasil bumi dan pertunjukan seni rakyat.</p>",
                "image" => "https://images.unsplash.com/photo-1516962215378-7fa2e137ae93?q=80&w=2670&auto=format&fit=crop", // Cultural parade
                "is_published" => true,
                "is_headline" => true,
                "is_trending" => false,
                "published_at" => "2025-12-27 10:00:00",
                "category" => "Seni & Budaya"
            ],
            [
                "title" => "Perbaikan Jalan Rusak di Wilayah Bruno Jadi Prioritas Pemkab",
                "slug" => "perbaikan-jalan-bruno-prioritas",
                "content" => "<p>Akses jalan yang tertutup longsor dan rusak parah di wilayah Bruno mulai diperbaiki untuk mobilitas warga.</p>",
                "image" => "https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=2670&auto=format&fit=crop", // Road repair
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-26 08:00:00",
                "category" => "Pembangunan"
            ],
            [
                "title" => "Peluncuran Bus Trans Jateng Rute Purworejo-Magelang",
                "slug" => "trans-jateng-purworejo-magelang",
                "content" => "<p>Fasilitas transportasi umum ini diharapkan dapat mempermudah mobilitas pekerja dan pelajar antar kabupaten.</p>",
                "image" => "https://images.unsplash.com/photo-1570125909232-eb2be3b38962?q=80&w=2670&auto=format&fit=crop", // Bus
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => true,
                "published_at" => "2025-12-25 12:00:00",
                "category" => "Transportasi"
            ],
            [
                "title" => "Wisata Curug Siklotok Tawarkan Sensasi Alam Menoreh yang Asri",
                "slug" => "wisata-curug-siklotok-purworejo",
                "content" => "<p>Destinasi wisata air terjun di Kaligesing ini semakin populer dikunjungi wisatawan saat akhir pekan.</p>",
                "image" => "https://images.unsplash.com/photo-1463194537334-394078479e90?q=80&w=2672&auto=format&fit=crop", // Waterfall
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-24 14:30:00",
                "category" => "Pariwisata"
            ],
            [
                "title" => "KONI Purworejo Siapkan Atlet Unggulan untuk Porprov Jateng",
                "slug" => "koni-purworejo-siapkan-atlet-porprov",
                "content" => "<p>Cabang olahraga atletik dan pencak silat menjadi tumpuan utama Purworejo untuk mendulang medali emas.</p>",
                "image" => "https://images.unsplash.com/photo-1561574888-29ec96c31a70?q=80&w=2670&auto=format&fit=crop", // Athlete
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-23 09:00:00",
                "category" => "Olahraga"
            ],
            [
                "title" => "Inovasi Desa Digital di Purworejo Mulai Diterapkan di 10 Desa",
                "slug" => "inovasi-desa-digital-purworejo",
                "content" => "<p>Layanan administrasi desa kini bisa diakses secara online guna mempercepat pelayanan kepada masyarakat.</p>",
                "image" => "https://images.unsplash.com/photo-1544256718-3bcf237f3974?q=80&w=2671&auto=format&fit=crop", // Digital/Laptop
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-22 11:00:00",
                "category" => "Teknologi"
            ],
            [
                "title" => "Penanaman Ribuan Bibit Pohon di Area Sabuk Hijau Bendungan Bener",
                "slug" => "penanaman-pohon-bendungan-bener",
                "content" => "<p>Kegiatan penghijauan ini bertujuan untuk menjaga ekosistem dan mencegah erosi di sekitar bendungan.</p>",
                "image" => "https://images.unsplash.com/photo-1542601906990-24d4c16419d9?q=80&w=2674&auto=format&fit=crop", // Planting trees
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-21 10:00:00",
                "category" => "Lingkungan"
            ],
            [
                "title" => "Sosialisasi Bahaya Narkoba di Lingkungan Sekolah se-Purworejo",
                "slug" => "sosialisasi-narkoba-sekolah-purworejo",
                "content" => "<p>BNK Purworejo mengajak para pelajar untuk menjauhi narkoba demi masa depan yang lebih cerah.</p>",
                "image" => "https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2670&auto=format&fit=crop", // School/Seminar
                "is_published" => true,
                "is_headline" => false,
                "is_trending" => false,
                "published_at" => "2025-12-20 08:00:00",
                "category" => "Pendidikan"
            ]
        ];

        foreach ($newsData as $data) {
            News::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'excerpt' => Str::limit(strip_tags($data['content']), 150),
                'image' => $data['image'],
                'category' => $data['category'],
                'author_id' => $admin->id,
                'is_published' => $data['is_published'],
                'is_headline' => $data['is_headline'],
                'is_trending' => $data['is_trending'],
                'published_at' => $data['published_at'],
                'views_count' => rand(100, 5000),
            ]);
        }
    }
}
