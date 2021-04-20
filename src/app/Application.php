<?php
    namespace coldzero\Framework\App;

    class Application{
        private static $controllerPrefix = '\\coldzero\\Framework\\Controller\\';//날릴부분
        private static $controllerPostfix = 'Controller';//붙일 부분
        private $controller = null;
        private $action =null;

        public function __construct(){
            $url="";
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                $url = filter_var($url,FILTER_SANITIZE_URL);

                $params = explode('/',$url);
                $counts = count($params);
                $controllerName = Application::$controllerPrefix.'Home'. Application ::$controllerPostfix;
                if(isset($params[0])){
                    $controllerName = Application::$controllerPrefix . ucfirst($params[0]).Application::$controllerPostfix;
                }
                $this->action = 'index';

                try{
                    if(class_exists($controllerName)){
                        $this->controller = new $controllerName();
                    }else{
                        throw new \Exception('해당 요청은 처리할수없습니다.');
                    }
                    if(isset($params[1])){
                        if($params[1]) $this -> action = $params[1];
                    }
                    switch($counts){
                        case '0':break;
                        case '1':break;
                        case '2':
                            $this->controller->{$this->action}();
                            break;
                        case '3':
                            $this->controller->{$this->action}($params[2]);
                            break;
                        case '4':
                            $this->controller->{$this->action}($params[2],$params[3]);
                            break;
                        case '5':
                            $this->controller->{$this->action}($params[2],$params[3],$params[4]);
                            break;
                        case '5':
                            $this->controller->{$this->action}($params[2],$params[3],$params[4],$params[5]);
                            break;
                        default:
                        throw new \Exception('해당 페이지가 존재하지 않습니다.');
                        break;
                    }
                }catch(\Exception $e){
                    $this->controller = new \coldzero\Framework\Controller\Nullcontroller();
                    $this->controller->index($e->getMessage());
                }
            }
        }
    }