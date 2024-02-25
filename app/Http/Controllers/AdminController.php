<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PDF;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.tables')->with(['users' => User::paginate(100)]);
    }

    public function generatePDF()
    { 
    $users = User::all();

    $pdf = PDF::loadView('admin.pdf', ['users' => $users]);

    return $pdf->download('Data Users Echomic.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'tgl_lahir' => 'required',
        'gender' => 'required',
    ]);

    // Create a new User instance
    $user = new User;

    // Set the user attributes
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = Hash::make($request->password); // Hash the password
    $user->tgl_lahir = $request->tgl_lahir;
    $user->gender = $request->gender;
    $user->level = $request->level;
    // Save the user to the database
    $user->save();

    // Redirect to a success page or return a response as needed
    return redirect()->route('admin.tables')->with('success', 'User berhasil ditambah');

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
        return view('admin.edit')->with(['users' => User::find($id),]);
    }

    /**
     * Update the specified resource in storage.
     */

     public function search(Request $request)
{
    $search = $request->input('search');

    // Perform the search on the User model
    $users = User::where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->get();

    // Pass the search results to the view
    return view('admin.tables')->with(['users' => $users, 'search' => $search]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'password' => 'nullable|min:8|confirmed',
            'level' => 'required|in:user,admin,author', // Ensure the level is one of these values
        ]);
    
        $user = User::findOrFail($id);
    
        // Update fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->gender = $request->gender;
    
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->level = $request->level;
        $user->save();
    
        return redirect()->route('admin.tables')->with('success', 'User berhasil diupdate');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        $users->delete();

        return back()->with('success','User berhasil dihapus');
    }
}
