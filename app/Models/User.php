<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_sekolah',
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
    ];

    public function getOperator($where =[]) {
        $operator = DB::table('users')
        ->select(
                DB::raw(
                    'users.id, users.name, users.email, users.id_sekolah, sekolah.nama_sekolah'
                )
            )
        ->leftJoin('sekolah', 'users.id_sekolah', '=', 'sekolah.id_sekolah');

        if (!empty($where)) {
            # code...
            $operator->where($where);
        }
        $operator->orWhere('users.id_sekolah', '<>', NULL);

        $operator->orderby('users.id', 'desc');

        return $operator->get();
    }
}
