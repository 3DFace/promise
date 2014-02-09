<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class FulfilledTest extends PromiseTest {

	function testPlainResult(){
		$this->assertFulfilledResult(new Fulfilled(1), 1);
	}

	function testRejectedResult(){
		$this->assertRejectedReason(new Fulfilled(new Rejected(1)), 1);
	}

	function testFulfilledResult(){
		$this->assertFulfilledResult(new Fulfilled(new Fulfilled(1)), 1);
	}

	function testAsyncFulfilledResult(){
		$x = $this->fulfilLater(1);
		$this->resolveDelayed();
		$this->assertFulfilledResult($x, 1);
	}

}
