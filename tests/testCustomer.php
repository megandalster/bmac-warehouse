<?php

include_once(dirname(__FILE__).'/../domain/Customer.php');
class testCustomer extends UnitTestCase {

     function testCustomerModule() {
        $customer = new Customer("customerid", "address", "city","state", "zip", "county", "contact", "phone","email", "status", "notes");
        $this->assertTrue($customer->get_customer_id() == "customerid");
        $this->assertTrue($customer->get_address()== "address");
        $this->assertTrue($customer->get_city() == "city");
        $this->assertTrue($customer->get_state() == "state");
        $this->assertTrue($customer->get_zip() == "zip");
        $this->assertTrue($customer->get_county() == "county");
        $this->assertTrue($customer->get_contact() == "contact");
        $this->assertTrue($customer->get_phone() == "phone");
        $this->assertTrue($customer->get_email() == "email");
        $this->assertTrue($customer->get_status()=="status");
        $this->assertTrue($customer->get_notes()=="notes");
        echo ("testCustomer complete\n");
    }
}
?>
