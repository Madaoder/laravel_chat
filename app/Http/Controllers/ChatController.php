<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatroom;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Providers\NewMssage;
use Illuminate\Support\Facades\Hash;

class ChatController extends Controller
{
    public function rooms()
    {
        return Chatroom::all();
    }

    public function messages(Request $request, $roomId)
    {
        return Message::where('chatroom_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function talk(Request $request, $roomId)
    {
        $message = Message::create([
            'message' => $request->message,
            'user_id' => Auth::id(),
            'chatroom_id' => $roomId,
        ]);

        broadcast(new NewMssage($message))->toOthers();

        return $message;
    }

    public function createRoom(Request $request)
    {
        $room = Chatroom::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return $room;
    }

    public function hasPassword($roomId)
    {
        $room = Chatroom::where('id', $roomId)->first();
        if ($room->password) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function checkRoom(Request $request, $roomId)
    {
        $room = Chatroom::where('id', $roomId)->first();
        if (Hash::check($request->password, $room->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }
}
