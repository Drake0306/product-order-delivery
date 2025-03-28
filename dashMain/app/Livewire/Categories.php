<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Flux\Flux;

class Categories extends Component
{
    use WithPagination;

    public $sortBy = 'name';
    public $sortDirection = 'desc';
    public $name, $description, $categorieId, $deleteId, $search = '';


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
            'categorieId',
            'name', 
            'description', 
        ]);
    }

    public function render()
    {
        $query = Category::query();

        // Apply search filter if search term exists
        if (!empty($this->search)) {
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        }

        // Apply sorting
        $categories = $query->orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        
        return view('livewire.categories', compact('categories'));
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => '',
        ]);

        Category::create([
            'tenant_id' => 1,
            'name' => $this->name,
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
            'name' => 'required|string|max:255',
            'description' => 'string',
        ]);

        $update = Category::findOrFail($this->categorieId);
        $update->name = $this->name;
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
        $categories = Category::paginate(10);
        if ($categories->currentPage() < $categories->lastPage()) {
            $this->gotoPage($categories->currentPage() + 1);
        }

    }

    public function editRestaurant($id) // Fetch Edit categories
    {
        $categories = Category::findOrFail($id);
        
        // Populate the properties with the selected categories's data
        $this->categorieId = $categories->id;
        $this->name = $categories->name;
        $this->description = $categories->description;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function deleteRestaurant()
    {
        if ($this->deleteId) {
            Category::find($this->deleteId)?->delete();
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
