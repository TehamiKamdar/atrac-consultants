<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentdocument extends Model
{
    use HasFactory;

    protected $table = "student_documents";

    protected $fillable = ['student_id','document_type', 'file_path'];

    public function student(){
        return $this->belongsTo(students::class);
    }
}
