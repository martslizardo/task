<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

	public $title;
	public $details;
	public $user_id;
	public $color;
	public $status;
	public $created_by;
	public $created_at;
	public $updated_at;

	public function get($status = null) {
		
		if($status != null)
			$tasks = $this->db->get_where('tasks', ['user_id' => 1, 'status' => $status])->result();
		else
			$tasks = $this->db->get('tasks')->result();
		foreach ($tasks as $task) {
			$task->notes = $this->get_task_notes($task->id);
		}
		return $tasks;
	}

	#
	# @params $order_by = column name
	# @params $direction = asc/desc
	#
	public function order_by($order_by, $direction) {
		return $this->db->order_by($order_by, $direction);
	}

	public function get_task_by_id($id) {
		return $this->db->get_where('tasks', ['id' => $id])->result();
	}

	public function get_task_notes($task_id) {
		return $this->db->get_where('task_notes', ['task_id' => $task_id])->result();
	}

	public function insert($task_details) {
		$task_details['user_id'] = 1;
		$task_details['status'] = 1;
		$task_details['created_at'] = date('Y-m-d');
		$task_details['updated_at'] = date('Y-m-d');

		$this->db->insert('tasks', $task_details);
	}

	public function archive($id){
		return $this->db->update('tasks', ['status' => 2, 'completion_date' => date('Y-m-d')], "id = $id");
	}

	public function update($key, $task_id, $val) {
		return $this->db->update('tasks', [$key => $val, 'updated_at' => date('Y-m-d')], "id = $task_id");
	}
	
}