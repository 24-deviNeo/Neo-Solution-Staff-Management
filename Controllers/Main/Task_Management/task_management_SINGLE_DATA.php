<?php

include_once __DIR__ . '/../../../UxUi-Back/Tasks/ProjectTaskStore.php';

class task_management_SINGLE_DATA
{
    private $data = null;

    public function __construct($id)
    {
        $store = new ProjectTaskStore();
        $this->data = $store->getTask((int)$id);
    }

    public function get_state()
    {
        return $this->data !== null;
    }

    public function get_id() { return $this->data['id'] ?? null; }
    public function get_task_title() { return $this->data['title'] ?? null; }
    public function get_department() { return $this->data['department'] ?? null; }
    public function get_assigned_employee() { return $this->data['assigned_to'] ?? null; }
    public function get_work_mode() { return $this->data['mode'] ?? null; }
    public function get_priority() { return $this->data['priority'] ?? null; }
    public function get_deadline() { return $this->data['deadline'] ?? null; }
    public function get_status() { return $this->data['status'] ?? null; }

    public function to_array()
    {
        if ($this->data === null) {
            return [];
        }
        return [
            'id' => (int)$this->data['id'],
            'task_title' => $this->data['title'],
            'description' => $this->data['description'],
            'department' => $this->data['department'],
            'assigned_employee' => $this->data['assigned_to'],
            'work_mode' => $this->data['mode'],
            'priority' => $this->data['priority'],
            'deadline' => $this->data['deadline'],
            'progress' => (int)$this->data['progress'],
            'status' => $this->data['status']
        ];
    }
}
?>
