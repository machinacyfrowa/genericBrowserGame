<?php
class Log 
{
    private $log; //tablica tablic (timestamp, treść, waznosc = {info, alert})

    public function __construct()
    {
        $this->log = array();
    }

    public function log(string $message, string $type) 
    {
        //stworz wpis z znacznika czasu i wiadomosci
        $entry = array(
            'timestamp' => time(),
            'message'   => $message,
            'type'      => $type,
        );
        //dopisz wpis na końcu listy logów
        array_push($this->log, $entry);
    }
    public function getLog() : array
    {
        return array_slice($this->log, -10);
    }
}
?>