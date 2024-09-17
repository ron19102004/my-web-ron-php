<?php
class Post
{
    public $id;
    public $title;
    public $context;
    public $category_id;
    public $created_at;
    public $hidden;
    public $slug;

    public function __construct(int $id, string $title, string $context, int $category_id, string $created_at, int $hidden,$slug)
    {
        $this->id = $id;
        $this->title = $title;
        $this->context = $context;
        $this->category_id = $category_id;
        $this->created_at = $created_at;
        $this->hidden = $hidden;
        $this->slug = $slug;
    }

    public static function fromArray(array $data): Post
    {
        $compressed_data_from_db = base64_decode($data['context']);
        $decompressed_data = gzuncompress($compressed_data_from_db); 
        return new Post(
            $data['id'],
            $data['title'],
            $decompressed_data,
            $data['category_id'],
            $data['created_at'],
            $data['hidden'],
            $data['slug']
        );
    }
}
