<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Menu;
use App\Models\Restaurant;
use Livewire\WithPagination;
use Flux\Flux;

class Menus extends Component
{
    use WithPagination;

    public $sortBy = 'title';
    public $sortDirection = 'desc';
    public $title, $restaurant_id, $description, $categorieId, $deleteId, $search = '';


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
            'menuId',
            'restaurant_id',
            'title', 
            'description', 
        ]);
    }

    public function render()
    {
        $query = Menu::query();

        // Apply search filter if search term exists
        if (!empty($this->search)) {
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        }

        // Apply sorting
        $menus = $query->orderBy($this->sortBy, $this->sortDirection)->with('restaurant')->paginate(10);
        
        $restaurant = Restaurant::all();
        
        return view('livewire.menus', compact('menus','restaurant'));
    }

    public function submit()
    {
        $this->validate([
            'restaurant_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => '',
        ]);

        Menu::create([
            'tenant_id' => 1,
            'restaurant_id' => $this->restaurant_id,
            'title' => $this->title,
            'description' => $this->description,
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
            'restaurant_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'string',
        ]);

        $update = Menu::findOrFail($this->menuId);
        $update->restaurant_id = $this->restaurant_id;
        $update->title = $this->title;
        $update->description = $this->description;
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
        $menus = Menu::paginate(10);
        if ($menus->currentPage() < $menus->lastPage()) {
            $this->gotoPage($menus->currentPage() + 1);
        }

    }

    public function editRestaurant($id) // Fetch Edit menus
    {
        $menus = Menu::findOrFail($id);
        
        // Populate the properties with the selected menus's data
        $this->menuId = $menus->id;
        $this->restaurant_id = $menus->restaurant_id;
        $this->title = $menus->title;
        $this->description = $menus->description;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteRestaurant()
    {
        if ($this->deleteId) {
            Menu::find($this->deleteId)?->delete();
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
