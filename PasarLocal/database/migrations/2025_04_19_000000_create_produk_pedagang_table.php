<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_pedagang', function (Blueprint $table) {
            $table->id('id_produk_pedagang');
            $table->unsignedBigInteger('id_pedagang');
            $table->unsignedBigInteger('id_produk');
            $table->integer('stok');
            $table->integer('jumlah_satuan')->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('foto_produk');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_pedagang')->references('id_pedagang')->on('pedagang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id')->on('produk')->onDelete('cascade');
        });
        // Insert initial data
        
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 1, 'id_produk' => 1, 'stok' => 50, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 3000, 'foto_produk' => 'bayam_hijau.jpg', 'deskripsi' => 'Bayam hijau segar, kaya akan zat besi dan vitamin', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 2, 'stok' => 40, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 4000, 'foto_produk' => 'kangkung.jpg', 'deskripsi' => 'Kangkung segar, cocok untuk tumisan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 3, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 15000, 'foto_produk' => 'wortel.jpg', 'deskripsi' => 'Wortel segar, kaya vitamin A', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 4, 'stok' => 35, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 5000, 'foto_produk' => 'kacang_panjang.jpg', 'deskripsi' => 'Kacang panjang segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 5, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 12000, 'foto_produk' => 'tomat_merah.jpg', 'deskripsi' => 'Tomat merah segar, cocok untuk sambal', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 6, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 8000, 'foto_produk' => 'selada_hijau.jpg', 'deskripsi' => 'Selada hijau segar, cocok untuk salad', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 7, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 10000, 'foto_produk' => 'mentimun.jpg', 'deskripsi' => 'Mentimun segar, cocok untuk lalapan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 8, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 20000, 'foto_produk' => 'kubis_putih.jpg', 'deskripsi' => 'Kubis putih segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 9, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 25000, 'foto_produk' => 'brokoli.jpg', 'deskripsi' => 'Brokoli segar, kaya serat', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 10, 'stok' => 30, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 6000, 'foto_produk' => 'buncis.jpg', 'deskripsi' => 'Buncis segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 11, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 15000, 'foto_produk' => 'terong_ungu.jpg', 'deskripsi' => 'Terong ungu segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 12, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 12000, 'foto_produk' => 'labu_siam.jpg', 'deskripsi' => 'Labu siam segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 31, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 175000, 'foto_produk' => 'sapi_has_dalam.jpg', 'deskripsi' => 'Daging sapi has dalam segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 32, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 165000, 'foto_produk' => 'sapi_has_luar.jpg', 'deskripsi' => 'Daging sapi has luar segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 1, 'id_produk' => 33, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 145000, 'foto_produk' => 'iga_sapi.jpg', 'deskripsi' => 'Iga sapi segar, cocok untuk sop', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 2, 'id_produk' => 1, 'stok' => 30, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 5000, 'foto_produk' => 'bayam_hijau.jpg', 'deskripsi' => 'Bayam hijau segar, kaya akan zat besi dan vitamin', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 2, 'stok' => 25, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 6000, 'foto_produk' => 'kangkung.jpg', 'deskripsi' => 'Kangkung segar, cocok untuk tumisan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 21, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 35000, 'foto_produk' => 'apel_merah.jpg', 'deskripsi' => 'Apel merah segar, kaya vitamin', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 22, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 25000, 'foto_produk' => 'pisang_ambon.jpg', 'deskripsi' => 'Pisang ambon segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 23, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 30000, 'foto_produk' => 'mangga_harummanis.jpg', 'deskripsi' => 'Mangga harum manis segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 24, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 28000, 'foto_produk' => 'jeruk_medan.jpg', 'deskripsi' => 'Jeruk medan segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 25, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 45000, 'foto_produk' => 'semangka_merah.jpg', 'deskripsi' => 'Semangka merah segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 26, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'melon_hijau.jpg', 'deskripsi' => 'Melon hijau segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 27, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 40000, 'foto_produk' => 'anggur_merah.jpg', 'deskripsi' => 'Anggur merah segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 28, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 25000, 'foto_produk' => 'nanas_madu.jpg', 'deskripsi' => 'Nanas madu segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 29, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 20000, 'foto_produk' => 'pepaya_california.jpg', 'deskripsi' => 'Pepaya california segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 30, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'buah_naga_merah.jpg', 'deskripsi' => 'Buah naga merah segar, manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 16, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 15000, 'foto_produk' => 'jagung_manis.jpg', 'deskripsi' => 'Jagung manis segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 17, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 8000, 'foto_produk' => 'pare.jpg', 'deskripsi' => 'Pare segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 2, 'id_produk' => 18, 'stok' => 30, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 5000, 'foto_produk' => 'sawi_hijau.jpg', 'deskripsi' => 'Sawi hijau segar, cocok untuk sayur', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 3, 'id_produk' => 31, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 180000, 'foto_produk' => 'sapi_has_dalam.jpg', 'deskripsi' => 'Daging sapi has dalam segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 32, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 160000, 'foto_produk' => 'sapi_has_luar.jpg', 'deskripsi' => 'Daging sapi has luar segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 33, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 140000, 'foto_produk' => 'iga_sapi.jpg', 'deskripsi' => 'Iga sapi segar, cocok untuk sop', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 34, 'stok' => 18, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 150000, 'foto_produk' => 'brisket_sapi.jpg', 'deskripsi' => 'Brisket sapi segar, cocok untuk steak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 35, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 120000, 'foto_produk' => 'kikil_sapi.jpg', 'deskripsi' => 'Kikil sapi segar, cocok untuk sop', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 36, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 100000, 'foto_produk' => 'tetelan_sapi.jpg', 'deskripsi' => 'Tetelan sapi segar, cocok untuk sop', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 37, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 130000, 'foto_produk' => 'lidah_sapi.jpg', 'deskripsi' => 'Lidah sapi segar, cocok untuk semur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 38, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 110000, 'foto_produk' => 'hati_sapi.jpg', 'deskripsi' => 'Hati sapi segar, kaya zat besi', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 39, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 90000, 'foto_produk' => 'usus_sapi.jpg', 'deskripsi' => 'Usus sapi segar, cocok untuk sambal goreng', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 40, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 170000, 'foto_produk' => 'sapi_giling.jpg', 'deskripsi' => 'Daging sapi giling segar, cocok untuk bakso', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 41, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 45000, 'foto_produk' => 'fillet_dada_ayam.jpg', 'deskripsi' => 'Fillet dada ayam segar, cocok untuk steak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 42, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 40000, 'foto_produk' => 'fillet_paha_ayam.jpg', 'deskripsi' => 'Fillet paha ayam segar, cocok untuk steak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 43, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'ayam_potong_1_ekor.jpg', 'deskripsi' => 'Ayam potong 1 ekor utuh, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 44, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 20000, 'foto_produk' => 'ayam_potong_1_2_ekor.jpg', 'deskripsi' => 'Ayam potong 1/2 ekor, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 3, 'id_produk' => 45, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 12000, 'foto_produk' => 'ayam_potong_1_4_ekor.jpg', 'deskripsi' => 'Ayam potong 1/4 ekor, segar', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 4, 'id_produk' => 31, 'stok' => 10, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 190000, 'foto_produk' => 'sapi_has_dalam.jpg', 'deskripsi' => 'Daging sapi has dalam segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 32, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 170000, 'foto_produk' => 'sapi_has_luar.jpg', 'deskripsi' => 'Daging sapi has luar segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 41, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 45000, 'foto_produk' => 'fillet_dada_ayam.jpg', 'deskripsi' => 'Fillet dada ayam segar, cocok untuk steak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 42, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 40000, 'foto_produk' => 'fillet_paha_ayam.jpg', 'deskripsi' => 'Fillet paha ayam segar, cocok untuk steak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 43, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'ayam_potong_1_ekor.jpg', 'deskripsi' => 'Ayam potong 1 ekor utuh, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 44, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 20000, 'foto_produk' => 'ayam_potong_1_2_ekor.jpg', 'deskripsi' => 'Ayam potong 1/2 ekor, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 45, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 12000, 'foto_produk' => 'ayam_potong_1_4_ekor.jpg', 'deskripsi' => 'Ayam potong 1/4 ekor, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 46, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 32000, 'foto_produk' => 'ayam_potong_1_kg.jpg', 'deskripsi' => 'Ayam potong 1 kg, segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 47, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 48000, 'foto_produk' => 'paha_atas_ayam.jpg', 'deskripsi' => 'Paha atas ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 48, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 42000, 'foto_produk' => 'paha_bawah_ayam.jpg', 'deskripsi' => 'Paha bawah ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 49, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 38000, 'foto_produk' => 'sayap_ayam.jpg', 'deskripsi' => 'Sayap ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 50, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 46000, 'foto_produk' => 'dada_ayam.jpg', 'deskripsi' => 'Dada ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 51, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 44000, 'foto_produk' => 'paha_ayam.jpg', 'deskripsi' => 'Paha ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 52, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 35000, 'foto_produk' => 'ampela_ayam.jpg', 'deskripsi' => 'Ampela ayam segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 4, 'id_produk' => 53, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 32000, 'foto_produk' => 'hati_ayam.jpg', 'deskripsi' => 'Hati ayam segar', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 5, 'id_produk' => 58, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 250000, 'foto_produk' => 'ikan_salmon_fillet.jpg', 'deskripsi' => 'Ikan salmon fillet segar, kaya omega-3', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 59, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 180000, 'foto_produk' => 'ikan_tuna_fillet.jpg', 'deskripsi' => 'Ikan tuna fillet segar, kaya protein', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 60, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 120000, 'foto_produk' => 'ikan_tenggiri_segar.jpg', 'deskripsi' => 'Ikan tenggiri segar, cocok untuk pempek', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 61, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 80000, 'foto_produk' => 'ikan_kembung_segar.jpg', 'deskripsi' => 'Ikan kembung segar, cocok untuk goreng', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 62, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 90000, 'foto_produk' => 'ikan_bawal_putih.jpg', 'deskripsi' => 'Ikan bawal putih segar, cocok untuk goreng', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 63, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 85000, 'foto_produk' => 'ikan_bandeng.jpg', 'deskripsi' => 'Ikan bandeng segar, cocok untuk presto', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 64, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 150000, 'foto_produk' => 'ikan_kakap_merah.jpg', 'deskripsi' => 'Ikan kakap merah segar, cocok untuk asam manis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 65, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 45000, 'foto_produk' => 'ikan_lele.jpg', 'deskripsi' => 'Ikan lele segar, cocok untuk pecel lele', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 66, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 180000, 'foto_produk' => 'udang_windu.jpg', 'deskripsi' => 'Udang windu segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 67, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 150000, 'foto_produk' => 'udang_vaname.jpg', 'deskripsi' => 'Udang vaname segar, cocok untuk berbagai masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 68, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 200000, 'foto_produk' => 'udang_galah.jpg', 'deskripsi' => 'Udang galah segar, kualitas premium', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 69, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 120000, 'foto_produk' => 'udang_rebon.jpg', 'deskripsi' => 'Udang rebon segar, cocok untuk terasi', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 70, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 120000, 'foto_produk' => 'cumi_cumi_segar.jpg', 'deskripsi' => 'Cumi-cumi segar, cocok untuk goreng tepung', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 71, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 140000, 'foto_produk' => 'cumi_cumi_fillet.jpg', 'deskripsi' => 'Cumi-cumi fillet segar, cocok untuk tumis', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 5, 'id_produk' => 72, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 80000, 'foto_produk' => 'kerang_hijau.jpg', 'deskripsi' => 'Kerang hijau segar, cocok untuk sup', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 6, 'id_produk' => 1, 'stok' => 20, 'jumlah_satuan' => 250, 'satuan' => 'gram', 'harga' => 4000, 'foto_produk' => 'bayam_hijau.jpg', 'deskripsi' => 'Bayam hijau segar, kaya akan zat besi dan vitamin', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 75, 'stok' => 100, 'jumlah_satuan' => 50, 'satuan' => 'gram', 'harga' => 3000, 'foto_produk' => 'daun_jeruk.jpg', 'deskripsi' => 'Daun jeruk segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 76, 'stok' => 80, 'jumlah_satuan' => 50, 'satuan' => 'gram', 'harga' => 2000, 'foto_produk' => 'daun_salam.jpg', 'deskripsi' => 'Daun salam segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 77, 'stok' => 60, 'jumlah_satuan' => 50, 'satuan' => 'gram', 'harga' => 2500, 'foto_produk' => 'daun_pandan.jpg', 'deskripsi' => 'Daun pandan segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 78, 'stok' => 70, 'jumlah_satuan' => 50, 'satuan' => 'gram', 'harga' => 3000, 'foto_produk' => 'daun_ketumbar.jpg', 'deskripsi' => 'Daun ketumbar segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 79, 'stok' => 65, 'jumlah_satuan' => 50, 'satuan' => 'gram', 'harga' => 3500, 'foto_produk' => 'daun_kemangi.jpg', 'deskripsi' => 'Daun kemangi segar untuk lalapan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 80, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 25000, 'foto_produk' => 'jahe_segar.jpg', 'deskripsi' => 'Jahe segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 81, 'stok' => 45, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 28000, 'foto_produk' => 'kunyit_segar.jpg', 'deskripsi' => 'Kunyit segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 82, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 22000, 'foto_produk' => 'lengkuas_segar.jpg', 'deskripsi' => 'Lengkuas segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 83, 'stok' => 50, 'jumlah_satuan' => 100, 'satuan' => 'gram', 'harga' => 3000, 'foto_produk' => 'sereh_segar.jpg', 'deskripsi' => 'Sereh segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 84, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 35000, 'foto_produk' => 'kemiri.jpg', 'deskripsi' => 'Kemiri untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 85, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 40000, 'foto_produk' => 'kayu_manis.jpg', 'deskripsi' => 'Kayu manis untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 86, 'stok' => 20, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 45000, 'foto_produk' => 'cengkeh.jpg', 'deskripsi' => 'Cengkeh untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 87, 'stok' => 15, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 50000, 'foto_produk' => 'pala.jpg', 'deskripsi' => 'Pala untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 6, 'id_produk' => 88, 'stok' => 50, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 25000, 'foto_produk' => 'bawang_merah.jpg', 'deskripsi' => 'Bawang merah segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 7, 'id_produk' => 88, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 28000, 'foto_produk' => 'bawang_merah.jpg', 'deskripsi' => 'Bawang merah segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 89, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 30000, 'foto_produk' => 'bawang_putih.jpg', 'deskripsi' => 'Bawang putih segar untuk bumbu masakan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 96, 'stok' => 100, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 3500, 'foto_produk' => 'indomie_goreng.jpg', 'deskripsi' => 'Indomie goreng instan, rasa original', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 97, 'stok' => 100, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 3000, 'foto_produk' => 'mie_sedaap_goreng.jpg', 'deskripsi' => 'Mie sedaap goreng instan, rasa original', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 98, 'stok' => 80, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 4000, 'foto_produk' => 'soto_mie_instans.jpg', 'deskripsi' => 'Soto mie instan, rasa soto ayam', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 99, 'stok' => 90, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 3200, 'foto_produk' => 'supermi_goreng.jpg', 'deskripsi' => 'Supermi goreng instan, rasa original', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 100, 'stok' => 50, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 25000, 'foto_produk' => 'sosis_ayam.jpg', 'deskripsi' => 'Sosis ayam siap masak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 101, 'stok' => 60, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'nugget_ayam.jpg', 'deskripsi' => 'Nugget ayam siap goreng', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 102, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 30000, 'foto_produk' => 'bakso_sapi.jpg', 'deskripsi' => 'Bakso sapi siap masak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 103, 'stok' => 45, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 40000, 'foto_produk' => 'hamburger_patty.jpg', 'deskripsi' => 'Hamburger patty sapi siap masak', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 104, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 45000, 'foto_produk' => 'daging_rendang_instan.jpg', 'deskripsi' => 'Daging rendang instan siap saji', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 105, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 35000, 'foto_produk' => 'kornet_sapi.jpg', 'deskripsi' => 'Kornet sapi siap saji', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 106, 'stok' => 55, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 15000, 'foto_produk' => 'tahu_putih.jpg', 'deskripsi' => 'Tahu putih segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 107, 'stok' => 50, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 18000, 'foto_produk' => 'tahu_coklat.jpg', 'deskripsi' => 'Tahu coklat segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 7, 'id_produk' => 108, 'stok' => 45, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 16000, 'foto_produk' => 'tahu_kuning.jpg', 'deskripsi' => 'Tahu kuning segar', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('produk_pedagang')->insert([
            ['id_pedagang' => 8, 'id_produk' => 96, 'stok' => 80, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 4000, 'foto_produk' => 'indomie_goreng.jpg', 'deskripsi' => 'Indomie goreng instan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 97, 'stok' => 70, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 3500, 'foto_produk' => 'mie_sedaap_goreng.jpg', 'deskripsi' => 'Mie sedaap goreng instan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 120, 'stok' => 50, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 5000, 'foto_produk' => 'teh_botol.jpg', 'deskripsi' => 'Teh botol minuman', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 121, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 8000, 'foto_produk' => 'jus_jeruk.jpg', 'deskripsi' => 'Jus jeruk minuman', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 122, 'stok' => 60, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 15000, 'foto_produk' => 'kopi_instan.jpg', 'deskripsi' => 'Kopi instan', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 123, 'stok' => 45, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 12000, 'foto_produk' => 'susu_uht.jpg', 'deskripsi' => 'Susu UHT', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 124, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 10000, 'foto_produk' => 'air_kelapa.jpg', 'deskripsi' => 'Air kelapa segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 125, 'stok' => 100, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 3000, 'foto_produk' => 'mineral_water.jpg', 'deskripsi' => 'Air mineral', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 109, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 12000, 'foto_produk' => 'tempe_papan.jpg', 'deskripsi' => 'Tempe papan segar', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 110, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'pcs', 'harga' => 10000, 'foto_produk' => 'tempe_mendoan.jpg', 'deskripsi' => 'Tempe mendoan siap goreng', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 111, 'stok' => 25, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 15000, 'foto_produk' => 'beras.jpg', 'deskripsi' => 'Beras putih berkualitas', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 112, 'stok' => 30, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 12000, 'foto_produk' => 'gula_pasir.jpg', 'deskripsi' => 'Gula pasir putih', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 113, 'stok' => 50, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 5000, 'foto_produk' => 'garam.jpg', 'deskripsi' => 'Garam dapur', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 114, 'stok' => 40, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 10000, 'foto_produk' => 'tepung_terigu.jpg', 'deskripsi' => 'Tepung terigu serbaguna', 'created_at' => now(), 'updated_at' => now()],
            ['id_pedagang' => 8, 'id_produk' => 115, 'stok' => 35, 'jumlah_satuan' => 1, 'satuan' => 'kg', 'harga' => 12000, 'foto_produk' => 'tepung_beras.jpg', 'deskripsi' => 'Tepung beras putih', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_pedagang');
    }
};
