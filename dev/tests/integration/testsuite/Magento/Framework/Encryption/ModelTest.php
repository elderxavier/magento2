<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\Encryption;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Encryption\Encryptor
     */
    protected $_model;

    protected function setUp()
    {
        $this->_model = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Framework\Encryption\Encryptor'
        );
    }

    public function testEncryptDecrypt()
    {
        $encryptor = $this->_model;

        $this->assertEquals('', $encryptor->decrypt($encryptor->encrypt('')));
        $this->assertEquals('test', $encryptor->decrypt($encryptor->encrypt('test')));
    }

    public function testEncryptDecrypt2()
    {
        $encryptor = $this->_model;

        $initial = md5(uniqid());
        $encrypted = $encryptor->encrypt($initial);
        $this->assertNotEquals($initial, $encrypted);
        $this->assertEquals($initial, $encryptor->decrypt($encrypted));
    }

    public function testValidateKey()
    {
        $validKey = md5(uniqid());
        $this->assertInstanceOf('Magento\Framework\Encryption\Crypt', $this->_model->validateKey($validKey));
    }

    public function testGetValidateHash()
    {
        $password = uniqid();
        $hash = $this->_model->getHash($password);

        $this->assertTrue(is_string($hash));
        $this->assertTrue($this->_model->validateHash($password, $hash));
    }
}
