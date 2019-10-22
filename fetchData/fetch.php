<?php
include 'config.php';

$url = "https://api.coinmarketcap.com/v2/listings/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);

$output = json_decode($output);


for($i =0; $i<sizeof($output->data); $i++)
{
	// print_r($output->data[$i]);
	$id  = $output->data[$i]->id;
	$name = mysqli_real_escape_string($connection,$output->data[$i]->name);
	$symbol = $output->data[$i]->symbol;
	$slug = $output->data[$i]->website_slug;
	$sql = "Insert into coin_list(id,name, symbol, slug) values ('$id', '$name', '$symbol','$slug')";

	if($connection->query($sql) == FALSE)
	{
		echo "Error ".$connection->error;
	}
}
?>