<?php
/* author: Denis Ponomarev <ponomarev@gmail.com> */

namespace dface\promise;

class Link extends AbstractPromise {

	/** @var Deferred[] */
	protected $followers = [];
	/** @var Promise */
	protected $resolved;
	protected $on_fulfill;
	protected $on_reject;

	protected function __construct(callable $on_fulfill = null, callable $on_reject = null){
		$this->on_fulfill = $on_fulfill;
		$this->on_reject = $on_reject;
	}

	function then(callable $on_fulfill = null, callable $on_reject = null){
		if($this->resolved){
			return $this->resolved->then($on_fulfill, $on_reject);
		}else{
			return $this->followers[] = new self($on_fulfill, $on_reject);
		}
	}

	protected function resolve(Promise $promise){
		if(!$this->resolved){
			$this->resolved = $promise->then($this->on_fulfill, $this->on_reject);
			foreach($this->followers as $f){
				$f->resolve($this->resolved);
			}
			$this->followers = [];
		}
	}

}
