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

        $keys = array();
        foreach ($builtData as $rec) {
            $parentId = $rec['parentId'];
            if (!isset($keys[$parentId])) {
                $keys[$parentId] = array();
            }

            array_push($keys[$parentId], $rec);
        }

        $this->treeData = array();
        $this->buildTree($this->treeData, $keys);

        return $this->treeData;
    }

    /**
     * Build the data into tree.
     *
     * @param array  $tree
     * @param array  $keys
     * @param string $id
     * @param int    $depth
     *
     * @return int
     */
    protected function buildTree(array &$tree, array &$keys, $id = null, $depth = 0)
    {
        if (!isset($keys[$id])) {
            return 0;
        }

        $total = 0;
        foreach ($keys[$id] as $i => $rec) {
            $node = &$keys[$id][$i];
            $node['children'] = array();
            $total += $n = $this->buildTree($node['children'], $keys, $node['id'], $depth + 1);
            $node['n'] = $n;
        }

        $tree = $keys[$id];

        return $total + sizeof($keys[$id]);
    }
}
