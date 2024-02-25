<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Komik;
use App\Models\gambar_komik;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\volume;
use PDF;
use Illuminate\Auth\Middleware\AuthorMiddleware;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('authorMiddleware');
    }

    public function carikomikauthor(Request $request)
    {
        $search = $request->input('search');
    
        // Perform the search on the User model
        $komiks = Komik::where('judul_komik', 'like', '%' . $search . '%')->get();
    
        // Pass the search results to the view
        return view('author.index')->with(['komiks' => $komiks, 'search' => $search]);
    }

    public function comicToPdf()
    {
        // Retrieve the authenticated user
        $authorId = auth()->user()->id;
    
        // Retrieve the komik data created by the authenticated user
        $komiks = Komik::where('user_id', $authorId)
                        ->withCount('volumes')
                        ->get();
    
        // Load the view content into a variable
        $pdfContent = view('author.comic_pdf', compact('komiks'))->render(); // Menggunakan file komik_pdf.blade.php
    
        // Create PDF with DOMPDF
        $pdf = PDF::loadHtml($pdfContent);
    
        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
    
        // Output PDF to browser and make it download automatically
        return $pdf->download('Data Komik.pdf');
    }
    
    

    public function listbaca_author($id, $volume)
{

    $komik = Komik::with(['volumes.gambarKomik', 'user'])->find($id);

    // Dapatkan volume yang sesuai dengan parameter
    $selectedVolume = $komik->volumes->find($volume);

    return view('author.listbaca_author', compact('komik', 'selectedVolume'));
}
        
     public function index()
     {
         // Ambil ID pengguna yang sedang login
         $userId = Auth::id();
     
         // Ambil data komik beserta relasinya dan pembuat komik (user)
         $komiks = Komik::with(['volumes', 'gambarKomik', 'user'])
                        ->where('user_id', $userId)
                        ->get();
     
         return view('author.index', compact('komiks'));
     }

     public function halaman_tambahkomik()
     {
        return view('author.halaman_tambahkomik');
     }
     
     public function tambahkomik(Request $request)
     {
        // Validasi data permintaan untuk langkah pertama (informasi komik)
        $request->validate([
            'judul_komik' => 'required|string',
            'tgl_rilis' => 'required|date',
            'genre' => 'required|string',
            'sinopsis' => 'required|string',
            'cover_komik' => 'required|image|mimes:jpeg,png,jpg',
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
        $komik->user_id = Auth::id(); // Gunakan ID pengguna yang sedang masuk
        $komik->jumlah_pembaca = 0;
        $komik->save();
    
        // Redirect ke langkah berikutnya (form volume) dengan menyimpan ID komik
        return redirect()->route('author.halaman_tambahvolume', ['komik_id' => $komik->id])->with('success','Silahkan tambah volume komik');
     }

     public function halaman_tambahvolume(Request $request)
     {
           // Ambil ID komik dari permintaan
           $komikId = $request->input('komik_id');
 
           // Tampilkan formulir volume dengan menyertakan ID komik
           return view('author.halaman_tambahvolume', ['komikId' => $komikId]);
     }

     public function halaman_tambahvol2($komik_id)
     {
        // Dapatkan komik berdasarkan ID
    $komik = Komik::find($komik_id);

    // Tampilkan halaman tambah volume dengan data komik
    return view('author.halaman_tambahvol2', compact('komik'));
     }


     public function tambahvolumeauthor(Request $request)
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
    return redirect()->route('author.index')->with('success','Volume berhasil ditambah');;
     }


     public function tambahvolume(Request $request)
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
        return redirect()->route('author.index')->with('success','Komik berhasil ditambah');;
     }

     public function halaman_datavolume(Request $request)
     {
         // Ambil komik_id dari parameter request
         $komikId = $request->input('komik_id');
    
         // Dapatkan komik dengan relasi volumes
         $komik = Komik::with('volumes')->find($komikId);
     
         // Pass data ke view
         return view('author.halaman_datavolume', compact('komik'));
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
        //
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
    
        return view('author.halaman_editkomik', compact('komik'));
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
        // Simpan perubahan data komik
        $komik->save();
    
        return redirect()->route('author.index')->with('success', 'Komik berhasil diupdate');
    }

    public function halaman_editvolume($id)
    {
        // Temukan volume berdasarkan ID
        $volume = Volume::findOrFail($id);
    
        // Dapatkan gambar-gambar terkait dengan volume
        $gambarKomik = gambar_komik::where('volume_id', $volume->id)->get();
    
        return view('author.halaman_editvolume', compact('volume', 'gambarKomik'));
    }

    public function author_hapusvolume($id)
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
    
        return redirect()->back()->with('success', 'Volume berhasil dihapus');
    }


    public function author_updatevolume(Request $request, $id)
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
    
        return redirect()->route('author.index')->with('success', 'Volume berhasil diupdate.');
    }
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
            return redirect()->route('author.index')->with('success', 'Komik Berhasil dihapus');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            // Tangani kesalahan, log, atau berikan respons yang sesuai
            return redirect()->route('author.index')->with('error', 'Terjadi kesalahan saat menghapus komik');
        }
    }
}
