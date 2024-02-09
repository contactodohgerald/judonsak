<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{ 
    Person, 
    Message, 
    Conversation 
};
use Illuminate\Support\Str;

// return (string) Str::uuid();
class ConversationController extends Controller
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
    public function index($type)
    {
        $user_id = Auth::id();
        $people = Person::all();
        switch ($type) {
            case 'private':
                $conversations = Conversation::whereHas('people', function($query) use ($user_id){
                        $query->where([ 
                            ['person_id', '=', $user_id],
                            ['other_id', '!=', null]]
                        )
                        ->orWhere('other_id', '=', $user_id);
                    })
                    ->orderBy('updated_at', 'desc')
                    ->get();
                break;
            
            case 'group':
                $conversations = Conversation::whereHas('people', function($query) use ($user_id){
                        $query->where([
                            ['person_id', '=', $user_id],
                            ['other_id', '=', null]
                        ])
                            ->orWhere('other_id', '=', $user_id);
                    })
                    ->orderBy('updated_at', 'desc')
                    ->get();
                break;
            
            default:
                abort(404);
                break;
        }

        $conversations->load('messages.person', 'people');
        
        return view( 'conversation.index', compact('conversations', 'people'))
                ->with('title', ' Conversations');
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
    public function store(Request $request, Person $person, $type = 1)
    {
        // dd($person->id, \Auth::id());
        if (Auth::id() == $person->user_id)
            abort(404);

        $user = Auth::user();
        switch ($type) {
            case 1:
                $conversation = Conversation::whereHas( 'people', 
                    function($query) use ($user, $person){
                        $query->where([
                            ['person_id', '=', $user->person->id],
                            ['other_id', '=', $person->id]
                        ])
                        ->orWhere([
                            ['person_id', '=', $person->id],
                            ['other_id', '=', $user->person->id]
                        ]);
                })->get();

                if ($conversation->count() < 1) {
                    $conversation = new Conversation;
                    $conversation->type = $type;
                    $conversation->slug = Str::uuid();
                    $conversation->save();

                    $conversation->people()->attach($user->id, ['other_id'=>$person->id]);
                }

                break;

            case 2:
                # code...
                break;
            
            default:
                abort(404);
                break;
        }

        return redirect()
        ->route( 'conversation.index', ['type' => 'private']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show($conversation)
    {
        $conversations = Conversation::where('slug', '=', $conversation)->get();
        // dd($conversations[0]->people[0]->pivot);
        $person_id = \Auth::user()->person->id;
        if ($conversations[0]->people[0]->pivot->person_id != $person_id && 
            $conversations[0]->people[0]->pivot->other_id != $person_id
        )
            abort(404);

        //todo update user notification
        $people = Person::all();
        $conversations->load('messages.person', 'people');
        
        return view( 'conversation.index', compact('conversations', 'people'))
                ->with('title', ' Conversations');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        $client->delete();
    }
}
