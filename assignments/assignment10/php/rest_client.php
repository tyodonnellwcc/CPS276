<?php

function getWeather() {

    if (!isset($_POST["zip_code"]) || trim($_POST["zip_code"]) == "") {
        return ["<p class='alert alert-danger'>No zip code provided.</p>", ""];
    }

    $zip = urlencode($_POST["zip_code"]);
    $url = "https://russet-v8.wccnet.edu/~sshaper/assignments/assignment10_rest/get_weather_json.php?zip_code=$zip";

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $response = curl_exec($curl);

    if ($response === false) {
        return ["<p class='alert alert-danger'>There was an error retrieving the records.</p>", ""];
    }

    curl_close($curl);

    $data = json_decode($response, true);

    if (isset($data["error"])) {
        return ["<p class='alert alert-danger'>{$data['error']}</p>", ""];
    }

    $out = "";

    $city = $data["searched_city"]["name"];
    $temp = $data["searched_city"]["temperature"];
    $humidity = $data["searched_city"]["humidity"];
    $forecast = $data["searched_city"]["forecast"];

    $out .= "<h2>Weather for $city</h2>";
    $out .= "<p><strong>Temperature:</strong> $temp<br>";
    $out .= "<strong>Humidity:</strong> $humidity</p>";

    $out .= "<h4>Three-Day Forecast</h4><ul>";
    foreach ($forecast as $f) {
        $out .= "<li>{$f['day']}: {$f['condition']}</li>";
    }
    $out .= "</ul>";

    $higher = $data["higher_temperatures"];

    if (count($higher) == 0) {
        $out .= "<h4>Cities With Higher Temperatures</h4>";
        $out .= "<p class='alert alert-info'>No cities have a higher temperature.</p>";
    } else {

        $out .= "<h4>Cities With Higher Temperatures</h4>";
        $out .= "<table class='table table-bordered'><tr><th>City</th><th>Temperature</th></tr>";

        foreach ($higher as $h) {
            $out .= "<tr><td>{$h['name']}</td><td>{$h['temperature']}</td></tr>";
        }

        $out .= "</table>";
    }

    $lower = $data["lower_temperatures"];

    if (count($lower) == 0) {
        $out .= "<h4>Cities With Lower Temperatures</h4>";
        $out .= "<p class='alert alert-info'>No cities have a lower temperature.</p>";
    } else {

        $out .= "<h4>Cities With Lower Temperatures</h4>";
        $out .= "<table class='table table-bordered'><tr><th>City</th><th>Temperature</th></tr>";

        foreach ($lower as $low) {
            $out .= "<tr><td>{$low['name']}</td><td>{$low['temperature']}</td></tr>";
        }

        $out .= "</table>";
    }

    return ["", $out];
}

?>