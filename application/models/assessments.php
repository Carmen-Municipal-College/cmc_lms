<?php
defined('BASEPATH') or exit('No direct script access allowed');

class assessments extends CI_Model
{

    public function get_students_assessments($student_id, $section)
    {
        $sql = "
            SELECT 
                a.id,
                a.iotype_id,
                a.title,
                a.description,
                a.max_score,
                a.created_at,
                a.due,
                iot.type,
                cs.section
            FROM 
                classwork_assign a
            LEFT JOIN 
                submissions c 
                ON a.id = c.id 
                AND c.student_id = ?
            JOIN 
                class_schedule cs
                ON a.schedule_id = cs.schedule_id
            JOIN
                io_type iot
                ON iot.iotype_id = a.iotype_id
            WHERE 
                c.classwork_id IS NULL AND cs.section = ?
            ORDER BY 
                a.created_at DESC
        ";

        $query = $this->db->query($sql, [$student_id, $section]);

        if ($query === false) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return []; // Return an empty array or handle the error as needed
        }

        return $query->result_array();
    }

    public function get_submitted_assessments($student_id)
    {
        $sql = "
            SELECT * FROM classworks c 
            JOIN assessments a ON c.assessment_id = a.assessment_id 
            JOIN io_type iot ON a.iotype_id = iot.iotype_id
            WHERE student_id = ? ORDER BY c.created_at DESC";

        $query = $this->db->query($sql, [$student_id]);

        if ($query === false) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return []; // Return an empty array or handle the error as needed
        }

        return $query->result_array();
    }
}
