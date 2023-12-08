<?php

include('includes/connect.php');
include('includes/config.php');
include('includes/functions.php');

$url = 'https://rebrickable.com/api/v3/lego/colors/?page_size=1000';

$curl = curl_init($url);

/* curl will not verify the SSL certificate against the host name of the server */
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
/* curl will not verify the peer's SSL certificate */
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Authorization: key '.REBRICKABLE_API_KEY,
]);

$response = curl_exec($curl);
curl_close($curl);

$response = json_decode($response, true);

echo '<pre>';
print_r($response);
echo '</pre>';
    
$query = 'TRUNCATE TABLE colours';
mysqli_query($connect, $query);

$query = 'TRUNCATE TABLE externals';
mysqli_query($connect, $query);

foreach($response['results'] as $colour)
{

    echo '<pre>';
    print_r($colour);
    echo '</pre>';

    $query = 'INSERT INTO colours (
            name,
            is_trans,
            rgb,
            rebrickable_id
        ) VALUES (
            "'.$colour['name'].'",
            "'.($colour['is_trans'] ? 'yes' : 'no').'",
            "'.$colour['rgb'].'",
            "'.$colour['id'].'"
        )';
    mysqli_query($connect, $query);

    $id = mysqli_insert_id($connect);

    foreach($colour['external_ids'] as $key => $value)
    {

        foreach($value['ext_ids'] as $key2 => $value2)
        {

            $query = 'INSERT INTO externals (
                    name,
                    source,
                    colour_id,
                    external_id
                ) VALUES (
                    "'.$colour['external_ids'][$key]['ext_descrs'][$key2][0].'",
                    "'.strtolower($key).'",
                    "'.$id.'",
                    "'.($value2 ? $value2 : $key2).'"
                )';
            mysqli_query($connect, $query);

        }

    }

}

