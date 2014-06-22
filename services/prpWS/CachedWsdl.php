<?php
class CachedWsdl {
    private $bWsdlAvailable = FALSE;
    private $sWsdl          = null;
    private $sSourceFile    = '';
    private $sCacheFile     = '';

    public function __construct($sSourceFile) {
        $this->setSource($sSourceFile);
    }

    public function setSource($sSourceFile) {
        $this->sSourceFile  = $sSourceFile;
        $this->sCacheFile   = '/var/www/prpWS/cache/'.$sSourceFile.'.'.$_SERVER['HTTP_HOST'];
    }

    public function getCacheFile() {
        return($this->sCacheFile);
    }

    function getWsdl() {
        $this->ensure();

        return($this->sWsdl);
    }

    public function dump() {
        $this->ensure();

        // Outputs WSDL.
        header("Content-Type: text/xml");
        echo $this->getWsdl();
    }

    public function ensure() {
        if (!$this->bWsdlAvailable) {
            $this->generateWsdl();
            $this->bWsdlAvailable   = TRUE;
        }
    }

    private function generateWsdl() {
        if (file_exists($this->sCacheFile) && filemtime($this->sCacheFile) > filemtime($this->sSourceFile)) {
            // If the WSDL cache exists and it's newer than the source, use the cached one.
            $this->sWsdl    = file_get_contents($this->sCacheFile);
        } else {
//            $protocol       = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) ? 'https://' : 'http://';
            // If it doesn't exist or it's old, generate a new cache file.
            $this->sWsdl    = file_get_contents($this->sSourceFile);
//            $this->sWsdl    = str_replace('{HTTP_HOST}', $_SERVER['HTTP_HOST'], $this->sWsdl);
//            $this->sWsdl    = str_replace('{PROTOCOL}', $protocol, $this->sWsdl);
            file_put_contents($this->sCacheFile, $this->sWsdl);
        }
    }

}
?>