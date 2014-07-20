<?php

define('WS_ROOT', '/var/www/working_copies/trunk/gprieto_analisis_refactor_WS_v3/');

//require_once('PHPUnit/Framework/TestResult.php');
require_once('PHPUnit/Util/Report.php');
require_once('PHPUnit/Runner/Version.php');
require_once('PHPUnit/Util/Log/CodeCoverage/XML/Clover.php');

class MyTestResult extends PHPUnit_Framework_TestResult
{

    public function topTestSuite()
    {
        return new PHPUnit_Framework_TestSuite();
    }

    public function getCodeCoverageInformation($filterTests = TRUE)
    {
        foreach (CoverageFiles::getNames() as $filename)
        {
            print $filename . "\n";
            $codeCoverage = unserialize(file_get_contents($filename));
            $this->appendCodeCoverageInformation(new MyTestCase, $codeCoverage);
        }

        $ignore = array();

        $ignoreLines = file(CoverageFiles::getIgnoreFile());
        foreach ($ignoreLines as $ignoreLine)
        {
            $ignoreLine = rtrim($ignoreLine);
            $pos = strrpos($ignoreLine, ':');
            $filename = substr($ignoreLine, 0, $pos);
            $lineno = substr($ignoreLine, $pos + 1);
            $ignore[$filename][] = $lineno;
        }

        foreach ($ignore as $file => $lines)
        {
            foreach ($lines as $lineno)
            {
                foreach ($this->codeCoverageInformation as &$codeCovInfo)
                {
                    $x = $codeCovInfo['executable'][$file][$lineno];
                    if ($codeCovInfo['executable'][$file][$lineno] == 1)
                    {
                        print 'Warning: Covered by tests but ignored: ' . $file . ':' . $lineno . "\n";
                    }
                    else
                    {
                        unset($codeCovInfo['executable'][$file][$lineno]);
                    }
                }
            }
        }

        return parent::getCodeCoverageInformation($filterTests);
    }

}

class MyTestCase extends PHPUnit_Framework_TestCase
{

}

class CoverageFiles
{

    public static function getNames()
    {
        return glob(WS_ROOT.'code_coverage/*.code_coverage');
    }

    public static function getIgnoreFile()
    {
        return WS_ROOT.'ignore_coverage';
    }

}

$htmlOutputDir = WS_ROOT.'coverage/';
$xmlOutput     = WS_ROOT.'coverage/coverage.xml';

$res = new MyTestResult;
PHPUnit_Util_Report::render($res, $htmlOutputDir);
$xmlClover = new PHPUnit_Util_Log_CodeCoverage_XML_Clover($xmlOutput);
$xmlClover->process($res);

foreach (CoverageFiles::getNames() as $filename)
{
    unlink($filename);
}
