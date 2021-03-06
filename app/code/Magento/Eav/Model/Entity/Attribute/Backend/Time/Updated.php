<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Eav\Model\Entity\Attribute\Backend\Time;

/**
 * Entity/Attribute/Model - attribute backend default
 */
class Updated extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    /**
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     */
    public function __construct(\Magento\Framework\Stdlib\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * Set modified date
     *
     * @param \Magento\Framework\Object $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $object->setData($this->getAttribute()->getAttributeCode(), $this->dateTime->now());
        return $this;
    }
}
