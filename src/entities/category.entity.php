<?php
class Category
{
    public $id;
    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromArray(array $data): Category
    {
        return new Category(
            $data['id'],
            $data['name']
        );
    }
}