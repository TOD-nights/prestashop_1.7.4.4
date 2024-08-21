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
namespace PrestaShop\Module\Chatgptcontentgenerator\Entity;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name=GptContentGenerator::TABLE)
 * @ORM\Entity(repositoryClass="PrestaShop\Module\Chatgptcontentgenerator\Repository\GptContentGeneratorRepository")
 */
class GptContentGenerator
{
    public const TABLE = _DB_PREFIX_ . 'content_generator';

    public const TYPE_PRODUCT = 1;
    public const TYPE_CATEGORY = 2;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_content_generator", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_object", type="integer")
     */
    private $idObject;

    /**
     * @var int
     *
     * @ORM\Column(name="object_type", type="integer")
     */
    private $objectType = 0;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * @param int $idObject
     * @return $this
     */
    public function setIdObject(int $idObject)
    {
        $this->idObject = $idObject;

        return $this;
    }

    /**
     * Get type name
     *
     * @return string
     */
    public function getObjectTypeName()
    {
        $name = '';
        switch ((int) $this->objectType) {
            case self::TYPE_CATEGORY:
                $name = 'category';
                break;

            case self::TYPE_PRODUCT:
                $name = 'amount';
                break;

            default:
                $name = 'none';
                break;
        }

        return $name;
    }

    /**
     * @return int|null
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * @param int|null $objectType
     * @return $this
     */
    public function setObjectType(int $objectType)
    {
        $this->objectType = $objectType;
        return $this;
    }
}
