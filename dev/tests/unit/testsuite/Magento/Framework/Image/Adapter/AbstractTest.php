<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Test class for \Magento\Framework\Image\Adapter\AbstractAdapter.
 */
namespace Magento\Framework\Image\Adapter;

class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Image\Adapter\AbstractAdapter
     */
    protected $_model;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject |\Magento\Framework\Filesystem\Directory\Write
     */
    protected $directoryWriteMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject |\Magento\Framework\Filesystem
     */
    protected $filesystemMock;

    protected function setUp()
    {
        $this->directoryWriteMock = $this->getMock(
            'Magento\Framework\Filesystem\Directory\Write',
            [],
            [],
            '',
            false
        );
        $this->filesystemMock = $this->getMock(
            'Magento\Framework\Filesystem',
            ['getDirectoryWrite', 'createDirectory'],
            [],
            '',
            false
        );
        $this->filesystemMock->expects(
            $this->once()
        )->method(
            'getDirectoryWrite'
        )->will(
            $this->returnValue($this->directoryWriteMock)
        );

        $this->_model = $this->getMockForAbstractClass(
            'Magento\Framework\Image\Adapter\AbstractAdapter',
            [$this->filesystemMock]
        );
    }

    protected function tearDown()
    {
        $this->directoryWriteMock = null;
        $this->_model = null;
        $this->filesystemMock = null;
    }

    /**
     * Test adaptResizeValues with null as a value one of parameters
     *
     * @dataProvider adaptResizeValuesDataProvider
     */
    public function testAdaptResizeValues($width, $height, $expectedResult)
    {
        $method = new \ReflectionMethod($this->_model, '_adaptResizeValues');
        $method->setAccessible(true);

        $result = $method->invoke($this->_model, $width, $height);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function adaptResizeValuesDataProvider()
    {
        $expected = [
            'src' => ['x' => 0, 'y' => 0],
            'dst' => ['x' => 0, 'y' => 0, 'width' => 135, 'height' => 135],
            'frame' => ['width' => 135, 'height' => 135],
        ];

        return [[135, null, $expected], [null, 135, $expected]];
    }

    /**
     * @dataProvider prepareDestinationDataProvider
     */
    public function testPrepareDestination($destination, $newName, $expectedResult)
    {
        $property = new \ReflectionProperty(get_class($this->_model), '_fileSrcPath');
        $property->setAccessible(true);
        $property->setValue($this->_model, '_fileSrcPath');

        $property = new \ReflectionProperty(get_class($this->_model), '_fileSrcName');
        $property->setAccessible(true);
        $property->setValue($this->_model, '_fileSrcName');

        $method = new \ReflectionMethod($this->_model, '_prepareDestination');
        $method->setAccessible(true);

        $result = $method->invoke($this->_model, $destination, $newName);

        $this->assertEquals($expectedResult, $result);
    }

    public function prepareDestinationDataProvider()
    {
        return [
            [__DIR__, 'name.txt', __DIR__ . '/name.txt'],
            [__DIR__ . '/name.txt', null, __DIR__ . '/name.txt'],
            [null, 'name.txt', '_fileSrcPath' . '/name.txt'],
            [null, null, '_fileSrcPath' . '/_fileSrcName']
        ];
    }
}
