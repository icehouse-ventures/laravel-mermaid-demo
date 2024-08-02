<?php

namespace App\Livewire;

use IcehouseVentures\LaravelMermaid\Facades\Mermaid;
use Livewire\Component;
use App\Models\User;

class UsersDemo extends Component
{
    public $users;
    public $selectedUserId;
    public $selectedUser;
    public $graphType;
    public $mermaid;

    public function mount()
    {
        $this->users = User::all();
        $this->selectedUserId = 'all';
        $this->selectedUser = null;
        $this->graphType = 'graph LR';
    }

    public function updatedSelectedUserId($userId)
    {
        if ($userId && $userId !== 'all') {
            $user = User::find($userId);
            $this->selectedUser = $user;
        } else {
            $this->selectedUser = null;
        }
    }

    public function render()
    {
        if($this->selectedUserId === 'all') {
            $collection = User::with('posts')->get();
        } else {
            $collection = User::where('id', $this->selectedUserId)->with('posts')->get();
        }
        
        $this->mermaid = Mermaid::build()->generateDiagramFromCollection($collection, null, $this->graphType);

        return view('livewire.users-demo');
    }
}