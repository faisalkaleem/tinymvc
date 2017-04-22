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
class ProgramController extends BaseConroller {
    public function actionIndex() {
        $program = new Program();
        $programs = $program->findAll();
        $this->render('index', array('programs' => $programs));
    }
}
