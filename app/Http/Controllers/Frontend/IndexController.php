<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Berita;
use App\Models\BKAppointment;
use App\Models\BKComplaint;
use App\Models\Events;
use App\Models\Footer;
use App\Models\ImageSlider;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\KategoriBerita;
use App\Models\Kegiatan;
use App\Models\ProfileSekolah;
use App\Models\User;
use App\Models\Video;
use App\Models\Visimisi;
use Carbon\Carbon;
use App\Models\Gallery;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //Welcome
    public function index()
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Gambar Slider
        $slider = ImageSlider::where('is_Active','0')->get();

        // About
        $about = About::where('is_Active','0')->first();

        // Video
        $video = Video::where('is_active','0')->first();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Berita
        $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

        // Event
        $event = Events::where('is_active','0')->orderBy('created_at','desc')->get();

        // Footer
        $footer = Footer::first();

        return view('frontend.welcome', compact('jurusanM','kegiatanM','slider','about','video','pengajar','berita','event','footer'));
    }

    // Berita
    public function berita()
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();

         // Kategori
         $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();

         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->paginate(10);

         return view('frontend.content.beritaAll', compact('berita','kategori','jurusanM','kegiatanM','footer'));
    }
    // Show Detail Berita
    public function detailBerita($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Footer
        $footer = Footer::first();

        // Kategori
        $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();

        // Berita
        $beritaOther = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

        $berita = Berita::where('slug',$slug)->first();
        return view('frontend.content.showBerita', compact('berita','kategori','beritaOther','jurusanM','kegiatanM','footer'));
    }


    // Events
    public function events()
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();

         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

         $event = Events::where('is_active','0')->orderBy('created_at','desc')->get();
         return view('frontend.content.event.eventAll', compact('event','berita','jurusanM','kegiatanM','footer'));
    }


    // Detail Event
    public function detailEvent($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();

         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

         $event = Events::where('slug',$slug)->first();
         $eventOther = Events::where('is_active','0')->orderBy('created_at','desc')->get();

         return view('frontend.content.event.detailEvent', compact('event','eventOther','berita','jurusanM','kegiatanM','footer'));
    }

    // Profile Sekolah
    public function profileSekolah()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $profile = ProfileSekolah::first();
        return view('frontend.content.profileSekolah', compact('profile','jurusanM','kegiatanM','pengajar','footer'));
    }

    // Visi dan Misi
    public function visimisi()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $visimisi = Visimisi::first();
        return view('frontend.content.visimisi', compact('visimisi','jurusanM','kegiatanM','pengajar','footer'));
    }

    // Galeri

public function gallery(Request $request)
{
    $jurusanM = Jurusan::all();
    $kegiatanM = Kegiatan::all();
    $footer = Footer::first();

    $category = $request->query('category');

    $query = Gallery::orderBy('created_at', 'desc');

    if ($category) {
        $query->where('category', $category);
    }

    $galleries = $query->paginate(12);

    $categoriesRaw = DB::select("SHOW COLUMNS FROM gallery WHERE Field = 'category'")[0]->Type;

    preg_match_all("/'([^']+)'/", $categoriesRaw, $matches);
    $categories = $matches[1];

    return view('frontend.content.gallery', compact('galleries', 'jurusanM', 'kegiatanM', 'footer', 'categories', 'category'));
}

    public function rapot()
    {
        $jurusanM = Jurusan::all();
        $kegiatanM = Kegiatan::all();
        $footer = Footer::first();

        $pengajars = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // SEMENTARA \\
        $sambutan_kepsek = 'Bismiillahirahmanirrahim..
                    Assalamualaikum Wr.Wb.
                    Puji syukur kehadirat Allah SWT yang telah memberikan nikmat dan karunianya kepada kita semua, dan kepadanyalah kelak kita nanti kan kembali. Shalawat serta salam semoga senantiasa tercurah kepada junjungan kita Nabi Muhammad SAW beserta keluarga dan para sahabatnya.
                    Kami ucapkan selamat datang di website SMPN 2 Tegal. Website ini digunakan sebagai sarana informasi dan publikasi bagi masyarakat yang membutuhkan informasi seputar tentang SMPN 2 Tegal.
                    Semoga informasi yang diberikan, bisa memberikan gambaran yang cukup untuk mengetahui rangkaian kegiatan yang telah dilaksanakan oleh SMPN 2 Tegal. Kami menyadari akan kekurangan yang kami miliki. Tidak terputus kami mohon Doa dan dukungan dari semua pihak, sangat kami harapkan agar generasi penerus bangsa dapat terus semangat dalam berkarya.
                    Wassalamu alaikum wr.wb';
        $nama_kepsek ='Dr. Kepsek S.Kom, M.Si';

        return view('frontend.content.rapot', compact('jurusanM', 'kegiatanM', 'footer', 'pengajars', 'sambutan_kepsek', 'nama_kepsek'));
    }

    public function cetakRapot()
    {
        return view('frontend.content.cetakRapot');
    }

    public function cekRapot()
    {
        return view('frontend.content.cekRapot');
    }
    public function bk()
    {
        $jurusanM = Jurusan::all();
        $kegiatanM = Kegiatan::all();
        $footer = Footer::first();
        $kelas = Kelas::orderBy('kelas', 'asc')->get();
        $problemTypes = ['bullying' => 'Bullying', 'academic' => 'Akademik', 'family' => 'Keluarga', 'career' => 'Karier', 'other' => 'Lainnya'];
        $urgencyLevels = ['low' => 'Rendah', 'medium' => 'Sedang', 'high' => 'Tinggi'];
        $konsultasi = ['academic' => 'Akademik', 'career' => 'Karir', 'personal' => 'Personal', 'social' => 'Sosial', 'other'=>'Lainnya'];
        $appointments = BKAppointment::with(['kelas', 'counselor'])
            ->latest()
            ->get();
        return view('frontend.bk-complaint.index', compact('jurusanM', 'kegiatanM', 'footer','kelas','appointments', 'problemTypes', 'urgencyLevels','konsultasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'class' => 'required|exists:kelas,id',
            'problem_type' => 'required|in:bullying,academic,family,career,other',
            'description' => 'required|string',
            'urgency' => 'required|in:low,medium,high'
        ],[
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'class.required' => 'Kelas harus diisi.',
            'class.exists' => 'Kelas yang dipilih tidak valid.',
            'problem_type.required' => 'Jenis masalah harus diisi.',
            'problem_type.in' => 'Jenis masalah harus berupa bullying, akademik, keluarga, karier, atau lainnya.',
            'description.required' => 'Deskripsi masalah harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'urgency.required' => 'Tingkat urgensi harus diisi.',
            'urgency.in' => 'Tingkat urgensi harus berupa low, medium, atau high.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus berupa pending, dalam proses, atau selesai.'
        ]);

        BKComplaint::create([
            'name' => $validated['name'],
            'class_id' => $validated['class'],
            'problem_type' => $validated['problem_type'],
            'description' => $validated['description'],
            'urgency' => $validated['urgency']
        ]);

        return redirect()->route('bk-complaint.index')->with('success', 'Pengaduan berhasil dikirim');
    }
    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:online,offline',
            'name' => 'required|string|max:255',
            'class' => 'required|exists:kelas,id',
            'phone' => 'required|string|max:15',
            'email' => 'required_if:type,online|nullable|email',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'consultation_topic' => 'required|string',
            'description' => 'nullable|string',
            'counselor' => 'nullable|exists:users,id',
            'platform' => $request->type === 'online' ? 'required|string|in:google_meet,zoom,whatsapp' : 'nullable'
        ],[
            'type.required' => 'Jenis konsultasi harus diisi.',
            'type.in' => 'Jenis konsultasi harus berupa online atau offline.',
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'class.required' => 'Kelas harus diisi.',
            'class.exists' => 'Kelas yang dipilih tidak valid.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
            'email.required_if' => 'Email harus diisi jika jenis konsultasi online.',
            'email.email' => 'Format email tidak valid.',
            'appointment_date.required' => 'Tanggal konsultasi harus diisi.',
            'appointment_date.date' => 'Tanggal konsultasi harus berupa tanggal yang valid.',
            'appointment_date.after_or_equal' => 'Tanggal konsultasi tidak boleh sebelum hari ini.',
            'appointment_time.required' => 'Waktu konsultasi harus diisi.',
            'consultation_topic.required' => 'Topik konsultasi harus diisi.',
            'consultation_topic.in' => 'Topik konsultasi tidak valid.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'counselor.exists' => 'Konselor yang dipilih tidak valid.',
            'platform.required_if' => 'Platform harus diisi jika jenis konsultasi online.',
            'platform.in' => 'Platform harus berupa Google Meet, Zoom, atau WhatsApp.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus berupa pending, approved, completed, atau cancelled.',
            'meeting_link.required_if' => 'Link meeting harus diisi jika status disetujui.',
            'meeting_link.url' => 'Format link meeting tidak valid.'
        ]);

        $appointment = new BKAppointment();
        $appointment->type = $validated['type'];
        $appointment->name = $validated['name'];
        $appointment->class_id = $validated['class'];
        $appointment->phone = $validated['phone'];
        $appointment->email = $validated['email'] ?? null;
        $appointment->appointment_date = $validated['appointment_date'];
        $appointment->appointment_time = $validated['appointment_time'];
        $appointment->consultation_topic = $validated['consultation_topic'];
        $appointment->description = $validated['description'] ?? null;
        $appointment->counselor_id = $validated['counselor'] ?? null;

        if ($request->type === 'online') {
            $appointment->platform = $validated['platform'];
        }

        $appointment->save();

        return redirect()->route('bk-complaint.index')->with('success', 'Janji konsultasi Anda berhasil dibuat');
    }
}
