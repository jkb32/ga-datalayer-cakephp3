<?php
namespace DataLayer\View\Helper;

use Cake\Event\Event;
use Cake\View\Helper;

/**
 * Class DataLayerHelper
 * @package DataLayer\View\Helper
 * @property Helper\HtmlHelper $Html
 */
class DataLayerHelper extends Helper
{
    public $helpers = ['Html'];

    public function beforeRender(Event $event, $viewFile)
    {
        $events = $this->getConfig('events');

        $output = '';
        foreach ($events as $event) {
            $output .= "dataLayer.push({'event': '" . $this->getConfig('eventName') . "', '" . $this->getConfig('eventName') . "': ";
            $output .= json_encode($event);
            $output .= "});";
        }

        $this->Html->scriptBlock($output, ['block' => $this->getConfig('blockName')]);
    }
}
