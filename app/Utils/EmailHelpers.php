<?php

namespace App\Utils;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class EmailHelpers
{
    public static function sendEmail($to, $subject, $template, $data = [])
    {
        $body = View::make($template, $data)->render();

        Mail::send([], [], function ($message) use ($to, $subject, $body) {
            $message->to($to)
                ->subject($subject)
                ->html($body);
        });
    }

    public static function sendEmailJson($to, $subject, $view, $data, $attachmentPath)
{
    \Mail::send($view, $data, function($message) use ($to, $subject, $attachmentPath) {
        $message->to($to)
                ->subject($subject)
                ->attach($attachmentPath); 
    });
}
}
