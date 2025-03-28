<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Restaurant;
use Livewire\WithPagination;
use Flux\Flux;

class Restaurants extends Component
{
    use WithPagination;

    public $sortBy = 'name';
    public $sortDirection = 'desc';
    public $name, $address, $contact_info, $operating_hours, $restaurantId, $deleteId, $search = '';


    public function updatingSearch()
    {
        $this->resetPage();
    }

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
        $query = Restaurant::query();

        // Apply search filter if search term exists
        if (!empty($this->search)) {
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        }

        // Apply sorting
        $restaurants = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        
        return view('livewire.restaurants', compact('restaurants'));
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => '',
            'contact_info' => 'max:255',
            'operating_hours' => 'max:255'
        ]);

        Restaurant::create([
            'tenant_id' => 1,
            'name' => $this->name,
            'address' => $this->address,
            'contact_info' => $this->contact_info,
            'operating_hours' => $this->operating_hours,
        ]);

        $this->reset();

        Flux::toast(
            variant: 'success',
            heading: 'Changes saved.',
            text: 'You can always update this from edit.',
        );


    }
    
    public function updateSubmit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'string',
            'contact_info' => 'string|max:255',
            'operating_hours' => 'string|max:255'
        ]);

        $update = Restaurant::findOrFail($this->restaurantId);
        $update->name = $this->name;
        $update->address = $this->address;
        $update->contact_info = $this->contact_info;
        $update->operating_hours = $this->operating_hours;
        $update->save();


        $this->reset();

        Flux::toast(
            variant: 'success',
            heading: 'Changes updated.',
            text: 'You can always change anything from edit.',
        );
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

            Flux::toast(
                variant: 'success',
                heading: 'Item deleted',
                text: 'you cant undo this action.',
            );
        }
    }
}
