<?php

namespace App\Models;

use App\DTOs\ArticlesController\StoreRequestDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static find(int $articleId)
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property string $title
 * @property string $text
 * @property string|null $thumbnail
 */
class Article extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public static function createFromDTO(int $userId, StoreRequestDTO $dto): Article
    {
        $article = new Article();
        $article->team_id = $dto->getTeamId();
        $article->user_id = $userId;
        $article->title = $dto->getTitle();
        $article->text = $dto->getText();
        $article->save();
        return $article;
    }

    public static function updateFromDTO(Article $article, StoreRequestDTO $dto): void
    {
        $article->team_id = $dto->getTeamId();
        $article->title = $dto->getTitle();
        $article->text = $dto->getText();
        $article->save();
    }

    public static function createArticle(
        int $id,
        int $userId,
        int $teamId,
        string $title,
        string $text,
        ?string $thumbnail = null
    ): Article
    {
        $article = new Article();
        $article->id = $id;
        $article->user_id = $userId;
        $article->team_id = $teamId;
        $article->title = $title;
        $article->text = $text;
        $article->thumbnail = $thumbnail;
        $article->save();
        return $article;
    }
}
