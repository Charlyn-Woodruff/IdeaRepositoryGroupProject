<?php
class Log {
    public $logFile;

    function __construct(string $logPath) {
        $this->logFile = fopen($logPath, "a");
    }
    function log(string $message) {
        $now = date_format(new DateTime(), "D d M Y H:i:s");
        fwrite($this->logFile, $now." --- ".$message."\n");
    }
}