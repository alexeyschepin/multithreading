<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), array(
            'name' => 'My Console Application',
                )
);

