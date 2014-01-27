<?php

namespace NoizuLabs\Core\Tests\Suites\Unit;

class UnitTestBase extends \NoizuLabs\PHPConform\PHPUnitExtension\ScenarioSuite
{
    protected $container;
    public function setUp()
    {
        global $container;
        $this->container = $container;

    }



}
