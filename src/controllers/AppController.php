<?php
    class AppController{
        private $request;

        public function __construct(){
            $this->request = $_SERVER['REQUEST_METHOD'];
        }

        public function isPost(): bool{
            return $this->request === 'POST';
        }

        protected function render(string $template = null, array $variables = []){
            $templatePath = 'public/views/'.$template.'.php';
            $output = 'File not found';

            if(file_exists($templatePath)){
                extract($variables);
                
                ob_start();
                include $templatePath;
                $output = ob_get_clean();
            }
            print $output;
        }

        protected function isStrongPassword($password) {
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
            return preg_match($pattern, $password);
        }
    }