<?php
namespace backend\controllers;

interface BaseControllerInterface
{
    public function getModel();
    public function getSearchModel();
}