<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Catalog\Model\Rss\Product;

use Magento\TestFramework\Helper\ObjectManager as ObjectManagerHelper;

/**
 * Class SpecialTest
 * @package Magento\Catalog\Model\Rss\Product
 */
class SpecialTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Catalog\Model\Rss\Product\Special
     */
    protected $special;

    /**
     * @var ObjectManagerHelper
     */
    protected $objectManagerHelper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $productFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Catalog\Model\Product
     */
    protected $product;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManager;

    protected function setUp()
    {
        $this->product = $this->getMock('Magento\Catalog\Model\Product', [], [], '', false);
        $this->productFactory = $this->getMock('Magento\Catalog\Model\ProductFactory', ['create'], [], '', false);
        $this->productFactory->expects($this->any())->method('create')->will($this->returnValue($this->product));
        $this->storeManager = $this->getMock('Magento\Store\Model\StoreManager', [], [], '', false);

        $this->objectManagerHelper = new ObjectManagerHelper($this);
        $this->special = $this->objectManagerHelper->getObject(
            'Magento\Catalog\Model\Rss\Product\Special',
            [
                'productFactory' => $this->productFactory,
                'storeManager' => $this->storeManager
            ]
        );
    }

    public function testGetProductsCollection()
    {
        $storeId = 1;
        $store = $this->getMock('Magento\Store\Model\Store', [], [], '', false);
        $this->storeManager->expects($this->once())->method('getStore')->with($storeId)->will(
            $this->returnValue($store)
        );
        $websiteId = 1;
        $store->expects($this->once())->method('getWebsiteId')->will($this->returnValue($websiteId));

        /** @var \Magento\Catalog\Model\Resource\Product\Collection $productCollection */
        $productCollection = $this->getMock('Magento\Catalog\Model\Resource\Product\Collection', [], [], '', false);
        $this->product->expects($this->once())->method('getResourceCollection')->will(
            $this->returnValue($productCollection)
        );
        $customerGroupId = 1;
        $productCollection->expects($this->once())->method('addPriceDataFieldFilter')->will($this->returnSelf());
        $productCollection->expects($this->once())->method('addPriceData')->with($storeId, $customerGroupId)->will(
            $this->returnSelf()
        );
        $productCollection->expects($this->once())->method('addAttributeToSelect')->will($this->returnSelf());
        $productCollection->expects($this->once())->method('addAttributeToSort')->will($this->returnSelf());

        $products = $this->special->getProductsCollection($storeId, $customerGroupId);
        $this->assertEquals($productCollection, $products);
    }
}
