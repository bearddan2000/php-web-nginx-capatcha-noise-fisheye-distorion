<?php

function generate_string()
{
    $strength = 5;
    $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}
function guess_string()
{
    if (isset($_REQUEST["provided"])) {
        $provided = $_REQUEST["provided"];
        if (is_null($provided)) {
            return "Provided capatcha null";
        } elseif ($provided == " ") {
            return "Provided capatcha empty";
        }
    }

    if (isset($_REQUEST["guess"])) {
        $guess = $_REQUEST["guess"];
        if (is_null($guess)) {
            return "Guess capatcha null";
        } elseif ($guess == " ") {
            return "Guess capatcha empty";
        }
    }

    $comp = strcmp($guess, $provided);

    if ($comp == 0) {
        return "Match";
    } else {
        $x = "Mismatch compare " . $comp;
        $x .= "\nGuess: " . $guess;
        $x .= "\nProvided: " . $provided;
        return $x;
    }
}

if (isset($_REQUEST["mode"])) {
    $mode = $_REQUEST["mode"];
}
/*
controls the RESTful services
URL mapping
*/
switch ($mode) {

    case "init":
        header('Content-Type: text/plain; charset=UTF-8');
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        print(generate_string());
        break;

    case "guess":
        header('Content-Type: text/plain; charset=UTF-8');
        print(guess_string());
        break;

    case "":
        header("HTTP/1.0 404 Not Found");
        break;
}
