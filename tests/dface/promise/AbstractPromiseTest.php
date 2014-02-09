<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class AbstractPromiseTest  extends PromiseTest {

	function testTrapNotReachedByFulfill(){
		$reached = false;
		$x = new Deferred();
		$x->trap(function() use (&$reached){
			$reached = true;
		});
		$x->fulfill();
		$this->assertFalse($reached, '"trap" called on fulfill');
	}

	function testTrapReachedByReject(){
		$reached = false;
		$x = new Deferred();
		$x->trap(function() use (&$reached){
			$reached = true;
		});
		$x->reject();
		$this->assertTrue($reached, '"trap" is not reachable');
	}

	function testEndReachedByFulfill(){
		$reached = false;
		$x = new Deferred();
		$x->end(function() use (&$reached){
			$reached = true;
		});
		$x->fulfill();
		$this->assertTrue($reached, '"end" is not reachable');
	}

	function testEndReachedByReject(){
		$reached = false;
		$x = new Deferred();
		$x->end(function() use (&$reached){
			$reached = true;
		});
		$x->reject();
		$this->assertTrue($reached, '"end" is not reachable');
	}

} 
