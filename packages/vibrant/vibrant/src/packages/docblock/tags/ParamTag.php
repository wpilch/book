<?php
/**
 * ParamTag class.
 *
 * Vibrant DocBlock extends the original DocBlock package by Thomas Gossman: https://github.com/gossi/docblock
 * And API to read and parse and generate PHP DocBlock.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */
namespace Vibrant\Vibrant\Packages\DocBlock\Tags;

use gossi\docblock\tags\ParamTag as gossiParamTag;

class ParamTag extends gossiParamTag {

    public function getRawDescription(){
        return $this->description;
    }

    public function getDescription(){
        $descArray = explode('|', $this->getRawDescription());
        return $descArray[0];
    }

    public function getRequired(){
        $descPartsArray = explode('|', $this->getRawDescription());
        foreach ($descPartsArray as $part){
            if($part === 'o'){
                return false;
            }
        }
        return true;
    }

    public function getDefault(){
        $descPartsArray = explode('|', $this->getRawDescription());
        foreach ($descPartsArray as $part){
            $atomPart = explode('=', $part);
            if($atomPart[0] === 'd'){
                unset($atomPart[0]);
                return implode('=', $atomPart);
            }
        }
        return '';
    }

    public function getInputType(){
        $descPartsArray = explode('|', $this->getRawDescription());
        foreach ($descPartsArray as $part){
            $atomPart = explode('=', $part);
            if($atomPart[0] === 'i'){
                $input = $atomPart[1];
                $inputParts = explode(':', $input);
                return $inputParts[0];
            }
        }
        return '';
    }

    public function getInputOptions(){
        $descPartsArray = explode('|', $this->getRawDescription());
        foreach ($descPartsArray as $part){
            $atomPart = explode('=', $part);
            if($atomPart[0] === 'i'){
                $input = $atomPart[1];
                $inputParts = explode(':', $input);
                if(count($inputParts) > 1){
                    $str = $inputParts[1];
                    $str = substr($str, 1);
                    $str = substr($str, 0, -1);
                    return $str;
                }
            }
        }
        return '';
    }

    public function getExampleValue(){
        $descPartsArray = explode('|', $this->getRawDescription());
        foreach ($descPartsArray as $part){
            $atomPart = explode('=', $part);
            if($atomPart[0] === 'e'){
                unset($atomPart[0]);
                return implode('=', $atomPart);
            }
        }
        return '';
    }

}
