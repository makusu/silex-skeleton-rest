<?php

namespace Todo\TaskBundle\Repository;

use Todo\TaskBundle\Core\RepositoryCore;

class ItemRepository extends RepositoryCore
{
    public function insert($params) {
        $params['created'] = date("Y-m-d H:i:s");

        return $this->db->insert($this->table, $params);
    }
}
