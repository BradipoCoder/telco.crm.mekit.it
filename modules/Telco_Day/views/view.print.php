<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 15.07
 */

require_once ("modules/Telco_Day/views/view.php");

/**
 * Class Telco_DayViewList
 */
class Telco_DayViewPrint extends Telco_DayView
{
    /** @var bool */
    private $forceDownload = false;
    
    /**
     * Display view
     */
    public function display()
    {
        ob_end_clean();
        $this->interceptPostValues();
        $this->prepareTemplateData();
    
        $templateFile = 'modules/Telco_Day/tpls/TelcoPrintHtml.tpl';
        $outputTemplate = new \Sugar_Smarty();
        
        $outputTemplate->assign("page_title", "Telco day");
        $outputTemplate->assign("page_content", $this->getDisplayHtml());
        
        $pageHtml = $outputTemplate->fetch($templateFile, null, null, false);
        
        $fileServed = false;
        $tempFilePath = $this->createTemporaryHtmlFile($pageHtml);
        if($tempFilePath)
        {
            $pdfPath = $this->createPdf($tempFilePath);
            if($pdfPath)
            {
                $this->handleOutput($pdfPath, "x.pdf");
                $fileServed = true;
            }
        }
        
        if(!$fileServed)
        {
            print "Error creating pdf!";
        }
        
        exit();
    }
    
    private function handleOutput($pdfPath, $filename)
    {
        $disposition = $this->forceDownload ? "attachment" : "inline";
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: '.$disposition.'; filename="'.$filename.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdfPath));
        
        ob_clean();
        flush();
        readfile($pdfPath);
    }
    
    /**
     * @param $tempFilePath
     *
     * @see https://wkhtmltopdf.org/usage/wkhtmltopdf.txt
     *
     * @return mixed|string
     */
    private function createPdf($tempFilePath)
    {
        $pdfPath = str_replace(".html", ".pdf", $tempFilePath);
        $pdfPath = $_SERVER["DOCUMENT_ROOT"]  . "/" . $pdfPath;
        
        $htmlUri = $_SERVER["HTTP_ORIGIN"] . "/" . $tempFilePath;
        $htmlUri = str_replace("https://", "http://", $htmlUri);
        
        $command = "/usr/local/bin/wkhtmltopdf ${htmlUri} ${pdfPath}";
        @exec($command);
        
        return $pdfPath;
    }
    
    /**
     * @param string $content
     *
     * @return string
     */
    private function createTemporaryHtmlFile($content)
    {
        $tempFileName = md5($content) . ".html";
        $tempFilePath = "tmp/$tempFileName";
        sugar_file_put_contents($tempFilePath, $content);
        
        return $tempFilePath;
    }
    
}
