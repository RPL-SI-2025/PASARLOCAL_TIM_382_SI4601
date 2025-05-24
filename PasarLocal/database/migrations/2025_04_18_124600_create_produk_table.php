<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->text('deskripsi_produk')->nullable();
            $table->foreignId('id_kategori')->constrained('kategori_produk')->onDelete('cascade');
            $table->string('gambar')->nullable();
            $table->timestamps();
            });

        // Seeder langsung setelah migrasi
        DB::afterCommit(function () {
            DB::table('produk')->insert([
                //1. Sayur
                ['nama_produk' => 'Bayam Hijau', 'deskripsi_produk' => 'Bayam segar langsung dari kebun.', 'id_kategori' => 1, 'gambar' => 'bayam_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kangkung Air', 'deskripsi_produk' => 'Kangkung air segar dipetik pagi hari.', 'id_kategori' => 1, 'gambar' => 'kangkung.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Wortel', 'deskripsi_produk' => 'Wortel manis dan renyah.', 'id_kategori' => 1, 'gambar' => 'wortel.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kacang Panjang', 'deskripsi_produk' => 'Kacang panjang segar dari petani lokal.', 'id_kategori' => 1, 'gambar' => 'kacang_panjang.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tomat Merah', 'deskripsi_produk' => 'Tomat merah segar siap konsumsi.', 'id_kategori' => 1, 'gambar' => 'tomat_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Selada Hijau', 'deskripsi_produk' => 'Selada hijau segar cocok untuk salad.', 'id_kategori' => 1, 'gambar' => 'selada_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Mentimun', 'deskripsi_produk' => 'Mentimun segar dengan tekstur renyah.', 'id_kategori' => 1, 'gambar' => 'mentimun.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kubis Putih', 'deskripsi_produk' => 'Kubis putih segar dan padat.', 'id_kategori' => 1, 'gambar' => 'kubis_putih.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Brokoli', 'deskripsi_produk' => 'Brokoli hijau sehat untuk direbus atau ditumis.', 'id_kategori' => 1, 'gambar' => 'brokoli.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Buncis', 'deskripsi_produk' => 'Buncis segar cocok untuk berbagai masakan.', 'id_kategori' => 1, 'gambar' => 'buncis.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Terong Ungu', 'deskripsi_produk' => 'Terong ungu segar siap masak.', 'id_kategori' => 1, 'gambar' => 'terong_ungu.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Labu Siam', 'deskripsi_produk' => 'Labu siam segar untuk sayur lodeh.', 'id_kategori' => 1, 'gambar' => 'labu_siam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daun Singkong', 'deskripsi_produk' => 'Daun singkong muda dan empuk.', 'id_kategori' => 1, 'gambar' => 'daun_singkong.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Bayam Merah', 'deskripsi_produk' => 'Bayam merah segar penuh nutrisi.', 'id_kategori' => 1, 'gambar' => 'bayam_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Rebung Muda', 'deskripsi_produk' => 'Rebung muda segar, enak untuk tumisan.', 'id_kategori' => 1, 'gambar' => 'rebung_muda.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Jagung Manis', 'deskripsi_produk' => 'Jagung manis segar dan siap rebus.', 'id_kategori' => 1, 'gambar' => 'jagung_manis.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Pare', 'deskripsi_produk' => 'Pare segar meskipun pahit, banyak manfaat.', 'id_kategori' => 1, 'gambar' => 'pare.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Sawi Hijau', 'deskripsi_produk' => 'Sawi hijau segar untuk sop dan mie.', 'id_kategori' => 1, 'gambar' => 'sawi_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Oyong', 'deskripsi_produk' => 'Oyong segar lembut untuk sayur bening.', 'id_kategori' => 1, 'gambar' => 'oyong.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Petai', 'deskripsi_produk' => 'Petai segar khas dengan aroma kuat.', 'id_kategori' => 1, 'gambar' => 'petai.jpg', 'created_at' => now(), 'updated_at' => now()],

                //2. Buah-buahan
                ['nama_produk' => 'Apel Merah', 'deskripsi_produk' => 'Apel manis dan segar.', 'id_kategori' => 2, 'gambar' => 'apel_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Pisang Ambon', 'deskripsi_produk' => 'Pisang ambon matang.', 'id_kategori' => 2, 'gambar' => 'pisang_ambon.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Mangga Harum Manis', 'deskripsi_produk' => 'Mangga harum dan manis.', 'id_kategori' => 2, 'gambar' => 'mangga_harum_manis.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Jeruk Medan', 'deskripsi_produk' => 'Jeruk Medan segar dan juicy.', 'id_kategori' => 2, 'gambar' => 'jeruk_medan.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Semangka Merah', 'deskripsi_produk' => 'Semangka tanpa biji.', 'id_kategori' => 2, 'gambar' => 'semangka_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Melon Hijau', 'deskripsi_produk' => 'Melon hijau segar dan manis.', 'id_kategori' => 2, 'gambar' => 'melon_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Anggur Merah', 'deskripsi_produk' => 'Anggur merah tanpa biji.', 'id_kategori' => 2, 'gambar' => 'anggur_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Nanas Madu', 'deskripsi_produk' => 'Nanas manis dengan aroma harum.', 'id_kategori' => 2, 'gambar' => 'nanas_madu.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Pepaya California', 'deskripsi_produk' => 'Pepaya manis cocok untuk diet.', 'id_kategori' => 2, 'gambar' => 'pepaya_california.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Buah Naga Merah', 'deskripsi_produk' => 'Buah naga merah segar dan kaya serat.', 'id_kategori' => 2, 'gambar' => 'buah_naga_merah.jpg', 'created_at' => now(), 'updated_at' => now()],

                //3. Daging Sapi
                ['nama_produk' => 'Daging Sapi Has Dalam', 'deskripsi_produk' => 'Daging sapi bagian has dalam, cocok untuk steak.', 'id_kategori' => 3, 'gambar' => 'sapi_has_dalam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daging Sapi Has Luar', 'deskripsi_produk' => 'Daging sapi bagian has luar, empuk dan gurih.', 'id_kategori' => 3, 'gambar' => 'sapi_has_luar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Iga Sapi', 'deskripsi_produk' => 'Iga sapi segar, cocok untuk sop atau barbeque.', 'id_kategori' => 3, 'gambar' => 'iga_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Brisket Sapi', 'deskripsi_produk' => 'Daging sandung lamur sapi, lemaknya pas.', 'id_kategori' => 3, 'gambar' => 'brisket_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kikil Sapi', 'deskripsi_produk' => 'Kikil sapi bersih dan siap masak.', 'id_kategori' => 3, 'gambar' => 'kikil_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tetelan Sapi', 'deskripsi_produk' => 'Campuran daging dan lemak sapi.', 'id_kategori' => 3, 'gambar' => 'tetelan_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Lidah Sapi', 'deskripsi_produk' => 'Lidah sapi segar, cocok untuk semur.', 'id_kategori' => 3, 'gambar' => 'lidah_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Hati Sapi', 'deskripsi_produk' => 'Hati sapi segar dan kaya zat besi.', 'id_kategori' => 3, 'gambar' => 'hati_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Usus Sapi', 'deskripsi_produk' => 'Usus sapi bersih, cocok untuk soto.', 'id_kategori' => 3, 'gambar' => 'usus_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daging Sapi Giling', 'deskripsi_produk' => 'Daging sapi segar digiling.', 'id_kategori' => 3, 'gambar' => 'sapi_giling.jpg', 'created_at' => now(), 'updated_at' => now()],
             
                //4. Daging Ayam       
                ['nama_produk' => 'Fillet Dada Ayam', 'deskripsi_produk' => 'Fillet dada ayam tanpa tulang, daging lembut dan bersih.', 'id_kategori' => 4, 'gambar' => 'fillet_dada_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Fillet Paha Ayam', 'deskripsi_produk' => 'Fillet paha ayam tanpa tulang, cocok untuk tumis atau panggang.', 'id_kategori' => 4, 'gambar' => 'fillet_paha_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ayam Potong 1 Ekor (Ayam Negeri)', 'deskripsi_produk' => 'Ayam potong utuh 1 ekor, ayam negeri segar dan siap masak.', 'id_kategori' => 4, 'gambar' => 'ayam_potong_1_ekor.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ayam Potong 1/2 Ekor (Ayam Negeri)', 'deskripsi_produk' => 'Ayam potong setengah ekor, ayam negeri praktis dan siap dimasak.', 'id_kategori' => 4, 'gambar' => 'ayam_potong_1_2_ekor.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ayam Potong 1/4 Ekor (Ayam Negeri)', 'deskripsi_produk' => 'Ayam potong seperempat ekor, ayam negeri cocok untuk keluarga kecil.', 'id_kategori' => 4, 'gambar' => 'ayam_potong_1_4_ekor.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ayam Potong 1 Kg (Ayam Negeri)', 'deskripsi_produk' => 'Ayam potong 1 kg, ayam negeri segar dan siap dimasak.', 'id_kategori' => 4, 'gambar' => 'ayam_potong_1_kg.jpg', 'created_at' => now(), 'updated_at' => now()],

                ['nama_produk' => 'Paha Atas Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Paha atas ayam negeri, daging empuk dan lezat.', 'id_kategori' => 4, 'gambar' => 'paha_atas_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Paha Bawah Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Paha bawah ayam negeri, cocok untuk digoreng atau dipanggang.', 'id_kategori' => 4, 'gambar' => 'paha_bawah_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Sayap Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Sayap ayam negeri, cocok untuk digoreng, dibakar, atau dibuat sup.', 'id_kategori' => 4, 'gambar' => 'sayap_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Dada Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Dada ayam negeri, daging tanpa tulang, ideal untuk masakan sehat.', 'id_kategori' => 4, 'gambar' => 'dada_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Paha Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Paha ayam negeri utuh, daging tebal dan kenyal, cocok untuk berbagai masakan.', 'id_kategori' => 4, 'gambar' => 'paha_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],

                ['nama_produk' => 'Ampela Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Ampela ayam negeri segar, cocok untuk digoreng atau dimasak dengan sambal.', 'id_kategori' => 4, 'gambar' => 'ampela_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Hati Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Hati ayam negeri segar, pas untuk sambal hati atau masakan tradisional.', 'id_kategori' => 4, 'gambar' => 'hati_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Jantung Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Jantung ayam negeri segar, cocok untuk tumis atau dijadikan sup.', 'id_kategori' => 4, 'gambar' => 'jantung_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ceker Ayam (Ayam Negeri)', 'deskripsi_produk' => 'Ceker ayam negeri segar, enak dimasak dengan kuah atau digoreng.', 'id_kategori' => 4, 'gambar' => 'ceker_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                
                ['nama_produk' => 'Ayam Kampung Utuh', 'deskripsi_produk' => 'Ayam kampung utuh segar, ayam dengan rasa yang lebih alami.', 'id_kategori' => 4, 'gambar' => 'ayam_kampung_utuh.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ayam Kampung Potong', 'deskripsi_produk' => 'Ayam kampung potong, daging lebih kenyal dan rasa lebih gurih.', 'id_kategori' => 4, 'gambar' => 'ayam_kampung_potong.jpg', 'created_at' => now(), 'updated_at' => now()],
             
                //5. Ikan Laut
                ['nama_produk' => 'Ikan Salmon Fillet', 'deskripsi_produk' => 'Ikan salmon fillet segar, cocok untuk dipanggang atau dibuat sashimi.', 'id_kategori' => 5, 'gambar' => 'ikan_salmon_fillet.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Tuna Fillet', 'deskripsi_produk' => 'Ikan tuna fillet segar, cocok untuk dipanggang atau sushi.', 'id_kategori' => 5, 'gambar' => 'ikan_tuna_fillet.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Tenggiri Segar', 'deskripsi_produk' => 'Ikan tenggiri segar, pas untuk dibakar atau digoreng.', 'id_kategori' => 5, 'gambar' => 'ikan_tenggiri_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Kembung Segar', 'deskripsi_produk' => 'Ikan kembung segar, bisa digoreng atau dibuat pepes.', 'id_kategori' => 5, 'gambar' => 'ikan_kembung_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Bawal Putih', 'deskripsi_produk' => 'Ikan bawal putih segar, cocok untuk digoreng atau dibuat sup.', 'id_kategori' => 5, 'gambar' => 'ikan_bawal_putih.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Bandeng', 'deskripsi_produk' => 'Ikan bandeng segar, pas untuk digoreng atau dibakar.', 'id_kategori' => 5, 'gambar' => 'ikan_bandeng.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Kakap Merah', 'deskripsi_produk' => 'Ikan kakap merah segar, dagingnya lezat dan cocok untuk dibakar.', 'id_kategori' => 5, 'gambar' => 'ikan_kakap_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Ikan Lele', 'deskripsi_produk' => 'Ikan lele segar, cocok untuk digoreng atau dibakar.', 'id_kategori' => 5, 'gambar' => 'ikan_lele.jpg', 'created_at' => now(), 'updated_at' => now()],

                // Udang
                ['nama_produk' => 'Udang Windu', 'deskripsi_produk' => 'Udang windu segar, besar dan kenyal, cocok untuk digoreng atau dibakar.', 'id_kategori' => 5, 'gambar' => 'udang_windu.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Udang Vaname', 'deskripsi_produk' => 'Udang vaname segar, ukuran medium, pas untuk hidangan seafood.', 'id_kategori' => 5, 'gambar' => 'udang_vaname.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Udang Galah', 'deskripsi_produk' => 'Udang galah segar, besar dan lezat, cocok untuk dibakar atau ditumis.', 'id_kategori' => 5, 'gambar' => 'udang_galah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Udang Rebon', 'deskripsi_produk' => 'Udang rebon segar, cocok untuk dibuat sambal atau bahan masakan lainnya.', 'id_kategori' => 5, 'gambar' => 'udang_rebon.jpg', 'created_at' => now(), 'updated_at' => now()],
                
                // Cumi-Cumi
                ['nama_produk' => 'Cumi-Cumi Segar', 'deskripsi_produk' => 'Cumi-cumi segar, cocok untuk ditumis atau dibakar.', 'id_kategori' => 5, 'gambar' => 'cumi_cumi_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cumi-Cumi Fillet', 'deskripsi_produk' => 'Cumi-cumi fillet, siap dimasak dalam berbagai masakan.', 'id_kategori' => 5, 'gambar' => 'cumi_cumi_fillet.jpg', 'created_at' => now(), 'updated_at' => now()],
                
                // Kerang
                ['nama_produk' => 'Kerang Hijau', 'deskripsi_produk' => 'Kerang hijau segar, cocok untuk dibuat sup atau dibakar.', 'id_kategori' => 5, 'gambar' => 'kerang_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kerang Laut', 'deskripsi_produk' => 'Kerang laut segar, pas untuk dijadikan hidangan penutup atau sup.', 'id_kategori' => 5, 'gambar' => 'kerang_laut.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kerang Tiram', 'deskripsi_produk' => 'Kerang tiram segar, bisa dimakan mentah atau dibakar.', 'id_kategori' => 5, 'gambar' => 'kerang_tiram.jpg', 'created_at' => now(), 'updated_at' => now()],
                        
                //6. Rempah & Bumbu
                ['nama_produk' => 'Daun Jeruk', 'deskripsi_produk' => 'Daun jeruk segar, memberikan aroma khas pada masakan.', 'id_kategori' => 6, 'gambar' => 'daun_jeruk.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daun Salam', 'deskripsi_produk' => 'Daun salam segar, digunakan untuk memberi aroma pada masakan.', 'id_kategori' => 6, 'gambar' => 'daun_salam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daun Pandan', 'deskripsi_produk' => 'Daun pandan segar, memberikan aroma manis pada kue dan masakan.', 'id_kategori' => 6, 'gambar' => 'daun_pandan.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daun Ketumbar', 'deskripsi_produk' => 'Daun ketumbar segar, untuk penyedap rasa dalam masakan.', 'id_kategori' => 6, 'gambar' => 'daun_ketumbar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daun Kemangi', 'deskripsi_produk' => 'Daun kemangi segar, sering digunakan dalam sambal atau sebagai pelengkap masakan.', 'id_kategori' => 6, 'gambar' => 'daun_kemangi.jpg', 'created_at' => now(), 'updated_at' => now()],
                
                ['nama_produk' => 'Jahe Segar', 'deskripsi_produk' => 'Jahe segar, cocok untuk minuman hangat atau bumbu masakan.', 'id_kategori' => 6, 'gambar' => 'jahe_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kunyit Segar', 'deskripsi_produk' => 'Kunyit segar, digunakan untuk bumbu masakan dan obat tradisional.', 'id_kategori' => 6, 'gambar' => 'kunyit_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Lengkuas Segar', 'deskripsi_produk' => 'Lengkuas segar, memberikan aroma khas pada masakan.', 'id_kategori' => 6, 'gambar' => 'lengkuas_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Sereh Segar', 'deskripsi_produk' => 'Sereh segar, memberikan aroma wangi pada masakan.', 'id_kategori' => 6, 'gambar' => 'sereh_segar.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kemiri', 'deskripsi_produk' => 'Kemiri kering, digunakan untuk membuat bumbu halus.', 'id_kategori' => 6, 'gambar' => 'kemiri.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kayu Manis', 'deskripsi_produk' => 'Kayu manis kering, memberikan rasa hangat pada masakan dan minuman.', 'id_kategori' => 6, 'gambar' => 'kayu_manis.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cengkeh', 'deskripsi_produk' => 'Cengkeh kering, digunakan untuk membuat bumbu rempah dan minuman hangat.', 'id_kategori' => 6, 'gambar' => 'cengkeh.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Pala', 'deskripsi_produk' => 'Pala kering, memberikan rasa pedas hangat pada masakan dan kue.', 'id_kategori' => 6, 'gambar' => 'pala.jpg', 'created_at' => now(), 'updated_at' => now()],
    
                ['nama_produk' => 'Bawang Merah', 'deskripsi_produk' => 'Bawang merah segar, untuk bumbu dasar masakan.', 'id_kategori' => 6, 'gambar' => 'bawang_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Bawang Putih', 'deskripsi_produk' => 'Bawang putih segar, memberikan aroma dan rasa khas pada masakan.', 'id_kategori' => 6, 'gambar' => 'bawang_putih.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Bawang Bombay', 'deskripsi_produk' => 'Bawang bombay segar, digunakan untuk menambah aroma dan rasa pada masakan.', 'id_kategori' => 6, 'gambar' => 'bawang_bombay.jpg', 'created_at' => now(), 'updated_at' => now()],

                ['nama_produk' => 'Cabai Merah', 'deskripsi_produk' => 'Cabai merah segar, untuk masakan pedas.', 'id_kategori' => 6, 'gambar' => 'cabe_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cabai Rawit', 'deskripsi_produk' => 'Cabai rawit segar, sangat pedas untuk masakan.', 'id_kategori' => 6, 'gambar' => 'cabe_rawit.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cabai Hijau', 'deskripsi_produk' => 'Cabai hijau segar, memberikan rasa pedas pada masakan.', 'id_kategori' => 6, 'gambar' => 'cabe_hijau.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cabai Keriting', 'deskripsi_produk' => 'Cabai keriting segar, untuk bumbu sambal atau masakan pedas.', 'id_kategori' => 6, 'gambar' => 'cabe_keriting.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Cabai Kering', 'deskripsi_produk' => 'Cabai kering, digunakan untuk sambal atau masakan pedas.', 'id_kategori' => 6, 'gambar' => 'cabe_kering.jpg', 'created_at' => now(), 'updated_at' => now()],


                //7. Makanan Instan
                ['nama_produk' => 'Indomie Goreng', 'deskripsi_produk' => 'Mie instan goreng dengan rasa gurih dan pedas, cepat dan lezat.', 'id_kategori' => 7, 'gambar' => 'indomie_goreng.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Mie Sedaap Goreng', 'deskripsi_produk' => 'Mie instan goreng dengan bumbu pedas yang menggugah selera.', 'id_kategori' => 7, 'gambar' => 'mie_sedaap_goreng.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Soto Mie Instan', 'deskripsi_produk' => 'Mie instan dengan kuah soto yang segar, siap santap.', 'id_kategori' => 7, 'gambar' => 'soto_mie_instans.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Supermi Goreng', 'deskripsi_produk' => 'Mie instan goreng Supermi dengan rasa pedas dan nikmat.', 'id_kategori' => 7, 'gambar' => 'supermi_goreng.jpg', 'created_at' => now(), 'updated_at' => now()],
            
                //8. Produk Olahan Daging 
                ['nama_produk' => 'Sosis Ayam', 'deskripsi_produk' => 'Sosis ayam olahan yang gurih, cocok untuk berbagai hidangan.', 'id_kategori' => 8, 'gambar' => 'sosis_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Nugget Ayam', 'deskripsi_produk' => 'Nugget ayam dengan rasa lezat, crispy di luar, empuk di dalam.', 'id_kategori' => 8, 'gambar' => 'nugget_ayam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Bakso Sapi', 'deskripsi_produk' => 'Bakso sapi kenyal dengan rasa gurih, siap santap.', 'id_kategori' => 8, 'gambar' => 'bakso_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Hamburger Patty', 'deskripsi_produk' => 'Daging burger patty olahan yang lezat, cocok untuk sandwich atau burger.', 'id_kategori' => 8, 'gambar' => 'hamburger_patty.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Daging Rendang Instan', 'deskripsi_produk' => 'Daging rendang olahan dengan bumbu khas, praktis dan lezat.', 'id_kategori' => 8, 'gambar' => 'daging_rendang_instan.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kornet Sapi', 'deskripsi_produk' => 'Kornet sapi siap saji yang lezat, cocok untuk berbagai masakan.', 'id_kategori' => 8, 'gambar' => 'kornet_sapi.jpg', 'created_at' => now(), 'updated_at' => now()],
                //9. Produk Olahan Nabati
                ['nama_produk' => 'Tahu Putih', 'deskripsi_produk' => 'Tahu putih lembut, cocok untuk digoreng atau direbus.', 'id_kategori' => 9, 'gambar' => 'tahu_putih.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tahu Coklat', 'deskripsi_produk' => 'Tahu coklat dengan tekstur lebih padat dan berwarna kecoklatan.', 'id_kategori' => 9, 'gambar' => 'tahu_coklat.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tahu Kuning', 'deskripsi_produk' => 'Tahu kuning dengan warna khas, lembut dan gurih.', 'id_kategori' =>9, 'gambar' => 'tahu_kuning.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tempe Papan', 'deskripsi_produk' => 'Tempe papan tradisional yang keras dan kaya rasa.', 'id_kategori' => 9, 'gambar' => 'tempe_papan.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tempe Mendoan', 'deskripsi_produk' => 'Tempe mendoan cocok untuk camilan.', 'id_kategori' =>9, 'gambar' => 'tempe_mendoan.jpg', 'created_at' => now(), 'updated_at' => now()],
                //10. Bahan Pokok
                ['nama_produk' => 'Beras', 'deskripsi_produk' => 'Beras kualitas terbaik, siap masak.', 'id_kategori' => 10, 'gambar' => 'beras_putih.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Gula Pasir', 'deskripsi_produk' => 'Gula pasir manis, cocok untuk memasak atau minuman.', 'id_kategori' => 10, 'gambar' => 'gula_pasir.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Garam', 'deskripsi_produk' => 'Garam dapur halus untuk berbagai keperluan memasak.', 'id_kategori' => 10, 'gambar' => 'garam.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tepung Terigu', 'deskripsi_produk' => 'Tepung terigu serbaguna, cocok untuk membuat kue dan roti.', 'id_kategori' => 10, 'gambar' => 'tepung_terigu.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Tepung Beras', 'deskripsi_produk' => 'Tepung beras murni, digunakan untuk membuat berbagai hidangan.', 'id_kategori' => 10, 'gambar' => 'tepung_beras.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Minyak Goreng', 'deskripsi_produk' => 'Minyak goreng untuk berbagai keperluan memasak.', 'id_kategori' => 10, 'gambar' => 'minyak_goreng.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kecap Manis', 'deskripsi_produk' => 'Kecap manis dengan rasa manis dan gurih, cocok untuk masakan.', 'id_kategori' => 10, 'gambar' => 'kecap_manis.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Santan Kelapa', 'deskripsi_produk' => 'Santan kelapa kental, digunakan untuk membuat masakan khas Indonesia.', 'id_kategori' => 10, 'gambar' => 'santan_kelapa.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Beras Merah', 'deskripsi_produk' => 'Beras merah organik, sehat dan bergizi.', 'id_kategori' => 10, 'gambar' => 'beras_merah.jpg', 'created_at' => now(), 'updated_at' => now()],
                //11. Minuman
                ['nama_produk' => 'Teh Botol', 'deskripsi_produk' => 'Teh botol manis, siap diminum kapan saja.', 'id_kategori' => 11, 'gambar' => 'teh_botol.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Jus Jeruk', 'deskripsi_produk' => 'Jus jeruk segar, kaya akan vitamin C.', 'id_kategori' => 11, 'gambar' => 'jus_jeruk.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Kopi Instan kapal api', 'deskripsi_produk' => 'Kopi instan praktis untuk memulai hari.', 'id_kategori' => 11, 'gambar' => 'kopi_instan.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Susu UHT', 'deskripsi_produk' => 'Susu UHT dengan rasa lezat, cocok untuk minuman keluarga.', 'id_kategori' => 11, 'gambar' => 'susu_uht.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Air Kelapa', 'deskripsi_produk' => 'Air kelapa segar alami, menyegarkan dan kaya elektrolit.', 'id_kategori' => 11, 'gambar' => 'air_kelapa.jpg', 'created_at' => now(), 'updated_at' => now()],
                ['nama_produk' => 'Mineral Water', 'deskripsi_produk' => 'Air mineral dalam kemasan praktis untuk di perjalanan.', 'id_kategori' => 11, 'gambar' => 'mineral_water.jpg', 'created_at' => now(), 'updated_at' => now()],

            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
