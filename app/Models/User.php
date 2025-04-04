<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\WebSocketHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'email',
        'password',
        'photo',
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
        ];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    private function getConsistentColor()
    {
        $hash = md5($this->name ?? env('APP_AUTHOR'));
        $color = substr($hash, 0, 6);

        return $color;
    }
    public function getPhotoAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return $value;
        }
        $color = $this->getConsistentColor();
        $name = $this->name ?? env('APP_AUTHOR');

        return "https://api.dicebear.com/6.x/initials/svg?seed=" . urlencode($name) . "&backgroundColor=" . $color;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function getPermissionCodes()
    {
        if ($this->is_active) {
            $codes = $this->userPermissions
                ? $this->userPermissions->pluck('Permission.code')
                : collect([]);

            if ($codes->contains('all_feature')) {
                return Permission::pluck('code');
            }
            if ($this->roles->contains(env('APP_HIGHEST_ROLE', 'superadmin'))) {
                return Permission::pluck('code');
            }
            return $codes;
        } else {
            return collect([]);
        }
    }

    public function getPermissions()
    {
        if ($this->is_active) {
            $permissions = $this->userPermissions;
            if ($permissions->pluck('permission_id')->contains(Permission::where('code', 'all_feature')->first()->id ?? 0)) {
                return Permission::all();
            }
            if ($this->roles->pluck('code')->contains(env('APP_HIGHEST_ROLE', 'superadmin'))) {
                return Permission::all();
            }
        } else {
            return collect([]);
        }
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getMoney()
    {
        return WebSocketHelper::getPlayerBalance($this->name);
    }
}
