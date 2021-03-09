<?php
    class SampleHostingCP_Module extends ServerModule
    {
        private $api;
        function __construct($server,$options=[])
        {
            $this->_name = __CLASS__;

            // If you are developing, set the $this->force_setup value to be false.
            $this->force_setup  = true; // If "true", even if the module gets an error message, it will be ignored and the installation is complete. 
            parent::__construct($server,$options);
        }

        protected function define_server_info($server=[])
        {
            /*
            if(!class_exists("SampleApi")) include __DIR__.DS."api.class.php";
            $this->api = new SampleApi(
                $server["name"],
                $server["ip"],
                $server["username"],
                $server["password"],
                $server["access_hash"],
                $server["port"],
                $server["secure"],
                $server["port"]
            );
            */
        }

        public function testConnect(){

            try
            {
                $connect    = 'OK';  #$this->api->checkConnect();
            }
            catch(Exception $e){
                $this->error = $e->getMessage();
                return false;
            }

            if($connect != 'OK'){
                $this->error = $connect;
                return false;
            }

            return true;
        }

        public function config_options($data=[])
        {
            return [
                'example1'          => [
                    'wrap_width'        => 100,
                    'name'              => "Text Box",
                    'description'       => "Text Box Description",
                    'type'              => "text",
                    'value'             => isset($data["example1"]) ? $data["example1"] : "sample",
                    'placeholder'       => "sample placeholder",
                ],
                'example2'          => [
                    'wrap_width'        => 100,
                    'name'              => "Password Box",
                    'description'       => "Password Box Description",
                    'type'              => "password",
                    'value'             => isset($data["example2"]) ? $data["example2"] : "sample",
                    'placeholder'       => "sample placeholder",
                ],
                'example3'          => [
                    'wrap_width'        => 100,
                    'name'              => "Approval Button",
                    'description'       => "Approval Button Description",
                    'type'              => "approval",
                    'checked'           => isset($data["example3"]) && $data["example3"] ? true : false,
                ],
                'example4'          => [
                    'wrap_width'        => 100,
                    'name'              => "Dropdown Menu 1",
                    'description'       => "Dropdown Menu 1 Description",
                    'type'              => "dropdown",
                    'options'           => "Option 1,Option 2,Option 3,Option 4",
                    'value'             => isset($data["example4"]) ? $data["example4"] : "Option 2",
                ],
                'example5'          => [
                    'wrap_width'        => 100,
                    'name'              => "Dropdown Menu 2",
                    'description'       => "Dropdown Menu 2 Description",
                    'type'              => "dropdown",
                    'options'           => [
                        'opt1'     => "Option 1",
                        'opt2'     => "Option 2",
                        'opt3'     => "Option 3",
                        'opt4'     => "Option 4",
                    ],
                    'value'             => isset($data["example5"]) ? $data["example5"] : "opt2",
                ],
                'example6'          => [
                    'wrap_width'        => 100,
                    'name'              => "Circular(Radio) Button 1",
                    'description'       => "Circular(Radio) Button 1",
                    'width'             => 40,
                    'description_pos'   => 'L',
                    'is_tooltip'        => true,
                    'type'              => "radio",
                    'options'           => "Option 1,Option 2,Option 3,Option 4",
                    'value'             => isset($data["example6"]) ? $data["example6"] : "Option 2",
                ],
                'example7'          => [
                    'wrap_width'        => 100,
                    'name'              => "Circular(Radio) Button 2",
                    'description'       => "Circular(Radio) Button 2 Description",
                    'description_pos'   => 'L',
                    'is_tooltip'        => true,
                    'type'              => "radio",
                    'options'           => [
                        'opt1'     => "Option 1",
                        'opt2'     => "Option 2",
                        'opt3'     => "Option 3",
                        'opt4'     => "Option 4",
                    ],
                    'value'             => isset($data["example7"]) ? $data["example7"] : "opt2",
                ],
                'example8'          => [
                    'wrap_width'        => 100,
                    'name'              => "Text Area",
                    'description'       => "Text Area Description",
                    'rows'              => "3",
                    'type'              => "textarea",
                    'value'             => isset($data["example8"]) ? $data["example8"] : "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                    'placeholder'       => "sample placeholder",
                ],
            ];
        }
        
        public function generate_username($domain='',$half_mixed=false){
            $exp            = explode(".",$domain);
            $domain         = Filter::transliterate($exp[0]);
            $username       = $domain;
            $fchar          = substr($username,0,1);
            $size           = strlen($username);
            if($fchar == "0" || (int)$fchar)
                $username   = Utility::generate_hash(1,false,"l").substr($username,1,$size-1);

            if($size>=8){
                $username   = substr($username,0,5);
                $username .= Utility::generate_hash(3,false,"l");
            }elseif($size>4 && $size<9){
                $username   = substr($username,0,5);
                $username .= Utility::generate_hash(3,false,"l");
            }elseif($size>=1 && $size<5){
                $how        = (8 - $size);
                $username   = substr($username,0,$size);
                $username .= Utility::generate_hash($how,false,"l");
            }

            return $username;
        }

        public function create($domain = '',array $order_options=[])
        {
            $username       = $this->generate_username($domain);
            $password       = Utility::generate_hash(12);


            if(isset($order_options["username"]) && $order_options["username"]) $username = $order_options["username"];
            if(isset($order_options["password"]) && $order_options["password"]) $password = $order_options["password"];

            $username       = str_replace("-","",$username);
            $creation_info  = isset($order_options["creation_info"]) ? $order_options["creation_info"] : [];
            $disk_limit     = isset($order_options["disk_limit"]) ? $order_options["disk_limit"] : '';



            try
            {
                /*
                 * $order_options or $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK|101"; #$this->api->create();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Failed to create server, something went wrong.";
            */
            if(substr($result,0,2) == 'OK')
            {
                $host       = $this->server["ip"];
                if(Validation::NSCheck($this->server["name"])) $host = $this->server["name"];

                return [
                    'username' => $username,
                    'password' => $password,
                    'ftp_info' => [
                        'ip'   => $this->server["ip"],
                        'host' => $host,
                        'username' => $username,
                        'password' => $password,
                        'port' => 21,
                    ],
                ];
            }
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function suspend()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result             = "OK"; #$this->api->suspend();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }
            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function unsuspend()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK"; #$this->api->unsuspend();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function terminate()
        {
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK"; # $this->api->terminate();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function getDisk(){
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result             = [
                    'used'      => 2562,
                    'limit'     => 10240,
                ]; #$this->api->get_disk();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            $limit  = $result["limit"];
            $used   = $result["used"];
            if($limit == "unlimited") $limit = 0;

            if($limit && $used) $percent = Utility::getPercent($used,$limit);
            else $percent = 0;
            if($percent>100) $percent = 100;


            return [
                'limit' => $limit ? $limit : 0,
                'used'  => $used ? $used : 0,
                'used-percent' => $percent,
                'format-limit' => $limit ? $limit.' MB' : "∞",
                'format-used' => $used ? $used." MB" : "0 MB",
            ];
        }

        public function getBandwidth(){
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result             = [
                    'used'      => 46,
                    'limit'     => 100,
                ]; #$this->api->get_bandwidth();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            $limit  = $result["limit"];
            $used   = $result["used"];
            if($limit == "unlimited") $limit = 0;

            if($limit && $used) $percent = Utility::getPercent($used,$limit);
            else $percent = 0;
            if($percent>100) $percent = 100;


            return [
                'limit' => $limit ? $limit : 0,
                'used'  => $used ? $used : 0,
                'used-percent' => $percent,
                'format-limit' => $limit ? $limit.' GB' : "∞",
                'format-used' => $used ? $used." GB" : "0 GB",
            ];
        }

        public function change_password($password=''){
            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = "OK"; # $this->api->change_password($this->>config["user"],$password);
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }

        public function apply_updowngrade($orderopt=[],$product=[]){
            $o_creation_info        = $orderopt["creation_info"];
            $p_creation_info        = $product["module_data"];
            $disk_limit             = $product["options"]["disk_limit"];
            $bandwidth_limit        = $product["options"]["bandwidth_limit"];
            $email_limit            = $product["options"]["email_limit"];
            $database_limit         = $product["options"]["database_limit"];
            $addons_limit           = $product["options"]["addons_limit"];
            $subdomain_limit        = $product["options"]["subdomain_limit"];
            $ftp_limit              = $product["options"]["ftp_limit"];
            $park_limit             = $product["options"]["park_limit"];
            $max_email_per_hour     = $product["options"]["max_email_per_hour"];

            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                 *
                $params                 = [
                    'disk'          => $disk_limit == 'unlimited' || $disk_limit < 1 ? '-1' : $disk_limit,
                    'bandwidth'     => $bandwidth_limit == 'unlimited' || $bandwidth_limit < 1 ? '-1' : $bandwidth_limit,
                    ...
                ];

                */
                $result = "OK"; # $this->api->modify_account($this->config["user"],$params);
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            if($result == 'OK')
                return true;
            else
            {
                $this->error = $result;
                return false;
            }
        }


        public function listAccounts(){

            try
            {
                /*
                 * $this->order["options"]
                * for parameters: https://docs.wisecp.com/en/kb/hosting-panel-module-development-parameters
                * Here are the codes to be sent to the API...
                */
                $result = [
                    [
                        'start_date'    => "2019-12-24 18:08:26", // Y-m-d H:i:s
                        'domain'        => 'example3.com',
                        'username'      => 'tsetexa3',
                        'package'       => 'package3',
                        'suspended'     => false,
                    ],
                    [
                        'start_date'    => "2019-12-23 17:07:15", // Y-m-d H:i:s
                        'domain'        => 'example2.com',
                        'username'      => 'tsetexa2',
                        'package'       => 'package2',
                        'suspended'     => false,
                    ],
                    [
                        'start_date'    => "2019-12-22 16:06:04", // Y-m-d H:i:s
                        'domain'        => 'example1.com',
                        'username'      => 'tsetexa1',
                        'package'       => 'package1',
                        'suspended'     => false,
                    ],
                ]; # $this->api->getAccounts();
            }
            catch (Exception $e){
                $this->error = $e->getMessage();
                self::save_log(
                    'Servers',
                    $this->_name,
                    __FUNCTION__,
                    ['order' => $this->order],
                    $e->getMessage(),
                    $e->getTraceAsString()
                );
                return false;
            }

            /*
            * Error Result:
            * $result             = "Error Message";
            */

            $accounts = [];

            if(!is_array($result))
            {
                $this->error = $result;
                return false;
            }

            if($result){
                foreach($$result AS $row){
                    $item   = [];
                    $item["cdate"]          = $row["start_date"]; // Format: Y-m-d H:i:s
                    $item["domain"]         = $row["domain"];
                    $item["username"]       = $row["username"];
                    $item["plan"]           = $row["package"];
                    $item["suspended"]      = $row["suspended"] ? true : false;

                    $accounts[] = $item;
                }
            }


            return $accounts;

        }

        public function clientArea()
        {
            $content    = $this->clientArea_buttons_output();
            $_page      = $this->page;

            if(!$_page) $_page = 'home';

            $content .= $this->get_page('clientArea-'.$_page,['test1' => 'hello world', 'test2' => 'sample var']);
            return  $content;
        }

        public function clientArea_buttons()
        {
            $buttons    = [];

            if($this->page && $this->page != "home")
            {
                $buttons['home'] = [
                    'text' => $this->lang["turn-back"],
                    'type' => 'page-loader',
                ];
            }
            else
            {

                $buttons['custom_transaction'] = [
                    'text'  => 'Run Transaction',
                    'type'  => 'transaction',
                ];

                $buttons['another'] = [
                    'text'  => 'Another Page',
                    'type'  => 'page-loader',
                ];

                $buttons['custom_function'] = [
                    'text'  => 'Open Function',
                    'type'  => 'function',
                    'target_blank' => true,
                ];

                $buttons['another-link'] = [
                    'text'      => 'Another link',
                    'type'      => 'link',
                    'url'       => 'https://www.google.com',
                    'target_blank' => true,
                ];
            }

            return $buttons;
        }

        public function use_clientArea_another(){
            echo Utility::jencode([
                'status' => "error",
                'message' => "Example Error Message",
            ]);
        }

        public function use_clientArea_custom_transaction()
        {
            echo  Utility::jencode([
                'status' => "successful",
                'message' => 'Successful Transaction',
            ]);

            return true;
        }

        public function use_clientArea_custom_function()
        {
            if(Filter::POST("var2"))
            {
                echo  Utility::jencode([
                    'status' => "successful",
                    'message' => 'Successful message',
                ]);
            }
            else
            {
                echo "Content Here...";
            }

            return true;
        }

        public function use_clientArea_SingleSignOn()
        {
            $api_result     = 'OK|bmd5d0p384ax7t26zr9wlwo4f62cf8g6z0ld';

            if(substr($api_result,0,2) != 'OK'){
                echo "An error has occurred, unable to access.";
                return false;
            }

            $token          = substr($api_result,2);
            $url            = 'https://modulewebsite.com/api/access/'.$token;

            Utility::redirect($url);

            echo "Redirecting...";
        }

        public function use_clientArea_webMail()
        {
            $url            = 'https://modulewebsite.com/webmail';

            Utility::redirect($url);

            echo "Redirecting...";
        }


        public function adminArea_buttons()
        {
            $buttons = [];

            $buttons['custom_transaction'] = [
                'text'  => 'Run Transaction',
                'type'  => 'transaction',
            ];
            $buttons['custom_function'] = [
                'text'  => 'Open Function',
                'type'  => 'function',
                'target_blank' => true,
            ];

            $buttons['another-link'] = [
                'text'      => 'Another link',
                'type'      => 'link',
                'url'       => 'https://www.google.com',
                'target_blank' => true,
            ];

            return $buttons;
        }

        public function use_adminArea_custom_transaction()
        {
            echo  Utility::jencode([
                'status' => "successful",
                'message' => 'Successful Transaction',
            ]);

            return true;
        }

        public function use_adminArea_custom_function()
        {
            if(Filter::POST("var2"))
            {
                echo  Utility::jencode([
                    'status' => "successful",
                    'message' => 'Successful message',
                ]);
            }
            else
            {
                echo "Content Here...";
            }

            return true;
        }

        public function use_adminArea_SingleSignOn()
        {
            $api_result     = 'OK|bmd5d0p384ax7t26zr9wlwo4f62cf8g6z0ld';

            if(substr($api_result,0,2) != 'OK'){
                echo "An error has occurred, unable to access.";
                return false;
            }

            $token          = substr($api_result,2);
            $url            = 'https://modulewebsite.com/api/access/'.$token;

            Utility::redirect($url);

            echo "Redirecting...";
        }

        public function use_adminArea_root_SingleSignOn()
        {
            $api_result     = 'OK|bmd5d0p384ax7t26zr9wlwo4f62cf8g6z0ld';

            if(substr($api_result,0,2) != 'OK'){
                echo "An error has occurred, unable to access.";
                return false;
            }

            $token          = substr($api_result,2);
            $url            = 'https://modulewebsite.com/api/access/'.$token;

            Utility::redirect($url);

            echo "Redirecting...";
        }

        public function adminArea_service_fields(){
            $c_info                 = $this->options["creation_info"];
            $field1                 = isset($c_info["field1"]) ? $c_info["field1"] : NULL;
            $field2                 = isset($c_info["field2"]) ? $c_info["field2"] : NULL;

            return [
                'field1'                => [
                    'wrap_width'        => 100,
                    'name'              => "Field 1",
                    'description'       => "Field 1 Description",
                    'type'              => "text",
                    'value'             => $field1,
                    'placeholder'       => "sample placeholder",
                ],
                'field2'                => [
                    'wrap_width'        => 100,
                    'name'              => "Field 2",
                    'type'              => "output",
                    'value'             => '<input type="text" name="creation_info[field2]" value="'.$field2.'">',
                ],
            ];
        }

        public function save_adminArea_service_fields($data=[]){

            /* OLD DATA */
            $o_c_info           = $data['old']['creation_info'];
            $o_config           = $data['old']['config'];
            $o_ftp_info         = $data['old']['ftp_info'];
            $o_options          = $data['old']['options'];

            /* NEW DATA */

            $n_c_info           = $data['new']['creation_info'];
            $n_config           = $data['new']['config'];
            $n_ftp_info         = $data['new']['ftp_info'];
            $n_options          = $data['new']['options'];

            if($n_c_info['field1'] == '')
            {
                $this->error = 'Do not leave Field 1 empty.';
                return false;
            }

            if($o_options['disk_limit'] != $n_options['disk_limit'])
            {
                /* Example: Change Disk Limit
                if(!$this->change_disk_quota($n_options["disk_limit"])) return false;
                */
            }

            return [
                'creation_info'     => $n_c_info,
                'config'            => $n_config,
                'ftp_info'          => $n_ftp_info,
                'options'           => $n_options,
            ];
        }



    }


   // Hook Usage Sample
/*
    Hook::add("changePropertyToAccountOrderDetails",1,function($params = [])
    {
        if($params["module"] == "SampleHostingCP" && !Filter::isPOST())
        {
            $options        = $params["options"];
            Helper::Load("Products");
            $server         = Products::get_server($options["server_id"]);
            if($server) $options["ip"] = $server["ip"];
            $params["options"] = $options;
            return $params;
        }
    });
*/
