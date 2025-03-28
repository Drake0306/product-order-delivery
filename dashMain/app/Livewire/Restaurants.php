<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;

class Restaurants extends Component
{
    use WithPagination;

    public $sortBy = 'name';
    public $sortDirection = 'desc';
    public $name, $address, $contact_info, $operating_hours, $restaurantId, $deleteId;


    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }


    public function resetFields()
    {
        $this->reset([
            'restaurantId',
            'name', 
            'address', 
            'contact_info', 
            'operating_hours'
        ]);
    }

    public function render()
    {
        $restaurants = Restaurant::orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        return view('livewire.restaurants', compact('restaurants'));
    }

    public function submit()
    {
        // $this->validate();

        Restaurant::create([
            'tenant_id' => 1,
            'name' => $this->name,
            'address' => $this->address,
            'contact_info' => $this->contact_info,
            'operating_hours' => $this->operating_hours,
        ]);

        session()->flash('success', 'Message sent successfully!');

        $this->reset();
    }
    
    public function updateSubmit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_info' => 'required|string',
            'operating_hours' => 'required|string'
        ]);

        $update = Restaurant::findOrFail($this->restaurantId);
        $update->name = $this->name;
        $update->address = $this->address;
        $update->contact_info = $this->contact_info;
        $update->operating_hours = $this->operating_hours;
        $update->save();

        session()->flash('success', 'Message sent successfully!');

        $this->reset();
    }

    public function nextPage() // Automatically go to next page if there are more pages
    {
        // Automatically go to next page if there are more pages
        $restaurants = Restaurant::paginate(10);
        if ($restaurants->currentPage() < $restaurants->lastPage()) {
            $this->gotoPage($restaurants->currentPage() + 1);
        }

    }

    public function editRestaurant($id) // Fetch Edit Restaurant
    {
        $restaurant = Restaurant::findOrFail($id);
        
        // Populate the properties with the selected restaurant's data
        $this->restaurantId = $restaurant->id;
        $this->name = $restaurant->name;
        $this->address = $restaurant->address;
        $this->contact_info = $restaurant->contact_info;
        $this->operating_hours = $restaurant->operating_hours;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteRestaurant()
    {
        if ($this->deleteId) {
            Restaurant::find($this->deleteId)?->delete();
            $this->deleteId = null; // Reset after deletion

            $this->dispatch('modal-close', name: 'delete-profile');
        }
    }
}
