<?php
/**
 * LinkTag class.
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

use gossi\docblock\tags\AbstractVarTypeTag;

class LinkTag extends AbstractVarTypeTag {

    public function __construct($content = '') {
        parent::__construct('link', $content);
    }
}
