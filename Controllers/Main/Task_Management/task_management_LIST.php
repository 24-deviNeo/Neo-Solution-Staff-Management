<?php

include_once __DIR__ . '/../../../UxUi-Back/Tasks/ProjectTaskStore.php';

class task_management_LIST
{
    private $conditions = [];
    private $limit = '';
    private $countOnly = false;
    private $removedOnly = false;
    private $store;

    public function __construct()
    {
        $this->store = new ProjectTaskStore();
    }

    public function filter_by_ast($ast)
    {
        $this->removedOnly = (string)$ast === '0';
    }

    public function filter_by_id($id)
    {
        $this->conditions[] = '`id` = ' . (int)$id;
    }

    public function filter_by_status($status)
    {
        $connection = $this->store->getConnection();
        $status = strtolower($connection->real_escape_string((string)$status));
        if ($status === 'pending') {
            $this->conditions[] = '`is_pending` = 1';
        } elseif ($status === 'completed' || $status === 'done') {
            $this->conditions[] = '`is_completed` = 1';
        } elseif ($status === 'in progress' || $status === 'in-progress') {
            $this->conditions[] = '`is_pending` = 0 AND `is_completed` = 0';
        }
    }

    public function filter_by_department($department)
    {
        $value = $this->store->getConnection()->real_escape_string((string)$department);
        $this->conditions[] = "`department` = '{$value}'";
    }

    public function filter_by_employee($employee)
    {
        $value = $this->store->getConnection()->real_escape_string((string)$employee);
        $this->conditions[] = "`assigned_to` LIKE '%{$value}%'";
    }

    public function filter_by_search($search)
    {
        $value = $this->store->getConnection()->real_escape_string((string)$search);
        $this->conditions[] = "(`title` LIKE '%{$value}%' OR `department` LIKE '%{$value}%' OR `assigned_to` LIKE '%{$value}%')";
    }

    public function get_count_report()
    {
        $this->countOnly = true;
    }

    public function set_data_limits($start, $count)
    {
        $this->limit = ' ORDER BY `id` DESC LIMIT ' . max(0, (int)$start) . ', ' . max(0, (int)$count);
    }

    public function remove_list()
    {
        $this->removedOnly = true;
    }

    public function get_result()
    {
        $connection = $this->store->getConnection();
        if ($this->removedOnly) {
            return $connection->query("SELECT `id` FROM `project_tasks` WHERE 1 = 0");
        }

        $selection = $this->countOnly
            ? 'COUNT(`id`) AS `count`'
            : "`id`, `title` AS `task_title`, `description`, `department`,
               `assigned_to` AS `assigned_employee`, `mode` AS `work_mode`, `priority`,
               `deadline`, `progress`,
               CASE WHEN `is_completed` = 1 THEN 'Completed'
                    WHEN `is_pending` = 1 THEN 'Pending' ELSE 'In Progress' END AS `status`";
        $sql = "SELECT {$selection} FROM `project_tasks`";
        if ($this->conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $this->conditions);
        }
        $sql .= $this->limit;
        $result = $connection->query($sql);
        if ($result === false) {
            throw new RuntimeException($connection->error);
        }
        return $result;
    }
}
?>
