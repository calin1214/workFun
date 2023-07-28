<?php

namespace frontend\controllers;

use common\models\UserModel;
use Exception;

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
        $model = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imageUploaded = true;
            $model->name = $_POST['name'];
            $model->email = $_POST['email'];
            $model->terms_of_service = isset($_POST['acceptTerms']) ? 1 : 0;

            if (!empty($_FILES) && !empty($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $imageUploaded = false;
                try {
                    $model->image = strtolower(str_replace(' ', '_', $model->name)) .
                        '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    $model->uploadImage();

                    $imageUploaded = true;
                } catch (Exception $exc) {
                    $errorTitle = 'Not Acceptable';
                    $errorMessage = $exc->getMessage();

                    include 'views/user/_form_error.php';
                }
            }

            if ($imageUploaded) {
                try {
                    $model->save();

                    $model = new UserModel();
                    include 'views/site/success.php';
                } catch (Exception $exc) {
                    $errorTitle = 'Bad Request (#400)';
                    $errorMessage = $exc->getMessage();

                    include 'views/user/_form_error.php';
                }
            }
        }

        include 'views/user/index.php';
    }
}