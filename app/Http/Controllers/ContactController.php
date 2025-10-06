<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('approver-room')) {
            $i = ['Bilik'];
        } elseif (Auth::user()->hasRole('approver-vc')) {
            $i = ['VC'];
        } elseif (Auth::user()->hasRole('super-admin')) {
            $i = ['Bilik', 'VC'];
        }

        $contacts = Contact::whereIn('kategori', $i)->orderBy('id', 'DESC')->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'nama' => 'required',
                'email' => 'required|email',
                'no_telefon_office' => 'required|numeric',
                'peranan' => 'required',
                'status' => 'required',
            ],
            [
                'nama.required' => 'Medan Nama diperlukan.',
                'email.required' => 'Email diperlukan.',
                'email.email' => 'Sila Masukkan Email yang sah.',
                'no_telefon_office.required' => 'Medan No. Telefon Pejabat diperlukan.',
                'no_telefon_office.numeric' => 'Nombor sahaja dibenarkan.',
                'peranan.required' => 'Medan Peranan diperlukan.',
                'status.required' => 'Medan Status diperlukan.',

            ]
        );


        if ($request->peranan == 'Pentadbir Bilik' || $request->peranan == 'Teknikal Sistem' || $request->peranan == 'PMSB' || $request->peranan == 'BizPoint') {
            $kategori = 'Bilik';
        } elseif ($request->peranan == 'Pentadbir VC') {
            $kategori = 'VC';
        } else {
            $kategori = '';
        }

        $input = new Contact();
        $input->nama = $request->nama;
        $input->email = $request->email;
        $input->no_telefon_office = $request->no_telefon_office;
        $input->status = $request->status;
        $input->role = $request->peranan;
        $input->kategori = $kategori;
        $input->created_by = Auth::user()->id;
        $input->created_at = now();

        $input->save();
        $msg = 'Maklumat telah berjaya ditambah.';
        // return redirect('contact/')->with('successMessage', $msg);
        return redirect()->back()->with('successMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $contact = Contact::where('id', $id)->first();

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate(
            $request,
            [
                'nama' => 'required',
                'email' => 'required|email',
                'no_telefon_office' => 'required|numeric',
                'role' => 'required',
                'status' => 'required',
            ],
            [
                'nama.required' => 'Medan Nama diperlukan.',
                'email.required' => 'Email diperlukan.',
                'email.email' => 'Sila Masukkan Email yang sah.',
                'no_telefon_office.required' => 'Medan No. Telefon Pejabat diperlukan.',
                'no_telefon_office.numeric' => 'Nombor sahaja dibenarkan.',
                'role.required' => 'Medan Peranan diperlukan.',
                'status.required' => 'Medan Status diperlukan.',

            ]
        );
        // $request->role;
        $input = $request->all();

        $id = decrypt($id);
        $contact = Contact::find($id);

        $contact->update($input);
        $msg = 'Maklumat telah berjaya dikemaskini.';
        return redirect('/contact')->with('successMessage', $msg)->with('contact', $contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        Contact::where('id', $contact->id)->delete();
        return redirect('/contact');
    }

    public function hubungikami()
    {
        $contacts = Contact::orderBy('id', 'ASC')->get()->groupBy('role');
        $room_announcements = Announcement::where('kategori', 'Bilik')->orderBy('id', 'DESC')->get();
        $vc_announcements = Announcement::where('kategori', 'VC')->orderBy('id', 'DESC')->get();
        return view('welcome', compact('contacts', 'room_announcements', 'vc_announcements'));
    }

    public function events()
    {
        $contacts = Contact::orderBy('id', 'ASC')->get()->groupBy('role');
        $umums = Announcement::orderBy('id', 'ASC')->get();
        return view('welcome_events', compact('contacts', 'umums'));
    }
}
