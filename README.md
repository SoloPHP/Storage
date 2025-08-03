# Solo Storage

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solophp/storage.svg)](https://packagist.org/packages/solophp/storage)
[![License](https://img.shields.io/packagist/l/solophp/storage.svg)](LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/solophp/storage.svg)](https://packagist.org/packages/solophp/storage)

A lightweight, file-based storage system for PHP applications that provides simple key-value pair storage functionality.

## Features

- Simple key-value storage interface
- File-based persistence
- Thread-safe file operations
- Directory traversal protection
- Minimal dependencies
- Type-safe implementation (strict types)

## Requirements

- PHP 8.1 or higher

## Installation

```bash
composer require solophp/storage
```

## Usage

### Basic Setup

```php
use Solo\Storage;

// Initialize with default storage location (current directory)
$storage = new Storage();

// Or specify a custom storage directory
$storage = new Storage('/path/to/storage/directory');
```

### Store Data

```php
// Store a string value
$storage->set('user.name', 'John Doe');
$storage->set('user.email', 'john@example.com');
```

### Retrieve Data

```php
// Get a stored value
$name = $storage->get('user.name'); // Returns 'John Doe'

// Handle non-existent keys
$value = $storage->get('non.existent.key'); // Returns null
```

### Check Data Existence

```php
// Check if a key exists
if ($storage->has('user.name')) {
    // Key exists
}
```

### Delete Data

```php
// Delete a stored value
$storage->delete('user.name');
```

## Error Handling

All methods are designed to fail gracefully:

- `set()` returns `bool` indicating success/failure
- `get()` returns `null` if key doesn't exist or on error
- `has()` returns `bool` indicating key existence
- `delete()` returns `bool` indicating success/failure

## Security

The storage system includes protection against directory traversal attacks by sanitizing storage keys.

## Thread Safety

File operations use exclusive locks (`LOCK_EX`) to ensure thread safety when writing data.

## License

MIT