<?php
/**
 * This file is tiptop
 */

/**
 * Asd
 */
class Test
{
    /**
     * Blubb
     *
     * @dataProvider Asd
     * @date         2017-02-17
     * @anotherdate  2017-02-17T02:19:15+010
     * @return       void
     */
    function test()
    {
    }
}

/**
 * [test description]
 *
 * @dataProvider {{dataProvider}}
 * @date         2017-02-17
 * @anotherdate  2017-02-17T02:17:27+010
 * @param        integer $test Aasdasd.
 * @param        string  $as   Test.
 * @return       void
 */
function test(int $test, string $as)
{
    $test = 'blubb'.$as;
    // ToDo: Add blubb
    'test';
}

/**
 * [test2 description]
 *
 * @dataProvider {{dataProvider}}
 * @date         2017-02-17
 * @anotherdate  2017-02-17T02:34:08+010
 * @param        integer $arsch This is blubb.
 * @param        boolean $blubb This is test.
 * @return       void
 */
function test2(int $arsch, bool $blubb)
{
}

test('abc', 'test');

if (test && blub) {
    for ($i=0; $i<s; $i++) {
        $test = 'blubb';
    }
}
