<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserEmployee extends Authenticatable
{
    use Notifiable;

    protected $table = 'employees';

    protected $fillable = [
        'first_name', 'last_name','countrycode', 'mobile', 'whatsapp', 'email', 'password',
        'department_id', 'sub_department_id', 'designation_id', 'user_role_id',
        'profile_image', 'is_superadmin', 'is_active', 'miscellaneous', 'updated_by',
        'added_by','is_deleted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function followups()
    {
        return $this->hasMany(Followup::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_employee', 'employee_id', 'department_id');
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
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

        public function permission()
    {
        return $this->hasOne(Permission::class, 'employee_id');
    }

        public function isAdmin()
    {
        return $this->user_role_id == 1; // Admin
    }

    public function isManager()
    {
        return $this->user_role_id == 2; // Manager
    }

    public function isAccounts()
    {
        return $this->user_role_id == 3; // Accounts
    }

    public function isOperations()
    {
        return $this->user_role_id == 4; // Operations
    }


    public function hasPermission($permission)
    {
        $permissions = $this->permission;
        return $permissions && isset($permissions->$permission) && $permissions->$permission;
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeAccessibleByManager($query, $loggedInUser)
    {
        // Check if the user is a manager
        if ($loggedInUser->userRole->name === 'Manager') {
            // Retrieve the department IDs for the logged-in manager
            $departmentIds = $loggedInUser->departments()->pluck('departments.id')->toArray();

            // Debugging: Check if department IDs are correct
            logger()->info('Manager Department IDs: ', $departmentIds);

            // Apply filtering to get only employees who belong to these departments
            $query->whereHas('departments', function ($query) use ($departmentIds) {
                $query->whereIn('departments.id', $departmentIds);
            });
        }

        return $query;
    }



    //$employees = UserEmployee::accessibleByManager(auth()->user())->get();

    public function softDelete()
    {
        $this->is_deleted = true;
        $this->is_active = false;
        $this->save();
    }






}
