<?php

/*
* This file is part of GeeksWeb Bot (GWB).
*
* Author(s):
*
* © 2017 Rubén Torre
*
*/

include 'src/Autoloader.php';

$bot = new Telegram\Bot("475117500:AAEPc8h8TaWx7Qd_8ozJq_Zz_WbbClTVrCE", "MyUserBot", "SkynetRubot");
$tg  = new Telegram\Receiver($bot);

//The app
try {

    if($tg->text_has("Yes")){
        $tg->send
            ->text("Yes!")
            ->send();
    }else if($tg->text_regex("I'm {N:age}") and $tg->words() <= 4){
        $num = $tg->input->age;
        $str = "So old...";
        if($num < 18){ $str = "You're young!"; }
        $tg->send
            ->text($str)
            ->send();
    }else if($tg->text_regex("My name's {name}")){
     $tg->send
        ->text("Nice to meet you, " .$tg->input->name ."!")
        ->send();
    }elseif($tg->text_has("Buttons") and $tg->words() <= 5){
    $tg->send
        ->text("Here you have some buttons, you choose.")
        ->inline_keyboard()
            ->row()
                ->button("B1", "but1")
                ->button("B2", "but2")
            ->end_row()
            ->row()
                ->button("B3", "but3")
                ->button("B4", "but4")
            ->end_row()
        ->show()
    ->send();
    }elseif($tg->callback == "but1"){
    $tg->answer_if_callback(""); // Stop loading button.
    $tg->send
        ->message(TRUE)
        ->chat(TRUE)
        ->text("You pressed the first button!")
        ->edit("text");
    }elseif($tg->callback == "but2"){
    $tg->answer_if_callback("You pressed the second button!", TRUE);
    // Display an alert and stop loading button.
    }elseif($tg->callback == "but3"){
    $tg->answer_if_callback(""); // Stop loading button.
    $tg->send
        ->message(TRUE)
        ->chat(TRUE)
        ->text("You pressed the third button!")
        ->edit("text");
    }elseif($tg->callback == "but4"){
    $tg->answer_if_callback("You pressed the fourth button!", TRUE);
    // Display an alert and stop loading button.
    }

} catch (\Zelenin\Telegram\Bot\NotOkException $e) {

    //echo error message ot log it
    //echo $e->getMessage();

}
