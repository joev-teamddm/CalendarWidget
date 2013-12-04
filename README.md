CalendarWidget
==============

Class for easily rendering a calendar server-side in PHP.  Loop through your query of events, etc. and easily highlight and provide actions to dates with one simple method call.

###In your controller:
$calendar = new CalendarWidget();
//this url will be applied to all days with events, :day will be replaced by the date in format 2011-12-08
$calendar->setUrlTemplate('/events/day/:day');

//parameters (date of event, css class for this date)
foreach($events as $event){
	$calendar->setDate($event->startDate, 'red');
}

###In your view:
Be sure to include CalendarWidget.js
You do need to use classes 'calendar-widget', 'previous-month', 'current-month', and 'next-month' for the js to work properly but their exact html structure is up to you provided 'calendar-widget' contains the other classes.
<div class="calendar-widget">
	<div class="header">
        <span class="previous-month">◄</span>
        <span class="current-month"></span>
        <span class="next-month">►</span>
    </div>
	<?php $calendar->render(); ?>
</div>