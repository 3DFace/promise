<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class ThenTest extends PromiseTest {

	function testFulfilledValue(){
		$x = new Deferred();
		$y = $x->then(function ($result){
				$this->assertEquals(1, $result);
				return 2;
			}
		)->then(function ($result){
					$this->assertEquals(2, $result);
					return 3;
				}
			);
		$x->fulfill(1);
		$this->assertFulfilledResult($y, 3);
	}

	function testRejectedValue(){
		$x = new Deferred();
		$y = $x->trap(function ($reason){
			$this->assertEquals(1, $reason);
			return 2;
		})->then(function ($result){
			$this->assertEquals(2, $result);
			throw new \Exception(3);
		})->trap(function ($e){
			/** @var \Exception $e */
			$this->assertEquals(3, $e->getMessage());
			return 4;
		});
		$x->reject(1);
		$this->assertFulfilledResult($y, 4);
	}

	function testDisposable(){
		$v = 0;
		$x = new Deferred();
		$y = $x->then(function ($result) use (&$v){
				$v++;
				return $result;
			}
		);
		$z = new Deferred();
		$x->resolve($z);
		$z->fulfill(1);
		$z->fulfill(2);
		$x->fulfill(3);
		$x->reject(1);
		$this->assertFulfilledResult($x, 1);
		$this->assertFulfilledResult($y, 1);
		$this->assertFulfilledResult($z, 1);
		$this->assertEquals(1, $v);
	}

}
