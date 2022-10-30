<?php

namespace App\Models;

use App\DTOs\RegisterController\StoreRequestDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property mixed $teams
 * @property boolean $is_admin
 * @method static where(string $string, string $string1, string $email)
 * @method static find(int $userId)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'user_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'user_team');
    }

    public static function findByEmail(string $email): ?User
    {
        return self::where('email', '=', $email)->first();
    }

    public static function updateFromDTO(User $user, StoreRequestDTO $dto): void
    {
        $requestName = $dto->getName();
        $requestEmail = $dto->getEmail();
        $requestPassword = $dto->getPassword();

        if (strlen($requestName) > 0) {
            $user->name = $requestName;
        }

        if (strlen($requestEmail) > 0) {
            $user->email = $requestEmail;
        }

        if (strlen($requestPassword) > 0) {
            $user->password = $requestPassword;
        }

        $user->save();
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin == true;
    }

    public static function createUser(int $id, string $email, string $name, string $password, bool $isAdmin = false): User
    {
        $user = new User();
        $user->id = $id;
        $user->email = $email;
        $user->name = $name;
        $user->password = Hash::make($password);
        $user->is_admin = $isAdmin;
        $user->save();

        return $user;
    }
}
