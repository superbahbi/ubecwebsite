<h1>
    <?php 
    echo ucfirst($page);
    ?>
</h1>

<div class="span12">
    <?php
        include './config/function.php';
		include_once('./classes/trading.class.php');	
	
		$trading = new trading();
		
		try {
			$trading->url = 'http://www.gw2spidy.com/api/v0.9/json/gem-price';
			$trading->get_api_data();
		
			foreach ($trading->get_api_data() as $item) {
				$gem_to_gold = $item->gem_to_gold;
				$gold_to_gem = $item->gold_to_gem;
			}

			$gold_to_usd = round((1.25 * 10000) / $gem_to_gold, 2);
			$gem_to_gold = convert_gold($gem_to_gold);
			$gold_to_gem = convert_gold($gold_to_gem);
		} catch (Exception  $e ) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
				return;
		}
			
        echo '<h3> Gem Exchange Rate </h3>';
		echo '<ul>';
             echo '<li>100 gems sells for '; $trading->show_gold($gem_to_gold);  echo '<br>';
             echo '<li>100 gems costs '; $trading->show_gold($gold_to_gem); echo 'to buy. <br>';
             echo '<li>100 gems costs 1.25 USD to buy.</li>';
             echo '<li>1<a class="gw2gold">g</a> costs ';  echo $gold_to_usd; echo ' USD to buy through gems.';
        echo '</ul>';
		
		echo '<h3> Precursor </h3>';
		
		
		echo '<div class="row">';
			foreach($item_id as $item) {					
				echo '<div class="span3 ">';
					$url = 'http://www.gw2spidy.com/api/v0.9/json/item/';
					$url .= $item;
					$trading->item_id = $item;
					$trading->url = $url;
					$trading->show_data($trading->get_api_data());
				echo'</div>';
			}
		echo'</div>';
		
?>
</div>