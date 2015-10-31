<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.

class CustomerTest extends TestCase
{

    private $_customerProperties = [
        'pname' => 'John Smith',
        'login' => 'john-unit-test',
        'passwd' => 'simple-password',
    ];

    public function testCreate()
    {
        $customer = $this->_client->customer()->create($this->_customerProperties);
        $this->assertInternalType('integer', $customer->id);
        $this->assertGreaterThan(0, $customer->id);

        $this->_client->customer()->delete('id', $customer->id);
    }

    public function testDelete()
    {
        $customer = $this->_client->customer()->create($this->_customerProperties);
        $result = $this->_client->customer()->delete('id', $customer->id);
        $this->assertTrue($result);
    }

    public function testGet()
    {
        $customer = $this->_client->customer()->create($this->_customerProperties);
        $customerInfo = $this->_client->customer()->get('id', $customer->id);
        $this->assertEquals('John Smith', $customerInfo->personalName);
        $this->assertEquals('john-unit-test', $customerInfo->login);
        $this->assertEquals($customer->id, $customerInfo->id);

        $this->_client->customer()->delete('id', $customer->id);
    }

    public function testGetDomainList()
    {
        $domainList = $this->_client->customer()->getDomainList('login', 1);
        $this->assertGreaterThan(0, $domainList[0]->id);
    }

    public function testGetAll()
    {
        $customerList = $this->_client->customer()->get();
        $this->assertGreaterThan(0, $customerList[0]->id);
    }

}
