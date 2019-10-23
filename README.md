# GA DataLayer plugin for CakePHP 3

## Introduction

This plugin allow you to store Google Analytics events in cookie and push them to Data Layer in below structure:

```
dataLayer.push({
    'event': 'customEventName',
    'customEventName': {
        "event_category":"Users",
        "event_action":"login",
        "event_label":null,
        "value":0
    }
});
```

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require kiczek/ga-datalayer-cakephp3
```

In Controller load component using:

```
$this->loadComponent("DataLayer.DataLayer", [
    'cookieKey' => '_dl',
    'eventName' => 'customEventName',
    'blockName' => 'dataLayerEvents'
]);
```

At the end of your layout render Data Layer push script:

```
echo $this->fetch('dataLayerEvents');
```

## Usage

Push event from Controller to Data Layer using:

```
$this->DataLayer->addEvent('Users', 'login');
```

