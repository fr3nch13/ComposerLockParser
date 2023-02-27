<?php declare(strict_types=1);

namespace ComposerLockParser;

/**
 * The main entrypoint for this library.
 */
class ComposerInfo {

    /**
     * @var string The path to the lock file.
     */
    private $pathToLockFile;

    /**
     * @var array<string, mixed> The parsed lockfile into PHP.
     */
    private $decodedValue = [];

    /**
     * @var \ComposerLockParser\PackagesCollection The collection of found projects.
     */
    private $packages;

    /**
     * @var int Constant flag for all packages, see getPackage()
     */
    const ALL = 0;

    /**
     * @var int Constant flag for production packages, see getPackage()
     */
    const PRODUCTION = 1;

    /**
     * @var int Constant flag for development packages, see getPackage()
     */
    const DEVELOPMENT = 2;

    /**
     * Creates the instance and sets the path to the lock file.
     *
     * @param string $pathToLockFile The path to the composer.lock file
     * @return $this
     */
    public function __construct(string $pathToLockFile)
    {
        $this->pathToLockFile = $pathToLockFile;
    }

    /**
     * Parses the lock file into a json object.
     *
     * @return void
     * @throws \ComposerLockParser\RuntimeException if the lock file is unable to be parsed.
     */
    private function parse(): void
    {
        $this->checkFile();

        /** @var string */
        $content = file_get_contents($this->pathToLockFile);

        $this->decodedValue = json_decode($content, true);

        if (json_last_error()) {
            throw new RuntimeException("Json parser error: {$this->getJsonLastErrorMsg()}");
        }
    }

    /**
     * Gets the hash from the lock file
     *
     * @return string|null The has, or null if it's not found, or not set.
     */
    public function getHash(): ?string
    {
        if (empty($this->decodedValue)) {
            $this->parse();
        }

        return array_key_exists('content-hash', $this->decodedValue) ? $this->decodedValue['content-hash'] : null;
    }

    /**
     * Gets the minimum stability
     *
     * @return string|null The minimum tability or null if not found.
     */
    public function getMinimumStability(): ?string
    {
        if (empty($this->decodedValue)) {
            $this->parse();
        }

        return array_key_exists('minimum-stability', $this->decodedValue) ? $this->decodedValue['minimum-stability'] : null;
    }

    /**
     * Get the list of packages as a collection object.
     *
     * @param int $list What list of packages should we return.
     *      self::ALL - Both dev and production.
     *      self::PRODUCTION - Just production.
     *      se=lf::DEVELOPMENT - Just dev.
     * @return \ComposerLockParser\PackagesCollection of Package
     */
    public function getPackages(int $list = self::ALL): PackagesCollection
    {
        if (empty($this->decodedValue)) {
            $this->parse();
        }

        // remove the check if packages is already set.

        $this->packages = new PackagesCollection();

        // Production packages
        if (in_array($list, [self::ALL, self::PRODUCTION]) && isset($this->decodedValue['packages'])) {
            foreach ($this->decodedValue['packages'] as $packageInfo) {
                $this->packages->append(Package::factory($packageInfo));
            }
        }

        // Dev packages
        if (in_array($list, [self::ALL, self::DEVELOPMENT]) && isset($this->decodedValue['packages-dev'])) {
            foreach ($this->decodedValue['packages-dev'] as $packageInfo) {
                $this->packages->append(Package::factory($packageInfo));
            }
        }

        return $this->packages;
    }

    /**
     * Checks the lock file to make sure it exists and is readable.
     *
     * @return void
     * @throws \ComposerLockParser\RuntimeException if it doesn't exist, or isn't readable.
     */
    private function checkFile(): void
    {
        if (!file_exists($this->pathToLockFile) || !is_readable($this->pathToLockFile)) {
            throw new RuntimeException("File {$this->pathToLockFile} not found or not readable.");
        }
    }

    /**
     * Reports the last error message from PHP's json library.
     *
     * @return string The error message.
     */
    private function getJsonLastErrorMsg(): string
    {
        $errors = [
            JSON_ERROR_NONE             => null,
            JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
            JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        ];

        $error = json_last_error();
        return array_key_exists($error, $errors) ? $errors[$error] : "Unknown error ({$error})";
    }
}
