<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm as JetstreamUpdateProfileInformationForm;

class UpdateProfileInformationForm extends JetstreamUpdateProfileInformationForm
{
    public function mount()
    {
        parent::mount();

        $user = $this->getUserProperty();

        $this->state = array_merge($this->state, [
            'city' => $user->profile->city,
            'phonenumber' => $user->profile->phone_number,
            'opt_out' => $user->profile->opt_out,
        ]);
    }
}
