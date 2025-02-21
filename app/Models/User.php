<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'mobile', 'whatsapp', 'email', 'password', 'department_id', 'sub_department_id', 'designation_id', 'user_role_id', 'permissions', 'miscellaneous'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

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
    public function followups()
    {
        return $this->hasMany(Followup::class);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_departments');
    }

    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    //  /**
    //  * Check if the user has a specific permission.
    //  *
    //  * @param string $permission
    //  * @return bool
    //  */
    // public function hasPermission(string $permission): bool
    // {
    //     $permissions = $this->permissions ?? [];
    //     return in_array($permission, $permissions);
    // }

    // public function hasPermission($permission)
    // {
    //     $permissions = json_decode($this->permissions, true);
    //     return in_array($permission, $permissions);
    // }

    public function hasPermission($permission)
    {
        // Default permissions
        $defaultPermissions = ['view', 'show'];

        // Decode the permissions stored in the database
        $permissions = json_decode($this->permissions, true);

        // If the permissions are null or empty, return false to trigger the custom response
        if (is_null($permissions) || empty($permissions)) {
            return false;
        }

        // Merge default permissions with user-specific permissions
        $allPermissions = array_merge($defaultPermissions, $permissions);

        // Check if the required permission exists
        return in_array($permission, $allPermissions);
    }

}
