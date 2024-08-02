<div>
    <div style="border-bottom: 1px solid #999; margin: 0 0 2em; padding: 0 0 2em;">
        <div>
            <label for="user-select">Select user to view their relationships with Posts:</label>
            <select id="user-select" wire:model.live="selectedUserId">
                <option value="all">All</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="graph-type-select">Graph type</label>
            <select id="graph-type-select" wire:model.live="graphType">
                <option value="graph LR">Left to Right</option>
                <option value="graph TD">Top Down</option>
            </select>
        </div>
    </div>

    <div>
        <h1>{{ $this->selectedUser->name ?? 'All users' }}</h1>

        <x-mermaid::livewire-component wire:model="mermaid" />
    </div>
</div>
