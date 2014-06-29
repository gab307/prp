<?php

define('COVERAGE_FOLDER', 'coverage/');
define('SOURCE_ROOT', '/var/www/working_copies/trunk/gprieto_analisis_refactor_WS_v3/');
define('PREFIX', 'gprieto_analisis_refactor_WS_v3');

class CoverageMaker
{
    var $aXml;
    var $aRealFileContent;
    var $sRealFileName;
    var $aCoveredLines;
    public function  __construct()
    {
        $this->aXml = file('./coverage/coverage.xml');


        $countFiles = 0;
        $makingNow = false;
        for ($i = 0; $i < count($this->aXml);$i++)
        {
            $bFile = false;
            $line = $this->aXml[$i];
            if (strstr($line, '<file name'))
            {
                $bFile = true;
                if ($makingNow && $bFile)
                {
                    $this->generateHtmlFiles();
                    $makingNow = false;
//                    $i--;
                }
                list($basura, $fileName) = explode(" ", trim($line));

                $fileName = str_replace(array('name="', '">'), '', $fileName);
                $this->sRealFileName = $fileName;
                $this->aRealFileContent = file($fileName);
//                echo $fileName."\n";

                $makingNow = true;

                $countFiles ++;
            }

            if ($makingNow && !$bFile)
            {
//              <line num="2" type="stmt" count="18"/>
                $line = trim(str_replace(array("\"", "<", "/>", "line"), "", $line));
                list($num, $type, $count) = explode(" ", trim($line));
                list($basura, $num)   = explode("=", $num);
                list($basura, $type)  = explode("=", $type);
                list($basura, $count) = explode("=", $count);
                if (is_numeric($num))
                {
                    $this->aCoveredLines[] = $num;
                }
            }
        }
    }

    public function generateHtmlFiles()
    {
        $sRealName    = $this->sRealFileName;
        $aRealContent = $this->aRealFileContent;
        $aCoveredLines = array_flip($this->aCoveredLines);

        $sCoverageFileName = str_replace(SOURCE_ROOT, '', $sRealName);
        $sCoverageFileName = str_replace('/', '_', $sCoverageFileName);
        $sCoverageFileName = SOURCE_ROOT.COVERAGE_FOLDER.PREFIX."_".$sCoverageFileName.".html";

//        echo gettype($aCoveredLines." ".count($aCoveredLines));
        $file = fopen($sCoverageFileName, 'w');
        fwrite($file, '<pre>');
        $i = 0;
        foreach ($aRealContent as $line)
        {
            $i ++;
            if (array_key_exists($i, $aCoveredLines) !== false)
            {
                fwrite($file, "<span style='background: grey'>".$i."</span><span style='background: #dfd'>".$line."</span>");
            }
            else
            {
                fwrite($file, "<span style='background: grey'>".$i."</span><span style='background: #fdd'>".$line."</span>");
            }
        }
        fwrite($file, '</pre>');
        fclose($file);
        $this->aRealFileContent = array();
        $this->aCoveredLines    = array();
    }
}

$coverageMaker = new CoverageMaker();

?>