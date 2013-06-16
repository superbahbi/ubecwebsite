<?php


$check = mysql_query("SELECT * FROM cp_event");

$month = isset($_GET['m']) ? $_GET['m'] : NULL;
$year  = isset($_GET['y']) ? $_GET['y'] : NULL;

$calendar = Calendar::factory($month, $year);

while($result=mysql_fetch_object($check)){

    $event = $calendar->event()
        ->condition('month', $result->month)      
        ->condition('day', $result->day)  
        ->condition('year', $result->year)  
        ->title($result->event)
        ->output('<a href="/index.php?page=event&action=view&id=' . $result->id . '">' . $result->event . '</a>' );
        
    $calendar->attach($event);

}
$calendar->standard('today')
    ->standard('prev-next')
	->standard('holidays');
?>

<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
<div class="span12">
    		<table class="calendar">
				<thead>
					<tr class="navigation">
						<th class="prev-month"><a href="<?php echo htmlspecialchars($calendar->prev_month_url()) ?>"><?php echo $calendar->prev_month() ?></a></th>
						<th colspan="5" class="current-month"><?php echo $calendar->month() ?></th>
						<th class="next-month"><a href="<?php echo htmlspecialchars($calendar->next_month_url()) ?>"><?php echo $calendar->next_month() ?></a></th>
					</tr>
					<tr class="weekdays">
						<?php foreach ($calendar->days() as $day): ?>
							<th><?php echo $day ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($calendar->weeks() as $week): ?>
						<tr>
							<?php foreach ($week as $day): ?>
								<?php
								list($number, $current, $data) = $day;
								
								$classes = array();
								$output  = '';
								
								if (is_array($data))
								{
									$classes = $data['classes'];
									$title   = $data['title'];
									$output  = empty($data['output']) ? '' : '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
								}
								?>
								<td class="day <?php echo implode(' ', $classes) ?>">
									<span class="date" title="<?php echo implode(' / ', $title) ?>"><?php echo $number ?></span>
									<div class="day-content">
										<?php echo $output ?>
									</div>
								</td>
							<?php endforeach ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
            <a class="btn btn-primary" href="/index.php?page=event&action=add">Add event</a>
</div>

