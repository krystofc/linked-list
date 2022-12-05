<?php declare(strict_types=1);

namespace LinkedList;

use Closure;
use PHPUnit\Framework\TestCase;

class LinkedListTest extends TestCase{

	public function testAppendOnEmptyList(): void {
		$list = $this->givenEmptyList();
		$this->whenAppendList($list, 123);
		$this->thenListContainsExactOneNode($list, 123);
	}

	public function testAppendList(): void {
		$list = $this->givenListWithNode(1);
		$this->whenAppendList($list, 2);
		$this->thenListContainsSecondLastNodeValue($list, 2);
	}

	public function testInsertBeforeToHead(): void {
		$list = $this->givenListWithNode(1);
		assert($list->getHead() !== null);
		$this->whenInsertBefore($list, $list->getHead(), 0);
		$this->thenListContainsSorterValues($list, [0, 1]);
	}

	public function testInsertBeforeLastItem(): void {
		$list = $this->givenListWithNodes(1, 2, 4);
		assert($list->getLast() !== null);
		$this->whenInsertBefore($list, $list->getLast(), 3);
		$this->thenListContainsSorterValues($list, [1, 2, 3, 4]);
	}

	public function testInsertBeforeNotListedNode(): void {
		$this->expectException(\OutOfBoundsException::class);
		$list = $this->givenListWithNode(1);
		$node = $this->givenNode(1);
		$this->whenInsertBefore($list, $node, 5);
	}

	public function testInsertAfterHead(): void {
		$list = $this->givenListWithNodes(1, 3, 4);
		assert($list->getHead() !== null);
		$this->whenInsertAfter($list, $list->getHead(), 2);
		$this->thenListContainsSorterValues($list, [1, 2, 3, 4]);
	}

	public function testInsertAfterLastNode(): void {
		$list = $this->givenListWithNode(1);
		assert($list->getHead() !== null);
		$this->whenInsertAfter($list, $list->getHead(), 2);
		$this->thenListContainsSorterValues($list, [1, 2]);
	}

	public function testFindNodeHead(): void {
		$list = $this->givenListWithNodes(1, 2, 3);
		$found = $this->whenFindNode($list, fn(Node $node): bool => true);
		$this->thenNodeHasValue($found, 1);
	}

	public function testFindListNode(): void {
		$list = $this->givenListWithNodes(1, 2, 3);
		$found = $this->whenFindNode($list, fn(Node $node): bool => $node->getNextNode() === null);
		$this->thenNodeHasValue($found, 3);
	}

	/**
	 * @return LinkedList<int>
	 */
	private function givenEmptyList(): LinkedList {
		return new IntLinkedList();
	}

	/**
	 * @param  LinkedList<int> $list
	 */
	private function whenAppendList(LinkedList $list, int $value): void {
		$list->append($value);
	}

	/**
	 * @param LinkedList<int> $list
	 */
	private function thenListContainsExactOneNode(LinkedList $list, int $value): void {
		$this->assertSame($value, $list->getHead()?->getValue());
		$this->assertNull($list->getHead()->getNextNode());
	}

	/**
	 * @return LinkedList<int>
	 */
	private function givenListWithNode(int $value): LinkedList {
		return new LinkedList(new Node($value, null));
	}

	/**
	 * @param LinkedList<int> $list
	 */
	private function thenListContainsSecondLastNodeValue(LinkedList $list, int $value): void {
		$this->assertSame($value, $list->getHead()?->getNextNode()?->getValue());
		$this->assertNull($list->getHead()->getNextNode()->getNextNode());
	}

	/**
	 * @param LinkedList<int> $list
	 * @param Node<int> $node
	 */
	private function whenInsertBefore(LinkedList $list, Node $node, int $value): void {
		$list->insertBefore($value, $node);
	}

	/**
	 * @param LinkedList<int> $list
	 * @param Node<int> $node
	 */
	private function whenInsertAfter(LinkedList $list, Node $node, int $value): void {
		$list->insertAfter($value, $node);
	}

	/**
	 * @param LinkedList<int> $list
	 */
	private function thenListContainsSorterValues(LinkedList $list, array $expected): void {
		$this->assertSame($list->toArray(), $expected);
	}

	/**
	 * @return LinkedList<int>
	 */
	private function givenListWithNodes(int ...$values): LinkedList {
		$list = new LinkedList;
		foreach ($values as $value) {
			$list->append($value);
		}
		return $list;
	}

	/**
	 * @return Node<int>
	 */
	private function givenNode(int $value): Node {
		return new Node($value, null);
	}

	/**
	 * @param LinkedList<int> $list
	 */
	private function whenFindNode(LinkedList $list, Closure $predicate): ?Node {
		return $list->findNode($predicate);
	}

	/**
	 * @param Node<int> $node
	 */
	private function thenNodeHasValue(?Node $found, int $value): void {
		$this->assertSame($found->getValue(), $value);
	}
}
