<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    // public function sendMessage() 
    // {

    //     $subject = 'Testons le mail ';
    //     $body = 'Testons le mail avec son body.';        

    //        Mail::to(
    //         "ladyrokhaya@gmail.com"
    //        )->send(
    //         new MessageMail(
    //             $subject, $body
    //         )
    //         );
    // }

    public  function testMessage(Request $request){
        
        $message = new Message();
        
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;
        dd($request->all());
    }

    // public function contacterAdmin(Request $request)
    // {

    //     // dd($request);
    //     $message = new Message();

    //     $message->name = $request->name;
    //     $message->email = $request->email;
    //     $message->message = $request->phone;

    //     $message->save();

    //     if ($message) {
    //         return response()->json([
    //             'status_code' => 200,
    //             'status' => true,
    //             'message' => "Message envoyé",
    //             'data' =>  $message,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => "Echec de l'envoi du message, veuillez renseigner tous les champs."
    //         ]);
    //     }
    // }
}
