<?php
/*
 * This file is part of the Borobodur-NestedSet package.
 *
 * (c) Hexacodelabs <http://hexacodelabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Borobudur\NestedSet\Model\Read;

/**
 * @author      Steven Januar <januar.steven@gmail.com>
 * @created     01/12/15
 */
trait NestedSetTrait
{
    /**
     * @var string
     */
    private $parentId;

    /**
     * @var int
     */
    private $left;

    /**
     * @var int
     */
    private $right;

    /**
     * @var int
     */
    private $depth;

    /**
     * Get the parent id.
     *
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set the parent id.
     *
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get the left value.
     *
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set the left value.
     *
     * @param int $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * Get the right value.
     *
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Set the right value.
     *
     * @param int $right
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * Get the depth.
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set the depth.
     *
     * @param int $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }
}
