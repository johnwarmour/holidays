<?php

function groundhog_day($is_the_sun_out, $city)
{

    $sun = $is_the_sun_out;
    $groundhog = "Phil";
    $time_of_day = time();
    $end_of_spring = "March 20th, 2017";

    $location = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$city&sensor=false&region=US");
    $location = json_decode($location, true);
//print_r($location);
    $lat = $location['results'][0]['geometry']['location']['lat'];
    $long = $location['results'][0]['geometry']['location']['lng'];
//    echo("<br><br>latitude: " . $lat . "<br><br> longitude: " . $long);
    $sunrise = file_get_contents("http://api.sunrise-sunset.org/json?lat=$lat&lng=$long&formatted=0");
    $sunset = file_get_contents("http://api.sunrise-sunset.org/json?lat=$lat&lng=$long&formatted=0");
//    echo "<br><br>";
    $sunrise = json_decode($sunrise, true);
    $sunrise = $sunrise['results']['sunrise'];
    $sunrise = new DateTime($sunrise, new DateTimeZone('UTC'));
    $sunrise->setTimeZone(new DateTimeZone('America/New_York'));
//echo $sunrise['results']['sunrise'];
    print_r($sunrise);
    echo "<br><br>";
    $sunset = json_decode($sunset, true);
    $sunset = $sunset['results']['sunset'];
//echo $sunset['results']['sunset'];
//    echo $sunset;

    $sunrise = strtotime($sunrise->date);
//    print_r($sunrise);
    $sunset = strtotime($sunset);
    echo "<br><br>";

    $message = "YAYYYYY $groundhog didn't see his shadow; winter is banished 5eva!! Spring will come before $end_of_spring";

    if (($sun === true) && ($sunset > $time_of_day) && ($time_of_day > $sunrise)) {
        $end_of_spring = "after March 20th, 2017";
        $message = "OH NOES! $groundhog saw his shadow and now winter will last 5eva!! No spring until after $end_of_spring";
    }
    return $message;
}

$groundhog_message = groundhog_day(true, 'Raleigh');
echo $groundhog_message;
