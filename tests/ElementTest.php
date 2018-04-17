<?php
declare(strict_types=1);

namespace Aidantwoods\PreparedHTML\Tests;

use PHPUnit\Framework\TestCase;
use Aidantwoods\PreparedHTML\Element;

class ElementTests extends TestCase
{
    public function testNormalElement()
    {
        $Element = new Element('foo', 'bar');

        $Element['alt'] = 'foo';

        $this->assertSame('<foo alt="foo">bar</foo>', $Element->getHtml());
    }

    public function testBadAttribute()
    {
        $Element = new Element('foo', 'bar');
        $Element['alt'] = 'foo';

        $Element['><script>alert("xss!")</script><a'] = '"><script>alert("xss!")</script><a a="';

        $this->assertSame(
            '<foo alt="foo" <scriptalert(xss!)<script<a="&quot;&gt;&lt;script&gt;alert(&quot;xss!&quot;)&lt;/script&gt;&lt;a a=&quot;">bar</foo>',
            $Element->getHtml()
        );
    }

    public function testAddSubElement()
    {
        $Element = new Element('foo', 'bar');
        $Element['alt'] = 'foo';
        $Element['><script>alert("xss!")</script><a'] = '"><script>alert("xss!")</script><a a="';

        $Element->addElement(new Element('b', 'baz'));

        $this->assertSame(
            '<foo alt="foo" <scriptalert(xss!)<script<a="&quot;&gt;&lt;script&gt;alert(&quot;xss!&quot;)&lt;/script&gt;&lt;a a=&quot;">bar<b>baz</b></foo>',
            $Element->getHtml()
        );
    }

    public function testBadElement()
    {
        $Element = new Element('foo', 'bar');
        $Element['alt'] = 'foo';
        $Element['><script>alert("xss!")</script><a'] = '"><script>alert("xss!")</script><a a="';
        $Element->addElement(new Element('b', 'baz'));

        $Element->addElement(new Element('><script>alert("xss!!!!")</script><a', 'zoom'));
        $Element->addElement(new Element('doom', '<script>alert("xss!!!!")</script>'));

        $this->assertSame(
            '<foo alt="foo" <scriptalert(xss!)<script<a="&quot;&gt;&lt;script&gt;alert(&quot;xss!&quot;)&lt;/script&gt;&lt;a a=&quot;">bar<b>baz</b><scriptalertxssscripta>zoom</scriptalertxssscripta><doom>&lt;script&gt;alert("xss!!!!")&lt;/script&gt;</doom></foo>',
            $Element->getHtml()
        );
    }
}
