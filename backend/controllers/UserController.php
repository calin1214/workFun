<?php

namespace backend\controllers;

use common\models\UserModel;

/**
 * User controller
 */
class UserController
{
    /**
     * @return void
     */
    public function index()
    {
        global $params;

        $userModel = new UserModel();
        $data = $userModel->getAllWithPagination();

        include 'views/user/index.php';
    }

    /**
     * @return void
     */
    public function export()
    {
        $userModel = new UserModel();
        $data = $userModel->getAll();

        $csv_data = $this->getCsv($data);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_data.csv"');

        echo $csv_data;
        exit();
    }

    /**
     * @param $data
     * @return false|string
     */
    private function getCsv($data)
    {
        $output = fopen('php://temp', 'w');
        fputs($output, "\xEF\xBB\xBF");
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        return $csv;
    }
}