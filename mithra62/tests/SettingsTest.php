<?php
/**
 * mithra62 - Unit Test
 *
 * @copyright	Copyright (c) 2015, mithra62, Eric Lamb.
 * @link		http://mithra62.com/
 * @version		1.0
 * @filesource 	./mithra62/tests/SettingsTest.php
 */
 
namespace mithra62\tests;

use mithra62\Settings;
use mithra62\Db;
use mithra62\Language;
use mithra62\tests\TestFixture;

/**
 * Mock for testing the Settings Abstract
 * @package 	mithra62\Tests
 * @author		Eric Lamb <eric@mithra62.com>
 * @ignore
 */
class _settings extends Settings
{
    /**
     * (non-PHPdoc)
     * @ignore
     * @see \mithra62\Settings::validate()
     */
    public function validate(array $data, array $extra = array())
    {
        
    }
}


/**
 * mithra62 - Settings object Unit Tests
 *
 * Contains all the unit tests for the \mithra62\Settings object
 *
 * @package 	mithra62\Tests
 * @author		Eric Lamb <eric@mithra62.com>
 */
class SettingsTest extends TestFixture
{
    /**
     * Tests the initial attributes and property values
     */
    public function testInit()
    {
        $this->assertClassHasAttribute('settings', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('table', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('_global_defaults', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('serialized', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('custom_options', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('new_lines', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('encrypted', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('defaults', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('overrides', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('encrypt', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('lang', '\mithra62\tests\_settings');
        $this->assertClassHasAttribute('db', '\mithra62\tests\_settings');

        $db = new Db;
        $db->setCredentials($this->getDbCreds());
        $settings = new _settings($db, new Language );
        $this->assertObjectHasAttribute('settings', $settings);
        $this->assertObjectHasAttribute('table', $settings);
        $this->assertObjectHasAttribute('_global_defaults', $settings);
        $this->assertObjectHasAttribute('serialized', $settings);
        $this->assertObjectHasAttribute('custom_options', $settings);
        $this->assertObjectHasAttribute('new_lines', $settings);
        $this->assertObjectHasAttribute('encrypted', $settings);
        $this->assertObjectHasAttribute('defaults', $settings);
        $this->assertObjectHasAttribute('overrides', $settings);
        $this->assertObjectHasAttribute('encrypt', $settings);
        $this->assertObjectHasAttribute('lang', $settings);
        $this->assertObjectHasAttribute('db', $settings);

        $this->assertTrue(is_array($settings->getCustomOptions()));
        $this->assertCount(0, $settings->getCustomOptions());

        $this->assertTrue(is_array($settings->getOverrides()));
        $this->assertCount(0, $settings->getOverrides());

        $this->assertTrue(is_array($settings->getEncrypted()));
        $this->assertCount(0, $settings->getEncrypted());
        
        $this->assertEmpty($settings->getTable());
    }
    
    public function testDefaultEncryption()
    {
        $db = new Db;
        $db->setCredentials($this->getDbCreds());
        $settings = new _settings($db, new Language );
        $this->assertTrue(is_array($settings->getEncrypted()));
        $this->assertCount(0, $settings->getEncrypted());
    }
    
    /**
     * Tests the set and get methods for $table property
     */
    public function testSetTable()
    {
        $db = new Db;
        $db->setCredentials($this->getDbCreds());
        $settings = new _settings($db, new Language );
        $settings->setTable($this->test_table_name);
        $this->assertEquals($this->test_table_name, $settings->getTable());
    }
    
    public function testDefaultSettings()
    {
        $db = new Db;
        $db->setCredentials($this->getDbCreds());
        $settings = new _settings($db, new Language );
        $defaults = $settings->getDefaults();
        
        $this->assertTrue(is_array($settings->getDefaults()));
        $this->assertCount(0, $settings->getDefaults());
    }
    
    public function testGetSettings()
    {
        $db = new Db;
        $db->setCredentials($this->getDbCreds());
        $settings = new _settings($db, new Language );
        $data = $settings->setDefaults(array())->setTable($this->test_table_name)->get();
        
        $this->assertCount(5, $data);
        $this->assertArrayHasKey('date_format', $data);
        
        return $settings;
    }
    
    /**
     * @depends testGetSettings
     */
    public function testUpdateSettings($settings)
    {
        $settings->update(array('relative_time' => '1'));
        
        return $settings;
    }
}