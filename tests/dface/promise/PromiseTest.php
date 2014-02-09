<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class PromiseTest extends \PHPUnit_Framework_TestCase {

	/** @var callable[]  */
	protected $delayed = [];

	protected function resolveDelayed(){
		while($func = array_shift($this->delayed)){
			call_user_func($func);
		}
	}

	protected function fulfilLater($value){
		return new CallbackPromise(function ($fulfil) use ($value){
			$this->delayed[] = function () use ($fulfil, $value){
				$fulfil($value);
			};
		});
	}

	protected function rejectLater($value){
		return new CallbackPromise(function ($fulfil, $reject) use ($value){
			$this->delayed[] = function () use ($reject, $value){
				$reject($value);
			};
		});
	}

	protected function checkThen(Promise $promise){
		$fulfilled = false;
		$fulfilled_result = null;
		$rejected = false;
		$rejected_reason = null;
		$promise->then(function($val) use (&$fulfilled, &$fulfilled_result){
			$fulfilled = true;
			$fulfilled_result = $val;
		},function($val) use (&$rejected, &$rejected_reason){
			$rejected = true;
			$rejected_reason = $val;
		});
		return [$fulfilled, $rejected, $fulfilled_result, $rejected_reason];
	}

	protected function assertFulfilled(Promise $promise){
		list($fulfilled) = $this->checkThen($promise);
		$this->assertTrue($fulfilled, "not fulfilled");
	}

	protected function assertFulfilledResult(Promise $promise, $expected){
		list($fulfilled, , $fulfilled_result) = $this->checkThen($promise);
		$this->assertTrue($fulfilled, "not fulfilled");
		$this->assertEquals($expected, $fulfilled_result);
	}

	protected function assertNotFulfilled(Promise $promise){
		list($fulfilled) = $this->checkThen($promise);
		$this->assertFalse($fulfilled, "fulfilled");
	}

	protected function assertRejected(Promise $promise){
		list(, $rejected) = $this->checkThen($promise);
		$this->assertTrue($rejected, "not rejected");
	}

	protected function assertRejectedReason(Promise $promise, $expected){
		list(, $rejected, ,$rejected_reason) = $this->checkThen($promise);
		$this->assertTrue($rejected, "not rejected");
		if($rejected_reason instanceof \Exception){
			$this->assertEquals($expected, $rejected_reason->getMessage());
		}else{
			$this->assertEquals($expected, $rejected_reason);
		}
	}

	protected function assertNotRejected(Promise $promise){
		list(, $rejected) = $this->checkThen($promise);
		$this->assertFalse($rejected, "rejected");
	}

	protected function assertNotResolved(Promise $promise){
		list($fulfilled, $rejected) = $this->checkThen($promise);
		$this->assertFalse($fulfilled || $rejected, "resolved");
	}

	protected function assertResolved(Promise $promise){
		list($fulfilled, $rejected) = $this->checkThen($promise);
		$this->assertTrue($fulfilled || $rejected, "not resolved");
	}

}
