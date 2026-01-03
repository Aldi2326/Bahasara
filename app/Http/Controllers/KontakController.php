<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class KontakController extends Controller
{
    /**
     * Menampilkan pesan masuk
     */
    public function index()
    {
        $kontaks = Kontak::latest()->get();
        return view('pages.admin.pesan.index', compact('kontaks'));
    }

    /**
     * User mengirim umpan balik
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subjek' => 'required',
            'pesan' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        // Validasi ke Google reCAPTCHA
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip()
            ]
        );

        $result = $response->json();

        if (!isset($result['success']) || $result['success'] !== true) {
            return back()
                ->withErrors([
                    'g-recaptcha-response' => 'Silakan verifikasi bahwa Anda bukan robot.'
                ])
                ->with('focus_captcha', true)
                ->withInput();
        }

        Kontak::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subjek' => $request->subjek,
            'pesan' => $request->pesan,
        ]);

        return redirect('/kontak')->with('success', 'Pesan berhasil dikirim!');
    }


    /**
     * Form balasan admin
     */
    public function replyForm($id)
    {
        $kontak = Kontak::findOrFail($id);
        return view('pages.admin.pesan.reply', compact('kontak'));
    }

    /**
     * Proses mengirim balasan email
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string'
        ]);

        $kontak = Kontak::findOrFail($id);

        // Kirim email ke user
        Mail::html($request->reply_message, function ($message) use ($kontak) {
            $message->to($kontak->email)
                ->subject('Balasan dari Admin - ' . $kontak->subjek);
        });

        // Update status di database
        $kontak->update([
            'reply_message' => $request->reply_message,
            'status' => true,
            'replied_at' => now(),
        ]);

        return redirect()->route('kontak.index')->with('success', 'Balasan berhasil dikirim!');
    }

    /**
     * Hapus pesan
     */
    public function destroy($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();

        return redirect()->route('kontak.index')->with('success', 'Pesan berhasil dihapus!');
    }
}