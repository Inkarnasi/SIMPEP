<style>
    body {
        margin: 0;
        height: 100vh;
        background: url('/Assets/img/bg.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    /* overlay opsional supaya teks lebih jelas */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        /* lapisan gelap transparan */
        backdrop-filter: blur(3px);
        /* blur background */
        -webkit-backdrop-filter: blur(3px);
        z-index: -1;
    }

    .card.glass {
        background: rgba(255, 255, 255, 0.2);
        /* transparan */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #fff;
        /* teks putih biar kontras */
    }

    @media (max-width: 767px) {
        body {
            background: url('<?= base_url("Assets/img/bg_mobile.jpg"); ?>') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            width: 95%;
            padding: 10px;
        }

        .card {
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: none;
            text-align: left;
        }

        p {
            font-size: 14px;
            line-height: 1.5;
        }

    }
</style>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body" style="text-align: justify;">
            <h3 class="mb-3 text-center">Beranda</h3>

            <p>1. Undang-undang Nomor 25 Tahun 2004 tentang Sistem Perencanaan Pembangunan Nasional, Undang-Undang Nomor 23 Tahun 2014, tentang Pemerintahan Daerah dan Peraturan Menteri Dalam Negeri Nomor 86 Tahun 2017 tentang Pelaksanaan Peraturan Pemerintah Nomor 8 Tahun 2008 tentang Tata Cara Perencanaan, Pengendalian dan Evaluasi Rancangan Peraturan Daerah tentang Rencana Pembangunan Jangka Panjang Daerah dan Rencana Pembangunan Jangka Panjang Daerah dan Rencana Pembangunan Jangka Menengah Daerah, serta Tata Cara Perubahan Rencanan Pembangunan Jangka Panjang Daerah dan Rencana Pembangunan Jangka Menengah Daerah, serta Tata Cara Perubahan Rencana Pembangunan Jangka Panjang Daerah, Rencana Pembangunan Jangka Menengah Daerah dan Rencana Kerja Pemerintah Daerah, merupakan dasar hukum dalam pelaksaanan perencanaan evaluasi dan pelaporan di Dinas Pemadam Kebakaran dan Penyelamatan Kota Depok.</p>

            <p>2. Sekretariat Dinas Pemadam Kebakaran dan Penyelamatan merupakan salah satu organisasi di dalam Dinas Damkar. Sekretariat mempunyai tugas mengoordinasikan, perencanaan, pembinaan dan pengendalian terhadap program, administrasi dan sumber daya serta kerjasama. Sekretaris Utama menyelenggarakan fungsi dalam pengoordinasian, perencanaan, sinkronisasi dan integrasi perumusan kebijakan teknis.</p>

            <p>3. Peraturan Walikota Nomor 19 Tahun 2019 tentang Perubahan atas Peraturan Walikota Nomor 112 Tahun 2016 tentang Kedudukan Susunan Organisasi Tugas dan Fungsi Serta Tata Kerja Dinas Pemadam Kebakaran dan Penyelamatan, pada paragraf 2 Pasal 8 disampaikan tugas Sub Bagian Perencanaan Evaluasi Pelaporan yaitu melaksanakan pengelolaan, perencanaan, evaluasi dan laporan kegiatan Dinas. Dalam melaksanakan tugas tersebut Sub bagian perencanaan, evaluasi dan pelaporan menyelengarakan fungsi sebagai berikut:</p>

            <ul>
                <li>Penyusunan program kerja sub bagian sesuai dengan program kerja sekretariat;</li>
                <li>Pengumpulan, pengolahan data dan informasi, menginventarisasi permasalahan-permasalahan serta melaksanakan pemecahan permasalahan yang berkaitan dengan tugas-tugas urusan perencanaan, evaluasi dan pelaporan;</li>
                <li>Perencanaan, pelaksanaan, pengendalian, evaluasi dan pelaporan kegiatan sub bagian;</li>
                <li>Pengkoordinasian penyusunan bahan-bahan kebijakan dari bidang;</li>
                <li>Penyelengaraan analisis dan pengembangan kinerja Dinas;</li>
                <li>Pelaksanaan penyusunan Renstra Dinas;</li>
                <li>Pelaksanaan penyusunan rencana anggaran Dinas;</li>
                <li>Penyusunan program kerja tahunan Dinas;</li>
                <li>Penyusunan rancangan produk hukum Dinas;</li>
                <li>Penyusunan Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP) Dinas;</li>
                <li>Pelaksanaan analisis dan pengembangan kinerja sub bagian; dan</li>
                <li>Pelaksanaan tugas lainnya sesuai bidang tugasnya yang diberikan oleh sekretaris.</li>
            </ul>

            <p>4. Sehingga dalam melaksanakan tugas dan fungsi Sub bagian perencanaan evaluasi dan pelaporan harus mengedepankan koordinasi dan tim work untuk mencapai kinerja Dinas Pemadam Kebakaran dan Penyelamatan Kota Depok.</p>

            <p>5. Koordinasi yang dilaksanakan oleh sub bagian perencanaan evaluasi dan pelaporan mencakup koordinasi eksternal di luar Dinas Pemadam Kebakaran dan Penyelamatan seperti Bagian Pemerintahan terkait SPM Bencana dan Kebakaran, Bagian Organisasi terkait akuntabilitas kinerja Dinas yang tertuang pada indeks reformasi birokrasi, dan Bappeda terkait dokumen perencanaan Renstra, Rencana Kerja Tahunan, Rencana Aksi, Monev Evaluasi Kinerja, Laporan Penyelenggara Pemerintah Daerah (LPPD), dan Laporan Keterangan Pertanggungjawaban (LKPJ), DPA dan dokumen perencanaan lainnya.</p>

            <p>6. Terkait evaluasi dan pengendalian, Sub Bagian Perencanaan Evaluasi Pelaporan melakukan penyusunan Manajemen Risiko, Sistem Pengendalian Internal Pemerintah (SPIP), Rencana Tindak Pengendalian (RTP), dan berkoordinasi dengan Inspektorat Daerah Kota Depok.</p>

            <p>7. Dalam melaksanakan penyampaian terkait seluruh laporan kepada pihak eksternal Dinas Damkar dalam hal ini Pemerintah Daerah Kota Depok, Sub Bagian Perencanaan Evaluasi Pelaporan melakukan koordinasi internal dengan seluruh bidang baik Bidang Penanggulangan Bencana, Bidang Pengendalian Operasional Kebakaran, Bidang Pencegahan, Penyuluhan, dan Peran serta Masyarakat serta Bidang Sarana Prasarana.</p>

            <p>8. Untuk itu pentingnya kolaborasi yang baik antar unit kerja agar tercapainya target capaian kinerja Dinas Pemadam Kebakaran dan Penyelamatan Kota Depok sesuai dengan Rencana Strategis (Renstra).</p>

            <p>9. Website PEP Dinas Pemadam Kebakaran dan Penyelamatan ini merupakan wadah untuk mengumpulkan data dan informasi yang berkaitan dengan kinerja Sub Bagian PEP. Selain itu, website ini mempermudah pencarian dokumen yang dibutuhkan dalam waktu singkat serta meminimalisasi hilangnya dokumen perencanaan yang krusial dan penting.</p>
        </div>
    </div>
</div>

</div><!-- row sidebar -->
</div> <!-- container sidebar -->
