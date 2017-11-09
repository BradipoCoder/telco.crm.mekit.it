<?php
/**
 * Created by Adam Jakab.
 * Date: 25/10/17
 * Time: 15.07
 */

require_once("modules/Telco_Day/views/view.php");

/**
 * Class Telco_DayViewList
 */
class Telco_DayViewPrint extends Telco_DayView
{
    /** @var bool */
    protected $showHtml = false;
    
    /** @var bool */
    protected $forceDownload = false;
    
    /**
     * Display view
     */
    public function display()
    {
        ob_end_clean();
        $this->interceptPostValues();
        $this->prepareTemplateData();
        
        $pageTemplateData = [
            "title" => $this->templateData["title"],
        ];
        
        //copy css array to page template data and remove it from content
        $pageTemplateData["css"] = $this->templateData["css"];
        $pageTemplateData["css"] = array_merge($pageTemplateData["css"], [
            "/modules/Telco_Day/css/telco_day_print.css",
        ]);
        $this->templateData["css"] = [];
        
        $pageTemplateData["page_content"] = $this->getDisplayHtml();
        
        $templateFile = 'modules/Telco_Day/tpls/TelcoPrintHtml.tpl';
        $outputTemplate = new \Sugar_Smarty();
        $outputTemplate->assign("tplData", $pageTemplateData);
        $pageHtml = $outputTemplate->fetch($templateFile, null, null, false);
        
        if ($this->showHtml)
        {
            print $pageHtml;
        }
        else
        {
            $fileServed = false;
            $tempFilePath = $this->createTemporaryHtmlFile($pageHtml);
            if ($tempFilePath)
            {
                $pdfPath = $this->createPdf($tempFilePath);
                if ($pdfPath)
                {
                    $filename = $this->templateData["title"] . "("
                        . $this->templateData["periods"]["period_start_format_iso"] . " - "
                        . $this->templateData["periods"]["period_end_format_iso"] . ")"
                        . ".pdf";
                    
                    
                    $this->handleOutput($pdfPath, $filename);
                    $fileServed = true;
                    //unlink($pdfPath);
                }
                unlink($tempFilePath);
            }
            
            if (!$fileServed)
            {
                print "Error creating pdf!";
            }
        }
        
        exit();
    }
    
    /**
     * @param string $pdfPath
     * @param string $filename
     */
    private function handleOutput($pdfPath, $filename)
    {
        $disposition = $this->forceDownload ? "attachment" : "inline";
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Transfer-Encoding: binary');
        header('Content-Disposition: ' . $disposition . '; filename="' . $filename . '"');
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
        $pdfPath = $_SERVER["DOCUMENT_ROOT"] . "/" . $pdfPath;
        
        $htmlUri = $_SERVER["HTTP_ORIGIN"] . "/" . $tempFilePath;
        $htmlUri = str_replace("https://", "http://", $htmlUri);
        
        $converterOptions = [
            "--footer-line" => "",
            "--footer-spacing" => 1,
            "--footer-center" => "TELCO - " . $this->templateData["title"],
            "--footer-font-size" => 10,
        ];
    
        $flatConverterOptions = "";
        foreach($converterOptions as $k => $v)
        {
            $flatConverterOptions .= "${k} ";
            if(!empty($v))
            {
                $flatConverterOptions .= "'${v}' ";
            }
        }
        
        $command = "/usr/local/bin/wkhtmltopdf ${flatConverterOptions} ${htmlUri} ${pdfPath}";
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
