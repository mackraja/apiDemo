<?php



 if (!class_exists('security')) {
     class security
     {
         public $skey = 'SDF#$%FS&()DSF+_SDF@SER^&(~DTdir'; // you can change it Key must be 12, 24, 32 bit long

    /**
     * [safe_b64encode description].
     *
     * @param [type] $string [description]
     *
     * @return [type] [description]
     */
    private function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

        return $data;
    }

    /**
     * [safe_b64decode description].
     *
     * @param [type] $string [description]
     *
     * @return [type] [description]
     */
    private function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        return base64_decode($data);
    }

    /**
     * [encode description].
     *
     * @param [type] $value [description]
     *
     * @return [type] [description]
     */
    public function encode($value)
    {
        if (!$value) {
            return false;
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);

        return trim($this->safe_b64encode($crypttext));
    }

    /**
     * [decode description].
     *
     * @param [type] $value [description]
     *
     * @return [type] [description]
     */
    public function decode($value)
    {
        if (!$value) {
            return false;
        }
        $crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);

        return trim($decrypttext);
    }

    /**
     * [jsonEncode description].
     *
     * @param [type] $text [description]
     *
     * @return [type] [description]
     */
    public function jsonEncode($text)
    {
        static $from = array('\\', '/', "\n", "\t", "\r", "\b", "\f", '"');
        static $to = array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"');

        return str_replace($from, $to, $text);
    }

    /**
     * [handleCommand description].
     *
     * @return [type] [description]
     */
    public function handleCommand()
    {
        if (isset($_POST['action'])) {
            return  $_POST['action'];
        }
    }
    /**
     * [handleControl description].
     *
     * @return [type] [description]
     */
    public function handleControl()
    {
        if (strtotime(date('Ymd')) <= strtotime('20160307')) {
            return true;
        } else {
            return false;
        }
    }
     }
     $security = new security();
 }
