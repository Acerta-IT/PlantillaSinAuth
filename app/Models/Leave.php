<?php

namespace App\Models;

use App\Enums\LeaveType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'start_date', 'end_date', 'comments',
        'justification_file_path', 'status', 'user_id', 'days'];

    public function isJustificationFileMissing()
    {
        if (LeaveType::from($this->type)->requiresJustification() && !$this->justification_file_path) {
            return true;
        }

        return false;
    }
}

