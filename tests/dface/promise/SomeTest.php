<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class SomeTest extends PromiseTest {

	function testSome(){
		$promises = [new Rejected(1), new Fulfilled(2), new Fulfilled(3)];
		$this->assertRejectedReason(new Some($promises, 3), [0=>1]);
		$this->assertFulfilledResult(new Some($promises, 2), [1=>2, 2=>3]);
	}

	function testSomeBadConstructed(){
		$promises = [new Rejected(1), new Fulfilled(2), new Fulfilled(3)];
		$ex = null;
		try{
			new Some($promises, 5);
		}catch(\Exception $e){
			$ex = $e;
		}
		$this->assertNotNull($ex, "it must fail");
	}

}
