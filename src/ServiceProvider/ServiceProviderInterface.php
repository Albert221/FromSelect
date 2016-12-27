<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;

interface ServiceProviderInterface
{
    /**
     * Provide services
     *
     * @param FromSelect $fromSelect
     */
    public function provide(FromSelect $fromSelect);
}
