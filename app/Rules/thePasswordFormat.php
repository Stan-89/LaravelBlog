<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class thePasswordFormat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
      $allGood = true;

      //Verification steps:

      //At least 8 characters long
      if(strlen($value) < 8)
      {
        $allGood = false;
      }
      elseif(!preg_match("/[A-Z]/", $value))
      {
        $allGood = false;
      }
      elseif(!preg_match("/[0-9]/", $value))
      {
        $allGood = false;
      }

      return $allGood;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your password must contain at least one uppercase character and at least 1 number, with a minimum length of 8.';
    }
}
