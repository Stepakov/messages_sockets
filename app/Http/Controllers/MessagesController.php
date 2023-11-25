<?php

namespace App\Http\Controllers;


use App\Events\MessageEvent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $messages = Message::all();

        return view( 'messages.index', compact( 'messages' ) );
    }

    public function store( Request $request )
    {
        $fields = $request->only( [ 'body', 'user_id' ] );

//        dd( $fields );



        $message = Message::create( $fields );

//        dd( ( new MessageResource( $message ) )->toArray() );

//        event( new MessageEvent(  MessageResource::make( $message ) ) );
//        return redirect()->back();
        event( new MessageEvent( $message ) );
        return response()->json([
            'status' => true,
            'body' => MessageResource::make( $message ),
        ]);
    }
}
