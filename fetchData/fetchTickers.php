<?php
include 'config.php';

$url = "https://api.coinmarketcap.com/v2/ticker/?convert=BTC";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);

$output = json_decode($output);


foreach($output->data as $key =>$value)
{
	// print_r($output->data->$key);
	$id = $output->data->$key->id;
	$name = $output->data->$key->name;
	$symbol = $output->data->$key->symbol;
	$rank = $output->data->$key->rank;
	$slug = $output->data->$key->website_slug;
	$circ_supply = $output->data->$key->circulating_supply;	
	$total_supply = $output->data->$key->total_supply;
	$max_supply = $output->data->$key->max_supply;

	$usd_price = $output->data->$key->quotes->USD->price;
	$usd_vol24 = $output->data->$key->quotes->USD->volume_24h;
	$usd_marketcap = $output->data->$key->quotes->USD->market_cap;
	$usd_per1h = $output->data->$key->quotes->USD->percent_change_1h;
	$usd_per24h = $output->data->$key->quotes->USD->percent_change_24h;
	$usd_per7d = $output->data->$key->quotes->USD->percent_change_7d;

	$btc_price = $output->data->$key->quotes->BTC->price;
	$btc_vol24 = $output->data->$key->quotes->BTC->volume_24h;
	$btc_marketcap = $output->data->$key->quotes->BTC->market_cap;
	$btc_per1h = $output->data->$key->quotes->BTC->percent_change_1h;
	$btc_per24h = $output->data->$key->quotes->BTC->percent_change_24h;
	$btc_per7d = $output->data->$key->quotes->BTC->percent_change_7d;
	
	$check = "Select * from `tickers` where `id` = '$id'";
	$result = $connection->query($check);

	if($result->num_rows > 0)
	{
		$updateTickers = "UPDATE `tickers` SET `rank`='$rank',`circ_supply`='$circ_supply',`usd_price`='$usd_price',`usd_vol24`='$usd_vol24',`usd_marketcap`='$usd_marketcap',`usd_per1h`='$usd_per1h',`usd_per24h`='$usd_per24h',`usd_per7d`='$usd_per7d',`btc_price`='$btc_price',`btc_vol24`='$btc_vol24',`btc_marketcap`='$btc_marketcap',`btc_per1h`='$btc_per1h',`btc_per24h`='$btc_per24h',`btc_per7d`='$btc_per7d' where `id` = '$id'";
		if($connection->query($updateTickers) == FALSE)
	{
		echo "Error ".$connection->error;
	}

	}
	else
	{
	$sql = "INSERT INTO `tickers`(`id`, `name`, `symbol`, `rank`, `slug`, `circ_supply`, `total_supply`, `max_supply`, `usd_price`, `usd_vol24`, `usd_marketcap`, `usd_per1h`, `usd_per24h`, `usd_per7d`, `btc_price`, `btc_vol24`, `btc_marketcap`, `btc_per1h`, `btc_per24h`, `btc_per7d`) VALUES ('$id', '$name', '$symbol', '$rank', '$slug', '$circ_supply', '$total_supply', '$max_supply', '$usd_price', '$usd_vol24', '$usd_marketcap', '$usd_per1h', '$usd_per24h', '$usd_per7d', '$btc_price', '$btc_vol24', '$btc_marketcap','$btc_per1h', '$btc_per24h', '$btc_per7d')";

	if($connection->query($sql) == FALSE)
	{
		echo "Error ".$connection->error;
	}
	}
}
?>