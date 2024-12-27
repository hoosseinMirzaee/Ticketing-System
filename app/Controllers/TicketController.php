<?php

namespace App\Controllers;

use App\Models\Ticket;

class TicketController
{
    private $ticket_model;

    public function __construct()
    {
        $this->ticket_model = new Ticket();
    }

    public function index()
    {
        header('Content-Type: application/json');
        echo json_encode($this->ticket_model->get());
    }

// Create a new ticket
    public function store()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->subject) && !empty($data->description)) {
            $this->ticket_model->create(['user_name', 'user_mobile', 'user_email', 'subject', 'description', 'status'], [$data->user_name, $data->user_mobile, $data->user_email, $data->subject, $data->description, $data->status]);
            echo json_encode(['message' => 'Ticket created successfully']);
        } else {
            echo json_encode(['message' => 'Invalid data']);
        }
    }

// Update an existing ticket
    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->subject) && !empty($data->description)) {
            $this->ticket_model->update(['user_name', 'user_mobile', 'user_email', 'subject', 'description', 'status'], [$data->user_name, $data->user_mobile, $data->user_email, $data->subject, $data->description, $data->status], $id);
            echo json_encode(['message' => 'Ticket updated successfully']);
        } else {
            echo json_encode(['message' => 'Invalid data']);
        }
    }

// Delete a ticket
    public function delete($id)
    {
        $this->ticket_model->delete($id);
        echo json_encode(['message' => 'Ticket deleted successfully']);
    }
}