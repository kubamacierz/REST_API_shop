<?php

namespace App\Tests\EventListener;

use App\EventListener\ResponseListener;
use PHPUnit\Framework\TestCase;
use DG\BypassFinals;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListenerTest extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
    }

    public function testHeaderAddition()
    {
        $eventMock = $this->createMock(ResponseEvent::class);

        $eventMock->expects(self::once())
            ->method('getResponse');


        $newResponseListener = new ResponseListener();
        // $newResponseListener->onKernelResponse($eventMock);

    }
}