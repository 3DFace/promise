<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class RejectedTest extends PromiseTest {

	function testPlainReason(){
		$this->assertRejectedReason(new Rejected(1), 1);
	}

	function testRejectedReason(){
		$this->assertRejectedReason(new Rejected(new Rejected(1)), 1);
	}

	function testRejectedFulfilledResult(){
		$this->assertRejectedReason(new Rejected(new Fulfilled(1)), 1);
	}

	function testAsyncRejectedReason(){
		$x = $this->rejectLater(1);
		$this->resolveDelayed();
		$this->assertRejectedReason($x, 1);
	}

	function testRepairFailed(){
		$x = new Deferred();
		$y = $x->trap(function(){
			throw new \Exception("on_reject failed");
		});
		$x->reject(1);
		$this->assertRejectedReason($y, "on_reject failed");
	}

}
