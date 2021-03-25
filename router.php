<?php
class Router{
    public $routes=array(
        "GET"=>array(),
        "POST"=>array()
    );

    function get($route,$callback){
       $this->routes["GET"][$route]=$callback;
    }

    function post($route,$callback){
        $this->routes["POST"][$route]=$callback;
    }

    function exists($route,$method){
        foreach ($this->routes[$method] as $key => $value) {
            if(preg_match("%^{$key}$%",$route,$matches)===1){
                unset($matches[0]);
                return array("exist"=>true,"params"=>$matches,"handler"=>$value);
            }
        }
        return array("exist"=>false);
    }

    function run($route,$method){
        $exists=$this->exists($route,$method);
        if($exists["exist"]){
            call_user_func($exists["handler"],$exists["params"]);
        }else{
            http_response_code(404);
            echo '<h1>404</h1><br>';
        }
    }
}
?>