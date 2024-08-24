<?php

class Router {
  public function __construct(
    private $rutas = []
  ) {}

  public function get($uri, $callbak) {
    $uri = trim($uri, '/');
    $this->rutas['get'][$uri] = $callbak;
  }

  public function post($uri, $callbak) {
    $uri = trim($uri, '/');
    $this->rutas['post'][$uri] = $callbak;
  }

  public function dispatch() {
    $uri_current = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'); // Ignora query strings
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    
    foreach ($this->rutas[$method] as $ruta => $callback) {
      if (strpos($ruta, ':') !== false) {
        $ruta = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $ruta);
      }

      if (preg_match("#^$ruta$#", $uri_current, $matches)) {
        $params = array_splice($matches, 1);
        $response = $callback(...$params);

        if (is_array($response) || is_object($response)) {
          header('Content-Type: application/json');
          echo json_encode($response);
        } else {
          echo $response;
        }
        return;
      }
    }
    $this->show404();
  }


  private function show404() {
    http_response_code(404);
    include 'paginas/errores/404.php';
  }

}
