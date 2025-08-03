<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Solo\Storage\Storage;

class StorageTest extends TestCase
{
    private $storage;
    private $storageFolder = 'test_storage';

    protected function setUp(): void
    {
        $this->storage = new Storage($this->storageFolder);
    }

    protected function tearDown(): void
    {
        $files = glob($this->storageFolder . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        if (is_dir($this->storageFolder)) {
            rmdir($this->storageFolder);
        }
    }

    public function testSetAndGet()
    {
        $key = 'test_key';
        $value = 'test_value';

        $this->assertTrue($this->storage->set($key, $value));
        $this->assertSame($value, $this->storage->get($key));
    }

    public function testHas()
    {
        $key = 'test_key';
        $value = 'test_value';

        $this->storage->set($key, $value);
        $this->assertTrue($this->storage->has($key));
        $this->assertFalse($this->storage->has('non_existent_key'));
    }

    public function testDelete()
    {
        $key = 'test_key';
        $value = 'test_value';

        $this->storage->set($key, $value);
        $this->assertTrue($this->storage->has($key));
        $this->assertTrue($this->storage->delete($key));
        $this->assertFalse($this->storage->has($key));
    }

    public function testGetNonExistentKey()
    {
        $this->assertNull($this->storage->get('non_existent_key'));
    }
}
