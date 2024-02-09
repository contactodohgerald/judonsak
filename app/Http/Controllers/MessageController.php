<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\{ 
    Person, 
    Message, 
    Conversation 
};
use App\Notifications\NewConversationNotification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
                'message' => 'required|min:1',
        ]);

        $user_id = Auth::id();
        $message = new Message;
        $message->message = $request->message;
        $message->person_id = $user_id;
        $conversation->messages()->save($message);

        $people_ids = [];
        // send notification
        if ($conversation->type == 1) {
            $person = ($user_id != $conversation->people[0]->user_id) ? 
                $conversation->people[0] : 
                Person::find($conversation->people[0]->pivot->other_id);

            // \Notification::send($person->user, 
            //     new NewConversationNotification($conversation)
            // );
        } else {
            foreach ($conversation->people as  $value) {
                if ($user_id != $value['people_id']) {
                    $people_ids[] = $conversation->people->person_id;
                }
            }            
            Notification::send($people_ids, new NewConversationNotification($conversation));
        }
        return redirect()
                ->route('conversation.index',['type' => 'private']);

        // return response()->json([
        //     'grp_msg' => $request->message,
        //     'status' => 'success',
        //     'time' => date('Y-M-D h:i:s'),
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
