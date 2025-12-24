<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'email',
        'bio',
        'headline',
        'institution',
        'location',
        'city',
        'website',
        'category',
        'newsletter',
        'role',
        'proof_image',
        'avatar',
        'cover_image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'newsletter' => 'boolean',
            'last_activity' => 'integer',
        ];
    }

    /**
     * URL for the user's avatar; falls back to the app default avatar in public images.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/'.$this->avatar);
        }
        return asset('/images/icon/profil.png');
    }

    /**
     * User's artworks
     */
    public function artworks()
    {
        return $this->hasMany(\App\Models\Artwork::class);
    }

    /**
     * Artworks this user has liked
     */
    public function likedArtworks()
    {
        return $this->belongsToMany(\App\Models\Artwork::class, 'artwork_likes')->withTimestamps();
    }

    /**
     * Artworks this user has saved
     */
    public function savedArtworks()
    {
        return $this->belongsToMany(\App\Models\Artwork::class, 'artwork_saves')->withTimestamps();
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->username) && !empty($user->name)) {
                $base = Str::slug($user->name);
                $candidate = $base ?: Str::slug($user->email ?? 'user');
                $i = 0;
                while (\App\Models\User::where('username', $candidate)->exists()) {
                    $i++;
                    $candidate = $base . '-' . $i;
                }
                $user->username = $candidate;
            }
        });
    }

    /**
     * Users that follow this user
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    /**
     * Users this user is following
     */
    public function following()
    {
        return $this->belongsToMany(self::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * Articles authored by this user
     */
    public function articles()
    {
        return $this->hasMany(\App\Models\Article::class);
    }
}
