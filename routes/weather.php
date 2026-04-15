<?php

/**
 * Step 1: Convert a city name into Latitude and Longitude
 * Returns an array [lat, lon, name] or null if not found.
 */
function getCityCoordinates(string $city): ?array
{
    $cityEncoded = urlencode($city);
    $url = "https://geocoding-api.open-meteo.com/v1/search?name=$cityEncoded&count=1&language=en&format=json";

    $response = file_get_contents($url);
    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);

    if (!empty($data["results"])) {
        return [
            "lat" => $data["results"][0]["latitude"],
            "lon" => $data["results"][0]["longitude"],
            "name" => $data["results"][0]["name"],
        ];
    }

    return null;
}

/**
 * Step 2: Get weather data using coordinates
 * Returns the weather data array or null on failure.
 */
function getWeather(float $lat, float $lon): ?array
{
    $url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&current_weather=true";

    $response = file_get_contents($url);
    if ($response === false) {
        return null;
    }

    return json_decode($response, true);
}

// --- Logic to handle the Request ---

$weather = null;
$cityName = null;
$error = null;

if (isset($_GET["city"]) && !empty(trim($_GET["city"]))) {
    $location = getCityCoordinates($_GET["city"]);

    if ($location) {
        $cityName = $location["name"];
        $weather = getWeather($location["lat"], $location["lon"]);

        if (!$weather) {
            $error = "Could not retrieve weather data.";
        }
    } else {
        $error = "City not found.";
    }
}
?>


<?php // Use __DIR__ to go up one level and into templates
// require_once __DIR__ . "/../templates/header.php";
require_once APP_ROOT . "/templates/header.php"; ?>

<h1>Weather</h1>

<div class="container">
    <h2>Weather Search</h2>
    <form method="GET">
        <input type="text" name="city" placeholder="e.g. Tokyo" value="<?= htmlspecialchars(
            $_GET["city"] ?? "",
        ) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($weather): ?>
        <div class="weather-box">
            <h3><?= htmlspecialchars($cityName) ?></h3>
            <div class="temp"><?= $weather["current_weather"]["temperature"] ?>°C</div>
            <p>Wind: <?= $weather["current_weather"]["windspeed"] ?> km/h</p>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
</div>

<?php // require_once __DIR__ . "/../templates/footer.php";

require_once APP_ROOT . "/templates/footer.php";
?>
