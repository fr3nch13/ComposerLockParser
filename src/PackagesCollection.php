<?php declare(strict_types=1);

namespace ComposerLockParser;

use ArrayObject;

/**
 * The list of packages found in the lock file.
 *
 * @extends ArrayObject<int, Package>
 */
class PackagesCollection extends ArrayObject
{
    /**
     * @var array<string, mixed> Either indexed by the name, or namespace
     */
    private $indexedBy = [
        'name' => [],
        'namespace' => [],
    ];

    /**
     * Gets the package by it's name.
     *
     * @param string $name The name of the package to look for
     * @return Package The package for the name
     * @throws \UnexpectedValueException If no package by that name exists.
     */
    public function getByName(string $name): Package
    {
        if (!$this->hasByName($name)) {
            throw new \UnexpectedValueException("Package {$name} not exists");
        }

        return $this->getIndexedByName()[$name];
    }

    /**
     * Finds a package by it's namespace.
     *
     * @param string $namespace The namespace of the package to look for.
     * @return Package The package for the namenamespace
     * @throws \UnexpectedValueException If no package by that namespace exists.
     */
    public function getByNamespace(string $namespace): Package
    {
        if (!$this->hasByNamespace($namespace)) {
            throw new \UnexpectedValueException("Package {$namespace} not exists");
        }

        return $this->getIndexedByNamespace()[$namespace];
    }

    /**
     * Checks if a package exists by that name.
     *
     * @param string $name
     * @return bool
     */
    public function hasByName(string $name): bool
    {
        return array_key_exists($name, $this->getIndexedByName());
    }

    /**
     * Checks if a package exists by that namespace.
     *
     * @param string $namespace
     * @return bool
     */
    public function hasByNamespace(string $namespace): bool
    {
        return array_key_exists($namespace, $this->getIndexedByNamespace());
    }

    /**
     * Adds a package to the index.
     *
     * @param mixed $index The index to set with this package.
     * @param \ComposerLockParser\Package $package The Package to add to the indexed array.
     */
    public function offsetSet($index, $package): void
    {
        if ($package instanceof Package) {
            $this->indexedBy['name'][$package->getName()] = $package;
            $this->indexedBy['namespace'][$package->getNamespace()] = $package;
        }

        parent::offsetSet($index, $package);
    }

    /**
     * Gets the list of packages indexed by their name.
     *
     * @return array<string, mixed> The listed of packages indexed by their name.
     */
    private function getIndexedByName(): array
    {
        if (!empty($this->indexedBy['name'])) {
            return $this->indexedBy['name'];
        }

        /** @var Package $package */
        foreach($this->getArrayCopy() as $package) {
            if (!($package instanceof Package)) {
                continue;
            }
            $this->indexedBy['name'][$package->getName()] = $package;
        }

        return $this->indexedBy['name'];
    }

    /**
     * Gets the list of packages indexed by their namespace.
     *
     * @return array<string, mixed> The listed of packages indexed by their namespace.
     */
    private function getIndexedByNamespace()
    {
        if (!empty($this->indexedBy['namespace'])) {
            return $this->indexedBy['namespace'];
        }

        /** @var Package $package */
        foreach($this->getArrayCopy() as $package) {
            if (!($package instanceof Package)) {
                continue;
            }
            $this->indexedBy['namespace'][$package->getNamespace()] = $package;
        }

        return $this->indexedBy['namespace'];
    }

    /**
     * reset the indexedBy array.
     * Mainly used for testing.
     *
     * @return void
     */
    public function resetIndex(): void
    {
        $this->indexedBy = [
            'name' => [],
            'namespace' => [],
        ];
    }
}
