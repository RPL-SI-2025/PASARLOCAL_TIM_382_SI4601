<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pasar', function (Blueprint $table) {
            $table->string('id_pasar', 10)->primary();
            $table->string('nama_pasar');
            $table->text('lokasi');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        // Seeder data
        DB::afterCommit(function () {
            DB::table('pasar')->insert([
                [
                    'id_pasar' => 'P001',
                    'nama_pasar' => 'Pasar Cihapit',
                    'lokasi' => 'Jl. Cihapit No.32, Cihapit, Kec. Bandung Wetan, Kota Bandung, Jawa Barat 40114',
                    'deskripsi' => 'Terletak di pusat kota Bandung, Pasar Cihapit terkenal dengan nuansa tradisional yang tetap hidup di tengah modernisasi. Pasar ini menawarkan berbagai kebutuhan harian mulai dari sayur-sayuran segar, buah, daging, hingga pakaian dan peralatan rumah tangga.',
                    'gambar' => 'pasar cipahit.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P002',
                    'nama_pasar' => 'Pasar Astana Anyar',
                    'lokasi' => 'Jl. Astana Anyar No.179, Nyengseret, Kec. Astanaanyar, Kota Bandung, Jawa Barat 40242',
                    'deskripsi' => 'Pasar Astana Anyar adalah salah satu pasar terbesar di wilayah selatan Bandung. Selain kebutuhan pokok, pasar ini juga terkenal dengan sentra tekstil, kain, dan pakaian jadi yang ditawarkan dengan harga bersahabat.',
                    'gambar' => 'pasar anyar.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P003',
                    'nama_pasar' => 'Pasar Kiaracondong',
                    'lokasi' => 'Jl. Kebun Jayanti, Kec. Kiaracondong, Kota Bandung, Jawa Barat 40281',
                    'deskripsi' => 'Pasar Kiaracondong, atau lebih dikenal dengan Ps. Kiaracondong, merupakan pasar tradisional yang sangat ramai, melayani kebutuhan sehari-hari warga sekitar. Pasar ini juga menjadi rujukan untuk belanja bahan makanan dalam jumlah besar.',
                    'gambar' => 'pasar kiaracondong.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P004',
                    'nama_pasar' => 'Pasar Gegerkalong',
                    'lokasi' => 'Jl. Gegerkalong Tengah No.35 A, Gegerkalong, Kec. Sukasari, Kota Bandung, Jawa Barat 40153',
                    'deskripsi' => 'Berlokasi di kawasan Sukasari, Pasar Gegerkalong menawarkan suasana yang lebih santai dibandingkan pasar besar lainnya. Pasar ini dikenal dengan produk-produk segar lokal seperti sayur, buah, serta jajanan tradisional khas Bandung.',
                    'gambar' => 'pasar gegerkalong.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P005',
                    'nama_pasar' => 'Pasar Ujungberung',
                    'lokasi' => 'Jl. Raya Ujung Berung, Sukamulya, Kec. Cinambo, Kota Bandung, Jawa Barat 45474',
                    'deskripsi' => 'Pasar Ujungberung merupakan pusat perdagangan penting di bagian timur Bandung. Dikenal luas akan kelengkapan barangnya, pasar ini menjadi pilihan favorit warga untuk berbelanja bahan pokok, kebutuhan rumah tangga, hingga produk fashion.',
                    'gambar' => 'pasar ujungberung.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P006',
                    'nama_pasar' => 'Pasar Cicaheum',
                    'lokasi' => 'Jl. Raya Ujung Berung, Sukamulya, Kec. Cinambo, Kota Bandung, Jawa Barat 45474',
                    'deskripsi' => 'Pasar Cicaheum yang terletak di jalur strategis menuju kawasan timur Bandung menyediakan beragam kebutuhan sehari-hari. Selain itu, lokasinya yang dekat dengan terminal membuatnya menjadi titik singgah favorit bagi banyak orang.',
                    'gambar' => 'Pasar Cicaheum.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P007',
                    'nama_pasar' => 'Pasar Kosambi',
                    'lokasi' => 'Jl. A. Yani No.221-223, Kb. Pisang, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40112',
                    'deskripsi' => 'Pasar Kosambi adalah salah satu pasar legendaris di Bandung yang tidak hanya menjual bahan pangan, tapi juga menjadi sentra tekstil dan pusat oleh-oleh khas Bandung. Pasar ini kerap menjadi destinasi belanja wisatawan maupun warga lokal.',
                    'gambar' => 'pasar kosambi.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P008',
                    'nama_pasar' => 'Pasar Cicadas',
                    'lokasi' => 'Jl. Cikutra No.210, Cikutra, Kec. Cibeunying Kidul, Kota Bandung, Jawa Barat 40124',
                    'deskripsi' => 'Pasar Cicadas adalah pasar rakyat yang cukup padat di kawasan Cibeunying Kidul. Selain kebutuhan pokok, Pasar Cicadas juga terkenal dengan area elektronik dan pakaian murah yang menarik banyak pembeli dari berbagai kalangan.',
                    'gambar' => 'pasar cicadas.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P009',
                    'nama_pasar' => 'Pasar Gede Bage',
                    'lokasi' => 'Jl. Soekarno-Hatta, Mekar Mulya, Kec. Panyileukan, Kota Bandung, Jawa Barat 40294',
                    'deskripsi' => 'Pasar Gede Bage merupakan pasar grosir besar di Bandung, terutama untuk tekstil dan pakaian. Banyak pedagang dari luar kota datang ke sini untuk kulakan barang, menjadikan pasar ini salah satu pusat distribusi penting di wilayah Bandung Raya.',
                    'gambar' => 'pasar gedebage.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 'P010',
                    'nama_pasar' => 'Pasar Kordon',
                    'lokasi' => 'Jl. Ibrahim Adjie, Kujangsari, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40287',
                    'deskripsi' => 'Pasar Kordon, terletak di Bandung Kidul, dikenal sebagai pasar tradisional yang cukup lengkap. Selain kebutuhan dapur, pasar ini juga menawarkan peralatan rumah tangga dan beragam produk lokal dengan harga terjangkau',
                    'gambar' => 'pasar kordon.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasar');
    }
}; 