<?php
/*
 * This file is part of the Borobodur-NestedSet package.
 *
 * (c) Hexacodelabs <http://hexacodelabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Borobudur\NestedSet\Model\View;

use Borobudur\Cqrs\ViewModel\ViewModel;

/**
 * @author      Steven Januar <januar.steven@gmail.com>
 * @created     03/12/15
 */
class TreeViewModel extends ViewModel
{
    /**
     * @var array
     */
    protected $treeData;

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        if (null !== $this->treeData) {
            return $this->treeData;
        }

        $builtData = parent::build();
        $data = $this->getData();

        $maps = array();
        foreach ($data as $i => $rec) {
            $parentId = $rec['parentId'];
            if (!isset($maps[$parentId])) {
                $maps[$parentId] = array();
            }

            array_push($maps[$parentId], array(
                'id' => $rec['id'],
                'data' => $builtData[$i]
            ));
        }

        $this->treeData = array();
        $this->buildTree($this->treeData, $maps);

        return $this->treeData;
    }

    /**
     * Build the data into tree.
     *
     * @param array  $tree
     * @param array  $maps
     * @param string $id
     * @param int    $depth
     */
    protected function buildTree(array &$tree, array $maps, $id = null, $depth = 0)
    {
        if (!isset($maps[$id])) {
            return;
        }

        foreach ($maps[$id] as $map) {
            $node = $map['data'];
            $node['children'] = array();
            $this->buildTree($node['children'], $maps, $map['id'], $depth + 1);

            array_push($tree, $node);
        }
    }
}
