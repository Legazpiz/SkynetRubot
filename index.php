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
    }else if($tg->text_has("Guerra")){
        $tg->send
            ->notification(FALSE)
            ->file('audio', "files/audio/hipo.ogg");
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
    }elseif(
        $tg->text_has(["montar", "monta", "crear", "organizar", "organiza", "nueva"], ["quedada"]) and
        $tg->words() <= 20
    ){
        //TODO Organizar quedadas
        /*$place = NULL;
        if($tg->text_has("en")){
            $pos = strpos($tg->text(), " en ") + strlen(" en ");
            $place = substr($tg->text(), $pos);
            if(!$tg->text_has(["termina", "acaba"], ["a las"])){
                $place = preg_replace("/ a las \d\d[:.]\d\d$/", "", $place);
            }
        }
        if(empty($place) and $tg->words() > 5){ return; }

        $poke = pokemon_parse($tg->text());
        $time = time_parse($tg->text());*/

        $str = "Nueva #quedada";


        /*if(!empty($time) and isset($time['hour'])){
            $str .= " a las " .$time['hour'];
        }

        if(!empty($place)){
            $str .= " en $place";
        }

        $str .= "!\n";*/

        /* Desactivado por canal y gente que crea y no va.
        $user = $pokemon->user($tg->user->id);
        $team = ['R' => 'red', 'B' => 'blue', 'Y' => 'yellow'];
        $str .= "- " . $tg->emoji(":heart-" .$team[$user->team] .":") ." L" .$user->lvl ." @" .$user->username ."\n";
        */

        $tg->send
            ->text($str)
            ->inline_keyboard()
                ->row()
                    ->button("¡Me apunto!", "QuedadaApuntar")
                    ->button("¡Ya estoy!", "QuedadaEstoy")
                ->end_row()
                ->row()
                    ->button("Reflotar", "QuedadaReflotar")
                ->end_row()
            ->show()
        ->send();

        $tg->send->delete(TRUE);

        //return -1;
    }elseif($tg->callback == "QuedadaReflotar"){
        $tg->answer_if_callback("");
        //if(!in_array($telegram->user->id, telegram_admins(TRUE))){ return -1; }

        $tg->send
            ->text($tg->text_message())
            ->inline_keyboard()
                ->row()
                    ->button("¡Me apunto!", "QuedadaApuntar")
                    ->button("¡Ya estoy!", "QuedadaEstoy")
                ->end_row()
                ->row()
                    ->button("Reflotar", "QuedadaReflotar")
                ->end_row()
            ->show()
        ->send();
    }

} catch (\Zelenin\Telegram\Bot\NotOkException $e) {

    //echo error message ot log it
    //echo $e->getMessage();

}
