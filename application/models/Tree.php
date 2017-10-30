<?php
/**
 * Created by PhpStorm.
 * User: misha
 * Date: 02.09.17
 * Time: 16:50
 */

namespace Mvc\Application\Models;


use Mvc\Core\Base\BaseModel;
use Mvc\Core\Base\Db;
use Mvc\Core\MvcKernel;

class Tree extends BaseModel
{
    public $currentTable = 'tree';

    public $id;
    public $name;
    public $parent;

    public $children = [];

    public function fields()
    {
        return [
            'name',
            'parent',
            'id',
        ];
    }

    /**
     * @param $count
     * @return array
     */
    public static function generateRandomTree($count)
    {
        /**
         * @var $db Db
         */
        $db = MvcKernel::$app->getDb();
        $db->query('TRUNCATE table tree;');
        $tree = $hierarchyTree = [];
        for ($i = 1; $i <= $count+1; $i++) {
            $branch = new Tree();
            $branch->name = $branch->generateRandomString(rand(1, 4));
            $parentId = rand(0, $i);
            while ($parentId == $i || self::getCountChild($tree, $parentId) >= 5) {
                $parentId = rand(0, $i);
            }
            $branch->parent = $parentId;
            $branch->id = $i;
            $branch->save();
            $tree[$i] = $branch;
        }
        Tree::makeTree($tree, 0, $hierarchyTree);
        return $hierarchyTree;
    }

    /**
     * @param $tree
     * @param $id
     * @param int $countChilds
     * @return int
     */
    public static function getCountChild($tree, $id, $countChilds = 0)
    {
        if (isset($tree[$id]) && $tree[$id]->parent) {
            $countChilds += self::getCountChild($tree, $tree[$id]->parent, $countChilds) + 1;
        }
        return $countChilds;
    }

    /**
     * @param $rst
     * @param $level
     * @param $tree
     */
    public static function makeTree($rst, $level, &$tree)
    {
        for ($i = 1, $n = count($rst); $i < $n; $i++) {
            if ($rst[$i]->parent == $level) {
                $branch = new Tree();
                $branch->id = $rst[$i]->id;
                $branch->name = $rst[$i]->name;
                $branch->parent = $rst[$i]->parent;
                $branch->children = [];
                Tree::makeTree($rst, $rst[$i]->id, $branch->children);
                $tree[] = $branch;
            }
        }
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}