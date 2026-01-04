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
                "content" => "<p><strong>KUTOARJO</strong> - Proses perbaikan fasilitas publik di Alun-alun Kutoarjo kini telah mencapai tahap akhir dengan progres fisik menyentuh angka 90%. Pemerintah Kabupaten Purworejo optimis proyek ini dapat diselesaikan tepat waktu dan segera dinikmati oleh masyarakat.</p><p>Revitalisasi ini meliputi perbaikan pedestrian, penataan ulang taman kota, serta penambahan fasilitas bermain anak dan area olahraga. Bupati Purworejo menyatakan bahwa wajah baru Alun-alun Kutoarjo diharapkan tidak hanya menjadi ruang terbuka hijau yang nyaman, tetapi juga dapat menjadi pusat pertumbuhan ekonomi baru bagi warga sekitar.</p><ul><li>Perbaikan pedestrian dengan material ramah disabilitas</li><li>Penambahan 20 titik lampu hias estetik</li><li>Pembangunan amphitheater mini untuk pertunjukan seni</li></ul><p>Pedagang kaki lima yang sebelumnya menempati area sekitar alun-alun juga akan ditata ulang di lokasi khusus yang lebih higienis dan tertib.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Badan Penanggulangan Bencana Daerah (BPBD) Kabupaten Purworejo mengeluarkan peringatan dini terkait potensi bencana tanah longsor, menyusul tingginya curah hujan yang mengguyur wilayah ini dalam sepekan terakhir.</p><p>Kepala BPBD Purworejo menghimbau warga yang tinggal di zona merah, khususnya di area perbukitan Menoreh seperti Kecamatan Kaligesing, Bruno, dan Bener, untuk meningkatkan kewaspadaan. \"Kami telah menyiagakan tim reaksi cepat dan posko bencana 24 jam untuk memantau situasi terkini,\" ujarnya.</p><p>Langkah antisipasi yang disarankan meliputi:</p><ul><li>Membersihkan saluran air dari sampah</li><li>Memperhatikan retakan tanah di sekitar hunian</li><li>Segera mengungsi jika hujan deras turun lebih dari 2 jam berturut-turut</li></ul>",
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
                "content" => "<p><strong>JATIMALANG</strong> - Langit Pantai Jatimalang akan kembali dihiasi warna-warni layang-layang raksasa. Festival Layang-Layang Internasional 2026 dipastikan akan digelar bulan depan dengan diikuti oleh ratusan peserta dari berbagai negara.</p><p>Dinas Pariwisata dan Kebudayaan Purworejo menargetkan lonjakan kunjungan wisatawan selama event berlangsung. Selain kompetisi layang-layang hias dan train naga, festival ini juga akan dimeriahkan dengan bazaar kuliner laut khas pesisir selatan dan panggung hiburan rakyat.</p><p>\"Ini adalah momentum untuk mempromosikan pariwisata Purworejo ke kancah internasional. Kami siap menyambut peserta dari Jepang, India, hingga Swedia,\" ungkap Ketua Panitia penyelenggara.</p>",
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
                "content" => "<p><strong>BENER</strong> - Pembangunan Proyek Strategis Nasional (PSN) Bendungan Bener terus menunjukkan progres positif. Hingga awal tahun ini, konstruksi tubuh bendungan utama telah berjalan signifikan, dengan fokus pada percepatan penyelesaian terowongan pengelak.</p><p>Bendungan tertinggi di Indonesia ini diproyeksikan mampu mengairi lahan pertanian seluas 15.000 hektar di Kabupaten Purworejo dan Kebumen. Selain fungsi irigasi, Bendungan Bener juga akan menyuplai air baku hingga 1.500 liter per detik dan berpotensi menghasilkan listrik (PLTA) sebesar 6 Mega Watt.</p><p>\"Target kami pengisian air awal (impounding) bisa dilakukan sesuai jadwal. Ini krusial untuk ketahanan pangan nasional,\" tegas pimpinan proyek saat meninjau lokasi.</p>",
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
                "content" => "<p><strong>KUTOARJO</strong> - Pasca musibah kebakaran hebat yang melanda Pasar Kutoarjo, aktivitas perdagangan perlahan mulai bangkit. Pemerintah Kabupaten Purworejo telah menyelesaikan pembangunan lapak darurat di area sekitar pasar untuk menampung ratusan pedagang yang terdampak.</p><p>Bupati Purworejo saat meresmikan pasar darurat menyampaikan keprihatinannya dan berjanji akan segera mengupayakan revitalisasi bangunan pasar utama. \"Yang terpenting saat ini pedagang bisa berjualan kembali untuk menyambung hidup. Kami bebaskan retribusi pasar selama 6 bulan ke depan untuk meringankan beban bapak ibu sekalian,\" ucapnya di hadapan para pedagang.</p><p>Para pedagang menyambut baik relokasi ini meski mengaku omzet penjualan belum sepenuhnya pulih seperti sedia kala.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Prestasi membanggakan kembali ditorehkan oleh pelajar Purworejo. Tim inovasi dari SMK Negeri di Purworejo berhasil menciptakan alat penyiram tanaman otomatis berbasis Internet of Things (IoT) yang dapat dikendalikan melalui smartphone.</p><p>Inovasi bernama \"Smart-Tani\" ini dilengkapi sensor kelembaban tanah dan suhu udara, sehingga penyiraman hanya dilakukan saat tanaman benar-benar membutuhkan air. Alat ini diklaim mampu menghemat penggunaan air hingga 40% dan sangat cocok diterapkan pada lahan pertanian hortikultura.</p><p>\"Kami ingin membantu petani milenial agar lebih efisien dalam mengelola lahan. Semoga alat ini bisa diproduksi massal dengan harga terjangkau,\" ujar ketua tim pengembang siswa.</p>",
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
                "content" => "<p><strong>GRABAG</strong> - Clorot, kue tradisional khas Purworejo yang terbungkus janur kuning, kini tak hanya bisa ditemui di pasar tradisional. Berkat inovasi pengemasan vakum dan sterilisasi, Clorot asal Kecamatan Grabag kini mampu menembus pasar ekspor hingga ke negara tetangga seperti Malaysia dan Singapura.</p><p>Salah satu pelaku UMKM, Bu Sami (54), mengaku kaget dengan respon pasar internasional. \"Awalnya cuma coba-coba kirim lewat reseller, ternyata banyak yang suka karena rasanya yang manis legit dan bentuknya yang unik,\" tuturnya.</p><p>Dinas KUKMP Purworejo terus memberikan pendampingan terkait perizinan ekspor dan standarisasi produk agar semakin banyak kuliner lokal yang bisa 'naik kelas' ke pasar global.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Dinas Kesehatan Kabupaten Purworejo kembali menggencarkan program vaksinasi booster, kali ini dengan prioritas utama kelompok lanjut usia (lansia). Langkah ini diambil sebagai antisipasi perlindungan kesehatan jangka panjang bagi kelompok rentan.</p><p>Layanan jemput bola pun dilakukan dengan menerjunkan tenaga kesehatan langsung ke balai desa dan posyandu lansia. \"Kami ingin memastikan akses vaksinasi semudah mungkin bagi mbah-mbah kita yang mungkin kesulitan mobilitas jika harus ke Puskesmas,\" jelas Kepala Dinkes.</p><p>Selain vaksinasi, kegiatan ini juga dirangkaikan dengan skrining kesehatan gratis meliputi cek tensi, gula darah, dan kolesterol.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Antusiasme tinggi masyarakat terlihat dalam gelaran 'Purworejo Run 2026'. Sebanyak 2.500 pelari dari berbagai daerah memadati Alun-alun Purworejo sejak pukul 05.00 WIB untuk mengikuti kategori 5K dan 10K.</p><p>Daya tarik utama event lari tahun ini adalah rutenya yang melintasi berbagai landmark bersejarah (heritage) di pusat kota Purworejo, seperti Gereja GPIB, Masjid Agung Darul Muttaqin, hingga kompleks pendopo kabupaten. \"Suasananya sangat sejuk dan rutenya steril, asyik sekali lari sambil menikmati bangunan tua,\" ujar salah satu peserta dari Yogyakarta.</p><p>Pemerintah berharap event sport tourism seperti ini dapat rutin digelar untuk mendongkrak okupansi hotel dan ekonomi kreatif lokal.</p>",
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
                "content" => "<p><strong>PURWODADI</strong> - Jalur Lintas Selatan (JLS) atau Jalan Daendels di wilayah selatan Purworejo mulai menunjukkan peningkatan volume kendaraan yang signifikan menjelang libur panjang akhir pekan ini.</p><p>Kasat Lantas Polres Purworejo melaporkan kenaikan volume arus lalu lintas mencapai 30% dibanding hari biasa, didominasi oleh kendaraan pribadi pelat luar daerah. Untuk mengantisipasi kemacetan, petugas telah disiagakan di beberapa titik rawan seperti simpang tiga Jali dan area pasar tumpah.</p><p>\"Kami menghimbau pengendara untuk tetap berhati-hati, patuhi batas kecepatan, dan istirahat jika lelah. Jalur Daendels lurus dan mulus sering membuat pengemudi terlena,\" pesan Kasat Lantas.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Kabar gembira bagi ibu rumah tangga di Purworejo. Harga beras berbagai kualitas di Pasar Baledono terpantau mulai mengalami penurunan signifikan dalam tiga hari terakhir, rata-rata turun Rp 1.500 per kilogram.</p><p>Kepala Dinas Ketahanan Pangan Kabupaten Purworejo menjelaskan bahwa penurunan harga ini dipicu oleh mulai masuknya masa panen raya di sejumlah sentra padi seperti Kecamatan Ngombol dan Purwodadi. \"Stok di gudang Bulog juga sangat aman hingga 3 bulan ke depan,\" imbuhnya.</p><p>Salah satu pedagang beras, Slamet (45), mengaku penjualannya kembali stabil setelah harga turun. \"Pembeli jadi lebih berani beli karungan lagi, kemarin-kemarin kan ngecer sedikit-sedikit,\" ujarnya.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Galeri Seni Dewa Ruci yang terletak di selatan Alun-alun Purworejo menjadi saksi kreativitas tanpa batas para seniman muda lokal. Pameran bertajuk \"Purworejo Dalam Warna\" ini menampilkan lebih dari 50 karya seni rupa, mulai dari lukisan realis, abstrak, hingga fotografi human interest.</p><p>Kurator pameran, Eko Sutrisno, menyebut bahwa pameran ini bertujuan untuk membangkitkan ekosistem seni rupa di Purworejo yang sempat mati suri. \"Banyak talenta luar biasa di sini yang karyanya layak disandingkan dengan seniman Yogya atau Bandung,\" katanya.</p><p>Pameran ini dibuka gratis untuk umum selama dua pekan dan menghadirkan sesi workshop melukis totebag untuk anak-anak setiap akhir pekannya.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Puncak peringatan Hari Jadi Kabupaten Purworejo ke-195 berlangsung sangat meriah. Kirab budaya yang menampilkan iring-iringan kereta kencana bupati dan puluhan kelompok seni dari 16 kecamatan sukses memukau ribuan warga yang memadati sepanjang jalan protokol.</p><p>Atraksi utama yang paling ditunggu adalah rebutan gunungan hasil bumi setinggi 3 meter. Warga percaya mendapatkan bagian dari gunungan ini akan membawa berkah kesuburan dan rezeki. \"Alhamdulillah dapat kacang panjang dan terong, semoga panen tahun ini melimpah,\" ujar Suminah (60), warga Loano.</p><p>Bupati Purworejo berharap di usia yang semakin matang ini, Purworejo dapat terus berbenah menjadi kabupaten yang maju dan berdaya saing tanpa meninggalkan akar budayanya.</p>",
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
                "content" => "<p><strong>BRUNO</strong> - Pemerintah Kabupaten Purworejo merespon cepat keluhan warga terkait rusaknya akses jalan utama di Kecamatan Bruno. Ruas jalan penghubung antar desa yang sebelumnya rusak parah akibat gerusan air hujan dan tanah labil kini mulai diperbaiki dengan betonisasi.</p><p>Kepala Dinas PUPR Purworejo menyatakan telah mengalokasikan dana darurat sebesar Rp 2 Miliar untuk perbaikan tiga titik kritis. \"Target kami sebelum lebaran jalan ini sudah mulus fungsional, agar mobilitas ekonomi warga tidak terhambat,\" terangnya.</p><p>Warga setempat menyambut gembira perbaikan ini, mengingat jalan tersebut merupakan akses vital untuk mengangkut hasil pertanian durian dan manggis ke pasar kota.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Moda transportasi massal modern akhirnya hadir di Purworejo. Gubernur Jawa Tengah secara resmi meluncurkan operasional Bus Trans Jateng Koridor Purworejo-Magelang. Sebanyak 14 armada bus siap melayani rute Terminal Kutoarjo hingga Terminal Borobudur Magelang.</p><p>Layanan ini menawarkan tarif yang sangat terjangkau, yakni Rp 4.000 untuk umum dan Rp 2.000 untuk pelajar/buruh/veteran. Fasilitas bus yang nyaman, ber-AC, dan tepat waktu diharapkan mampu mengurangi penggunaan kendaraan pribadi di jalur padat tersebut.</p><p>\"Ini solusi cerdas untuk konektivitas antar wilayah aglomerasi. Pelajar Purworejo yang sekolah di Magelang atau sebaliknya akan sangat terbantu,\" ujar Gubernur.</p>",
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
                "content" => "<p><strong>KALIGESING</strong> - Curug Siklotok di Desa Kaligono, Kecamatan Kaligesing, kini menjadi primadona baru wisata alam di Purworejo. Air terjun setinggi 35 meter yang tersembunyi di balik rimbunnya hutan pinus ini menawarkan suasana sejuk dan asri yang menenangkan.</p><p>Kelompok Sadar Wisata (Pokdarwis) setempat terus berbenah dengan menambah spot foto instagramable, gazebo istirahat, dan akses jalan setapak yang lebih aman. Tak hanya air terjun, wisatawan juga bisa mencoba wahana flying fox dan camping ground di sekitar lokasi.</p><p>\"Tiket masuknya murah meriah, cuma Rp 5.000. Cocok banget buat healing tipis-tipis di akhir pekan bareng keluarga,\" sebut salah satu travel blogger asal Semarang yang berkunjung.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Komite Olahraga Nasional Indonesia (KONI) Kabupaten Purworejo mulai memanaskan mesin menjelang Pekan Olahraga Provinsi (Porprov) Jawa Tengah. Pemusatan latihan daerah (Pelatda) mandiri telah digelar untuk cabang olahraga unggulan seperti atletik, pencak silat, dan panahan.</p><p>Ketua KONI Purworejo menargetkan peningkatan perolehan medali emas dibanding edisi sebelumnya. \"Kita punya bibit-bibit potensial yang sudah berprestasi di level nasional. Fokus kita sekarang adalah menjaga kondisi fisik dan mental bertanding mereka,\" tegasnya.</p><p>Dukungan fasilitas latihan dan suplemen nutrisi bagi para atlet juga menjadi perhatian utama agar mereka dapat tampil maksimal demi mengharumkan nama daerah.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Transformasi digital merambah hingga ke tingkat desa. Sebanyak 10 desa di Kabupaten Purworejo terpilih sebagai pilot project program \"Desa Digital\". Program ini memungkinkan warga mengurus surat-menyurat administrasi kependudukan cukup melalui aplikasi smartphone dari rumah.</p><p>Kepala Dinas Dinpermades menyebutkan bahwa selain pelayanan administrasi, platform desa digital ini juga menyediakan fitur marketplace untuk memasarkan produk UMKM desa. \"Jadi digitalisasi ini tidak hanya soal birokrasi, tapi juga pemberdayaan ekonomi warga,\" jelasnya.</p><p>Para perangkat desa telah mendapatkan pelatihan intensif untuk mengoperasikan sistem ini guna memastikan pelayanan prima kepada masyarakat.</p>",
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
                "content" => "<p><strong>BENER</strong> - Ribuan bibit pohon bernilai konservasi dan ekonomi ditanam di area sabuk hijau (green belt) genangan Bendungan Bener. Jenis pohon yang ditanam meliputi beringin, gayam, serta buah-buahan seperti durian dan alpukat.</p><p>Kegiatan penanaman massal ini melibatkan unsur TNI/Polri, pecinta alam, dan pelajar. Tujuannya adalah untuk menjaga stabilitas tanah di sekitar bendungan agar tidak mudah longsor, sekaligus menjaga ketersediaan air tanah di masa depan.</p><p>\"Ini investasi jangka panjang kita untuk anak cucu. Kalau alam dijaga, alam akan menjaga kita,\" pesan Komandan Kodim 0708 Purworejo saat memimpin penanaman simbolis.</p>",
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
                "content" => "<p><strong>PURWOREJO</strong> - Badan Narkotika Kabupaten (BNK) Purworejo gencar melakukan roadshow sosialisasi bahaya narkoba ke SMA/SMK sederajat di seluruh wilayah kabupaten. Langkah preventif ini dinilai sangat penting mengingat peredaran narkoba kini kian masif menyasar generasi muda.</p><p>Dalam materinya, petugas BNK tidak hanya menjelaskan dampak kesehatan akibat narkoba, tetapi juga sanksi hukum yang berat bagi pengguna maupun pengedar. Siswa diajak untuk berani menolak dan melaporkan jika mengetahui adanya indikasi peredaran narkoba di lingkungan mereka.</p><p>\"Kalian adalah harapan bangsa. Jangan sampai masa depan kalian hancur sia-sia karena coba-coba barang haram ini,\" seru penyuluh BNK di hadapan ratusan siswa yang antusias.</p>",
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
