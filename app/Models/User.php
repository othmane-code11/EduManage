<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
        'role', 
        'profile_photo_path',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's blog posts.
     */
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * Get the user's blog comments.
     */
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }

    /**
     * Get the user's profile photo URL attribute.
     * 
     * @return string|null
     */
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->profile_photo_path) {
            return null;
        }

        // Check if the file exists
        if (Storage::disk('public')->exists($this->profile_photo_path)) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return null;
    }

    /**
     * Get the user's profile photo URL with a fallback.
     * 
     * @return string
     */
    public function getProfilePhotoUrlWithFallbackAttribute(): string
    {
        if ($this->profile_photo_url) {
            return $this->profile_photo_url;
        }
        
        // Generate a nice avatar with initials
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?background=2478c8&color=fff&name={$name}&size=120&rounded=true";
    }

    /**
     * Get the user's initials.
     * 
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        $nameParts = preg_split('/\s+/', trim($this->name ?? ''), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
        
        $initial = strtoupper(substr($firstName, 0, 1));
        if ($lastName) {
            $initial .= strtoupper(substr($lastName, 0, 1));
        }
        
        return $initial ?: 'U';
    }

    /**
     * Check if user has a profile photo.
     * 
     * @return bool
     */
    public function hasProfilePhoto(): bool
    {
        if (!$this->profile_photo_path) {
            return false;
        }
        
        return Storage::disk('public')->exists($this->profile_photo_path);
    }

    /**
     * Delete the user's profile photo.
     * 
     * @return bool
     */
    public function deleteProfilePhoto(): bool
    {
        if ($this->hasProfilePhoto()) {
            $deleted = Storage::disk('public')->delete($this->profile_photo_path);
            if ($deleted) {
                $this->profile_photo_path = null;
                $this->save();
            }
            return $deleted;
        }
        
        return false;
    }

    /**
     * Check if user is an admin.
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a formateur.
     * 
     * @return bool
     */
    public function isFormateur(): bool
    {
        return $this->role === 'formateur';
    }

    /**
     * Check if user is a student.
     * 
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
}