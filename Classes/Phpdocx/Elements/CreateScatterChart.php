<?php
namespace Phpdocx\Elements;
/**
 * Create Scatter Chart
 *
 * @category   Phpdocx
 * @package    elements
 * @copyright  Copyright (c) Narcea Producciones Multimedia S.L.
 *             (http://www.2mdc.com)
 * @license    phpdocx LICENSE
 * @link       https://www.phpdocx.com
 */
class CreateScatterChart extends CreateGraphic implements InterfaceGraphic
{
    /**
     * Create embedded xml chart
     *
     * @access public
     */
    public function createEmbeddedXmlChart()
    {
        $this->_xmlChart = '';
        $this->generateCHARTSPACE();
        $this->generateDATE1904(1);
        $this->generateLANG();
        $this->generateROUNDEDCORNERS($this->_roundedCorners);
        $color = 2;
        if ($this->_color) {
            $color = $this->_color;
        }
        $this->generateSTYLE($color);
        $this->generateCHART();
        if ($this->_title != '') {
            $this->generateTITLE();
            $this->generateTITLETX();
            $this->generateRICH();
            $this->generateBODYPR();
            $this->generateLSTSTYLE();
            $this->generateTITLEP();
            $this->generateTITLEPPR();
            $this->generateDEFRPR('title');
            $this->generateTITLER();
            $this->generateTITLERPR();
            $this->generateTITLET($this->_title);
            $this->generateTITLELAYOUT();
        } else {
            $this->generateAUTOTITLEDELETED();
            $title = '';
        }
        if (strpos($this->_type, '3D') !== false) {
            $this->generateVIEW3D();
            $rotX = 30;
            $rotY = 30;
            $perspective = 30;
            if ($this->_rotX != '') {
                $rotX = $this->_rotX;
            }
            if ($this->_rotY != '') {
                $rotY = $this->_rotY;
            }
            if ($this->_perspective != '') {
                $perspective = $this->_perspective;
            }
            $this->generateROTX($rotX);
            $this->generateROTY($rotY);
            $this->generatePERSPECTIVE($perspective);
        }
        if ($this->values == '') {
            exit('You haven`t added data');
        }
        $this->generatePLOTAREA();
        $this->generateLAYOUT();


        $this->generateSCATTERCHART();
        $this->generateSCATTERSTYLE($this->_style);

        $numValues = count($this->values['data']);
        $legend = 'Y values';
        if (isset($this->values['legend'])) {
            $legend = $this->values['legend'][0];
        }
        $this->generateVARYCOLORS($this->_varyColors);
        $letter = 'A';
        $this->generateSER();
        $this->generateIDX(0);
        $this->generateORDER(0);
        $letter++;

        $this->generateTX();
        $this->generateSTRREF();
        $this->generateF('Sheet1!$' . $letter . '$1');
        $this->generateSTRCACHE();
        $this->generatePTCOUNT();
        $this->generatePT();
        $this->generateV($legend);
        if (!empty($this->_symbol)) {
            if ($this->_symbol == 'line') {
                $this->generateMARKER('none');
            } elseif ($this->_symbol == 'dot') {
                $this->generateSPPR_SER();
                $this->generateLN(2, 25);
                $this->generateNOFILL();
            }
        }

        if (is_array($this->_theme) && isset($this->_theme['serRgbColors']) && isset($this->_theme['serRgbColors'][0])) {
            if ($this->_theme['serRgbColors'][0] != null) {
                $this->generateSPPR_SER();
                $this->generateSPPR_SOLIDFILL($this->_theme['serRgbColors'][0]);
            }
        }
        
        if (is_array($this->_theme) && isset($this->_theme['valueRgbColors']) && isset($this->_theme['valueRgbColors'][0]) && $this->_theme['valueRgbColors'][0] != null) {
            if ($this->_theme['valueRgbColors'][0] != null) {
                $this->generateCDPT($this->_theme['valueRgbColors'][0]);
            }
        }

        $this->cleanTemplate2();

        $this->generateXVAL();
        $this->generateNUMREF();
        $this->generateF('Sheet1!$A$2:$A$' . ($numValues + 1));
        $this->generateNUMCACHE();
        $this->generateFORMATCODE();
        $this->generatePTCOUNT($numValues);
        $num = 0;
        foreach ($this->values['data'] as $datas) {
            foreach ($datas['values'] as $data) {
                $this->generatePT($num);
                $this->generateV($data);
                $num++;
                break;
            }
        }
        $this->cleanTemplate2();
        $this->generateYVAL();
        $this->generateNUMREF();
        $this->generateF('Sheet1!$B$2:$B$' . ($numValues + 1));
        $this->generateNUMCACHE();
        $this->generateFORMATCODE();
        $this->generatePTCOUNT($numValues);
        $num = 0;
        foreach ($this->values['data'] as $datas) {
            $flag = true;
            foreach ($datas['values'] as $data) {
                if ($flag) {
                    $flag = false;
                    continue;
                }
                $this->generatePT($num);
                $this->generateV($data);
                $num++;
                break;
            }
        }
        $this->cleanTemplate2();
        if (!empty($this->_smooth) && $this->_smooth) {
            $this->generateSMOOTH();
        } else if ($this->_smooth === '0') {
            $this->generateSMOOTH(0);
        }
        $this->cleanTemplate3();

        //Generate labels
        $this->generateSERDLBLS();
        $this->generateSHOWLEGENDKEY($this->_showLegendKey);
        $this->generateSHOWVAL($this->_showValue);
        $this->generateSHOWCATNAME($this->_showCategory);
        $this->generateSHOWSERNAME($this->_showSeries);
        $this->generateSHOWPERCENT($this->_showPercent);
        $this->generateSHOWBUBBLESIZE($this->_showBubbleSize);


        $this->generateAXID();
        $this->generateAXID(59040512);
        $this->generateVALAX();
        $this->generateAXAXID(59034624);
        $this->generateSCALING();
        $this->generateDELETE($this->_delete);
        $this->generateORIENTATION();
        $this->generateAXPOS();
        switch ($this->_vgrid) {
            case 1:
                $this->generateMAJORGRIDLINES();
                break;
            case 2:
                $this->generateMINORGRIDLINES();
                break;
            case 3:
                $this->generateMAJORGRIDLINES();
                $this->generateMINORGRIDLINES();
                break;
            default:
                break;
        }
        if (!empty($this->_haxLabel)) {
            $this->generateAXLABEL($this->_haxLabel);
            $vert = 'horz';
            $rot = 0;
            if ($this->_haxLabelDisplay == 'vertical') {
                $vert = 'wordArtVert';
            }
            if ($this->_haxLabelDisplay == 'rotated') {
                $rot = '-5400000';
            }
            $this->generateAXLABELDISP($vert, $rot);
        }
        if ($this->_formatCode) {
            $this->generateNUMFMT($this->_formatCode, 0);
        } else {
            $this->generateNUMFMT();
        }
        $this->generateTICKLBLPOS();
        $this->generateCROSSAX();
        $this->generateCROSSES();
        $this->generateCROSSBETWEEN('midCat');
        $this->generateVALAX();
        $this->generateAXAXID(59040512);
        $this->generateSCALING(true);
        $this->generateDELETE($this->_delete);
        $this->generateORIENTATION();
        $this->generateAXPOS('l');
        switch ($this->_hgrid) {
            case 1:
                $this->generateMAJORGRIDLINES();
                break;
            case 2:
                $this->generateMINORGRIDLINES();
                break;
            case 3:
                $this->generateMAJORGRIDLINES();
                $this->generateMINORGRIDLINES();
                break;
            default:
                break;
        }
        if (!empty($this->_vaxLabel)) {
            $this->generateAXLABEL($this->_vaxLabel);
            $vert = 'horz';
            $rot = 0;
            if ($this->_vaxLabelDisplay == 'vertical') {
                $vert = 'wordArtVert';
            }
            if ($this->_vaxLabelDisplay == 'rotated') {
                $rot = '-5400000';
            }
            $this->generateAXLABELDISP($vert, $rot);
        }
        $this->generateNUMFMT();
        $this->generateTICKLBLPOS($this->_tickLblPos, true);
        $this->generateMAJORUNIT($this->_majorUnit);
        $this->generateMINORUNIT($this->_minorUnit);
        $this->generateCROSSAX(59034624);
        $this->generateCROSSES();
        $this->generateCROSSBETWEEN();

        $this->generateLEGEND();
        $this->generateLEGENDPOS($this->_legendPos);
        $this->generateLEGENDOVERLAY($this->_legendOverlay);
        $this->generatePLOTVISONLY();

        if ((!isset($this->_border) || $this->_border == 0 || !is_numeric($this->_border))
        ) {
            $this->generateSPPR();
            $this->generateLN();
            $this->generateNOFILL();
        } else {
            $this->generateSPPR();
            $this->generateLN($this->_border);
        }

        if ($this->_font != '') {
            $this->generateTXPR();
            $this->generateLEGENDBODYPR();
            $this->generateLSTSTYLE();
            $this->generateAP();
            $this->generateAPPR();
            $this->generateDEFRPR();
            $this->generateRFONTS($this->_font);
            $this->generateENDPARARPR();
        }

        $this->generateEXTERNALDATA();
        $this->cleanTemplateDocument();
        return $this->_xmlChart;
    }

    public function dataTag()
    {
        return array('xVal', 'yVal');
    }

    /**
     * Return the type of the xlsx object
     *
     * @access public
     */
    public function getXlsxType()
    {
        return CreateScatterXlsx::getInstance();
    }

}
