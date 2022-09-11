<?php

namespace App\Repositories;

interface RequestApiLogRepository{


    /**
     * Method to save a new page
     * @param int page
     * @return App\Models\UsersRequestLogModel information saved
     */
    public function savePage(int $page);

    /**
     * Method to get last page saved
     * @return int last page saved
     */
    public function getLastPage();

}
