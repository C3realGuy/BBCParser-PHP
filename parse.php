<?php

define('BBC_INDEX_PARAMS_FORCE', 1);
define('BBC_INDEX_PARAMS_ALLOW', 2);
define('BBC_INDEX_PARAMS_FORBID', 3);

define('BBC_INDEX_PARAMS_QUOTED_FORCE', 1);
define('BBC_INDEX_PARAMS_QUOTED_ALLOW', 2);
define('BBC_INDEX_PARAMS_QUOTED_FORBID', 3);

define('BBC_ASSOC_PARAMS_FORCE', 1);
define('BBC_ASSOC_PARAMS_ALLOW', 2);
define('BBC_ASSOC_PARAMS_FORBID', 3);

define('BBC_ASSOC_PARAMS_QUOTED_FORCE', 1);
define('BBC_ASSOC_PARAMS_QUOTED_ALLOW', 2);
define('BBC_ASSOC_PARAMS_QUOTED_FORBID', 3);


class BBCParser {
  function __construct() {
    $this->bbcodes = [
      [
        'tag' => 'b',
        'index_params' => BBC_INDEX_PARAMS_FORCE,
        'index_params_quoted' => BBC_INDEX_PARAMS_QUOTED_ALLOW,
        'assoc_params' => BBC_ASSOC_PARAMS_ALLOW,
        'assoc_params_quoted' => BBC_ASSOC_PARAMS_QUOTED_ALLOW,
        'parameters' => ['test'],
        'len' => 1,
      ],
      [
        'tag' => 'code',
        'len' => 4,
      ]
    ];
  }

  function parse($message) {
    usort($this->bbcodes, 'sort_desc_length');

    $messagelen = strlen($message);

    $stop_parsing = false;

    for( $pos = 0; $pos <= $messagelen; $pos++) {
      if($stop_parsing)
        break;
      $char = substr( $message, $pos, 1 );

      if($char == '[') {
        $this_bbc = null;

        foreach($this->bbcodes as $bbc) {
          if(substr( $message, $pos+1, $bbc['len']) == $bbc['tag']) {
            $this_bbc = $bbc;

            $posBehindTag = $pos + $bbc['len'] + 1;

            // even if $this_bbc is defined, we don't know if we have a valid tag found.
            // to make sure we have to find the closing ]
            echo substr($message, $posBehindTag) . "\n";
            $posNextClose = strpos($message, ']', $posBehindTag);

            $params_indexed = null;
            $params_associative = null;
            $valid_bbc = false;

            if($posNextClose === -1) {
              // We didn't find a closing tag at all, so no bbcodes. We can stop here.
              $stop_parsing = true;
              break;
            } else if($posNextClose == $posBehindTag) {
              // Tag is directly closed, so this is for sure fine.
              $valid_bbc = true;
            } else if($this_bbc['allow_index_params'] == true &&
                      $this->charAtPos($message, $posBehindTag) === '=') {
              // Check if we allow quoted index params and if we have a quoted indexed paramater
              if($this_bbc['allow_quoted_index_params'] === true     &&
                 $this->charAtPos($message, $posBehindTag+1) === '"' &&
                 $this->charAtPos($message, $posNextClose-1) === '"') {
                // We are quoted, so the character before the closing bracket has to
                // be an " too.
                $params_indexed = $this->strBetween($message, $posBehindTag+2, $posNextClose-1);
                $valid_bbc = true;
              } else {
                // Not quoted, so we can just look out for the next whitespace,
                // it it's position is behind our closing bracket, everything's fine!
                $posNextWhiteSpace = strpos($message, ' ', $posBehindTag);

                // If we don't find a whitespace or the next whitespace is behind our closing
                // bracket, we definetly have some type of indexed parameters
                if($posNextWhiteSpace === false || $posNextWhiteSpace > $posNextClose) {
                  $params_indexed = substr($message, $posBehindTag+1,
                                           $posNextWhiteSpace-$posBehindTag-1);
                  $valid_bbc = true;
                }
              }
            } else if(isset($this_bbc['parameters']) &&
                      $this->charAtPos($message, $posBehindTag === ' ')) {
              // Maybe some associative paramaters?!
            }

            echo $valid_bbc ? 'true' : 'false'."\n";
            echo $params_indexed;


          }
        }
      }
    }
    return $message;
  }

  function charAtPos($haystack, $pos) {
    return substr($haystack, $pos, 1);
  }

  function strBetween($haystack, $start, $end) {
    return substr($haystack, $start, $end - $start);
  }
}

function sort_desc_length($a,$b){
    return $b['len']-$a['len'];
}

$str = 'Test [b="as d"]blubb[/b]';

$parse = new BBCParser();
$parse->parse($str);
