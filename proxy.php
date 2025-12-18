<?php
// proxy.php - gateway between browser and ATS-Mini
// You need config.php in the same folder, with something like:
// <?php
// define('ATS_BASE_URL', 'http://atsmini.local');
// or the direct IP.

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config.php';

$atsBase = defined('ATS_BASE_URL') ? ATS_BASE_URL : 'http://10.1.1.1';
$action  = $_GET['action'] ?? '';

$method = 'GET';
$url    = '';
$body   = null;

switch ($action) {
    case 'status':
        // GET /api/status
        $url = $atsBase . '/api/status';
        break;

    case 'statusOptions':
        // GET /api/statusOptions
        $url = $atsBase . '/api/statusOptions';
        break;

    case 'update':
        // POST /api/status
        $url    = $atsBase . '/api/status';
        $method = 'POST';
        $body   = file_get_contents('php://input');
        break;

    /* ===== MEMORII ATS-MINI ===== */

    case 'memoryList':
        // GET /api/memory
        $url = $atsBase . '/api/memory';
        break;

    case 'memoryStore':
        // POST /api/memory/{slot}/storeCurrent
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        if ($id < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'invalid memory slot']);
            exit;
        }
        $url    = $atsBase . '/api/memory/' . $id . '/storeCurrent';
        $method = 'POST';
        $body   = '{}';
        break;

    case 'memoryTune':
        // POST /api/memory/{id}/tune
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        if ($id < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'invalid memory id']);
            exit;
        }
        $url    = $atsBase . '/api/memory/' . $id . '/tune';
        $method = 'POST';
        $body   = '{}';
        break;

    case 'memoryClear':
        // DELETE /api/memory/{id}
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        if ($id < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'invalid memory id']);
            exit;
        }
        $url    = $atsBase . '/api/memory/' . $id;
        $method = 'DELETE';
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'unknown action']);
        exit;
}

$headers = [
    "Content-Type: application/json\r\n",
];

$options = [
    'http' => [
        'method'        => $method,
        'header'        => implode('', $headers),
        'ignore_errors' => true,
        'timeout'       => 5,
    ]
];

if ($body !== null && $method !== 'GET') {
    $options['http']['content'] = $body;
}

$context  = stream_context_create($options);
$response = @file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'ATS-Mini unreachable', 'url' => $url]);
    exit;
}

//propagate status code from ATS-Mini
if (isset($http_response_header)) {
    foreach ($http_response_header as $h) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $h, $m)) {
            http_response_code(intval($m[1]));
            break;
        }
    }
}

echo $response;