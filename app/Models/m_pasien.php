<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_pasien extends Model
{
    protected $table = 'm_pasien';
    protected $primaryKey = 'id_pasien';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'no_rekam_medis',
        'nama_pasien',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'telpon',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static $rules = [
        'no_rekam_medis'		=> 'required|string|between:0,10',
        'nama_pasien'	=> 'required|string|between:0,gg40',
        'alamat'	=> 'required|string|between:0,100',
        'tanggal_lahir'	=> 'required|date',
        'jenis_kelamin'	=> 'required|string|between:0,1',
        'telpon'	=> 'required|string|between:0,13',
    ];
}
