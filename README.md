yii2-widget-timepicker
======================

log user actions, insert update delete

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
$ php composer.phar require rikcage/yii2-user-logs "@dev"
```

or add

```
"rikcage/yii2-user-logs": "@dev"
```

to the ```require``` section of your `composer.json` file.

./yii migrate --migrationPath=@rikcage/user-logs/migrations --interactive=0


## Usage

```php
use rikcage\time\TimePicker;

// usage without model
echo '<label>Start Time</label>';
echo TimePicker::widget([
	'name' => 'start_time', 
	'value' => '54:24',
	'pluginOptions' => [
		'showSeconds' => true
	]
]);
```
