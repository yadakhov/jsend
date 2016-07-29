<?php

use Yadakhov\Jsend;

class JsendTest extends BootstrapTest
{
    public function testSimpleObject()
    {
        $jsend = new Jsend();

        $this->assertTrue($jsend->isSuccess());
        $this->assertFalse($jsend->isFail());
        $this->assertFalse($jsend->isError());
        $this->assertEquals('success', $jsend->getStatus());
        $this->assertEquals('{"status":"success","data":null}', $jsend->toString());
        $this->assertEquals(['status' => 'success', 'data' => null], $jsend->toArray());
    }

    public function testGetInstance()
    {
        $jsend = Jsend::getInstance();

        $this->assertTrue($jsend->isSuccess());
        $this->assertFalse($jsend->isFail());
        $this->assertFalse($jsend->isError());
        $this->assertEquals('success', $jsend->getStatus());
        $this->assertEquals('{"status":"success","data":null}', $jsend->toString());
        $this->assertEquals(['status' => 'success', 'data' => null], $jsend->toArray());
    }

    public function testGetFailInstance()
    {
        $jsend = Jsend::getFailInstance();

        $this->assertTrue($jsend->isFail());
        $this->assertFalse($jsend->isSuccess());
        $this->assertFalse($jsend->isError());
        $this->assertEquals('fail', $jsend->getStatus());
        $this->assertEquals('{"status":"fail","data":null}', $jsend->toString());
        $this->assertEquals(['status' => 'fail', 'data' => null], $jsend->toArray());
    }

    public function testGetErrorInstance()
    {
        $jsend = Jsend::getErrorInstance();

        $this->assertTrue($jsend->isError());
        $this->assertFalse($jsend->isSuccess());
        $this->assertFalse($jsend->isFail());
        $this->assertEquals('error', $jsend->getStatus());
        $this->assertEquals('{"status":"error","message":null}', $jsend->toString());
        $this->assertEquals(['status' => 'error', 'message' => null], $jsend->toArray());
    }

    /**
     * {
     *   "status" : "success",
     *   "data" : {
     *     "post" : { "id" : 1, "title" : "A blog post", "body" : "Some useful content" }
     *   }
     */
    public function testBasicJsendCompliantResponse()
    {
        $data = [
            'post' => [
                'id' => 1,
                'title' => 'A blog post',
                'body' => 'Some useful content',
            ]
        ];

        $jsend = Jsend::getInstance()->setData($data);

        $this->assertEquals('success', $jsend->getStatus());
        $this->assertEquals('{"status":"success","data":{"post":{"id":1,"title":"A blog post","body":"Some useful content"}}}', $jsend->toJson());
    }

    public function testBasicError()
    {
        $jsend = Jsend::getInstance()->setStatus('error')->setMessage('Unable to communicate with database');

        $this->assertEquals('{"status":"error","message":"Unable to communicate with database"}', $jsend);
    }
}
