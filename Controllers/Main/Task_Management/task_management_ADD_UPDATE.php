<?php

include_once __DIR__ . '/../../../UxUi-Back/Tasks/ProjectTaskStore.php';

class task_management_ADD_UPDATE
{
    private $id = 0;
    private $task_title = '';
    private $description = '';
    private $department = '';
    private $assigned_employee = '';
    private $work_mode = 'Online';
    private $priority = 'Medium';
    private $deadline = '';
    private $status = 'Pending';
    private $ast = '1';
    private $error_msg = '';

    public function set_id($id)
    {
        $this->id = (int)$id;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function set_data(
        $task_title,
        $department,
        $assigned_employee,
        $work_mode = 'Online',
        $deadline = '',
        $priority_or_status = 'Medium',
        $status = null,
        $description = ''
    ) {
        $this->task_title = trim((string)$task_title);
        $this->department = trim((string)$department);
        $this->assigned_employee = trim((string)$assigned_employee);
        $this->work_mode = trim((string)$work_mode);
        $this->deadline = trim((string)$deadline);
        $this->description = trim((string)$description);

        if ($status === null && in_array(strtolower(trim((string)$priority_or_status)), ['pending', 'in progress', 'in-progress', 'completed', 'done'], true)) {
            $this->priority = 'Medium';
            $this->status = trim((string)$priority_or_status);
        } else {
            $this->priority = trim((string)$priority_or_status) ?: 'Medium';
            $this->status = $status === null ? 'Pending' : trim((string)$status);
        }
    }

    public function set_task_title($value) { $this->task_title = trim((string)$value); }
    public function set_description($value) { $this->description = trim((string)$value); }
    public function set_department($value) { $this->department = trim((string)$value); }
    public function set_assigned_employee($value) { $this->assigned_employee = trim((string)$value); }
    public function set_work_mode($value) { $this->work_mode = trim((string)$value); }
    public function set_priority($value) { $this->priority = trim((string)$value); }
    public function set_deadline($value) { $this->deadline = trim((string)$value); }
    public function set_status($value) { $this->status = trim((string)$value); }
    public function remove() { $this->ast = '0'; }
    public function get_error() { return $this->error_msg; }

    private function save($isNew)
    {
        try {
            $store = new ProjectTaskStore();
            $data = [
                'id' => $isNew ? 0 : $this->id,
                'title' => $this->task_title,
                'description' => $this->description,
                'department' => $this->department,
                'assigned_to' => $this->assigned_employee,
                'mode' => $this->work_mode,
                'priority' => $this->priority,
                'deadline' => $this->deadline,
                'status' => $this->status
            ];
            $this->id = $store->saveTask($data);
            $this->error_msg = '';
            return true;
        } catch (Throwable $error) {
            $this->error_msg = $error->getMessage();
            return false;
        }
    }

    public function process_new_record()
    {
        return $this->save(true);
    }

    public function process_update()
    {
        if ($this->ast === '0') {
            try {
                $store = new ProjectTaskStore();
                $deleted = $store->deleteTask($this->id);
                $this->error_msg = $deleted ? '' : 'Task not found.';
                return $deleted;
            } catch (Throwable $error) {
                $this->error_msg = $error->getMessage();
                return false;
            }
        }
        return $this->save(false);
    }
}

if (!class_exists('data_ADD_UPDATE')) {
    class data_ADD_UPDATE extends task_management_ADD_UPDATE {}
}
?>
