<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $umkmData = [
            [
                'name' => 'Soto Pak Rus Purworejo',
                'description' => 'Soto ayam kampung legendaris dengan kuah bening yang segar. Tersedia juga aneka sate seperti sate kerang, sate telur puyuh, dan perkedel. Cocok untuk sarapan dan makan siang.',
                'image' => 'https://images.unsplash.com/photo-1572656303169-694fe4e322d6?q=80&w=2670&auto=format&fit=crop', // Soto/Soup
                'category' => 'Kuliner',
                'address' => 'Jl. Mayjen Sutoyo No. 45, Purworejo',
                'phone' => '081234567890',
                'whatsapp' => '6281234567890',
                'instagram' => '@sotopakrus_pwr',
                'is_featured' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Batik Tulis Tirtonegoro',
                'description' => 'Produsen batik tulis halus dengan motif khas Purworejo seperti Manggis dan Kambing Etawa. Menerima pesanan seragam dan kain custom. Workshop terbuka untuk wisatawan yang ingin belajar membatik.',
                'image' => 'https://images.unsplash.com/photo-1599580665134-22b3b8c4c34d?q=80&w=2672&auto=format&fit=crop', // Batik/Fabric
                'category' => 'Kerajinan',
                'address' => 'Desa Tirtonegoro, Banyuurip, Purworejo',
                'phone' => '085678901234',
                'whatsapp' => '6285678901234',
                'instagram' => '@batiktirtonegoro',
                'is_featured' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Dawet Ireng Jembatan Butuh',
                'description' => 'Minuman segar khas Purworejo. Dawet berwarna hitam alami dari abu merang, disajikan dengan santan gurih dan gula merah asli. Nikmat diminum siang hari di pinggir sawah.',
                'image' => 'https://images.unsplash.com/photo-1550950158-d0d960dff51b?q=80&w=2670&auto=format&fit=crop', // Iced drink/Dessert
                'category' => 'Kuliner',
                'address' => 'Jembatan Butuh, Jalan Raya Purworejo-Kebumen',
                'phone' => '087890123456',
                'whatsapp' => null,
                'instagram' => null,
                'is_featured' => true,
                'is_verified' => false,
            ],
            [
                'name' => 'Geblek Bumbu Kacang Mbok Tas',
                'description' => 'Camilan tradisional dari tepung singkong yang kenyal dan gurih. Disajikan hangat dengan sambal bumbu kacang pedas manis. Oleh-oleh wajib khas Purworejo.',
                'image' => 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?q=80&w=2670&auto=format&fit=crop', // Fried snack
                'category' => 'Kuliner',
                'address' => 'Pasar Baledono Lantai Dasar',
                'phone' => '081345678901',
                'whatsapp' => '6281345678901',
                'instagram' => null,
                'is_featured' => false,
                'is_verified' => true,
            ],
            [
                'name' => 'Kopi Seplawan',
                'description' => 'Kopi Robusta asli dari pegunungan Menoreh. Diolah secara tradisional menghasilkan citarasa kopi yang pekat dan harum. Tersedia dalam bentuk bubuk dan biji sangrai.',
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=2574&auto=format&fit=crop', // Coffee
                'category' => 'Kuliner',
                'address' => 'Kawasan Wisata Goa Seplawan, Kaligesing',
                'phone' => '082123456789',
                'whatsapp' => '6282123456789',
                'instagram' => '@kopiseplawan',
                'is_featured' => false,
                'is_verified' => false,
            ],
            [
                'name' => 'Kerajinan Bambu "Awi Unik"',
                'description' => 'Aneka kerajinan tangan dari bambu seperti lampu hias, kursi, meja, dan perabotan rumah tangga. Desain modern namun tetap mempertahankan nuansa alami.',
                'image' => 'https://images.unsplash.com/photo-1506806732259-39c2d0268443?q=80&w=2672&auto=format&fit=crop', // Bamboo craft
                'category' => 'Kerajinan',
                'address' => 'Bruno, Purworejo',
                'phone' => '081298765432',
                'whatsapp' => '6281298765432',
                'instagram' => '@awi.unik',
                'is_featured' => false,
                'is_verified' => true,
            ],
            [
                'name' => 'Sate Winong',
                'description' => 'Sate kambing muda dengan bumbu kecap khas Winong yang legendaris. Daging empuk, bumbu meresap, dilengkapi dengan irisan bawang merah dan tomat segar.',
                'image' => 'https://images.unsplash.com/photo-1603360946369-dc9bb6f54262?q=80&w=2670&auto=format&fit=crop', // Satay
                'category' => 'Kuliner',
                'address' => 'Desa Winong, Kemiri, Purworejo',
                'phone' => '081312345678',
                'whatsapp' => '6281312345678',
                'instagram' => null,
                'is_featured' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Lanting Bumbu Aneka Rasa',
                'description' => 'Lanting renyah dengan varian rasa jagung bakar, pedas manis, keju, dan original. Pusat oleh-oleh khas Purworejo yang tahan lama dan harga terjangkau.',
                'image' => 'https://images.unsplash.com/photo-1599639535655-6b5825d14068?q=80&w=2574&auto=format&fit=crop', // Snacks
                'category' => 'Kuliner',
                'address' => 'Kutoarjo, Purworejo',
                'phone' => '085712345678',
                'whatsapp' => '6285712345678',
                'instagram' => '@lanting_enak',
                'is_featured' => false,
                'is_verified' => true,
            ]
        ];

        foreach ($umkmData as $data) {
            Umkm::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'image' => $data['image'],
                'category' => $data['category'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'whatsapp' => $data['whatsapp'],
                'instagram' => $data['instagram'],
                'owner_id' => $admin->id,
                'is_featured' => $data['is_featured'],
                'is_verified' => $data['is_verified'],
                'is_active' => true,
            ]);
        }
    }
}
