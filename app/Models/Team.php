<?php

namespace App\Models;

use App\DTOs\TeamsController\StoreRequestDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property mixed $articles
 * @method static find(int $teamId)
 */
class Team extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_team');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public static function createFromDTO(int $userId, StoreRequestDTO $dto): Team
    {
        $team = new Team();
        $team->user_id = $userId;
        $team->title = $dto->getTitle();
        $team->description = $dto->getDescription();
        $team->save();
        return $team;
    }

    public static function updateFromDTO(Team $team, StoreRequestDTO $dto): void
    {
        $team->title = $dto->getTitle();
        $team->description = $dto->getDescription();
        $team->save();
    }

    public static function createTeam(int $id, int $teamCreatorId, string $title, string $description): Team
    {
        $team = new Team();
        $team->id = $id;
        $team->user_id = $teamCreatorId;
        $team->title = $title;
        $team->description = $description;

        $team->save();
        return $team;
    }
}
