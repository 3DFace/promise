<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class LinkTest extends PromiseTest {

	function testAncestorsResolvedToFulfill(){
		$p1 = new Deferred();
		$p2 = $p1->then();
		$p3 = $p2->then();
		$p1->fulfill(1);
		$this->assertFulfilled($p2);
		$this->assertFulfilled($p3);
	}

	function testAncestorsResolvedToReject(){
		$p1 = new Deferred();
		$p2 = $p1->then();
		$p3 = $p2->then();
		$p1->reject(1);
		$this->assertRejected($p2);
		$this->assertRejected($p3);
	}

	function testAncestorsNotResolved(){
		$p1 = new Deferred();
		$p2 = $p1->then();
		$p3 = $p2->then();
		$this->assertNotResolved($p2);
		$this->assertNotResolved($p3);
	}

	function testDeep1(){
		$d1 = new Deferred();
		$d2 = new Deferred();
		$d3 = new Deferred();
		$x = $d1->then()->then()->then();
		$d1->resolve($d2);
		$d2->resolve($d3);
		$d3->fulfill(1);
		$this->assertFulfilledResult($x, 1);
	}

	function testDeep2(){
		$d1 = new Deferred();
		$d2 = new Deferred();
		$d3 = new Deferred();
		$x1 = $d1->then();
		$x2 = $d1->then();
		$x3 = $d1->then();
		$d1->resolve($d2);
		$d2->resolve($d3);
		$d3->fulfill(1);
		$this->assertFulfilledResult($x1, 1);
		$this->assertFulfilledResult($x2, 1);
		$this->assertFulfilledResult($x3, 1);
	}

	function testCapture(){
		$d = new Deferred();
		$v1 = 0;
		$v2 = 0;
		$d->then(function()use(&$v1){
			$v1 = 1;
		})->then(function()use(&$v1){
			$v1 = 2;
		})->trap(function($reason)use(&$v2){
			$v2 = $reason;
		});
		$d->reject(5);
		$this->assertEquals(0, $v1);
		$this->assertEquals(5, $v2);
	}

}
