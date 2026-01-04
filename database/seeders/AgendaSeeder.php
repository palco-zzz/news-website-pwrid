<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();

        $agendas = [
            [
                'title' => 'Purworejo Expo 2026',
                'description' => 'Pameran produk unggulan UMKM, teknologi tepat guna, dan potensi investasi Kabupaten Purworejo. Dimeriahkan dengan panggung hiburan rakyat dan festival kuliner.',
                'date' => '2026-02-15',
                'time' => '09:00',
                'end_time' => '21:00',
                'location' => 'Alun-alun Purworejo',
                'category' => 'Pameran',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50935339?q=80&w=2535&auto=format&fit=crop', // Expo/Fair
                'status' => 'published',
            ],
            [
                'title' => 'Festival Durian Kaligesing',
                'description' => 'Ajang kontes durian unggulan lokal dan bazar makan durian sepuasnya. Menampilkan varietas durian terbaik dari kawasan pegunungan Menoreh.',
                'date' => '2026-01-25',
                'time' => '08:00',
                'end_time' => '16:00',
                'location' => 'Pasar Hewan Kaligesing',
                'category' => 'Festival',
                'image' => 'https://images.unsplash.com/photo-1587393855524-087f83d95bc9?q=80&w=2000&auto=format&fit=crop', // Durian
                'status' => 'published',
            ],
            [
                'title' => 'Car Free Day Edisi Spesial',
                'description' => 'Minggu pagi sehat tanpa kendaraan bermotor. Senam massal, layanan kesehatan gratis, dan pojok baca perpustakaan keliling.',
                'date' => '2026-01-11',
                'time' => '06:00',
                'end_time' => '09:00',
                'location' => 'Jalan Mayjen Sutoyo (Depan Pendopo)',
                'category' => 'Olahraga',
                'image' => 'https://images.unsplash.com/photo-1552674605-5d2178b84916?q=80&w=2670&auto=format&fit=crop', // Running/Sports crowd
                'status' => 'published',
            ],
            [
                'title' => 'Pagelaran Wayang Kulit Semalam Suntuk',
                'description' => 'Pagelaran wayang kulit dengan dalang kondang, membawakan lakon "Bimo Suci". Melestarikan budaya luhur bangsa.',
                'date' => '2026-01-20',
                'time' => '20:00',
                'end_time' => '04:00',
                'location' => 'Pendopo Kabupaten Purworejo',
                'category' => 'Budaya',
                'image' => 'https://images.unsplash.com/photo-1583095117911-53b9260d8441?q=80&w=2574&auto=format&fit=crop', // Wayang (using generic puppet/tradition image if exact not avail, this ID is shadow puppet)
                'status' => 'published',
            ],
            [
                'title' => 'Job Fair Purworejo',
                'description' => 'Bursa kerja terbuka untuk umum. Diikuti oleh 30 perusahaan lokal dan nasional. Siapkan CV terbaikmu!',
                'date' => '2026-03-01',
                'time' => '09:00',
                'end_time' => '15:00',
                'location' => 'Gedung Wanita Purworejo',
                'category' => 'Bursa Kerja',
                'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2669&auto=format&fit=crop', // Meeting/Job interview
                'status' => 'draft',
            ],
        ];

        foreach ($agendas as $data) {
            Agenda::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'date' => $data['date'],
                'time' => $data['time'],
                'end_time' => $data['end_time'],
                'location' => $data['location'],
                'category' => $data['category'],
                'image' => $data['image'],
                'status' => $data['status'],
                'created_by' => $admin ? $admin->id : null,
            ]);
        }
    }
}
