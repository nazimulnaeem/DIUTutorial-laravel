<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Teacher;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
      public function role(){
        return $this->belongsTo(Role::class);
    }
    
     public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function questions(){
        return $this->hasMany(Question::class);
    }
    
     public function scopeStudents($query){
        return $query->where('role_id',2);
    }
    
    public function scopeTeachers($query){
        return $query->where('role_id',3);
    }
    
     public function favorite_posts(){
         return $this->belongsToMany(Post::class)->withTimestamps();
    }
    
     public function favorite_question(){
         return $this->belongsToMany(Question::class)->withTimestamps();
    }
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
}