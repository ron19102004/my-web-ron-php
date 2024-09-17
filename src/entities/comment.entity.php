<?php 
class Comment
{
    public $id;
    public $post_id;
    public $user_id;
    public $reply_id;
    public $content;
    public $created_at;

    public function __construct(int $id, int $post_id, int $user_id, ?int $reply_id, string $content, string $created_at)
    {
        $this->id = $id;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->reply_id = $reply_id;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    public static function fromArray(array $data): Comment
    {
        return new Comment(
            $data['id'],
            $data['post_id'],
            $data['user_id'],
            $data['reply_id'] ?? null, // Reply ID có thể là null
            $data['content'],
            $data['created_at']
        );
    }
}