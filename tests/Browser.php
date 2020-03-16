<?php

namespace LaraWhale\Cms\Tests;

use Laravel\Dusk\Browser as BaseBrowser;

class Browser extends BaseBrowser
{
    /**
     * Take a screenshot and store it with the given name with a small delay.
     * This delay will make sure all is loaded and css transitions happened.
     *
     * @param  string  $name
     * @return $this
     */
    public function screenshot($name): self
    {
        $this->pause(500);

        return parent::screenshot($name);
    }
}
