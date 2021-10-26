<?php

/** @not-serializable */
class swoole_table {
	public function __construct(int $table_size, ?float $conflict_proportion = 1.0) {}
	public function column(string $name, string $type, ?int $size): void {}
	public function create(): bool {}
	public function destroy(): bool {}
	public function set(string $key, array $value): bool {}
	public function get(string $key, string $field): array|bool {}
	public function count(): int {}
	public function del(string $key): bool {}
	public function exists(string $key): bool {}
	public function incr(string $key, string $column, int $incrby): int {}
	public function decr(string $key, string $column, int $decrby): int {}
	public function getSize(): int {}
	public function getMemorySize(): int {}
	public function rewind(): void {}
	public function valid(): bool {}
	public function next(): array|null {}
	public function current(): array|null {}
	public function key(): string|null {}

}