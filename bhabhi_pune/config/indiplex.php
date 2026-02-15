<?php
define("INDI_USERNAME", "INDI180");
define("INDI_PASSWORD", "MjAyNTA1MTQxNjQzMjE=");
define("INDI_ACCESS_TOKEN", "kcS1L9mbbw7DQOSm_a1aV-SHIitL7pxu5j3wRnlCJes");

define("INDI_BASE_URL", "https://api1.indiplex.co.in");

function getHeaders() {
    $basicAuth = base64_encode(INDI_USERNAME . ":" . INDI_PASSWORD);
    return [
        "Authorization: Basic $basicAuth",
        "x-api-key: " . INDI_ACCESS_TOKEN,
        "Content-Type: application/json"
    ];
}
