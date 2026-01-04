<?php

namespace Database\Seeders;

use App\Models\CitizenReport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitizenReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        // Create a regular user for reporting
        $reporter = User::factory()->create([
            'name' => 'Warga Purworejo',
            'email' => 'warga@example.com',
        ]);

        $reports = [
            [
                'title' => 'Jalan Berlubang di Jalan Raya Winong',
                'content' => 'Mohon perhatian dinas terkait, terdapat lubang cukup dalam di tengah jalan raya Winong Km 5. Sangat membahayakan pengendara motor terutama saat malam hari karena minim penerangan. Sudah ada beberapa korban jatuh.',
                'image' => 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=2670&auto=format&fit=crop', // Pothole
                'category' => 'Infrastruktur',
                'location' => 'Jalan Raya Winong Km 5',
                'status' => 'verified',
                'is_anonymous' => false,
                'is_published' => true,
                'upvotes_count' => 15,
            ],
            [
                'title' => 'Tumpukan Sampah di Pasar Suronegaran',
                'content' => 'Sampah di TPS Pasar Suronegaran sudah menumpuk berhari-hari dan belum diangkut. Baunya sangat menyengat dan mengganggu aktivitas jual beli serta warga sekitar. Mohon segera ditindaklanjuti.',
                'image' => 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?q=80&w=2574&auto=format&fit=crop', // Garbage
                'category' => 'Lingkungan',
                'location' => 'Pasar Suronegaran',
                'status' => 'pending',
                'is_anonymous' => true,
                'is_published' => false,
                'upvotes_count' => 5,
            ],
            [
                'title' => 'Lampu PJU Mati di Perempatan Kutoarjo',
                'content' => 'Lampu penerangan jalan umum di perempatan lampu merah Kutoarjo mati total sudah 3 hari ini. Kondisi gelap gulita rawan kecelakaan dan kejahatan. Mohon perbaikan secepatnya.',
                'image' => 'https://images.unsplash.com/photo-1550523117-0b5c1c875152?q=80&w=2670&auto=format&fit=crop', // Street light/Dark street
                'category' => 'Fasilitas Umum',
                'location' => 'Perempatan Kutoarjo',
                'status' => 'resolved',
                'is_anonymous' => false,
                'is_published' => true,
                'upvotes_count' => 42,
            ],
            [
                'title' => 'Pohon Tumbang Menutup Jalan di Kaligesing',
                'content' => 'Akibat hujan deras semalam, ada pohon besar tumbang menutupi separuh jalan arah Kaligesing. Lalu lintas tersendat. Perlu evakuasi segera.',
                'image' => 'https://images.unsplash.com/photo-1562664348-2182b771e1ad?q=80&w=2670&auto=format&fit=crop', // Fallen tree/Storm damage
                'category' => 'Bencana',
                'location' => 'Jl. Kaligesing Km 8',
                'status' => 'in_progress',
                'is_anonymous' => false,
                'is_published' => true,
                'upvotes_count' => 28,
            ],
            [
                'title' => 'Saluran Irigasi Tersumbat di Bayan',
                'content' => 'Saluran irigasi sekunder di Desa Bayan tersumbat sampah plastik dan sedimen lumpur. Sawah warga terancam kekeringan padahal sedang masa tanam. Mohon bantuan normalisasi.',
                'image' => 'https://images.unsplash.com/photo-1550989460-0adf9ea622e2?q=80&w=2574&auto=format&fit=crop', // Water/Canal
                'category' => 'Pertanian',
                'location' => 'Desa Bayan',
                'status' => 'verified',
                'is_anonymous' => true,
                'is_published' => true,
                'upvotes_count' => 12,
            ],
        ];

        foreach ($reports as $data) {
            CitizenReport::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'image' => $data['image'],
                'category' => $data['category'],
                'location' => $data['location'],
                'reporter_id' => $data['is_anonymous'] ? null : $reporter->id,
                'reporter_name' => $data['is_anonymous'] ? 'Warga' : $reporter->name,
                'reporter_phone' => $data['is_anonymous'] ? null : '08123456789',
                'status' => $data['status'],
                'is_anonymous' => $data['is_anonymous'],
                'is_published' => $data['is_published'],
                'published_at' => $data['is_published'] ? now() : null,
                'upvotes_count' => $data['upvotes_count'],
            ]);
        }
    }
}
