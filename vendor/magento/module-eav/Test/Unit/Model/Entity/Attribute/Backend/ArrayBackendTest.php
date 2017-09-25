<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Eav\Test\Unit\Model\Entity\Attribute\Backend;

class ArrayBackendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend
     */
    protected $_model;

    /**
     * @var \Magento\Eav\Model\Entity\Attribute
     */
    protected $_attribute;

    protected function setUp()
    {
        $this->_attribute = $this->getMock(
            \Magento\Eav\Model\Entity\Attribute::class,
            ['getAttributeCode', '__wakeup'],
            [],
            '',
            false
        );
        $logger = $this->getMock(\Psr\Log\LoggerInterface::class);
        $this->_model = new \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend($logger);
        $this->_model->setAttribute($this->_attribute);
    }

    /**
     * @dataProvider attributeValueDataProvider
     */
    public function testValidate($data)
    {
        $this->_attribute->expects($this->atLeastOnce())->method('getAttributeCode')->will($this->returnValue('code'));
        $product = new \Magento\Framework\DataObject(['code' => $data, 'empty' => '']);
        $this->_model->validate($product);
        $this->assertEquals('1,2,3', $product->getCode());
        $this->assertEquals(null, $product->getEmpty());
    }

    public static function attributeValueDataProvider()
    {
        return [[[1, 2, 3]], ['1,2,3']];
    }
}
