<?php declare(strict_types=1);

namespace LinkedList;

/**
 * @template T of int|string
 */
class Node {

	/**
	 * @param T $value
	 * @param Node<T>|null $nextNode
	 */
	public function __construct(
		private int|string $value,
		private Node|null $nextNode,
	) {}

	/**
	 * @return T
	 */
	public function getValue(): int|string {
		return $this->value;
	}

	/**
	 * @return Node<T>|null
	 */
	public function getNextNode(): Node|null {
		return $this->nextNode;
	}

	/**
	 * @param Node<T> $node
	 */
	public function setNextNode(Node $node): void {
		$this->nextNode = $node;
	}
}
