<?php
// 1. Get the full URI: "/about?id=123"
$requestUri = $_SERVER["REQUEST_URI"];
printf("debug: requestUri=%s\n", $requestUri);

// 2. Parse the URL to extract only the 'path' component
// This strips off everything after the "?"
// https://www.php.net/manual/uk/function.parse-url.php
$path = parse_url($requestUri, PHP_URL_PATH);
$query = parse_url($requestUri, PHP_URL_QUERY);
printf("debug: path=%s\n", $path);
printf("debug: query=%s\n", $query);

$routes = [
    "/" => function () {
        echo "<h1>Home</h1>";
    },
    "/about" => function () {
        echo "<h1>About</h1>";
    },
];

// 3. Match against the cleaned path instead of the full URI
if (array_key_exists($path, $routes)) {
    $routes[$path]();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
