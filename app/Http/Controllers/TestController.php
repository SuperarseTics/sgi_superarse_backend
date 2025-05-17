<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Http\Controllers;

/**
 * Description of TestController
 *
 * @author USUARIO
 */
use App\Http\Controllers\Controller;

class TestController extends Controller {

    //put your code here

    public function index() {
        $mail = new \App\Http\Clases\MailClass();
        $mail->enviarCorreoEvaluador(1, "abc123");
    }

}
