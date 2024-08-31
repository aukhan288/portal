<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_assigned_users_to_leads extends CI_Migration
{
    public function up()
    {
        $fields = array(
            'assigned_users' => array(
                'type' => 'TEXT',
                'null' => TRUE,
                'default' => NULL,
                'after' => 'some_existing_column'  // Adjust according to your table structure
            ),
        );

        $this->db->forge->add_column('leads', $fields);
    }

    public function down()
    {
        $this->db->forge->drop_column('leads', 'assigned_users');
    }
}