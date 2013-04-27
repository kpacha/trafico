<?php
$services = getenv("VCAP_SERVICES");
$services_json = json_decode($services, true);
$parameters = array(
        'redis' => $services_json["redis-2.2"][0]["credentials"],
        'google.api.key' => getenv("GOOGLE_API_KEY")
    );

return $parameters;