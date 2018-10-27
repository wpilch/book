<?php
/**
 * DocBlock class.
 *
 * Vibrant DocBlock extends the original DocBlock package by Thomas Gossman: https://github.com/gossi/docblock
 * And API to read and parse and generate PHP DocBlock.
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */
namespace Vibrant\Vibrant\Packages\DocBlock;

use gossi\docblock\Docblock as gossiDocBlock;

use Vibrant\Vibrant\Packages\DocBlock\Tags\TagFactory as TagFactory;

class DocBlock extends gossiDocBlock
{
    public function __construct($docblock = null) {
        parent::__construct($docblock);
    }

    /**
     * Parses an individual tag line
     *
     * @param string $line
     * @throws \InvalidArgumentException
     * @return \gossi\docblock\tags\AbstractTag
     */
    protected function parseTag($line) {
        $matches = [];
        if (!preg_match('/^@(' . self::REGEX_TAGNAME . ')(?:\s*([^\s].*)|$)?/us', $line, $matches)) {
            throw new \InvalidArgumentException('Invalid tag line detected: ' . $line);
        }

        $tagName = $matches[1];
        $content = isset($matches[2]) ? $matches[2] : '';

        return TagFactory::create($tagName, $content);
    }

}
