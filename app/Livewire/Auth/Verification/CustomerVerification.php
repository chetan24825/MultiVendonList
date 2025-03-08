<?php

namespace App\Livewire\Auth\Verification;

use Livewire\Component;
use App\Models\Advertiser;
use App\Models\Location\City;
use App\Models\Location\State;
use Illuminate\Support\Facades\Auth;

class CustomerVerification extends Component
{
    public $id;
    public $user;

    public $name,
        $first_name,
        $last_name,
        $country,
        $state,
        $city,
        $company_name,
        $phone2,
        $technologies,
        $type,
        $email,
        $avatar,
        $phone,
        $address;

    public $allCity = [];  // Initialize as empty array

    // Fetch the advertiser based on ID
    public function mount($id)
    {
        $this->user = Advertiser::findOrFail($id);

        // Populate fields if user data is available
        $this->type = $this->user->type;
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->company_name = $this->user->company_name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->phone2 = $this->user->phone2;
        $this->country = $this->user->country;
        $this->state = $this->user->state;
        $this->city = $this->user->city;
        $this->address = $this->user->address;

        // Load cities if a state is already selected
        if ($this->state) {
            $this->loadCities();
        }
    }

    // Load cities based on selected state
    public function loadCities()
    {
        if ($this->state) {
            $this->allCity = City::where('state_id', $this->state)->get();
        } else {
            $this->allCity = [];  // Clear cities if no state is selected
        }
        $this->city = null;  // Reset city selection
    }

    // Save form data
    public function save()
    {
        // Validation rules based on type
        $this->validate($this->getValidationRules());

        // Save data to the user
        $this->user->update([
            'type' => $this->type,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'address' => $this->address,
        ]);

        Auth::guard('advertiser')->login($this->user);
        session()->flash('success', 'Profile updated successfully!');
        return redirect()->route('advertiser.dashboard');
    }

    // Validation rules method
    protected function getValidationRules()
    {
        return [
            'type' => 'required|in:1,2',
            'first_name' => 'required_if:type,1|max:255',
            'last_name' => 'required_if:type,1|max:255',
            'company_name' => 'required_if:type,2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:20',
            'phone2' => 'nullable|max:20',
            'country' => 'required|max:100',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'address' => 'nullable|max:500',
        ];
    }

    public function render()
    {
        return view('livewire.auth.verification.customer-verification', [
            'allState' => State::all(),  // Pass all states to view
        ]);
    }
}
