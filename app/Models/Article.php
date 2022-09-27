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

    public static function createFromDTO(StoreRequestDTO $dto): Article
    {
        $article = new Article();
        $article->team_id = $dto->getTeamId();
        $article->user_id = $dto->getUserId();
        $article->title = $dto->getTitle();
        $article->text = $dto->getText();
        $article->save();
        return $article;
    }

    public static function updateFromDTO(Article $article, StoreRequestDTO $dto): void
    {
        $article->team_id = $dto->getTeamId();
        $article->user_id = $dto->getUserId();
        $article->title = $dto->getTitle();
        $article->text = $dto->getText();
        $article->save();
    }
}
