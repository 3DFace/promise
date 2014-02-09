<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class DeferredTest extends PromiseTest {

	function testResolvedToFulfill(){
		$x = new Deferred();
		$x->fulfill(1);
		$this->assertFulfilled($x);
	}

	function testResolvedToReject(){
		$x = new Deferred();
		$x->reject(1);
		$this->assertRejected($x);
	}

	function testNotResolved(){
		$x = new Deferred();
		$this->assertNotResolved($x);
	}

}
