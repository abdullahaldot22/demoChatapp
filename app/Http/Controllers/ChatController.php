<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function __construct()
    {}

    public function index ($id)
    {
        $user = User::where('id', $id)->first(['id', 'name']);
//        dd(md5(uniqid(str()->random(20), true)));
//        $uid = Conversation::where(['sender' => Auth::id(), 'receiver' => $id])->orWhere(['receiver' => Auth::id(), 'sender' => $id])->get('uid');
////        dd($uid);
//        if($uid == null) {
//            $con = Conversation::create([
//                'sender' => Auth::id(),
//                'receiver' => $id,
//                'uid' => md5(uniqid(str()->random(20), true)),
//            ]);
//            $uid = $con->uid;
//        }
//
//        $user = [
//            'id' => $user->id,
//            'name' => $user->name,
//            'uid' => $uid['uid'],
//        ];

//        dd($user);

//        $messages = Message::where(['sender_id' => Auth::id(), 'receiver_id' => $id])->orWhere(['sender_id' => $id, 'receiver_id' => Auth::id()])->orderBy('created_at', 'DESC')->with('sender:id,name', 'receiver:id,name')->get()->take(10);
        $messages = Message::where(function ($q) use ($id) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('receiver_id', Auth::id())->where('sender_id', $id);
        })->orderBy('created_at', 'DESC')->get()->take(10);
//        $messages = Message::where(['conversation_id' => $uid])->orderBy('created_at', 'DESC')->get()->take(10);
//        $messages = Message::where(['conversation_id' => $uid])->get();
//        dd($messages);

        return Inertia::render('Chat', [
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    public function send_message (Request $request) {

        $request->validate([
            'text' => 'required|string',
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
//            'uid' => 'required',
        ]);

        try {
            $message = Message::create([
                'text' => $request->text,
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
//                'conversation_id' => $request->uid,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
//        $message = new Message();
//        $message->sender_id = $request->sender_id;
//        $message->receiver_id = $request->receiver_id;
//        $message->text = $request->text;
//        $message->save();

        broadcast(new MessageSendEvent($message))->toOthers();
        // return $this->index($request->receiver_id);

    }

//    public function listenForMessage($event){
//        dd($event);
//    }
}
