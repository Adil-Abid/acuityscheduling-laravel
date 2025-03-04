<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AcuityService
{
    protected $client;
    protected $userId;
    protected $apiKey;

    public function __construct()
    {
        $this->userId = env('ACUITY_USER_ID');
        $this->apiKey = env('ACUITY_API_KEY');
        $this->client = new Client([
            'base_uri' => 'https://acuityscheduling.com/api/v1/',
            'auth' => [$this->userId, $this->apiKey],
        ]);
    }

    /**
     * Fetch all appointment types.
     */
    public function getAppointmentTypes()
    {
        try {
            $response = $this->client->get('appointment-types');
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Create a new appointment.
     */
    public function createAppointment($data)
    {
        try {
            $response = $this->client->post('appointments', [
                'json' => $data,
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Fetch available appointment times.
     */
    public function getAvailability($appointmentTypeId, $date = null)
    {
        try {
            $query = ['query' => ['appointmentTypeID' => $appointmentTypeId]];
            if ($date) {
                $query['query']['date'] = $date;
            }
            $response = $this->client->get('availability/times', $query);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getAppointmentsByEmail($email)
{
    try {
        $response = $this->client->get('appointments', [
            'query' => ['email' => $email],
        ]);
        return json_decode($response->getBody(), true);
    } catch (GuzzleException $e) {
        return ['error' => $e->getMessage()];
    }
}
}
