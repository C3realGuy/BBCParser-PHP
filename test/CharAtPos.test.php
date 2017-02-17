<?php

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../src/BBCParser.php');

class CharAtPosTest extends TestCase {

  /**
   * [testCharAtPos description]
   * @dataProvider charAtPosProvider
   * @author test
   * @version 1.0
   * @date 12.1.17
   * @param  String $message  [description]
   * @param  int $pos      [description]
   * @param  char $expected [description]
   * @return void
   */
  public function testCharAtPos($message, $pos, $expected) {
    $this->assertEquals($expected, charAtPos($message, $pos));
  }

  /**
   * [charAtPosProvider description]
   * @dataProvider {dataProvider}
   * @author test
   * @return       [type]         [description]
   */
  public function charAtPosProvider() {
    return [
             ['lorem ipsum', 0, 'l'],
             ['lorem ipsum', 6, 'i'],
             ['lorem ipsum', -1, 'm'],
             ['lorem ipsum', 11, '' ]
           ];
  }
}
