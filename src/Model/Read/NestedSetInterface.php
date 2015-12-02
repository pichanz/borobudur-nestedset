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

use Borobudur\Cqrs\ReadModel\ReadModelInterface;

/**
 * @author      Steven Januar <januar.steven@gmail.com>
 * @created     01/12/15
 */
interface NestedSetInterface extends ReadModelInterface
{
    public function getParentId();

    public function setParentId($parentId);

    public function getLeft();

    public function setLeft($left);

    public function getRight();

    public function setRight($right);

    public function getDepth();

    public function setDepth($depth);
}
