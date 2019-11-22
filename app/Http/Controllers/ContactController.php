<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller{

    public function form() {
        return view('contact');
    }

    public function send(Request $req) {
        $this->validate($req, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        ini_set("SMTP","ssl://smtp.gmail.com"); // SMTP на пощата
        ini_set("smtp_port","465"); // порт на пощата
        $to = "kaloyanvelchkov@gmail.com"; // до кой ще се изпраща съобщението
        $subject = "Сайта"; // тема на съобщението

        $name = $req->name;
        $phone = $req->phone;
        $email = $req->email;
        $comment = $req->message;

        $message = "Име: ".$name." \r\nТелефон: ".$phone."\r\n\r\nСъобщение: \r\n" . $comment;
        $headers = "From: " . $email;
        //send_mail($message, "From: " . $email);

        mail($to, $subject, $message, $headers);
    }

}