<?php

namespace App\Observers;

use App\Models\User;

class UserFormSubmissionObserver
{
    public function created(User $user)
    {
        return redirect('user/all-product');
    }
}
