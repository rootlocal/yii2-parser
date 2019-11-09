<?php


namespace rootlocal\parser\helpers;

/**
 * Class Parsedown
 * @package rootlocal\parser\helpers
 * https://github.com/erusev/parsedown/wiki/Tutorial:-Create-Extensions#add-inline-element
 */
class Parsedown extends \Parsedown
{

    function __construct()
    {
        //$this->InlineTypes['{'][] = 'ColoredText';
        //$this->inlineMarkerList .= '{';
    }

    /**
     * This example adds a ColoredText element. You can find a description of this element at
     *
     * @example
     * {c:red}my text{/c}
     * {c:#ffffff}my text{/c}
     * @param $excerpt
     * @return array
     */
   /* protected function inlineColoredText($excerpt)
    {
        if (preg_match('/^{c:([#\w]\w+)}(.*?){\/c}/', $excerpt['text'], $matches)) {
            return array(

                // How many characters to advance the Parsedown's
                // cursor after being done processing this tag.
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'span',
                    'text' => $matches[2],
                    'attributes' => array(
                        'style' => 'color: ' . $matches[1],
                    ),
                ),

            );
        }

        return $excerpt;
    }*/


    /**
     * @param $excerpt
     * @return array|null|void
     */
    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);

        if (!isset($image)) {
            return null;
        }

        if (!isset($image['element']['attributes']['alt']) || empty($image['element']['attributes']['alt'])) {
            $image['element']['attributes']['alt'] = '';
        }
        $image['element']['attributes']['class'] = 'img mx-auto d-block img-responsive img-thumbnail';

        return $image;
    }
}