<?php

use Sabre\VObject\Reader;
use GuzzleHttp\Client;
function parseICSFile($filePath,&$locations,&$dates) {
    $icsContent = file_get_contents($filePath);
    $vcalendar = Reader::read($icsContent);

    $events = [];
    foreach ($vcalendar->VEVENT as $vevent) {
        $events[] = [
            'uid' => (string) $vevent->UID,
            'summary' => (string) $vevent->SUMMARY,
            'location' => (string) $vevent->LOCATION,
            'start' => (string) $vevent->DTSTART,
            'end' => (string) $vevent->DTEND,
        ];
        $locations[(string) $vevent->LOCATION] = 1;
        $dates[] = (string) $vevent->DTSTART;
    }
    sort($dates);
    return $events;
}

function formatDateForGraph($icsDate, $sourceTimeZone = 'Europe/Amsterdam') {
    $date = DateTime::createFromFormat('Ymd\THis', $icsDate, new DateTimeZone($sourceTimeZone));
    if ($date) {
        return $date->format('Y-m-d\TH:i:s'); // ISO 8601 format
    }
    return null;
}

function getAccessToken($tenant_id, $client_id, $client_secret) {
    $client = new Client();
    $url = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/token";

    $response = $client->post($url, [
        'form_params' => [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => 'https://graph.microsoft.com/.default',
            'grant_type' => 'client_credentials',
        ],
    ]);

    $data = json_decode($response->getBody(), true);
    return $data['access_token'];
}

function getEventsByPeriod($accessToken, $email, $startDate, $endDate) {
    // Debug the input dates
    // Format start and end dates for the query
    $startDate = (new DateTime(substr($startDate, 0, 10) . " 00:00:00", new DateTimeZone('Europe/Amsterdam')))
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d\TH:i:s\Z');
    $endDate = (new DateTime(substr($endDate, 0, 10) . " 23:59:59", new DateTimeZone('Europe/Amsterdam')))
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d\TH:i:s\Z');

    // Initialize HTTP client
    $client = new Client();
    $url = "https://graph.microsoft.com/v1.0/users/$email/events";

    // Query parameters
    $query = [
        '$filter' => "start/dateTime ge '$startDate' and end/dateTime le '$endDate' and location/displayName eq 'RSTR-RM'",
        '$top' => 999, // Optional limit for the number of results
    ];

    // Make a single API request
    try {
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
            ],
            'query' => $query,
        ]);

        // Parse the response
        $data = json_decode($response->getBody(), true);

        // Extract events if available
        if (isset($data['value'])) {
            return $data['value']; // Return all retrieved events
        }

        // Return an empty array if no events were found
        return [];
    } catch (\Exception $e) {
        // Handle errors (e.g., invalid token, network issues)
        echo "Error fetching events: " . $e->getMessage();
        return [];
    }
}

function getAllEventsByPeriod($accessToken, $email, $startDate, $endDate) {
    // Debug the input dates
    // Format start and end dates for the query
    $startDate = (new DateTime(substr($startDate, 0, 10) . " 00:00:00", new DateTimeZone('Europe/Amsterdam')))
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d\TH:i:s\Z');
    $endDate = (new DateTime(substr($endDate, 0, 10) . " 23:59:59", new DateTimeZone('Europe/Amsterdam')))
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d\TH:i:s\Z');

    // Initialize HTTP client
    $client = new Client();
    $url = "https://graph.microsoft.com/v1.0/users/$email/events";

    // Query parameters
    $query = [
        '$filter' => "start/dateTime ge '$startDate' and end/dateTime le '$endDate'", //  and location/displayName eq 'RSTR-RM'
        // '$filter' => "start/dateTime ge '$startDate' and end/dateTime le '$endDate' and location/displayName eq 'RSTR-RM'",
        // '$filter' => "start/dateTime ge '$startDate' and end/dateTime le '$endDate' and (location/displayName eq 'RSTR-RM' or locations/any(loc: loc/displayName eq 'RSTR-RM'))",

        '$top' => 999, // Optional limit for the number of results
    ];

    // Make a single API request
    try {
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
            ],
            'query' => $query,
        ]);

        // Parse the response
        $data = json_decode($response->getBody(), true);

        // Extract events if available
        if (isset($data['value'])) {
            return $data['value']; // Return all retrieved events
        }

        // Return an empty array if no events were found
        return [];
    } catch (\Exception $e) {
        // Handle errors (e.g., invalid token, network issues)
        echo "Error fetching events: " . $e->getMessage();
        return [];
    }
}

function deleteEventsByLocation($accessToken, $email, $events) {
    $client = new Client();

    foreach ($events as $event) {
        if (isset($event['location']['displayName']) && $event['location']['displayName'] === "RSTR-RM") {
            // echo "Deleting event {$event['id']}\n";
            try {
                $url = "https://graph.microsoft.com/v1.0/users/$email/events/" . $event['id'];
                $client->delete($url, [
                    'headers' => [
                        'Authorization' => "Bearer $accessToken",
                    ],
                ]);
                echo "Deleted event: " . $event['subject'] . "\n";
            } catch (Exception $e) {
                echo "Failed to delete event: " . $event['subject'] . "\n";
                echo "Error: " . $e->getMessage() . "\n";

                if (method_exists($e, 'getResponse')) {
                    echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
                }
            }
        }
        ob_flush();
        flush();
    }
}

function addEventToCalendar($accessToken, $email, $event) {
    $client = new Client();
    $url = "https://graph.microsoft.com/v1.0/users/$email/events";

    $data = [
        'subject' => $event['subject'],
        'start' => [
            'dateTime' => $event['start'],
            'timeZone' => 'Europe/Amsterdam',
        ],
        'end' => [
            'dateTime' => $event['end'],
            'timeZone' => 'Europe/Amsterdam',
        ],
        'showAs' => 'free',
        'categories' => ["RSTR " . $event['subject']],
        'location' => [
            'displayName' => 'RSTR-RM',
        ],
        'isReminderOn' => false, // Explicitly disable reminders
    ];

    if ($event['allDay']) {
        $data['isAllDay'] = true;
    }

    try {
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        if ($response->getStatusCode() === 201) {
            echo "Event added successfully: " . $event['subject'] . "\n";
        }
    } catch (Exception $e) {
        echo "Failed to add event: " . $event['subject'] . "\n";
        echo "Error: " . $e->getMessage() . "\n";

        if (method_exists($e, 'getResponse')) {
            echo "Response: " . $e->getResponse()->getBody()->getContents() . "\n";
        }
    }
}

function RunCalender($filename,$email,$accessToken) {
    global $diensten;
    echo "---\nRunning for $email\n";
    // Define locations and dates
    $locations = [];
    $dates = [];

    // $icsevents = parseICSFile("hans.ics");
    $icsevents = parseICSFile($filename,$locations,$dates);

    $l = array_keys($locations);

    $events = [];
    foreach ($icsevents as $event) {
        // $location = $event['location'];
        $summary = implode("|", array_filter(array_map('trim', explode("|", $event['summary']))));
        $dienst = $diensten[$summary] ?? "N/A ($summary)";
        $allday = !empty($dienst) && $dienst[0] === '#' ? 1 : 0;
        $dienst = ltrim($dienst, '#');
        $event['allday'] = $allday;
        $event['subject'] = $dienst;
        if ($dienst=="ICT-S") {
            // tijden aanpassen S dienst.
            $event['start'] = preg_replace('/(\d{8})T083000/im', '\1T090000', $event['start']);
            $event['end'] = preg_replace('/(\d{8})T180000/im', '\1T173000', $event['end']);
        }
        $events[] = $event;
    }

    $icsStartDate = reset($dates);
    $icsEndDate = end($dates);

    $startDate = formatDateForGraph($icsStartDate);
    $endDate = formatDateForGraph($icsEndDate);

    // $roosterevents = getEventsByPeriod($accessToken, $email, $startDate, $endDate);
    $roosterevents = getAllEventsByPeriod($accessToken, $email, $startDate, $endDate);

    // var_dump($roosterevents);
    // exit;
    deleteEventsByLocation($accessToken, $email, $roosterevents);

    foreach ($events as $event) {
        
        if ($event['allday']) {
                // var_dump($event['start']);
                $start = $event['start'];
                $event['start'] = (new DateTime(substr($start, 0, 8), new DateTimeZone('Europe/Amsterdam')))
                    ->modify('+0 day')
                    ->format('Ymd') . 'T000000';
                // var_dump($event['start']);
                $event['end'] = (new DateTime(substr($start, 0, 8), new DateTimeZone('Europe/Amsterdam')))
                    ->modify('+1 day')
                    ->format('Ymd') . 'T000000';
                $allDay = true;
        } else {
                $allDay = false;
        }

        $eventToAdd = [
            'subject' => $event['subject'],
            'start' => formatDateForGraph($event['start']),
            'end' => formatDateForGraph($event['end']),
            'allDay' => $allDay,
        ];

        // echo "Adding event: " . $eventToAdd['subject'] . "\n";
        addEventToCalendar($accessToken, $email, $eventToAdd);
        ob_flush();
        flush();
    }

}

?>