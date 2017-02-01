<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;

interface ServiceProviderInterface
{
    /**
     * Provide services.
     *
     * @param FromSelect $app
     */
    public function provide(FromSelect $app);
}
