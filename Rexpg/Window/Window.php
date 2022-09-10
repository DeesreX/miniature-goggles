<?php

namespace Rexpg;

/**
 * Creates a window with 100vh
 *
 */
class Window
{
    public function __construct()
    {

    }


    /**
     * Creates a window from content
     *
     * @param $content
     * @return false|string
     */
    public function createWindow($content)
    {
        ob_start();
        ?>
        <div class="rexpg-window">
            <?php echo $content ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Displays your window
     *
     * @param $window
     * @return void
     */
    public function display($window)
    {
        echo $window;
    }

    /**
     * Creates mini windows
     *
     * @param array $content
     * @return false|string
     */
    public function createContent(array $content)
    {
        foreach ($content as $part => $partHeight) {
            ob_start(); ?>
            <div class="container-fluid" style="height: <?php echo $partHeight ?>vh">
                <?php echo $part ?>
            </div>
            <?php
        }
        return ob_get_clean();
    }
}