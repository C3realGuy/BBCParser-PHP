<?php
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/BBCParser.php');

class StrBetweenTest extends TestCase {
  /**
   * [testStrBetween description]
   * @dataProvider strBetweenProvider
   * @param  [type]  $message   [description]
   * @param  [type] $pos_start [description]
   * @param  [type] $pos_end   [description]
   * @param  [type] $expected  [description]
   * @return [type]            [description]
   */
  public function testStrBetween($message, $pos_start, $pos_end, $expected) {
    $this->assertEquals($expected, strBetween($message, $pos_start, $pos_end));
  }

  public function strBetweenProvider() {
    return [
      ['lorem ipsum', 0, 3, 'lor'],
      ['lorem ipsum', 3, 0, '']
    ];
  }
}
