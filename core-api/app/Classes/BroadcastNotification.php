<?php
namespace App\Classes;

use GuzzleHttp\Client;

class BroadcastNotification
{         // calling comment apis from spring socket//
    public static function sendComment($post){
        $client = new Client([
            'base_uri' => env('SPRING_SOCKET_BASE_URL'),
        ]);
          
        $response = $client->request('POST', '/send-comment', [
            'json' => $post
        ]);

        return true;
    }
    //calling like api from spring socket//
    public static function sendlike($post){
        $client = new Client([
            'base_uri' => env('SPRING_SOCKET_BASE_URL'),
        ]);
          
        $response = $client->request('POST', '/send-like', [
            'json' =>$post
        ]);

        return true;
    }

}