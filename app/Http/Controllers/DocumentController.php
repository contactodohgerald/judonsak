<?php

namespace App\Http\Controllers;

use App\Models\{
    Document,
    Client,
    Person,
    Folder
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::whereHas('documents')->get();
        return view('documents.index', compact('clients'));
    }

    public function list()
    {
        $clients = Client::get();
        return response()->json(
            [
                'clients' => $clients
            ]
        );        
        // return view('documents.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $people   = Person::all();
        $folders   = Folder::all();
        $clients = Client::all();
        $contract = null;
        $instruction = null;
        return view(
            'documents.create', 
            compact('clients', 'contract', 'instruction', 'people', 'folders')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client' => 'required',
            'folder' => 'required',
            'name' => 'required',
            'file' => 'file',
        ]);

        $folder = Folder::find($request->folder);
        $client = Client::where('id', '=',$request->client)->first();

        if(!$request->hasFile('file')) {
            return redirect()
                ->back()
                ->with(
                    'status', 
                    toastReturnUpdate(
                        'Empty File', 
                        'error', 
                        'Error'
                    )
                );
        }

        $path = $request->file('file')->store($folder->name);
        $document = new Document;
        $document->name = $request->name;
        $document->path = $path;
        $document->folder_id = $folder->id;
        $document->client_id = $client->id;
        $document->save();

        return redirect()
            ->route(
                'document.client.document', 
                ['client' => $client->slug, 'folder' => $folder->id]
            )
            ->with('status', toastReturnUpdate(
                'Upload Succesful', 'success', 'Success')
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function folder(Client $client)
    {
        $folders = Folder::whereHas('documents', function($query) use($client){
            $query->where('client_id', '=', $client->id);
        })->get();
        $folders->load('documents');
        return view('documents.clients.folder', compact('client', 'folders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function clientDocument(Client $client, Folder $folder)
    {
        $folder->load('documents');
        return view('documents.clients.document', compact('client', 'folder'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function download(Client $client, Document $document)
    {
        // check if user has permission to download file
        return Storage::download($document->path, $document->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
