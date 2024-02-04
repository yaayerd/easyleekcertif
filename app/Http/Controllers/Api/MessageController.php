<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Message;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    public  function messageToAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        
        $message = new Message();
        
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;

        // dd($request->all());
        $message->save();

        if ($message) {
            return response()->json([
                'status_code' => 200,
                'status' => true,
                'message' => "Votre message a bien été envoyé.",
                'data' =>  $message
            ], 200);
        }
    }


    //  public function sendMessage() 
    // {
    //     $subject = 'Testons le mail ';
    //     $body = 'Testons le mail avec son body.';        

    //        Mail::to(
    //         "ladyrokhaya@gmail.com"
    //        )->send(
    //         new MessageMail(
    //             $subject, $body
    //         ));
    // }



    public function ListMessage()
     {

        try {
            
        $messages = Message::all(); // ->get()
        // dd($messages); 

            return response()->json([
                'status' => true,
                'statut code' => 200,
                'message' => "Voici les messages des utilisateurs. ",
                'menu'  => $messages,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "status_code" => 500,
                "message" => "Une erreur est survenue.",
                "error"   => $e
            ],  500);
        }



    }
}
