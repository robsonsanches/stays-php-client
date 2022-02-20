<?php
namespace RobsonSanches\Stays\Client\Tests;

use PHPUnit\Framework\TestCase;
use RobsonSanches\Stays\Client\Helper;

class HelperTest extends TestCase
{

    public function testRemoveLeadingSlash()
    {
        $string = '/endpoint';
        $string = Helper::removeLeadingSlash($string);

        $this->assertEquals('endpoint',$string);
    }

    public function testRemoveTrailingSlash()
    {
        $string = 'endpoint/';
        $string = Helper::removeTrailingSlash($string);
        
        $this->assertEquals('endpoint',$string);
    }

    public function testRemoveSlashes()
    {

        $string = '/endpoint/';
        $string = Helper::removeSlashes($string);
        
        $this->assertEquals('endpoint',$string);

    }

}