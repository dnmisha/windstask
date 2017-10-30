<?php

namespace Mvc\Application\Controllers;

use Mvc\Application\Models\Tree;
use Mvc\Components\SevenWinds;
use Mvc\Core\Base\BaseController;
use MvcKernel;


class TaskController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex($id)
    {
        switch ($id) {
            case 1:
                if (MvcKernel::$app->request->isPost() && $string = MvcKernel::$app->request->post('string')) {
                    $sevenWinds = new SevenWinds();
                    $data = $sevenWinds->parseTags($string);
                    return $this->render('task1', compact('data'));
                }
                return $this->render('task1');

                break;
            case 2:
                if (MvcKernel::$app->request->isPost() && MvcKernel::$app->request->post('random') && $count = MvcKernel::$app->request->post('count')) {
                    $data = Tree::generateRandomTree((int)$count);
                    $data  = empty($data)?'empty tree':SevenWinds::renderTree($data);
                    return $this->render('task2', compact('data'));
                }
                return $this->render('task2');
                break;
            case 3:
                if (MvcKernel::$app->request->isPost() && $string = MvcKernel::$app->request->post('string')) {
                    $sevenWinds = new SevenWinds();
                    $rawData = $sevenWinds->arrayCombinationGenerate($string);
                    $data = $sevenWinds->renderArrayCombination($rawData);
                    return $this->render('task3', compact('data'));
                }
                return $this->render('task3');
                break;
            default:
                return MvcKernel::$app->request->redirect('/');
                break;
        }

    }

    /**
     * @return string
     */
    public function actionDemo()
    {
        return $this->render('demo', ['rw' => 'wd']);
    }
}