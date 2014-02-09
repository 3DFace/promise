<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;


class CallbackTest extends PromiseTest {

	function testFailedCallback(){
		$x = new CallbackPromise(function(){
			throw new \Exception(1);
		});
		$this->assertRejected($x);
	}

	function testFulfilledCallback(){
		$x = new CallbackPromise(function($fulfill){
			$fulfill(1);
		});
		$this->assertFulfilled($x);
	}

	function testRejectedCallback(){
		/** @noinspection PhpUnusedParameterInspection */
		$x = new CallbackPromise(function($fulfill, $reject){
			$reject(1);
		});
		$this->assertRejected($x);
	}

}
