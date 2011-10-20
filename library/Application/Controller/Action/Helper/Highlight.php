<?php

/*

  These classes are used for highlighting, happy css-ing:

  .phpdefault { color:#0000BB; font-weight: bold;}
  .phpkeyword { color:#007700; font-weight: bold;}
  .phpstring  { color:#DD0000; font-weight: normal;}
  .phpcomment { color:#FF8000; font-weight: normal;}

 */
class Application_Controller_Action_Helper_Highlight extends Zend_Controller_Action_Helper_Abstract 
{

    /**
     * Highlights PHP-source snippets with and without php-tags, inserts class definitions on request
     *
     * Strips <code> and <span color:black>, removes empty spans
     *
     * @param string $source Source to highlight
     * @param boolean $classes, true links source elements to classes
     * @return string
     */
    public function direct($source, $classes=false)
    {
        if (version_compare(phpversion(), "5.0.0", "<"))
            return "PHP 5 required";

        $r1 = $r2 = '##';

        // adds required PHP tags (at least with vers. 5.0.5 this is required)
        if (strpos($source, ' ?>') === false) { // xml is not THAT important ;-)
            $source = "<?php " . $source . " ?>";
            $r1 = '#&lt;\?.*?(php)?.*?&nbsp;#s';
            $r2 = '#\?&gt;#s';
        } elseif (strpos($source, '<? ') !== false) {
            $r1 = '--';
            $source = str_replace('<? ', '<?php ', $source);
        }

        $source = highlight_string($source, true);

        if ($r1 == '--')
            $source = preg_replace('#(&lt;\?.*?)(php)?(.*?&nbsp;)#s', '\\1\\3', $source);

        $source = preg_replace(array('/.*<code>\s*<span style="color: #000000">/', //
            '#</span>\s*</code>#', //  <code><span black>
            $r1, $r2, // php tags
            '/<span[^>]*><\/span>/'   // empty spans
                ), '', $source);

        if ($classes)
            $source = str_replace(array('style="color: #0000BB"', 'style="color: #007700"',
                'style="color: #DD0000"', 'style="color: #FF8000"'), array('class="phpdefault"', 'class="phpkeyword"',
                'class="phpstring"', 'class="phpcomment"',), $source);

        return $source;
    }

}