<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',

        'role_id',
        'is_active',
        'user_image',
        'phoneNumber',
        'gymLocation',
        'gender',
        'dob',
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
    protected $casts=[
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    public function role(){
        $role =$this->belongsTo(Role::class);
        return $role;
    }
    public function abilities(){
        return [
            'admin'=> $this->role->id == 1,
            'user'=> $this->role->id == 3,
            'trainer'=> $this->role->id == 2,
            'staff'=> $this->role->id == 4,
        ];
         
    // public function role(){
    //     $this->belongsTo(Role::class);
    // }
}
}
