<?php
/**
 * Created by Adam Jakab.
 * Date: 12/12/17
 * Time: 10.32
 */

require_once('include/SugarTheme/SugarTheme.php');

/**
 * Class SuiteMekitSugarTheme
 */
class SuiteMekitSugarTheme extends SugarTheme
{

    /**
     * SuiteMekitSugarTheme constructor.
     * @param array $defaults
     */
    public function __construct(array $defaults)
    {
        parent::__construct($defaults);
    }

    /**
     * @return string
     */
    public function getJS()
    {
        $html = parent::getJS();

        return $html;
    }

    /**
     * @param null $color
     * @param null $font
     * @return string
     */
    public function getCSS(
        $color = null,
        $font = null
    ) {
        $html = parent::getCSS($color, $font);

        return $html;
    }
}
