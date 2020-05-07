<?php

namespace BMamba\Pipelines;


use BMamba\Traits\WithMagicFunction;
use BMamba\Contracts\Pipelines\ItemPipelineManager as ItemPipelineContract;

class ItemPipelineManager implements ItemPipelineContract
{
    use WithMagicFunction;

    public function processItem($item) {
        foreach($this->config->get("settings.ITEM_PIPELINES") as $pipelineCls => $priority) {
            $pipeline = $this->container->make($pipelineCls);
            if(method_exists($pipeline, 'processItem')) {
                $pipeline->processItem($item);
            }
        }
    }
}