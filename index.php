<?php

/*
*
* Author(s):
*
* 2017 Rubén Torre
* XXXX More to come
*/

include 'src/Autoloader.php';

$bot = new Telegram\Bot("475117500:AAEPc8h8TaWx7Qd_8ozJq_Zz_WbbClTVrCE", "MyUserBot", "SkynetRubot");
$tg  = new Telegram\Receiver($bot);

//The app
try {

    if($tg->text_has("ping")){
        $tg->send
            ->text("Pong!" . $tg->emoji(":table_tennis:"))
            ->send();
    }else if($tg->text_regex("I'm {N:age}") and $tg->words() <= 4){
        $num = $tg->input->age;
        $str = "So old...";
        if($num < 18){ $str = "You're young!"; }
        $tg->send
            ->text($str)
            ->send();
    }else if($tg->text_has(["amarillos", "amarillo"])){
        $tg->send
            ->notification(FALSE)
            ->file('photo', "files/img/amarillos.jpg");
    }else if($tg->text_has(["rojos", "rojo"])){
        $tg->send
            ->notification(FALSE)
            ->file('video', "files/video/rojos.mp4");
    }else if($tg->text_has(["buenos", "buenas", "hola", "kaixo"], ["skynet", "días", "día", "tarde", "tarda", "tardes", "noches", "nit"]) or $tg->text_has(["egunon", "egunones", "gabon"])){
        $str = "Buenas human..., esteee... " . $tg->user->username . "! " . $tg->emoji(":robot:") . $tg->emoji(":raised_hands:");
        if($tg->text_has(["noches", "gabon"])){
            $str = "Buenas noches human..., esteee... " . $tg->user->username . "! " . $tg->emoji(":robot:") . $tg->emoji(":hand:");
        }
        $tg->send
            ->text($str)
            ->send();
    }else if($tg->text_has(["skynet", "muestra", "pasa", "dime", "lista"], ["normas", "las normas"]) and in_array($tg->user->id, $tg->get_admins())){
        $str = "¿Qué os parecen las normas?\n¿Tenéis alguna idea para mejorarlas?\n Entrad aquí y comentadnos para que les demos una vuelta" . $tg->emoji(":muscle:") . "\n" . "https://docs.google.com/forms/d/e/1FAIpQLSdzaoc44-msZ1EW3aD56T65wNhsO7Ed4WDCwwYZB83T1WMs5g/viewform?usp=sf_link";
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
    }else if($tg->text_has("Buttons") and $tg->words() <= 5){
    $tg->send
        ->text("Here you have some buttons, your choice is?")
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
    }else if($tg->callback == "but1"){
    $tg->answer_if_callback(""); // Stop loading button.
    $tg->send
        ->message(TRUE)
        ->chat(TRUE)
        ->text("You pressed the first button!")
        ->edit("text");
    }else if($tg->callback == "but2"){
    $tg->answer_if_callback("You pressed the second button!", TRUE);
    // Display an alert and stop loading button.
    }else if($tg->callback == "but3"){
    $tg->answer_if_callback(""); // Stop loading button.
    $tg->send
        ->message(TRUE)
        ->chat(TRUE)
        ->text("You pressed the third button!")
        ->edit("text");
    }else if($tg->callback == "but4"){
    $tg->answer_if_callback("You pressed the fourth button!", TRUE);
    // Display an alert and stop loading button.
    }else if(
        $tg->text_has(["montar", "monta", "crear", "crea", "organizar", "organiza", "nueva"], ["quedada", "pokequedada"]) and
        $tg->words() <= 20
    ){
        //TODO Organizar quedadas
        $reason = NULL;
        $place = NULL;
        /*if($tg->text_has("en")){
            $pos = strpos($tg->text(), " en ") + strlen(" en ");
            $place = substr($tg->text(), $pos);
            if(!$tg->text_has(["termina", "acaba"], ["a las"])){
                $place = preg_replace("/ a las \d\d[:.]\d\d$/", "", $place);
            }
        }*/

        if($tg->text_has("para") and $tg->text_has("en") and $tg->text_has("a las")){
            $pos = strpos($tg->text(), " para ") + strlen(" para ");
            $reason = substr($tg->text(), $pos);
            //$time = time_parse($tg->text());

            $str = "Mira, una nueva #pokequedada";

            if(!empty($reason)){
                $str .= " para " . $reason;
            }

            //$str .= "!\n"; 

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
        }else{
            $str = $tg->emoji(":exclamation:") . "Humano, cometiste un error" . $tg->emoji(":exclamation:") . $tg->emoji(":robot:") . "\nRepite el comando de la siguiente forma:\nCrear pokequedada para <b>tal motivo</b> en <b>tal lugar</b> a las <b>hh:mm</b>";
            $tg->send
            ->text($str)
            ->send();
        }
        //if(empty($place) and $tg->words() > 5){ return;
        
    }else if($tg->callback == "QuedadaApuntar"){
        $str = $tg->text_message();
        $user = $tg->user->username;

        $str = explode("\n", $str);
        $str[1] = ""; // RESERVED
        $found = FALSE;

        foreach($str as $k => $s){
            if(strpos($s, $user) !== FALSE){
                $found = TRUE;
                unset($str[$k]);
            }
        }

        // Apuntarse
        if(!$found){
            $str[] = $tg->emoji(":ok:") . $user;
        }

        $str[1] = "Hay " .(count($str) - 2) ." personas apuntadas:";

        $str = implode("\n", $str);

        $tg->answer_if_callback();
        $tg->send
            ->chat(TRUE)
            ->message(TRUE)
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
        ->edit('text');

        //return -1;
    }else if($tg->callback == "QuedadaEstoy"){
        $str = $tg->text_message();
        $user = $tg->user->username;

        if(strpos($str, $user) !== FALSE){
            // $tg->answer_if_callback("¡Ya estás apuntado en la lista!", TRUE);
            // return -1;
            $str = explode("\n", $str);
            foreach($str as $k => $s){
                if(strpos($s, $user) !== FALSE){
                    if(strpos($s, $tg->emoji(":ok:")) !== FALSE){
                        $str[$k] = $tg->emoji(":check:") . $user;
                    }else{
                        $str[$k] = $tg->emoji(":ok:") . $user;
                    }
                }
            }
            $str = implode("\n", $str);
        }
        $tg->answer_if_callback();
        $tg->send
            ->chat(TRUE)
            ->message(TRUE)
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
        ->edit('text');

        //return -1;
    }else if($tg->callback == "QuedadaReflotar"){
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
    }else if($tg->text_has(["skynet", "avisar", "un"], ["dragón", "dragon", "dratini", "dragonair", "dragonite"])){
        $tg->send
            ->notification(FALSE)
            ->file('video', "files/video/dragon.mp4");
    }/*else if($tg->text_has(["skynet"], ["sabes", "puedes"]) and $tg->words() > 2){ 
        //$str = file_get_contents('files/txt/dos.txt', true);
        $tg->send
            ->text("De momento puedo: ")
            ->send();
    }*/else if($tg->text_has("skynet") and $tg->words() > 6){
        $tg->send
            ->text($tg->user->username . ", me temo que aún no tengo respuesta para eso" . $tg->emoji(":robot:"))
            ->send();
    }

} catch (\Zelenin\Telegram\Bot\NotOkException $e) {

    //echo error message ot log it
    //echo $e->getMessage();

}

//function definitions, we gotta tide this up...
function time_parse($string){
    $string = strtolower($string);
    $string = str_replace(["á","é"], ["a","e"], $string);
    $string = str_replace(["?", "¿", "!"], "", $string);
    $s = explode(" ", $string);
    $data = array();
    $number = NULL;
    // ---------
    $days = [
        'lunes' => 'monday', 'martes' => 'tuesday',
        'miercoles' => 'wednesday', 'jueves' => 'thursday',
        'viernes' => 'friday', 'sabado' => 'saturday',
        'domingo' => 'sunday'
    ];
    $months = [
        'enero' => 'january', 'febrero' => 'february', 'marzo' => 'march',
        'abril' => 'april', 'mayo' => 'may', 'junio' => 'june',
        'julio' => 'july', 'agosto' => 'august', 'septiembre' => 'september',
        'octubre' => 'october', 'noviembre' => 'november', 'diciembre' => 'december'
    ];
    $waiting_month = FALSE;
    $waiting_time = FALSE;
    $waiting_time_add = FALSE;
    $select_week = FALSE;
    $next_week = FALSE;
    $last_week = FALSE;
    $this_week_day = FALSE;
    foreach($s as $w){
        if($w == "de" && (!isset($data['date']) or empty($data['date']) )){ $waiting_month = TRUE; } // FIXME not working?
        if(!isset($data['hour']) and in_array($w, ["la", "las"])){ $waiting_time = TRUE; }
        if(!isset($data['hour']) and $w == "en"){ $waiting_time_add = TRUE; }

        if(is_int($w) or (in_array(strlen($w), [2,3]) && substr($w, -1) == "h")){
            $number = (int) abs($w);
            if($waiting_time){
                if($number >= 24){ continue; }
                if($number <= 6){ $number = $number + 12; }
                $data['hour'] = $number .":00";
                $waiting_time = FALSE;
            }
            continue;
        }

        if(!isset($data['hour']) && preg_match("/(\d\d?)[:.](\d\d)/", $w, $hour)){
            if($hour[1] >= 24){ $hour[1] = "00"; }
            if($hour[2] >= 60){ $hour[2] = "00"; }
            $data['hour'] = "$hour[1]:$hour[2]";
            continue;
        }

        if($waiting_time && in_array($w, ['noche']) && !isset($data['hour'])){
            $data['hour'] = "22:00";
            $waiting_time = FALSE;
            continue;
        }
        if($waiting_time && in_array($w, ['tarde']) && !isset($data['hour'])){
            $data['hour'] = "18:00";
            $waiting_time = FALSE;
            continue;
        }
        if($waiting_time && in_array($w, ['mañana', 'maana', 'manana']) && !isset($data['hour'])){
            $data['hour'] = "11:00";
            $waiting_time = FALSE;
            continue;
        }
        if($waiting_time_add && in_array($w, ['hora', 'horas']) && !isset($data['hour'])){
            $hour = date("H") + $number;
            if(date("i") >= 30){ $hour++; } // Si son más de y media, suma una hora.
            $data['hour'] = $hour .":00";
            if(!isset($data['date'])){ $data['date'] = date("Y-m-d"); } // HACK bien?
            $waiting_time_add = FALSE;
            continue;
        }
        if(in_array($w, array_keys($days)) && ($next_week or $last_week or $this_week_day) && !isset($data['date'])){
            $selector = "+1 week next";
            if($this_week_day && date("w") <= date("w", strtotime($days[$w]))){ $selector = "this"; }
            if($this_week_day && date("w") > date("w", strtotime($days[$w]))){ $selector = "next"; }
            if($last_week){ $selector = "last"; } // && date("w") > date("w", strtotime($days[$w]))
            if($next_week && date("w") >= date("w", strtotime($days[$w]))){ $selector = "next"; }
            $data['date'] = date("Y-m-d", strtotime($selector ." " .$days[$w]));
            $next_week = FALSE;
            $last_week = FALSE;
            $this_week_day = FALSE;
            continue;
        }
        if(in_array($w, array_keys($months))){ // FIXME $waiting_month no funciona
            if($number >= 1 && $number <= 31){
                $data['date'] = date("Y-m-d", strtotime($months[$w] ." " .$number));
            }
            $waiting_month = FALSE;
            continue;
        }
        if($w == "semana" && !isset($data['date'])){
            if($next_week){
                $data['date'] = date("Y-m-d", strtotime("next week"));
                $next_week = FALSE;
                continue;
            }
            $select_week = TRUE;
            continue;
        }
        if(in_array($w, ["proximo", "próximo", "proxima", "próxima", "siguiente"])){
            // proximo lunes != ESTE lunes, esta semana
            if($select_week && !isset($data['date'])){
                $data['date'] = date("Y-m-d", strtotime("next week"));
                $select_week = FALSE;
                continue;
            }
            $next_week = TRUE;
            continue;
        }
        if(in_array($w, ["pasado", "pasada"])){
            if(!isset($data['date']) or empty($data['date'])){
                if($this_week_day){ $this_week_day = FALSE; }
                if($select_week){
                    // last week = LUNES, marca el dia de hoy!
                    $en_days = array_values($days);
                    $data['date'] = date("Y-m-d", strtotime("last week " .$en_days[date("N") - 1]));
                    $select_week = FALSE;
                    continue;
                }
                $last_week = TRUE;
                continue;
            }
            // el pasado martes, el martes pasado.
            $tmp = new DateTime($data['date']);
            $tmp->modify('-1 week');
            $data['date'] = $tmp->format('Y-m-d');
            continue;
        }
        if(in_array($w, ["este", "el"])){
            // este lunes
            $this_week_day = TRUE;
            continue;
        }
        if(in_array($w, ['mañana', 'maana', 'manana']) && !isset($data['date'])){
            // Distinguir mañana de "por la mañana"
            $data['date'] = date("Y-m-d", strtotime("tomorrow"));
            continue;
        }
        if($w == "hoy" && !isset($data['date'])){
            $data['date'] = date("Y-m-d"); // TODAY
            continue;
        }
        if($w == "ayer" && !isset($data['date'])){
            $data['date'] = date("Y-m-d", strtotime("yesterday"));
            continue;
        }
    }

    if(isset($data['date'])){
        $strdate = $data['date'] ." " .(isset($data['hour']) ? $data['hour'] : "00:00");
        $strdate = strtotime($strdate);
        $data['left_hours'] = floor(($strdate - time()) / 3600);
        $data['left_minutes'] = floor(($strdate - time()) / 60);
    }

    return $data;
}