<div>
    <div style="border-bottom: 1px solid #999; margin: 0 0 2em; padding: 0 0 2em;">
        <div>
            <label for="verbosity-select">Increase the slider to visualise in more detail:</label>
            <input type="range" min="1" max="3" value="1" id="verbosity-select" wire:model.live="verbosity" />
        </div>
    </div>

    <div>
        <h1>Fund structure</h1>

        <x-mermaid::livewire-component wire:model="mermaid" />
    </div>
</div>
