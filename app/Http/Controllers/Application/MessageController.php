<?php

namespace App\Http\Controllers\Application;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $messages = Message::where('sender_parent_id', $id)
            ->orWhere('receiver_parent_id', $id)
            ->orWhere('sender_agent_id', $id)
            ->orWhere('receiver_agent_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($messages) {
            return response()->json(['msg' => 'Enregistrement avec succés', "messages" => $messages], 200);
        } else {
            return  response()->json(['message' => "une erreur est survenue."], 422);
        }
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
        $validator = Validator::make($request->all(), [
            'sender_parent_id' => 'nullable|exists:parents,id',
            'sender_agent_id' => 'nullable|exists:agents,id',
            'receiver_parent_id' => 'nullable|exists:parents,id',
            'receiver_agent_id' => 'nullable|exists:agents,id',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $message = new Message();

        if ($message) {

            $message->sender_parent_id = $request->sender_parent_id;
            $message->sender_agent_id = $request->sender_agent_id;
            $message->receiver_parent_id = $request->receiver_parent_id;
            $message->receiver_agent_id = $request->receiver_agent_id;
            $message->message = $request->message;

            $message->save();

            //diffuse message to subscribed
            // broadcast(new MessageSent($message))->toOthers();

            // Envoyer l'événement à Pusher
            broadcast(new MessageSent($message))->toOthers();

            // event(new MessageSent('Hello world with Trigo'));

            // return response()->json(['msg' => 'Opération reussie.', "message" => $message], 201);
        } else return response()->json(['message' => "Erreur d'insertion"], 422);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
