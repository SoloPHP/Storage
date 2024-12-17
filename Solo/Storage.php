<?php declare(strict_types=1);

namespace Solo;

/**
 * Class Storage
 * Simple file-based storage system for storing string data using key-value pairs.
 *
 * @package Solo
 */
class Storage
{
    /**
     * Base directory path where files will be stored
     *
     * @var string
     */
    private readonly string $storageFolder;

    /**
     * Initialize storage with specified directory
     *
     * @param string $storageFolder Directory path where files will be stored
     * @throws \Exception If directory creation fails
     */
    public function __construct(string $storageFolder = '')
    {
        $normalizedFolder = rtrim($storageFolder, '/\\') . DIRECTORY_SEPARATOR;

        if (!empty($normalizedFolder) && !is_dir($normalizedFolder)) {
            mkdir($normalizedFolder, permissions: 0755, recursive: true);
        }

        $this->storageFolder = $normalizedFolder;
    }

    /**
     * Store a string value with the specified key
     *
     * @param string $key Storage key for the value
     * @param string $string Value to store
     * @return bool True if storage was successful, false otherwise
     */
    public function set(string $key, string $string): bool
    {
        try {
            return file_put_contents($this->getFilePath($key), $string, LOCK_EX) !== false;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Retrieve stored value by key
     *
     * @param string $key Storage key to retrieve
     * @return string|null Stored string value or null if key doesn't exist or on error
     */
    public function get(string $key): ?string
    {
        try {
            return $this->has($key) ? file_get_contents($this->getFilePath($key)) : null;
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Check if a key exists in storage
     *
     * @param string $key Storage key to check
     * @return bool True if key exists, false otherwise
     */
    public function has(string $key): bool
    {
        return file_exists($this->getFilePath($key));
    }

    /**
     * Delete a stored value by key
     *
     * @param string $key Storage key to delete
     * @return bool True if deletion was successful or file didn't exist, false on error
     */
    public function delete(string $key): bool
    {
        try {
            $filePath = $this->getFilePath($key);
            return !file_exists($filePath) || unlink($filePath);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Generate a safe file path from a storage key
     *
     * @param string $key Storage key
     * @return string Sanitized file path
     * @throws \InvalidArgumentException If key is empty
     */
    private function getFilePath(string $key): string
    {
        if ($key === '') {
            throw new \InvalidArgumentException('Key cannot be empty');
        }

        // Sanitize the key to prevent directory traversal
        $sanitizedKey = str_replace(['../', '..\\'], '', $key);
        return $this->storageFolder . DIRECTORY_SEPARATOR . $sanitizedKey;
    }
}