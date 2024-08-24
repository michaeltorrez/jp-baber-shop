<?php

class Router {
  public function __construct(
    private $rutas = []
  ) {}

  public function get($uri, $callback) {
    $this->addRoute('get', $uri, $callback);
  }

  public function post($uri, $callback) {
    $this->addRoute('post', $uri, $callback);
  }

  private function addRoute($method, $uri, $callback) {
    $uri = trim($uri, '/');
    $this->rutas[$method][$uri] = $callback;
  }

  public function dispatch() {
    $uri_current = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    foreach ($this->rutas[$method] as $ruta => $callback) {
      if (preg_match_all('/:([a-zA-Z0-9_]+)\??/', $ruta, $paramNames)) {
        $rutaRegex = preg_replace('#:[a-zA-Z0-9_]+#', '([a-zA-Z0-9_]+)', $ruta);
        $rutaRegex = str_replace('?)', ')?', $rutaRegex); // Hacer el último parámetro opcional
      } else {
        $rutaRegex = $ruta;
      }
      echo '<br/>'.$rutaRegex.'<br/>';
      

      if (preg_match("#^$rutaRegex$#", $uri_current, $matches)) {
        $params = [];
        if (isset($paramNames[1])) {
          foreach ($paramNames[1] as $index => $paramName) {
            $params[$paramName] = $matches[$index + 1];
          }
        }
        call_user_func_array($callback, $params);
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

