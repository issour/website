<?php

namespace App;

use App\Workflow;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function votes()
    {
        return $this->belongsToMany(Workflow::class, 'votes')->withTimestamps();
    }

    public function getVoteFor($workflow)
    {
        return Vote::where([
            'workflow_id' => $workflow->id,
            'user_id' => $this->id,
        ])->first();
    }
}
