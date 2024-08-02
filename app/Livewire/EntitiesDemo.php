<?php

namespace App\Livewire;

use IcehouseVentures\LaravelMermaid\Facades\Mermaid;
use Livewire\Component;
use App\Models\Entity;

class EntitiesDemo extends Component
{
    public $entities = [];
    public $chartDepth = 1;
    public $mermaid;

    public function render() {
        $depth = $this->chartDepth;

        // Load entities to the depth specified
        $this->entities = Entity::with(['children' => function($query) use ($depth) {
            $this->applyDepthLimit($query, $depth, 1);
        }])->whereNull('parent_id')->get();
        
        // Generate a Mermaid diagram automatically from the collection
        $this->mermaid = Mermaid::build()->generateDiagramFromCollection($this->entities);

        return view('livewire.entities-demo');
    }

    private function applyDepthLimit($query, $depth, $currentDepth) {
        if($currentDepth < $depth) {
            $query->with(['children' => function ($query) use ($depth, $currentDepth) {
                $this->applyDepthLimit($query, $depth, $currentDepth + 1);
            }]);
        }
    }
}