<?php

namespace App\Livewire;

use IcehouseVentures\LaravelMermaid\Facades\Mermaid;
use App\Models\Entity;
use Livewire\Component;
use Illuminate\Support\Collection;

class VerbosityDemo extends Component
{
    public $verbosity = 1;
    public $mermaid;

    public function render()
    {
        // Get the top-level Fund entity
        $fund = Entity::where('type', 'Fund')->whereNull('parent_id')->first();

        // Recursively load all sub-entities
        $allEntities = $this->preloadEntities($fund);

        // Now filter to the required level of verbosity
        // The slider increases the verbosity of the mapping, so initially we see Fund -> Dividends regardless of how the Dividend is related to the Fund
        // As the slider increases, we will visualise Fund -> PreferredStock + ConvertibleNotes -> Dividends
        // and finally Fund -> Company -> PreferredStock + ConvertibleNotes -> Dividends as the most detail our example contains
        $filteredEntities = $this->filterEntities($allEntities, $this->verbosity);

        // Now generate our Mermaid nodes
        $chart = $this->generateNodes($filteredEntities);
        
        // Finally, generate a diagram from that data
        $this->mermaid = Mermaid::build()->generateDiagramFromArray($chart, 'graph LR;');

        return view('livewire.verbosity-demo');
    }

    private function preloadEntities($entity) {
        $entities = collect([$entity]);
    
        foreach($entity->children as $child) {
            $entities = $entities->merge($this->preloadEntities($child));
        }
    
        return $entities;
    }
    
    private function filterEntities($entities, $verbosity) {
        $fund = $entities->firstWhere('type', 'Fund');
        $filteredEntities = collect();
    
        switch($verbosity) {
            case 1:
                $filteredEntities->push($fund);
                $dividends = $entities->where('type', 'Dividend');
                foreach($dividends as $dividend) {
                    $newDividend = (object)[
                        'id' => $dividend->id,
                        'name' => $dividend->name,
                        'type' => 'Dividend',
                        'parent_id' => $fund->id
                    ];
                    $filteredEntities->push($newDividend);
                }
                break;
            case 2:
                $filteredEntities->push($fund);
                $intermediateEntities = $entities->whereIn('type', ['PreferredStock', 'ConvertibleNote']);
                foreach($intermediateEntities as $entity) {
                    $newEntity = (object)[
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'type' => $entity->type,
                        'parent_id' => $fund->id
                    ];
                    $filteredEntities->push($newEntity);
                    
                    $relatedDividends = $entities->where('type', 'Dividend')
                        ->filter(function($dividend) use($entity, $entities) {
                            return $this->isDescendant($dividend, $entity, $entities);
                        });
                    
                    foreach($relatedDividends as $dividend) {
                        $newDividend = (object)[
                            'id' => $dividend->id,
                            'name' => $dividend->name,
                            'type' => 'Dividend',
                            'parent_id' => $entity->id
                        ];
                        $filteredEntities->push($newDividend);
                    }
                }
                break;
            case 3:
                return $entities;
            default:
                return collect();
        }
    
        return $filteredEntities;
    }
    
    private function isDescendant($potentialDescendant, $entity, $allEntities) {
        $parent = $allEntities->firstWhere('id', $potentialDescendant->parent_id);
        while($parent) {
            if($parent->id == $entity->id) {
                return true;
            }
            $parent = $allEntities->firstWhere('id', $parent->parent_id);
        }
        return false;
    }

    private function generateNodes($entities) {
        $lines = [];
        $processedIds = [];

        foreach($entities as $entity) {
            $entityId = $this->getEntityId($entity->id);
            $entityLabel = $this->getEntityLabel("{$entity->type}: {$entity->name}");
            
            if(!in_array($entityId, $processedIds)) {
                $lines[] = "{$entityId}[\"{$entityLabel}\"]";
                $processedIds[] = $entityId;
            }
    
            if($entity->parent_id && $entities->contains('id', $entity->parent_id)) {
                $parentId = $this->getEntityId($entity->parent_id);
                $lines[] = "{$parentId} --> {$entityId}";
            }
        }

        return $lines;
    }

    // Generate consistent IDs
    private function getEntityId($id) {
        return 'id' . preg_replace('/[^a-zA-Z0-9]/', '', $id);
    }
    
    // Escape for formatting in Mermaid
    private function getEntityLabel($label) {
        return str_replace('"', '\"', $label);
    }
}