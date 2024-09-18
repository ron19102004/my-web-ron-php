<?php
class Category
{
    public $id;
    public $name;
    public $slug;

    public function __construct(int $id, string $name, string $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function fromArray(array $data): Category
    {
        return new Category(
            $data['id'],
            $data['name'],
            $data['slug']
        );
    }
}