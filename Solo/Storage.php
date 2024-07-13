<?php declare(strict_types=1);

namespace Solo;

class Storage
{
    private string $storageFolder;

    public function __construct(string $storageFolder = '')
    {
        $this->storageFolder = $storageFolder;
    }

    public function set(string $key, string $token): bool
    {
        $tokenFile = fopen($this->storageFolder . $key, 'wb');
        fwrite($tokenFile, $token);
        return fclose($tokenFile);
    }

    public function get(string $key): ?string
    {
        return $this->has($key) ? file_get_contents($this->storageFolder . $key) : null;
    }

    public function has(string $key): bool
    {
        return file_exists($this->storageFolder . $key);
    }

    public function delete(string $key): bool
    {
        $filePath = $this->storageFolder . $key;
        return file_exists($filePath) && unlink($filePath);
    }
}