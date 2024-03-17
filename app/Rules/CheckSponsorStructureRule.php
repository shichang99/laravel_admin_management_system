<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckSponsorStructureRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /*check recevier valid*/
        $user = $this->user;
        $uplineDetail = User::where('status',1)->where(function ($query)  use ($value) {
            $query->where('name', $value);
            })->first();
        
        if(!$uplineDetail)
        {
            return false;
        }
        if($uplineDetail->id == $user->id)
        {
             return false;
        }
        $member_sponsor_structure = $user->sponsor_structure.'|'.$user->id.'|';
        $sponsor_id = $user->id;

        $downline = User::where('id',$uplineDetail->id)
            ->where('status',1)
            ->where(function ($query)  use ($sponsor_id, $member_sponsor_structure) {
            $query->where('sponsor_id',$sponsor_id)
                  ->orWhere('sponsor_structure', 'like', '%' . $member_sponsor_structure . '%');
            })->get();

        $member_sponsor_structure = $uplineDetail->sponsor_structure.'|'.$uplineDetail->id.'|';
        $sponsor_id = $uplineDetail->id;
        $upline = User::where('id',$user->id)
            ->where('status',1)
            ->where(function ($query)  use ($sponsor_id, $member_sponsor_structure){
            $query->where('sponsor_id', $sponsor_id)
                  ->orWhere('sponsor_structure', 'like', '%' . $member_sponsor_structure . '%');
            })->get();        

        if (count($downline)<=0 && count($upline)<=0) {

            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ['message' => 'invalid_sponsor'];
    }
}
