<?php declare(strict_types=1);

namespace LinkedList;

use OutOfBoundsException;

/**
 * @template T of int|string
 */
class LinkedList {

	/**
	 * @param Node<T>|null $head
	 */
	public function __construct(
		private Node|null $head = null
	) {
	}

	/**
	 * @return Node<T>|null
	 */
	public function getHead(): ?Node {
		return $this->head;
	}

	public function isEmpty(): bool {
		return $this->head === null;
	}

	/**
	 * @param T $value
	 * @param Node<T> $nodeAfter
	 */
	public function insertBefore(int|string $value, Node $nodeAfter): void {
		if ($nodeAfter === $this->head) {
			$this->head = new Node($value, $this->head);
			return;
		}
		$nodeBefore = $this->findNode(fn(Node $node): bool => $node->getNextNode() === $nodeAfter);
		if ($nodeBefore === null) {
			throw new OutOfBoundsException("List doesn't contains this node");
		}
		$newNode = new Node($value, $nodeBefore->getNextNode());
		$nodeBefore->setNextNode($newNode);
	}

	/**
	 * @param T $value
	 * @param Node<T> $node
	 */
	public function insertAfter(int|string $value, Node $node): void {
		$newNode = new Node($value, $node->getNextNode());
		$node->setNextNode($newNode);
	}

	/**
	 * @param T $value
	 */
	public function append(int|string $value): void {
		$last = $this->getLast();
		$newNode = new Node($value, null);
		if ($last === null) {
			$this->head = $newNode;
		} else {
			$last->setNextNode($newNode);
		}
	}

	/**
	 * @return Node<T>|null
	 */
	public function getLast(): ?Node {
		return $this->findNode(fn(Node $node): bool => $node->getNextNode() === null);
	}

	/**
	 * @param callable(Node<T>): bool $predicate
	 * @return Node<T>|null
	 */
	public function findNode(callable $predicate): ?Node {
		$node = $this->head;
		while ($node !== null) {
			if ($predicate($node)) {
				return $node;
			}
			$node = $node->getNextNode();
		}
		return null;
	}

	/**
	 * @return T[]
	 */
	public function toArray(): array{
		$node = $this->head;
		$values = [];
		while ($node !== null) {
			$values[] = $node->getValue();
			$node = $node->getNextNode();
		}
		return $values;
	}
}
