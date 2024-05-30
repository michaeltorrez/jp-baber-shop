<?php

class Router {
  //Constructor property promoted
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
    $uri_current = trim($_SERVER['REQUEST_URI'], '/');
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    
    foreach ($this->rutas[$method] as $ruta => $callback) {
      if (strpos($ruta, ':') !== false) {
        $ruta = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $ruta);
      }

      if (preg_match("#^$ruta$#", $uri_current, $matches)) {
        $params = array_splice($matches, 1);
        $callback(...$params);
        return;
      }
    }
    echo '404';
  }

}