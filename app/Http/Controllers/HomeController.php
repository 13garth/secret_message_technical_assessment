<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::with('messages')->get();

        return view('home', compact('users'));
    }

    public function send_message()
    {
        $data = request()->validate([
            'sender_user_id' => 'required|integer',
            'recipient_user_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        try {
            $message = Message::create([
                'sender_user_id' => $data['sender_user_id'],
                'recipient_user_id' => $data['recipient_user_id'],
                'message' => encrypt($data['message']),
            ]);

            // Flash a success message to the session
            return redirect()->back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            // Handle the error
            return redirect()->back()->withErrors(['error' => 'Failed to send message: ' . $e->getMessage()]);
        }
    }

    public function decrypt_message($message_id)
    {
        $message = Message::findOrFail($message_id);
        $encryptedMessage = $message->message;
        $decryptedMessage = decrypt($message->message);

        // set message timestamp on expiry
        if (!isset($message->expiry)) {
            $message->update(['expiry' => now()->addMinutes(3)]);
            $message->save();
        }

        // Return the decrypted message
        return response()->json(['encryptedMessage' => $encryptedMessage, 'decryptedMessage' => $decryptedMessage]);
    }
}
