@extends('layouts.app')
@section('title', 'David Music Course - Home')
@section('content')
<!-- Hero Section -->
<section class="hero">
    <img src="{{ asset('images/bg1.jpg') }}" alt="">
    <div class="hero-content">
        <h1>Menghidupkan Musik, Menginspirasi Jiwa</h1>
        <p>
            Menginspirasi dan mendapatkan bakat musik dengan dasar pengajaran yang penuh kasih
        </p>
        @auth
        <a href="{{ route('courses.index') }}" class="cta-btn">Lihat Kelas</a>
        @else
        <a href="{{ route('register') }}" class="cta-btn">Daftar</a>
        @endauth
    </div>
    <div class="hero-bg"></div>
</section>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <h2>TENTANG KAMI</h2>
        <div class="about-content">
            <div class="about-text">
                <p>David Music Course adalah pusat pendidikan non-formal yang menawarkan kursus musik dengan instruktur
                    berpengalaman dan pendekatan personal. Kami menyediakan berbagai pilihan kursus seperti piano,
                    gitar, biola, drum, dan vokal untuk semua tingkat keahlian. Di lingkungan belajar yang inspiratif,
                    siswa dapat mengasah keterampilan mereka dan tampil di berbagai acara.</p>
                <div class="about-details">
                    <div class="detail-item">
                        <strong>Tahun Berdiri:</strong>
                        <span>2019</span>
                    </div>
                    <div class="detail-item">
                        <strong>Lokasi:</strong>
                        <span>Grand Vista Cikarang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission Section -->
<section class="vision-mission-section">
    <div class="container">
        <div class="vision-mission-grid">
            <div class="vision-card">
                <h3>VISI</h3>
                <p>Menjadi institusi pendidikan musik yang terkemuka, menginspirasi dan mengasah bakat musik dengan
                    dasar pengajaran yang penuh kasih.</p>
            </div>
            <div class="mission-card">
                <h3>MISI</h3>
                <ul>
                    <li>Memberikan Pendidikan Musik Berkualitas: Menyediakan program belajar musik yang komprehensif dan
                        berkualitas, didukung oleh instruktur berpengalaman.</li>
                    <li>Menciptakan Lingkungan Belajar yang Penuh Kasih: Membangun suasana yang mendukung, hangat, dan
                        penuh perhatian sehingga siswa merasa nyaman dan termotivasi.</li>
                    <li>Mengembangkan Potensi Individu: Menyediakan pendekatan pembelajaran yang disesuaikan dengan
                        kebutuhan dan potensi setiap siswa.</li>
                    <li>Menumbuhkan Kecintaan Terhadap Musik: Mendorong siswa untuk mengekspresikan diri dan menemukan
                        kegembiraan dalam bermusik.</li>
                    <li>Mempersiapkan Siswa untuk Berprestasi: Melatih dan mendukung siswa untuk tampil dan berprestasi
                        di berbagai panggung musik.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="courses-section">
    <div class="container">
        <h2>COURSES</h2>
        <div class="courses-grid">
            @if($courses && $courses->count() > 0)
            @foreach($courses as $course)
            <div class="course-item">
                <div class="course-icon">
                    @if(isset($course->icon) && $course->icon)
                    <img src="{{ asset('storage/' . $course->icon) }}" alt="{{ $course->name }}">
                    @else
                    <!-- Fallback image jika icon tidak ada -->
                    <img src="{{ asset('images/default-course.png') }}" alt="{{ $course->name }}"
                        onerror="this.src='{{ asset('images/music-note.svg') }}'; this.onerror=null;">
                    @endif
                </div>
                <h3>{{ strtoupper($course->name) }}</h3>
                @auth
                @else
                @endauth
            </div>
            @endforeach
            @else
            <div class="no-courses">
                <p>Belum ada kelas yang tersedia saat ini.</p>
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.courses.create') }}" class="admin-link">Tambah Kelas Baru</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section class="facilities-section">
    <div class="container">
        <h2>FASILITAS</h2>
        <div class="facilities-grid">
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h3>Ruang Kelas Musik</h3>
                <p>Ruang kelas yang nyaman dan dilengkapi dengan alat musik lengkap seperti piano, gitar, biola, dan
                    drum.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <h3>Ruang Praktek Individu</h3>
                <p>Ruang-ruang praktek pribadi yang tenang dan dilengkapi dengan instrumen untuk latihan individu.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Perpustakaan Musik</h3>
                <p>Koleksi buku, partitur musik, dan bahan referensi lainnya yang dapat dipinjam oleh siswa untuk
                    mendukung belajar mereka.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Ruang Ensemble dan Band</h3>
                <p>Ruang khusus untuk latihan grup seperti band, ansambel, dan orkestra kecil, lengkap dengan peralatan
                    audio yang diperlukan.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-couch"></i>
                </div>
                <h3>Lounge Siswa</h3>
                <p>Area istirahat yang nyaman untuk siswa bersosialisasi dan relaksasi di antara sesi pelajaran.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <h3>Wi-Fi Gratis</h3>
                <p>Akses internet gratis di seluruh area institut untuk mendukung pembelajaran dan riset online.</p>
            </div>
            <div class="facility-item">
                <div class="facility-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Ruang Konsultasi</h3>
                <p>Ruang untuk sesi konsultasi pribadi antara siswa dan instruktur untuk bimbingan dan dukungan belajar
                    lebih lanjut.</p>
            </div>
        </div>
    </div>
</section>

<!-- Instructors Section -->
<section class="instructors-section">
    <div class="container">
        <h2>PENGAJAR</h2>
        <div class="instructors-grid">
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>David John Kevin</h3>
                <p>Founder & Head Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Lamsihar Manalu</h3>
                <p>Music Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Rachel Nadine</h3>
                <p>Music Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Michele Putri</h3>
                <p>Music Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Elsha Yohana</h3>
                <p>Music Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Alberto Manulang</h3>
                <p>Music Instructor</p>
            </div>
            <div class="instructor-item">
                <div class="instructor-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>Dikko Putra</h3>
                <p>Music Instructor</p>
            </div>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="achievements-section">
    <div class="container">
        <h2>PRESTASI</h2>
        <div class="achievements-grid">
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Kerja Sama dengan Pakar</h3>
                <p>Pada bulan Agustus 2024, David Music Course bekerja sama dengan guru musik Yamaha Music School. Siswa
                    mendapatkan pengalaman belajar langsung dari musisi ternama dan banyak dari mereka menunjukkan
                    peningkatan signifikan dalam teknik bermain musik mereka.</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-music"></i>
                </div>
                <h3>Konser Tahunan</h3>
                <p>Konser tahunan "Symphony of Dreams" yang diselenggarakan pada Oktober 2024 di Mall Ciputra Cibubur
                    berhasil menarik lebih dari 1.000 penonton. Siswa tampil dengan sangat memukau dan konser ini
                    mendapatkan liputan dari media lokal.</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3>Siswa Memenangkan Kompetisi</h3>
                <p>Salah satu siswa, Stevanie, memenangkan juara 1 di Kompetisi Piano Nasional tahun 2023. Keberhasilan
                    Stevanie ini menjadi inspirasi bagi siswa lainnya dan meningkatkan kepercayaan diri mereka.</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Program Beasiswa Berprestasi</h3>
                <p>Pada tahun 2024, David Music Course meluncurkan program beasiswa untuk 10 siswa berbakat yang berasal
                    dari latar belakang ekonomi kurang mampu. Program ini mendapat apresiasi dari masyarakat dan
                    dukungan dari sponsor lokal.</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Partisipasi dalam Kegiatan Amal</h3>
                <p>Pada bulan Juni 2024, siswa David Music Course berpartisipasi dalam konser amal "Music for Hope"
                    untuk menggalang dana untuk pembangunan rumah ibadah. Acara ini berhasil mengumpulkan dana sebesar
                    20 juta rupiah.</p>
            </div>
            <div class="achievement-item">
                <div class="achievement-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Kurikulum yang Mendapat Pengakuan</h3>
                <p>Kurikulum David Music Course mendapat pengakuan dari Dinas Budaya dan Pariwisata Kabupaten Bogor.
                    Pengakuan ini menambah kredibilitas institusi dan menarik lebih banyak calon siswa.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <h2>KONTAK KAMI</h2>
        <div class="contact-grid">
            <div class="contact-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.8420207025065!2d107.06144239999999!3d-6.4143394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69970955555555%3A0x5e7e57d4edec8fee!2sGrand%20Vista%20Cikarang!5e0!3m2!1sen!2sid!4v1751908581686!5m2!1sen!2sid"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="contact-info">
                <div class="info-section">
                    <div class="about-section">
                        <h3><i class="fas fa-music"></i> Tentang David Music Course</h3>
                        <p>David Music Course adalah lembaga kursus musik terpercaya yang telah berpengalaman dalam
                            mengajarkan berbagai alat musik. Kami menyediakan pembelajaran musik yang berkualitas dengan
                            instruktur berpengalaman untuk semua tingkat, dari pemula hingga mahir.</p>
                        <p>Dengan metode pembelajaran yang menyenangkan dan fasilitas yang lengkap, kami membantu Anda
                            mewujudkan impian bermusik dengan profesional.</p>
                    </div>

                    <div class="bottom-sections">
                        <div class="schedule-section">
                            <h3><i class="fas fa-clock"></i> Jam Operasional</h3>
                            <div class="schedule-grid">
                                <div class="schedule-item">
                                    <span class="day">Senin - Jumat</span>
                                    <span class="time">09:00 - 21:00</span>
                                </div>
                                <div class="schedule-item">
                                    <span class="day">Sabtu - Minggu</span>
                                    <span class="time">08:00 - 18:00</span>
                                </div>
                            </div>
                        </div>

                        <div class="whatsapp-section">
                            <h3><i class="fab fa-whatsapp"></i> Hubungi Kami</h3>
                            <div class="whatsapp-content">
                                <div class="phone-number">
                                    <i class="fas fa-phone"></i>
                                    <span>+62 812-3456-7890</span>
                                </div>
                                <a href="https://wa.me/6281234567890?text=Halo%20saya%20ingin%20bertanya%20tentang%20kursus%20musik"
                                    class="whatsapp-btn" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Chat WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* Contact Section */
.contact-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #e17055 0%, #a0392e 100%);
    color: white;
}

.contact-section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 50px;
    color: white;
    font-weight: bold;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    max-width: 1200px;
    margin: 0 auto;
    align-items: start;
}

.contact-map {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.contact-map iframe {
    border-radius: 15px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.info-section {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.contact-section .about-section {
    background: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.contact-section .about-section h3 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: #d63031;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;
}

.contact-section .about-section p {
    font-size: 1rem;
    line-height: 1.7;
    color: #2d3436;
    margin-bottom: 15px;
    text-align: justify;
}

.contact-section .bottom-sections {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.contact-section .schedule-section {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.contact-section .schedule-section h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: #d63031;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;
}

.contact-section .schedule-grid {
    display: grid;
    gap: 12px;
}

.contact-section .schedule-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    border-radius: 10px;
    color: white;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(116, 185, 255, 0.3);
    transition: transform 0.3s ease;
}

.schedule-item:hover {
    transform: translateY(-2px);
}

.schedule-item .day {
    font-weight: 600;
}

.schedule-item .time {
    font-size: 1.1rem;
    font-weight: 700;
}

.whatsapp-section {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.whatsapp-section h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: #d63031;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;
}

.whatsapp-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.phone-number {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 8px;
    color: #2d3436;
    font-weight: 500;
    border-left: 4px solid #25D366;
}

.phone-number i {
    color: #25D366;
    font-size: 1.1rem;
}

.whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: white;
    padding: 15px 25px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    border: none;
}

.whatsapp-btn:hover {
    background: linear-gradient(135deg, #128C7E, #0d7377);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
    color: white;
    text-decoration: none;
}

.whatsapp-btn i {
    font-size: 1.3rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.contact-icon {
    font-size: 2rem;
    color: #ffeaa7;
    min-width: 50px;
}

.contact-details h3 {
    font-size: 1.2rem;
    margin-bottom: 8px;
    color: white;
}

.contact-details p {
    font-size: 1rem;
    line-height: 1.5;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 15px;
}

/* Responsive Design untuk Contact Section */
@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .contact-map iframe {
        height: 300px;
    }

    .contact-section h2 {
        font-size: 2rem;
    }

    .contact-section .about-section h3 {
        font-size: 1.3rem;
    }

    .contact-section .about-section p {
        font-size: 0.9rem;
    }

    .contact-section .bottom-sections {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .contact-section .schedule-item {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }

    .whatsapp-btn {
        padding: 12px 20px;
        font-size: 1rem;
    }

    .contact-section.info-section {
        gap: 20px;
    }

    .contact-section .about-section,
    .schedule-section,
    .whatsapp-section {
        padding: 20px;
    }
}

/* About Section */
.about-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
}

.about-section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #8b2635;
    font-weight: bold;
}

.about-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.about-text h3 {
    font-size: 2rem;
    color: #a0392e;
    margin-bottom: 20px;
}

.about-text p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #8b2635;
    margin-bottom: 30px;
}

.about-details {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.detail-item strong {
    font-size: 1.1rem;
    color: #8b2635;
}

.detail-item span {
    font-size: 1rem;
    color: #a0392e;
}

/* Vision Mission Section */
.vision-mission-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #e17055 0%, #a0392e 100%);
    color: white;
}

.vision-mission-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
}

.vision-card,
.mission-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 40px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.vision-card h3,
.mission-card h3 {
    font-size: 2rem;
    margin-bottom: 20px;
    text-align: center;
}

.vision-card p {
    font-size: 1.1rem;
    line-height: 1.6;
    text-align: center;
}

.mission-card ul {
    list-style: none;
    padding: 0;
}

.mission-card li {
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 15px;
    padding-left: 20px;
    position: relative;
}

.mission-card li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #fff;
    font-weight: bold;
}

/* Facilities Section */
.facilities-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #ffffff 0%, #ffeaa7 100%);
}

.facilities-section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 50px;
    color: #8b2635;
    font-weight: bold;
}

.facilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.facility-item {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(139, 38, 53, 0.1);
}

.facility-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(139, 38, 53, 0.2);
}

.facility-icon {
    font-size: 3rem;
    color: #e17055;
    margin-bottom: 20px;
}

.facility-item h3 {
    font-size: 1.3rem;
    color: #8b2635;
    margin-bottom: 15px;
}

.facility-item p {
    color: #a0392e;
    line-height: 1.6;
}

/* Instructors Section */
.instructors-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #fab1a0 0%, #e17055 100%);
}

.instructors-section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 50px;
    color: #8b2635;
    font-weight: bold;
}

.instructors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.instructor-item {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(139, 38, 53, 0.1);
}

.instructor-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(139, 38, 53, 0.2);
}

.instructor-avatar {
    font-size: 4rem;
    color: #e17055;
    margin-bottom: 20px;
}

.instructor-item h3 {
    font-size: 1.3rem;
    color: #8b2635;
    margin-bottom: 10px;
}

.instructor-item p {
    color: #a0392e;
    font-style: italic;
}

/* Achievements Section */
.achievements-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #ffeaa7 0%, #ffffff 100%);
}

.achievements-section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 50px;
    color: #8b2635;
    font-weight: bold;
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.achievement-item {
    background: linear-gradient(135deg, #e17055 0%, #a0392e 100%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.achievement-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(139, 38, 53, 0.3);
}

.achievement-icon {
    font-size: 3rem;
    margin-bottom: 20px;
}

.achievement-item h3 {
    font-size: 1.4rem;
    margin-bottom: 15px;
}

.achievement-item p {
    line-height: 1.6;
    font-size: 0.95rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .vision-mission-grid {
        grid-template-columns: 1fr;
    }

    .facilities-grid {
        grid-template-columns: 1fr;
    }

    .instructors-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .achievements-grid {
        grid-template-columns: 1fr;
    }

    .contact-info {
        flex-direction: column;
        align-items: center;
    }

    .about-details {
        flex-direction: column;
        gap: 20px;
    }
}
</style>
@endsection