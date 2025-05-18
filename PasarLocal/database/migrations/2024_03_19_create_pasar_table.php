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
            $table->id('id_pasar');
            $table->string('nama_pasar');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

        DB::afterCommit(function () {
            DB::table('pasar')->insert([
                [
                    'id_pasar' => 1,
                    'nama_pasar' => 'Pasar Kordon',
                    'alamat' => 'Jl. Ibrahim Adjie, Kujangsari, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40287',
                    'deskripsi' => 'Pasar Kordon, terletak di Bandung Kidul, dikenal sebagai pasar tradisional yang cukup lengkap. Selain kebutuhan dapur, pasar ini juga menawarkan peralatan rumah tangga dan beragam produk lokal dengan harga terjangkau',
                    'gambar' => 'pasar kordon.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 2,
                    'nama_pasar' => 'Pasar Baleendah',
                    'alamat' => 'Jl. Siliwangi, Baleendah, Kec. Baleendah, Kabupaten Bandung, Jawa Barat 40375',
                    'deskripsi' => 'Pasar Baleendah di Kabupaten Bandung adalah pasar tradisional yang ramai dan menjadi pusat ekonomi lokal. Di sini, masyarakat bisa menemukan bahan makanan segar, kebutuhan rumah tangga, pakaian, dan produk lokal dengan harga terjangkau. Suasana khasnya terasa dari interaksi hangat antara pedagang dan pembeli, menjadikannya tempat belanja sekaligus pengalaman budaya yang menarik.',
                    'gambar' => 'pasar baleendah.jpeg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 3,
                    'nama_pasar' => 'Pasar Kopo',
                    'alamat' => 'Jl. Raya Taman Kopo Indah 2, Rahayu, Kec. Margaasih, Kabupaten Bandung, Jawa Barat 40218',
                    'deskripsi' => 'Pasar Baleendah, terletak di Kabupaten Bandung, merupakan pasar tradisional yang ramai dan menjadi pusat aktivitas ekonomi masyarakat sekitar. Selain bahan makanan segar seperti sayur, buah, dan daging, pasar ini juga menyediakan berbagai kebutuhan rumah tangga, pakaian, serta produk lokal dengan harga bersahabat. Suasana pasar yang khas dengan interaksi hangat antara pedagang dan pembeli menjadikannya tempat yang menarik untuk berbelanja sekaligus merasakan kehidupan sehari-hari warga Baleendah.',
                    'gambar' => 'pasar kopo.jpg',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'id_pasar' => 4,
                    'nama_pasar' => 'Pasar Dayeuhkolot',
                    'alamat' => 'Jl. Raya Dayeuhkolot No.330, Dayeuhkolot, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40258',
                    'deskripsi' => 'Pasar Dayeuhkolot adalah pasar tradisional yang terletak di Kabupaten Bandung, Jawa Barat. Pasar ini memiliki sejarah panjang dan menjadi pusat perdagangan bagi masyarakat sekitar. Di sini, pengunjung dapat menemukan berbagai produk, mulai dari buah-buahan segar, sayuran, ikan laut, daging, rempah-rempah, hingga pakaian dan aksesoris.',
                    'gambar' => 'pasar dayeuhkolot.jpg',
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