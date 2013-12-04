<?php
//In your controller

$calendar = new CalendarWidget();

//all days in the calendar that are in your query will get a link, here you specify its format
//:day will be replaced by the date in format 2011-12-08
$calendar->setUrlTemplate('/events/day/:day');

//provide the date and the class you want applied to that date's link in the setDate method
foreach($events as $event){
	$calendar->setDate($event->startDate, 'red');
}



//In your view:

//Be sure to include CalendarWidget.js
//You do need to use classes 'calendar-widget', 'previous-month', 'current-month', and 'next-month' for the js to //work properly but their exact html markup is up to you, provided 'calendar-widget' contains the other classes.
?>

<div class="calendar-widget">
	<div class="header">
        <span class="previous-month"></span>
        <span class="current-month"></span>
        <span class="next-month"></span>
    </div>
	<?php $calendar->render(); ?>
</div>