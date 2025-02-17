<?php

namespace App\Html;

/**
 * Osztály: Response
 *
 * Ez az osztály kezeli az API válaszokat a különböző HTTP státuszkódokkal és a JSON válaszokkal.
 * Tartalmazza a leggyakrabban használt HTTP státuszkódokat és azok leírásait.
 */
class Response
{
    /**
     * HTTP státuszkódok listája és azok szöveges leírásai.
     * 
     * @var array<int, string>
     */
    const STATUSES = [
        100 => "Continue",
        101 => "Switching Protocols",
        102 => "Processing",
        200 => "OK",
        201 => "Created",
        202 => "Accepted",
        203 => "Non-Authoritative Information",
        204 => "No Content",
        205 => "Reset Content",
        206 => "Partial Content",
        207 => "Multi-Status",
        300 => "Multiple Choices",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        304 => "Not Modified",
        305 => "Use Proxy",
        306 => "(Unused)",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        402 => "Payment Required",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        407 => "Proxy Authentication Required",
        408 => "Request Timeout",
        409 => "Conflict",
        410 => "Gone",
        411 => "Length Required",
        412 => "Precondition Failed",
        413 => "Request Entity Too Large",
        414 => "Request-URI Too Long",
        415 => "Unsupported Media Type",
        416 => "Requested Range Not Satisfiable",
        417 => "Expectation Failed",
        418 => "I'm a teapot",
        419 => "Authentication Timeout",
        420 => "Method Failure, Enhance Your Calm",
        422 => "Unprocessable Entity",
        423 => "Locked",
        424 => "Failed Dependency",
        425 => "Unordered Collection",
        426 => "Upgrade Required",
        428 => "Precondition Required",
        429 => "Too Many Requests",
        431 => "Request Header Fields Too Large",
        444 => "No Response",
        449 => "Retry With",
        450 => "Blocked by Windows Parental Controls",
        451 => "Unavailable For Legal Reasons",
        494 => "Request Header Too Large",
        495 => "Cert Error",
        496 => "No Cert",
        497 => "HTTP to HTTPS",
        499 => "Client Closed Request",
        500 => "Internal Server Error",
        501 => "Not Implemented",
        502 => "Bad Gateway",
        503 => "Service Unavailable",
        504 => "Gateway Timeout",
        505 => "HTTP Version Not Supported",
        506 => "Variant Also Negotiates",
        507 => "Insufficient Storage",
        508 => "Loop Detected",
        509 => "Bandwidth Limit Exceeded",
        510 => "Not Extended",
        511 => "Network Authentication Required",
        598 => "Network read timeout error",
        599 => "Network connect timeout error",
    ];
    
    /**
     * Magic metódus: __call
     * 
     * Ez a metódus akkor fut le, ha egy nem definiált metódust próbálunk meghívni az osztályban.
     * Automatikusan egy 404-es válasszal tér vissza.
     *
     * @param string $name A hívott metódus neve.
     * @param array $arguments A metódusnak átadott argumentumok.
     * 
     * @return void
     */
    public function __call($name, $arguments)
    {
        $this->response(['data' => []], 404);
    }
    /**
     * API válasz létrehozása és kiküldése.
     * 
     * A metódus a megadott adatokkal és státuszkóddal JSON formátumban küldi vissza a választ.
     * 
     * @param array $data Az API válasz tartalma.
     * @param int $code Az HTTP válasz státuszkódja. Alapértelmezett: 200.
     * @param string $message Egyéni üzenet a válaszhoz. Ha nincs megadva, akkor a státuszkód leírása kerül felhasználásra.
     * 
     * @return void
     * 
     * @throws \JsonException Ha a JSON kódolás sikertelen.
     */
    static function response(array $data, $code = 200, $message = '')
    {
        if (isset(self::STATUSES[$code])) {
            http_response_code($code);
            if (!$message) {
                $message = self::STATUSES[$code];
            }
            $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
            header($protocol . ' ' . $code . ' ' . self::STATUSES[$code]);
        }
        header('Content-Type: application/json');
        $response = [
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ];

        echo json_encode($response, JSON_THROW_ON_ERROR);
    }
}