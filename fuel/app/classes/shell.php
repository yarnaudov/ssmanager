<?php

class Shell {

    private $wd;
    public $save_wd = true;

    function __construct() {

        if (!isset($_COOKIE['wd'])) {
            $this->_set_wd('cd ..;');
        }
        $this->wd = $_COOKIE['wd'];
    }

    public function exec($cmd) {

        $cmd = $this->_command_builder($cmd);
  
        if ($this->save_wd == true) {
            $this->_set_wd($cmd);
        }

        return $this->_exec($cmd);
    }

    private function _exec($cmd) {

        $descriptorspec = array(
            0 => array('pipe', 'r'), // stdin
            1 => array('pipe', 'w'), // stdout
            2 => array('pipe', 'a'), // stderr
        );

        $proc = proc_open($cmd, $descriptorspec, $pipes, DOCROOT . '../');
        if (is_resource($proc)) {
            return trim(stream_get_contents($pipes[1]));
        }

        proc_close($proc);
    }

    private function _command_builder($cmd) {

        $cmd = trim($cmd, ';');
        $cmd_arr = explode(';', $cmd);

        $new_cmd_arr = array();
        if(!empty($this->wd)){
            $new_cmd_arr = array('cd ' . $this->wd);
        }
        $new_cmd_arr = array_merge($new_cmd_arr, $cmd_arr);
        $new_cmd_arr = array_unique($new_cmd_arr);

        $cmd = implode(';', $new_cmd_arr);

        return $cmd . ' 2>&1;';
    }

    private function _set_wd($cmd) {

        $cmd_arr = explode(';', $cmd);

        $cmd = '';
        foreach ($cmd_arr as $cmd_str) {
            if (preg_match('/^cd (.*)$/', $cmd_str)) {
                $cmd .= $cmd_str . ';';
            }
        }

        $cmd .= 'pwd;';

        $wd_array = explode(PHP_EOL, $this->_exec($cmd));
        $wd = end($wd_array);
        $wd = trim($wd);

        setcookie('wd', $wd, 0, "/");
        $_COOKIE['wd'] = $wd;
    }

}
