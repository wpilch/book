<?php
/**
 * TagFactory class.
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
use gossi\docblock\tags\TagFactory as gossiTagFactoy;
use gossi\docblock\tags\UnknownTag;
/**
 * Tag Factory
 */
class TagFactory extends gossiTagFactoy{

	/**
	 * @var array An array with a tag as a key, and an FQCN as the handling class.
	 */
	private static $tagClassMap = array(
			'param' => '\Vibrant\Vibrant\Packages\DocBlock\Tags\ParamTag',
			'slot' => '\Vibrant\Vibrant\Packages\DocBlock\Tags\SlotTag',
            'link' => '\Vibrant\Vibrant\Packages\DocBlock\Tags\LinkTag'
	);


    /**
     * @param string $tagName
     * @param string $content
     * @return \gossi\docblock\tags\AbstractTag|UnknownTag
     */
    public static function create($tagName, $content = '') {
        if (isset(self::$tagClassMap[$tagName])) {
            $class = self::$tagClassMap[$tagName];
            return new $class($content);
        } else {
            return new UnknownTag($tagName, $content);
        }
    }

}
