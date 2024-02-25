<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gambar_komik;
use App\Models\komik;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\volume;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpankomik;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\AdminAuthor;
use App\Models\Komentar;
use PDF;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Auth\Middleware\AuthorMiddleware;

class KomikController extends Controller
{



    public function index()
    {
        $this->middleware('AuthorAdmin');
        // Ambil data komik beserta relasinya dan pembuat komik (user)
        $komiks = Komik::with(['volumes', 'gambarKomik', 'user'])->get();
    
        return view('komik.index', compact('komiks'));
    }

    public function carikomik(Request $request)
    {
      
    $search = $request->input('search');

    // Perform the search on the User model
    $komik = Komik::where('judul_komik', 'like', '%' . $search . '%')
                  ->get();

    // Pass the search results to the view
    return view('komik.index')->with(['komik' => $komik, 'search' => $search]);
    }


    public function datavolume(Request $request)
    {
        // Ambil komik_id dari parameter request
        $komikId = $request->input('komik_id');
    
        // Dapatkan komik dengan relasi volumes
        $komik = Komik::with('volumes')->find($komikId);
    
        // Pass data ke view
        return view('komik.datavolume', compact('komik'));
    }
    
    
    public function home(Request $request)
    {
        // Subquery untuk mendapatkan ID komik dengan volume 1
        $komikIdsWithVolumeOne = Volume::where('judul_volume', '=', 1)
            ->pluck('komik_id')
            ->unique();
    
        // Query dasar untuk mendapatkan komik dengan relasi volume, gambar, dan user hanya untuk komik dengan volume 1
        $query = Komik::with(['volumes', 'gambarKomik', 'user'])
            ->whereIn('id', $komikIdsWithVolumeOne);
    
        // Cek apakah ada pencarian
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            // Tambahkan kondisi pencarian ke query
            $query->where('judul_komik', 'like', '%' . $keyword . '%');
        }
    
         // Komik yang baru diinput (latest)
    $komiksTop = $query->orderBy('created_at', 'desc')->get();

    // Komik yang paling lama diinput (oldest)
    $komiksBottom = $query->orderBy('created_at', 'asc')->get();

    // Reverse the order for $komiksBottom
    $komiksBottom = $komiksBottom->reverse();

    $top = Komik::orderBy('jumlah_pembaca', 'desc')->limit(3)->get();
    
        return view('home', compact('komiksTop', 'komiksBottom','top'));
    }
    

    public function hasilCariKomik(Request $request)
    {
        // Mendapatkan hasil pencarian dari formulir di halaman home
        $keyword = $request->input('keyword');
    
        // Lakukan pencarian berdasarkan keyword di judul_komik atau judul_volume
        $hasilPencarian = Komik::where('judul_komik', 'like', '%' . $keyword . '%')
            ->orWhereHas('volumes', function ($query) use ($keyword) {
                $query->where('judul_volume', 'like', '%' . $keyword . '%');
            })
            ->get();
    
        return view('hasilcarikomik', compact('hasilPencarian', 'keyword'));
    }
    
    


     public function halaman_simpankomik()
     {
         // Ambil user yang sedang login
    $user = Auth::user();

    // Ambil simpanan komik berdasarkan user_id
    $simpankomiks = Simpankomik::where('user_id', $user->id)->get();

    // Kirim data ke view
    return view('simpankomik', ['simpankomiks' => $simpankomiks]);
     }

     public function input_simpankomik(Request $request)
     {
         // Validasi data
         $data = $request->validate([
             'komik_id' => 'required|exists:komik,id',
             'user_id' => 'required|exists:users,id',
             'volume_id' => 'nullable|exists:volume,id',
         ]);
     
         // Periksa apakah pengguna sudah menyimpan komik ini
         $existingEntry = Simpankomik::where('komik_id', $data['komik_id'])
             ->where('user_id', $data['user_id'])
             ->where('volume_id', $data['volume_id'])
             ->exists();
     
         if (!$existingEntry) {
             // Jika entri belum ada, buat yang baru
             Simpankomik::create($data);
     
             // Alihkan ke halaman beranda setelah penyimpanan berhasil
             return back()->with('success', 'Komik berhasil disimpan');
         } else {
             // Jika entri sudah ada, alihkan dengan pesan yang sesuai
             return back()->with('info', 'Komik sudah disimpan sebelumnya');
         }
     }

     public function delete_simpankomik($id)
     {
         // Retrieve the Simpankomik entry by ID
         $simpankomik = Simpankomik::find($id);
     
         // Check if the entry exists
         if ($simpankomik) {
             // Delete the Simpankomik entry
             $simpankomik->delete();
     
             // Redirect back with success message
             return back()->with('success', 'Komik berhasil dihapus');
         } else {
             // Redirect back with error message if entry doesn't exist
             return back()->with('error', 'Komik tidak ditemukan');
         }
     }
     
     
public function halamantambahvolume($komik_id)
{
    // Dapatkan komik berdasarkan ID
    $komik = Komik::find($komik_id);

    // Tampilkan halaman tambah volume dengan data komik
    return view('komik.tambahvolume', compact('komik'));
}


public function input_tambahvolume(Request $request)
{
     // Validate data for both volume and images
     $validatedData = $request->validate([
        'komik_id' => 'required|exists:komik,id',
        'judul_volume' => 'required|string',
        'jumlah_halaman' => 'required|integer|min:1', // Ensure jumlah_halaman is at least 1
        'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Create a new volume with the provided information
    $volume = Volume::create([
        'komik_id' => $validatedData['komik_id'],
        'judul_volume' => $validatedData['judul_volume'],
        'jumlah_halaman' => $validatedData['jumlah_halaman'],
    ]);

    // Loop through each image file and save it
    foreach ($request->file('gambar') as $gambar) {
        // Check if an image is provided for the current page
        if ($gambar) {
            $judulGambar = pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($judulGambar);
            $new_gambar = time() . '_' . $slug . '.' . $gambar->getClientOriginalExtension();

            // Move and save the image in the 'uploads/gambarkomik' folder
            $gambar->move('uploads/gambarkomik', $new_gambar);

            // Create a new image record for the komik
            gambar_komik::create([
                'komik_id' => $validatedData['komik_id'],
                'volume_id' => $volume->id,
                'judul_gambar' => 'uploads/gambarkomik/' . $new_gambar,
                'gambar_path' => $new_gambar,
            ]);
        }
    }
    // Redirect or display the success page
    return redirect()->route('komik.index');
}

public function detaillengkap($id)
{
    $komik = Komik::with(['volumes', 'gambarKomik', 'user'])
        ->find($id);

    $volumes = $komik->volumes()->paginate(4);
    $menit = 526000;
    $readStatus = Cookie::get('komik_' . $komik->id . '_user_' . Auth::id()) === 'read';
    if (!$readStatus) {
        
        $komik->jumlah_pembaca++;
        $komik->save();

        Cookie::queue('komik_' . $komik->id . '_user_' . Auth::id(), 'read', $menit);
    }

    return view('detaillengkap', compact('komik', 'volumes', 'readStatus'));
}

public function bacaKomik($id, $volume)
{
    // Dapatkan komik dengan relasi volume, gambar, dan user
    $komik = Komik::with(['volumes.gambarKomik', 'user'])->find($id);

    // Dapatkan volume yang sesuai dengan parameter
    $selectedVolume = $komik->volumes->find($volume);

    // Dapatkan komentar berdasarkan komik_id dan volume_id
    $komentar = Komentar::where('komik_id', $id)
        ->where('volume_id', $selectedVolume->id)
        ->get();


    return view('bacakomik', compact('komik', 'selectedVolume', 'komentar'));
}

public function logika_komentar(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required|integer',
        'komik_id' => 'required|integer',
        'volume_id' => 'required|integer',
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|string|max:255',
    ]);

    // Simpan rating dan komentar ke database
    Komentar::create($data);

    return redirect()->back()->with('success', 'Komentar Sukses Diposting');
}

public function hapuskomentar(string $id) {
    $komentar = Komentar::find($id);

    // Check if the comment exists
    if (!$komentar) {
        return back()->with('error', 'Komentar tidak ditemukan');
    }

    // Check if the authenticated user is the owner of the comment
    if (auth()->user()->id != $komentar->user_id) {
        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini');
    }

    // Delete the comment
    $komentar->delete();

    return back()->with('success', 'Komentar dihapus');
}

public function bagiankomik()
{
    $users = User::where('level', 'author')->get();
    $komik = new Komik; // Add this line to instantiate a new Komik
    return view('komik.bagiankomik', compact('users', 'komik'));
}

public function listbaca_admin($id, $volume)
{

    $komik = Komik::with(['volumes.gambarKomik', 'user'])->find($id);

    // Dapatkan volume yang sesuai dengan parameter
    $selectedVolume = $komik->volumes->find($volume);

    return view('komik.listbaca_admin', compact('komik', 'selectedVolume'));
}


 
    public function hapusvolume($id)
    {
        // Temukan volume berdasarkan ID
        $volume = Volume::findOrFail($id);
    
        // Dapatkan ID gambar_komik yang terkait dengan volume
        $gambarKomikIds = DB::table('gambar_komik')->where('volume_id', $volume->id)->pluck('id');
    
        // Hapus gambar-gambar terkait
        foreach ($gambarKomikIds as $gambarKomikId) {
            $gambarKomik = gambar_komik::findOrFail($gambarKomikId);
            if ($gambarKomik->path) {
                Storage::disk('public')->delete($gambarKomik->path);
            }
            $gambarKomik->delete();
        }
    
        // Hapus volume
        $volume->delete();
    
        return redirect()->back()->with('success', 'Volume berhasil dihapus.');
    }

    public function editvolume($id)
    {
        // Temukan volume berdasarkan ID
        $volume = Volume::findOrFail($id);
    
        // Dapatkan gambar-gambar terkait dengan volume
        $gambarKomik = gambar_komik::where('volume_id', $volume->id)->get();
    
        return view('komik.editvolume', compact('volume', 'gambarKomik'));
    }
    
 

    public function updatevolume(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'judul_volume' => 'required|string',
        'jumlah_halaman' => 'required|integer|min:1',
        'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg', // Perhatikan penggunaan "gambar.*" untuk validasi multiple file
    ]);

    // Dapatkan data volume berdasarkan ID
    $volume = Volume::findOrFail($id);

    // Perbarui data volume
    $volume->judul_volume = $request->judul_volume;
    $volume->jumlah_halaman = $request->jumlah_halaman;
    $volume->save();

    // Hapus gambar-gambar volume yang ada
    $volume->gambarKomik()->delete();

    // Simpan gambar-gambar baru
    if ($request->hasFile('gambar')) {
        foreach ($request->file('gambar') as $gambar) {
            // Check if an image is provided for the current page
            if ($gambar) {
                $judulGambar = pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME);
                $slug = Str::slug($judulGambar);
                $new_gambar = time() . '_' . $slug . '.' . $gambar->getClientOriginalExtension();

                // Move and save the image in the 'uploads/gambarkomik' folder
                $gambar->move('uploads/gambarkomik', $new_gambar);

                // Create a new image record for the komik
                $volume->gambarKomik()->create([
                    'judul_gambar' => 'uploads/gambarkomik/' . $new_gambar,
                    'gambar_path' => $new_gambar,
                    'komik_id' => $volume->komik_id, // Sesuaikan dengan nama kolom yang sesuai
                ]);
            }
        }
    }

    return redirect()->route('komik.index')->with('success', 'Volume berhasil diupdate.');
}

    
    
    



public function input_bagiankomik(Request $request)
{
    // Validasi data permintaan untuk langkah pertama (informasi komik)
    $request->validate([
        'judul_komik' => 'required|string',
        'tgl_rilis' => 'required|date',
        'genre' => 'required|string',
        'sinopsis' => 'required|string',
        'cover_komik' => 'required|image|mimes:jpeg,png,jpg',
        'user_id' => 'required|exists:users,id,level,author',
    ]);

    $cover = $request->file('cover_komik'); // Ambil objek file dari permintaan
    $slug = Str::slug($cover->getClientOriginalName());
    $extension = $cover->getClientOriginalExtension(); // Dapatkan ekstensi file

    $new_cover = time() . '_' . $slug . '.' . $extension; // Tambahkan titik sebelum ekstensi
    $cover->move('uploads/coverkomik', $new_cover);

    // Buat instance baru dari model Komik
    $komik = new Komik;

    // Atur nilai-nilai atribut
    $komik->judul_komik = $request->judul_komik;
    $komik->tgl_rilis = $request->tgl_rilis;
    $komik->genre = $request->genre;
    $komik->sinopsis = $request->sinopsis;
    $komik->cover_komik = 'uploads/coverkomik/' . $new_cover; // Sesuaikan path file
    $komik->user_id = $request->user_id;
    $komik->jumlah_pembaca = 0;
    $komik->save();

    // Redirect ke langkah berikutnya (form volume) dengan menyimpan ID komik
    return redirect()->route('komik.bagianvolume', ['komik_id' => $komik->id])->with('success','Silahkan tambah volume komik');
}

    public function semuabuku(Request $request)
    {
        // Subquery untuk mendapatkan ID komik dengan volume 1
        $komikIdsWithVolumeOne = Volume::where('judul_volume', '=', 1)
            ->pluck('komik_id')
            ->unique();

        // Query dasar untuk mendapatkan komik dengan relasi volume, gambar, dan user hanya untuk komik dengan volume 1
        $query = Komik::with(['volumes', 'gambarKomik', 'user'])
            ->whereIn('id', $komikIdsWithVolumeOne);

        // Cek apakah ada pencarian
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            // Tambahkan kondisi pencarian ke query
            $query->where('judul_komik', 'like', '%' . $keyword . '%');
        }

        // Dapatkan hasil query
        $komiks = $query->get();

        return view('semuabuku', compact('komiks'));
    }

     // Metode berikutnya untuk langkah kedua (form volume)
     public function bagianvolume(Request $request)
     {
         // Ambil ID komik dari permintaan
         $komikId = $request->input('komik_id');
 
         // Tampilkan formulir volume dengan menyertakan ID komik
         return view('komik.bagianvolume', ['komikId' => $komikId]);
     }
 
     

    public function bagian_volume_gambar(Request $request)
{
    // Validate data for both volume and images
    $validatedData = $request->validate([
        'komik_id' => 'required|exists:komik,id',
        'judul_volume' => 'required|string',
        'jumlah_halaman' => 'required|integer|min:1', // Ensure jumlah_halaman is at least 1
        'gambar.*' => 'required|image|mimes:jpeg,png,jpg',
    ]);

    // Create a new volume with the provided information
    $volume = Volume::create([
        'komik_id' => $validatedData['komik_id'], // Include the komik_id
        'judul_volume' => $validatedData['judul_volume'],
        'jumlah_halaman' => $validatedData['jumlah_halaman'],
    ]);

    // Loop through each image file and save it
    foreach ($request->file('gambar') as $gambar) {
        // Check if an image is provided for the current page
        if ($gambar) {
            $judulGambar = pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME);
            $slug = Str::slug($judulGambar);
            $new_gambar = time() . '_' . $slug . '.' . $gambar->getClientOriginalExtension();

            // Move and save the image in the 'uploads/gambarkomik' folder
            $gambar->move('uploads/gambarkomik', $new_gambar);

            // Create a new image record for the komik
            gambar_komik::create([
                'komik_id' => $validatedData['komik_id'],
                'volume_id' => $volume->id,
                'judul_gambar' => 'uploads/gambarkomik/' . $new_gambar,
                'gambar_path' => $new_gambar,
            ]);
        }
    }

    // Redirect or display the success page
    return redirect()->route('komik.index')->with('success','Komik Berhasil Ditambah');
}

// Dalam method komikToPdf()
public function komikToPdf()
{
    // Retrieve the komik data
    $komiks = Komik::withCount('volumes')->get(); // Menghitung jumlah volume untuk setiap komik

    // Load the view content into a variable
    $pdfContent = view('komik.komik_pdf', compact('komiks'))->render(); // Menggunakan file komik_pdf.blade.php

    // Create PDF with DOMPDF
    $pdf = PDF::loadHtml($pdfContent);

    // (Optional) Set paper size and orientation
    $pdf->setPaper('A4', 'landscape');

    // Output PDF to browser and make it download automatically
    return $pdf->download('Data Komik Echomic.pdf');
}

public function carikomikadmin(Request $request)
    {
        $search = $request->input('search');
    
        // Perform the search on the User model
        $komiks = Komik::where('judul_komik', 'like', '%' . $search . '%')->get();
    
        // Pass the search results to the view
        return view('komik.index')->with(['komiks' => $komiks, 'search' => $search]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
   
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Dapatkan data komik berdasarkan ID
        $komik = Komik::findOrFail($id);
    
        // Dapatkan daftar user dengan role author
        $users = User::where('level', 'author')->get();
    
        return view('komik.editkomik', compact('komik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(Request $request, string $id)
     {
         // Validasi input
         $request->validate([
             'judul_komik' => 'required|string',
             'tgl_rilis' => 'required|date',
             'genre' => 'required|string',
             'sinopsis' => 'required|string',
             'cover_komik' => 'nullable|image|mimes:jpeg,png,jpg',
             'user_id' => 'required|exists:users,id,level,author',
         ]);
     
         // Dapatkan data komik berdasarkan ID
         $komik = Komik::findOrFail($id);
     
         // Hapus cover lama jika ada
         if ($komik->cover_komik) {
             Storage::disk('public')->delete($komik->cover_komik);
         }
     
         // Simpan cover baru ke dalam direktori 'public/uploads/coverkomik'
         if ($request->hasFile('cover_komik')) {
             $cover = $request->file('cover_komik'); // Ambil objek file dari permintaan
             $slug = Str::slug($cover->getClientOriginalName());
             $extension = $cover->getClientOriginalExtension(); // Dapatkan ekstensi file
     
             $new_cover = time() . '_' . $slug . '.' . $extension; // Tambahkan titik sebelum ekstensi
             $cover->move('uploads/coverkomik', $new_cover);
     
             // Perbarui data komik dengan cover yang baru
             $komik->cover_komik = 'uploads/coverkomik/' . $new_cover;
         }
     
         // Perbarui data komik
         $komik->judul_komik = $request->judul_komik;
         $komik->tgl_rilis = $request->tgl_rilis;
         $komik->genre = $request->genre;
         $komik->sinopsis = $request->sinopsis;
         $komik->user_id = $request->user_id;
     
         // Simpan perubahan data komik
         $komik->save();
     
         return redirect()->route('komik.index')->with('success', 'Komik berhasil diupdate');
     }
     
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        // Mulai transaksi database
        DB::beginTransaction();

        // Temukan komik berdasarkan ID
        $komik = Komik::findOrFail($id);

        // Dapatkan ID volumes yang terkait dengan komik
        $volumeIds = $komik->volumes->pluck('id')->toArray();

        // Hapus gambarKomik berdasarkan volume_ids
        gambar_komik::whereIn('volume_id', $volumeIds)->delete();

        // Hapus volumes berdasarkan komik_id
        Volume::where('komik_id', $id)->delete();

        // Hapus komik
        $komik->delete();

        // Commit transaksi jika semua operasi berhasil
        DB::commit();

        // Redirect ke halaman yang sesuai atau berikan respons yang sesuai
        return redirect()->route('komik.index')->with('success', 'Komik Berhasil dihapus');
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();

        // Tangani kesalahan, log, atau berikan respons yang sesuai
        return redirect()->route('komik.index')->with('error', 'Terjadi kesalahan saat menghapus komik');
    }
}

}
