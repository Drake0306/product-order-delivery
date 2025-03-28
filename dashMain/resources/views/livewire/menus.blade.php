<div>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-2 md:grid-cols-4">
            <div class="relative my-5">
                <flux:modal.trigger name="add-profile">
                    <flux:button>Add Menus</flux:button>
                </flux:modal.trigger>
            </div>
            <div class="relative my-5">
                <flux:input 
                    wire:model.live.debounce.500ms="search" 
                    kbd="âK" 
                    icon="magnifying-glass" 
                    placeholder="Search name..."
                />
            </div>
        </div>
    </div>
                

    <div class="relative h-full flex-1 p-[20px] rounded-xl border border-neutral-200 dark:border-neutral-700">

        <flux:table :paginate="$menus" wire:sort.lazy="sortBy">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection" wire:click="sort('title')">Title</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'restaurant'" :direction="$sortDirection" wire:click="sort('restaurant')">Restaurant</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">Description</flux:table.column>
            </flux:table.columns>
        
            <flux:table.rows>
                @foreach ($menus as $item)
                    <flux:table.row :key="$item->id">
                        <flux:table.cell class="whitespace-nowrap">{{ $item->title }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ $item->restaurant->name }}</flux:table.cell>
        
                        <flux:table.cell variant="strong">{{ $item->description }}</flux:table.cell>
                
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Action</flux:button>
                                <flux:menu>
                                    <flux:modal.trigger name="edit-profile" wire:click="editRestaurant({{ $item->id }})">
                                        <flux:menu.item icon="pencil-square">Edit</flux:menu.item>
                                    </flux:modal.trigger>
                                    
                                    <flux:menu.separator />
                                    <flux:modal.trigger name="delete-profile" wire:click="confirmDelete({{ $item->id }})">
                                        <flux:menu.item variant="danger" icon="trash">Delete</flux:menu.item>
                                    </flux:modal.trigger>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

    </div>
    
    {{-- Add --}}
    <flux:modal name="add-profile" variant="flyout">
        <form wire:submit.prevent="submit">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Menu</flux:heading>
                    <flux:text class="mt-2">Add changes to add details.</flux:text>
                </div>

                <flux:select label="Select Restaurant" variant="combobox" wire:model="restaurant_id" placeholder="Choose ...">
                    @foreach ($restaurant as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Title" wire:model="title" placeholder="Your title" />

                <flux:textarea
                    wire:model="description"
                    label="Description"
                    placeholder="Fill the description..."
                />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Edit --}}
    <flux:modal name="edit-profile" variant="flyout">
        <form wire:submit.prevent="updateSubmit">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Edit Menu</flux:heading>
                    <flux:text class="mt-2">Add changes to update details.</flux:text>
                </div>

                <flux:select label="Select Restaurant" variant="combobox" wire:model="restaurant_id" placeholder="Choose ...">
                    @foreach ($restaurant as $item)
                        <flux:select.option value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Title" wire:model="title" placeholder="Your title" />

                <flux:textarea wire:model="description" label="Description" placeholder="Fill the description..." />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    {{-- Delete --}}
    <flux:modal name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>
                <flux:text class="mt-2">
                    <p>You're about to delete this.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" wire:click="deleteRestaurant">Delete project</flux:button>
            </div>
        </div>
    </flux:modal>
    {{-- Toast --}}
    <flux:toast />

</div>