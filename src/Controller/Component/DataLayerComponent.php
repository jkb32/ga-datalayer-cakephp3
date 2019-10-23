<?php
namespace DataLayer\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;

class DataLayerComponent extends Component
{
    protected $_defaultConfig = [
        'cookieKey' => '_dl',
        'eventName' => 'cakeEvent',
        'blockName' => 'dataLayerEvents'
    ];

    protected $events = [];

    public function initialize(array $config)
    {
        parent::initialize($config);

        $controller = $this->getController();
        $cookieKey = $this->getConfig("cookieKey");

        if (!empty($controller->getRequest()->getCookie($cookieKey))) {
            $this->events = json_decode($controller->getRequest()->getCookie($cookieKey), true);
        }
    }


    public function addEvent($eventCategory, $eventAction, $eventLabel = null, $eventValue = null)
    {
        $controller = $this->getController();

        $this->events[] = [
            'event_category' => $eventCategory,
            'event_action' => $eventAction,
            'event_label' => $eventLabel,
            'value' => (float)$eventValue
        ];

        $controller->setResponse(
            $controller->response->withCookie($this->getConfig('cookieKey'), [
                'value' => json_encode($this->events),
                'path' => '/',
                'httpOnly' => false,
                'secure' => false,
                'expire' => strtotime('+10 years')
            ])
        );
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function clearEvents()
    {
        $controller = $this->getController();

        $controller->setResponse(
            $controller->response->withCookie($this->getConfig('cookieKey'), [
                'value' => null,
                'path' => '/',
                'httpOnly' => false,
                'secure' => false,
                'expire' => strtotime('-10 years')
            ])
        );
    }

    public function beforeRender(Event $event)
    {
        $this->getController()
            ->viewBuilder()
            ->setHelpers(
                ["DataLayer.DataLayer" => [
                    'events' => $this->getEvents(),
                    'eventName' => $this->getConfig('eventName'),
                    'blockName' => $this->getConfig('blockName')
                ]
            ]);

        $this->clearEvents();
    }
}
