<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class AllTest extends PromiseTest {

	function testAllFulfilledInOrder(){
		$p1 = new Deferred();
		$p2 = new Deferred();
		$p3 = new Deferred();
		$x = new All([$p1, $p2, $p3]);
		$p3->fulfill(3);
		$p2->fulfill(2);
		$p1->fulfill(1);
		$this->assertFulfilledResult($x, [1,2,3]);
	}

	function testFirstRejected(){
		$p1 = new Deferred();
		$p2 = new Deferred();
		$p3 = new Deferred();
		$x = new All([$p1, $p2, $p3]);
		$p3->fulfill(3);
		$p2->reject(2);
		$p1->reject(1);
		$this->assertRejectedReason($x, 2);
	}

}
