<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
namespace PrestaShop\Module\Chatgptcontentgenerator\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PrestaShop\Module\Chatgptcontentgenerator\Entity\GptContentGenerator;

class GptContentGeneratorRepository extends EntityRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $dbPrefix;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function initRepository(Connection $connection, $dbPrefix, EntityManager $entityManager)
    {
        $this->connection = $connection;
        $this->dbPrefix = $dbPrefix;
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getByProductId($idProduct)
    {
        $node = $this->findOneBy([
            'idObject' => (int) $idProduct,
            'objectType' => GptContentGenerator::TYPE_PRODUCT,
        ]);

        return $node ? $node : (new GptContentGenerator());
    }

    public function getByCategoryId($idCategory)
    {
        $node = $this->findOneBy([
            'idObject' => (int) $idCategory,
            'objectType' => GptContentGenerator::TYPE_CATEGORY,
        ]);

        return $node ? $node : (new GptContentGenerator());
    }

    public function save(GptContentGenerator $object)
    {
        if (!$this->entityManager->isOpen()) {
            $this->entityManager = $this->entityManager->create(
                $this->connection,
                $this->entityManager->getConfiguration()
            );
        }

        if ($object->getId()) {
            $this->entityManager->merge($object);
        } else {
            $this->entityManager->persist($object);
        }
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $object;
    }

    public function delete(GptContentGenerator $object)
    {
        if ($object->getId()) {
            $this->entityManager->remove($object);
            $this->entityManager->flush();
        }

        return true;
    }
}
