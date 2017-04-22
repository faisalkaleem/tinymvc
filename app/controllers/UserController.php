<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Faisal
 */
class UserController extends BaseConroller {
    public function actionLogin() {
        $this->render('login');
    }
}
