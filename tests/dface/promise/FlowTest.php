<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class FlowTest extends PromiseTest {

	function testFulfilledFlow(){
		$x = new Flow(function () {
			$v = 0;
			$v = (yield $this->fulfilLater($v)) + 1;
			$v = (yield $this->fulfilLater($v)) + 1;
			yield $v;
		});
		$this->resolveDelayed();
		$this->assertFulfilledResult($x, 2);
	}

	function testRejectedFlow(){
		$x = new Flow(function (){
			$v = 0;
			$v = (yield $this->rejectLater(new \Exception($v))) + 1;
			$v = (yield $this->fulfilLater($v)) + 1;
			yield $v;
		});
		$this->resolveDelayed();
		$this->assertRejectedReason($x, 0);
	}

	function testExceptedFlow(){
		$x = new Flow(function () {
			$v = 0;
			$v = (yield $this->fulfilLater($v)) / 0;
			$v = (yield $this->fulfilLater($v)) + 1;
			yield $v;
		});
		$this->resolveDelayed();
		$this->assertRejectedReason($x, 'Division by zero');
	}

	function testNotOverflow(){
		$cycles = 1000;
		$max_nesting_level = 100;
		$nesting_level = 0;

		$x = new Flow(function () use ($cycles, &$nesting_level) {
			$v = 0;
			while($v < $cycles){
				$v = (yield $this->fulfilLater($v)) + 1;
				$e = new \Exception();
				$nesting_level = max($nesting_level, count($e->getTrace()));
			}
			yield $v;
		});
		$this->resolveDelayed();
		$this->assertFulfilledResult($x, $cycles);
		$this->assertLessThan($max_nesting_level, $nesting_level);
	}

}
