<?php

class Set
{
    private array $members;
    private bool $strictMode;

    public function __construct(bool $strictMode = true)
    {
        $this->members = [];
        $this->strictMode = $strictMode;
    }

    /**
     * Returns all members of the set
     */
    public function getItems()
    {
        return $this->members;
    }

    /**
     * Returns a member of the set from given index
     * @var index - Given index number
     */
    public function getItem(int $index)
    {
        if ($index < 0 || $index > (count($this->members) - 1)) {
            throw new Exception('Index out of bounds.');
            return;
        }

        return $this->members[$index];
    }

    /**
     * Checks if item is a member of the set
     * @var item - The needle
     * @return Bool - true is item is member of the set
     */
    public function contains($item): bool
    {
        return in_array($item, $this->members, $this->strictMode);
    }

    /**
     * Adds item(s) to the set if not exists
     * @var items - The supplied item(s)
     */
    public function add(...$items)
    {
        foreach ($items as $item) {
            if ($this->contains($item)) {
                continue;
            }
            $this->members[] = $item;
        }

        return $this;
    }

    /**
     * Removes item(s) from the set if exists
     * @var items - The supplied item(s)
     */
    public function remove(...$items)
    {
        foreach ($items as $item) {
            array_splice(
                $this->members,
                array_search($item, $this->members, $this->strictMode),
            );
        }

        return $this;
    }

    /**
     * Clears all item(s) from the set if exists
     * @var items - The supplied item(s)
     */
    public function clear()
    {
        unset($this->members);
        $this->members = [];

        return $this;
    }

    /**
     * Returns the union of sets
     * @var set - Given set
     */
    public function union(Set $set)
    {
        $newSet = new Set();
        $newSet->add(...$this->getItems());
        $items = $set->getItems();

        foreach ($items as $item) {
            $newSet->add($item);
        }

        return $newSet;
    }

    /**
     * Returns the intersection of sets
     * @var set - Given set
     */
    public function intersect(Set $set)
    {
        $newSet = new Set();
        $items = $set->getItems();

        foreach ($items as $item) {
            if ($this->contains($item)) {
                $newSet->add($item);
            }
        }

        return $newSet;
    }

    /**
     * Returns the difference of sets
     * @var set - Given set
     */
    public function difference(Set $set)
    {
        $newSet = new Set();

        foreach ($this->members as $member) {
            if ($set->contains($member)) {
                continue;
            }
            $newSet->add($member);
        }

        return $newSet;
    }

    /**
     * Returns the complement of sets
     * @var set - Given set
     */
    public function complement(Set $set)
    {
        return $set->difference($this);
    }
}
