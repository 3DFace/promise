<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class RaceTest extends PromiseTest {

	function testRaceFulfilled(){
		/** @var Deferred[] $promises */
		$promises = [new Deferred(), new Deferred(), new Deferred()];
		$race = new Race($promises);
		$promises[1]->fulfill(1);
		$promises[0]->fulfill(0);
		$promises[2]->fulfill(2);
		$this->assertFulfilledResult($race, 1);
	}

	function testRaceRejected(){
		/** @var Deferred[] $promises */
		$promises = [new Deferred(), new Deferred(), new Deferred()];
		$race = new Race($promises);
		$promises[1]->reject(1);
		$promises[0]->fulfill(0);
		$promises[2]->fulfill(2);
		$this->assertRejectedReason($race, 1);
	}

}
