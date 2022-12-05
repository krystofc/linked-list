<?php declare(strict_types=1);

namespace LinkedList;

/**
 * @template T of Node
 */
class LinkedList {

	/**
	 * @param T|null $head
	 */
	public function __construct(
		private Node|null $head = null
	) {
	}

	/**
	 * @return T|null
	 */
	public function getHead(): ?Node {
		return $this->head;
	}

	public function isEmpty(): bool {
		return $this->head === null;
	}
}
