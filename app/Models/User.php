<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\WebSocketHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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
        'minecraft_device',
        'minecraft_uuid',
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

    public function getPhotoAttribute($value)
    {
        if (!empty($value) && !is_null($value)) {
            return $value;
        }
        return Cache::remember('user_photo_' . $this->id, now()->addMinutes(10), function () {
            return $this->getSkinAttribute("head");
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function relation()
    {
        return $this->belongsToOne(User::class, 'user_relation_id') ?? null;
    }

    public function getPermissionCodes()
    {
        if ($this->is_active) {
            $codes = $this->userPermissions
                ? $this->userPermissions->pluck('Permission.code')
                : collect([]);

            if ($this->roles->contains(env('APP_HIGHEST_ROLE', 'superadmin'))) {
                return Permission::pluck('code');
            }
            if ($codes->contains('all_feature')) {
                return Permission::pluck('code');
            }
            // if ($this->roles->contains('admin')) {
            //     return Permission::pluck('code');
            // }
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

    public function getMinecraftData()
    {
        return WebSocketHelper::getPlayerData($this->name) ?? 0;
    }

    // Function untuk cek URL valid atau nggak
    private function checkUrlExists($url)
    {
        try {
            $response = Http::head($url); // Cuma cek HEAD, lebih cepat
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
    // https://starlightskins.lunareclipse.studio/render/:RENDERTYPE/:PLAYERNAME OR UUID/:RENDERCROP
    public function getSkinAttribute($type)
    {
        // Ambil username user
        $username = $this->name;

        $founderNames = ["kenndeclouv", "PixyPAYCRAFT", "AkangHaise"];
        $selectedFounder = $founderNames[rand(1, count($founderNames) - 1)];
        // List tipe pose yang tersedia
        $types = ["default", "marching", "walking", "crouching", "crossed", "criss_cross", "ultimate", "isometric", "cheering", "relaxing", "trudging", "pointing", "lunging", "dungeons", "archer", "kicking", "mojavatar", "reading", "high_ground"];

        // Pilih pose random
        $selectedType = $type ?? $types[rand(0, count($types) - 1)];

        if ($this->roles->contains('code', env('APP_HIGHEST_ROLE', 'super_admin'))) {
            return "https://starlightskins.lunareclipse.studio/render/{$selectedType}/kenndeclouv/full";
        }
        $modifiedUsername = '.' . $username; // Tambahin titik di depan username

        // Generate URLs
        $skinUrl = "https://starlightskins.lunareclipse.studio/render/{$selectedType}/{$username}/full";
        $skinUrlModified = "https://starlightskins.lunareclipse.studio/render/{$selectedType}/{$modifiedUsername}/full";

        // Cek URL pertama
        if ($this->checkUrlExists($skinUrl)) {
            return $skinUrl; // ✅ Return URL langsung
        }

        // Cek URL kedua (pakai titik)
        if ($this->checkUrlExists($skinUrlModified)) {
            return $skinUrlModified; // ✅ Return URL langsung
        }

        return "https://starlightskins.lunareclipse.studio/render/{$selectedType}/{$selectedFounder}/full"; // ❌ Kalau gak ada skin
    }

    public function getBackgrundAttribute()
    {
        // Ambil username user
        $username = $this->name;
        $modifiedUsername = '.' . $username; // Tambahin titik di depan username

        if ($this->roles->contains('code', env('APP_HIGHEST_ROLE', 'super_admin'))) {
            return "https://starlightskins.lunareclipse.studio/render/wallpaper/herobrine_hill/kenndeclouv";
        }

        // Generate URLs
        $backgroundUrl = "https://starlightskins.lunareclipse.studio/render/wallpaper/herobrine_hill/{$username}";
        $backgroundUrlModified = "https://starlightskins.lunareclipse.studio/render/wallpaper/herobrine_hill/{$modifiedUsername}";

        // Cek URL pertama
        if ($this->checkUrlExists($backgroundUrl)) {
            return $backgroundUrl; // ✅ Return URL langsung
        }

        // Cek URL kedua (pakai titik)
        if ($this->checkUrlExists($backgroundUrlModified)) {
            return $backgroundUrlModified; // ✅ Return URL langsung
        }

        return "https://starlightskins.lunareclipse.studio/render/wallpaper/quick_hide/kenndeclouv,PixyPAYCRAFT,AkangHaise"; // ❌ Kalau gak ada skin
    }
}
