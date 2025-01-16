<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPracticeTestAns extends Model
{
    protected $table = 'tbl_user_practice_test_ans';

    protected $fillable = [ 'user_id','exam_id', 'question_id', 'trainee_ans_option','is_correct','selected_option','status'];
}
