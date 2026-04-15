<?php

define("APP_ROOT", __DIR__);

// 1. Get the full URI: "/about?id=123"
$requestUri = $_SERVER["REQUEST_URI"];
printf("<p>debug: requestUri=%s</p>\n", $requestUri);

// 2. Parse the URL to extract only the 'path' component
// This strips off everything after the "?"
// https://www.php.net/manual/uk/function.parse-url.php
$path = parse_url($requestUri, PHP_URL_PATH);
$query = parse_url($requestUri, PHP_URL_QUERY);
printf("<p>debug: path=%s</p>\n", $path);
printf("<p>debug: query=%s</p>\n", $query);

// Routes is a path => handler file mapping
$routes = [
    "/" => "home.php",
    "/about" => "about.php",
    "/weather" => "weather.php",
];

// 3. Match against the cleaned path
if (array_key_exists($path, $routes)) {
    $file = __DIR__ . "/routes/" . $routes[$path];
    # include $file; => throws a warning if not found
    require $file; # throws an error if not found
} else {
    http_response_code(404);
    echo "404 Not Found";
}
