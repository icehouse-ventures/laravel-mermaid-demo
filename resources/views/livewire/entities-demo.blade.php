<div>
    <div style="border-bottom: 1px solid #999; margin: 0 0 2em; padding: 0 0 2em;">
        <div>
            <label for="depth-select">Slide to view further relationships down the tree:</label>
            <input type="range" min="1" max="3" value="1" id="depth-select" wire:model.live="chartDepth" />
        </div>
    </div>

    <div>
        <h1>Business Structure Diagram</h1>

        <x-mermaid::livewire-component wire:model="mermaid" />
    </div>
</div>
