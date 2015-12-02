<?php
/*
 * This file is part of the Borobodur-NestedSet package.
 *
 * (c) Hexacodelabs <http://hexacodelabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Borobudur\NestedSet\Helper;

use Borobudur\Collection\Criteria;
use Borobudur\Cqrs\Collection;
use Borobudur\Cqrs\Message\QueryInterface;
use Borobudur\Cqrs\ReadModel\AbstractReadModel;
use Borobudur\Cqrs\ReadModel\Repository\Repository;
use Borobudur\NestedSet\Model\Read\NestedSetInterface;

/**
 * @author      Steven Januar <januar.steven@gmail.com>
 * @created     01/12/15
 */
trait CalculateNestedSetHelperTrait
{
    /**
     * @var Repository
     */
    private $nestedSetRepository;

    /**
     * Calculate the nested set structure.
     *
     * @param QueryInterface $findAllQuery
     * @param Repository     $readModelRepository
     *
     * @throws \Exception
     */
    public function calculateNestedSetStructure(QueryInterface $findAllQuery, Repository &$readModelRepository)
    {
        /** @var Collection $allObj */
        $allObj = $this->query($findAllQuery);
        $root = $allObj->matching(
            Criteria::create()->where(
                Criteria::expr()->equal('depth', 0)
            )
        )->first()
        ;
        /** @var AbstractReadModel $root */
        $root = empty($root) ? $allObj->first() : $root;
        if (!$root instanceof NestedSetInterface) {
            throw new \Exception('Root is not a NestedSetInterface');
        }

        $this->nestedSetRepository = $readModelRepository;

        try {
            $this->calculateTree($allObj, $root->getId());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * The process to calculate the nested set left, right, and depth.
     *
     * @param Collection $data
     * @param string     $id
     * @param int        $left
     * @param int        $depth
     *
     * @return int
     * @throws \Exception
     */
    protected function calculateTree(Collection $data, $id = null, $left = 0, $depth = 0)
    {
        /** @var NestedSetInterface $node */
        $node = $data->matching(
            Criteria::create()->where(
                Criteria::expr()->equal('id', $id)
            )
        )->first()
        ;

        if (!$node instanceof NestedSetInterface) {
            throw new \Exception('Node is not a NestedSetInterface');
        }

        $left += 1;
        $prevRight = $left;

        $children = $data->matching(
            Criteria::create()->where(
                Criteria::expr()->equal('parentId', $id)
            )
        );
        foreach ($children as $childNode) {
            $childNodeId = $childNode->getId();
            $prevRight = $this->calculateTree($data, $childNodeId, $prevRight, $depth + 1);
        }

        $node->setLeft($left);
        $node->setRight($prevRight + 1);
        $node->setDepth($depth);

        $this->nestedSetRepository->save($node);

        return $node->getRight();
    }

    abstract protected function query(QueryInterface $query);
}
