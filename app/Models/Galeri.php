<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $primaryKey = 'id_galeri';

    public $timestamps = true;

    protected $fillable = [
        'id_kampung',
        'jenis',
        'media_path',
        'tipe',
        'kategori',
        'judul',
        'deskripsi',
        'tanggal_upload',
    ];
}
