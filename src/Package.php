<?php declare(strict_types=1);

namespace ComposerLockParser;

use DateTime;

/**
 * Contains the details of specific packages.
 *
 * @TODO Add more details from the lock file.
 */
class Package {

    /**
     * @var string The name of the package that packagist uses.
     */
    private $name;

    /**
     * @var string The version that is installed according to the lock file.
     */
    private $version;

    /**
     * @var array<string, string> The source information.
     */
    private $source;

    /**
     * @var array<string, string> The distribution information.
     */
    private $dist;

    /**
     * @var array<string, string> List of required packages for this one, and the version constraint.
     */
    private $require;

    /**
     * @var array<string, string> List of required development packages for this one, and the version constraint.
     */
    private $requireDev;

    /**
     * @var array<string, string> List of suggested packages.
     */
    private $suggest;

    /**
     * @var string The type of package, usually library, but can be others.
     */
    private $type;

    /**
     * @var array<string, mixed> List of extra info for this package.
     */
    private $extra;

    /**
     * @var array<string, array<string, string>> The autoload paths for composer to use.
     */
    private $autoload;

    /**
     * @var string The notofication URL, usually points to packagist.
     */
    private $notificationUrl;

    /**
     * @var array<int, string> The list of liceses this package uses.
     */
    private $license;

    /**
     * @var array<int, array<string, mixed>> List of authors and their information.
     */
    private $authors;

    /**
     * @var string Short description of this package.
     */
    private $description;

    /**
     * @var string The url to the homepage for this package.
     */
    private $homepage;

    /**
     * @var array<int, string> List of keywords to help categorize this package.
     */
    private $keywords;

    /**
     * @var DateTime Release date of this version.
     */
    private $time;

    /**
     * Creates the instance and fills out passed information, or sets defaults.
     *
     * @param string $name The name of the package that packagist uses.
     * @param string $version The version that is installed according to the lock file.
     * @param array<string, string> $source The source information.
     * @param array<string, string> $dist The distribution information.
     * @param array<string, string> $require List of required packages for this one, and the version constraint.
     * @param array<string, string> $requireDev List of required development packages for this one, and the version constraint.
     * @param array<string, string> $suggest List of suggested packages.
     * @param string $type The type of package, usually library, but can be others.
     * @param array<string, mixed> $extra List of extra info for this package.
     * @param array<string, array<string, string>> $autoload The autoload paths for composer to use.
     * @param string $notificationUrl The notofication URL, usually points to packagist.
     * @param array<int, string> $license The list of liceses this package uses.
     * @param array<int, array<string, mixed>> $authors List of authors and their information.
     * @param string $description Short description of this package.
     * @param string $homepage The url to the homepage for this package.
     * @param array<int, string> $keywords List of keywords to help categorize this package.
     * @param \DateTime $time Release date of this version.
     * @return $this
     */
    private function __construct(string $name, string $version, array $source, array $dist, array $require,
        array $requireDev, array $suggest, string $type, array $extra, array $autoload, string $notificationUrl, array $license, array $authors, string $description, string $homepage,
        array $keywords, $time)
    {
        $this->name = $name;
        $this->version = $version;
        $this->source = $source;
        $this->dist = $dist;
        $this->require = $require;
        $this->requireDev = $requireDev;
        $this->suggest = $suggest;
        $this->type = $type;
        $this->extra = $extra;
        $this->autoload = $autoload;
        $this->license = $license;
        $this->notificationUrl = $notificationUrl;
        $this->authors = $authors;
        $this->description = $description;
        $this->homepage = $homepage;
        $this->keywords = $keywords;
        $this->time = $time;
    }

    /**
     * Creates a new instance with information form an array
     *
     * @param array<string, mixed> $packageInfo The known package information used to create a new object.
     * @return \ComposerLockParser\Package
     */
    public static function factory(array $packageInfo)
    {
        return new self(
            $packageInfo['name'],
            $packageInfo['version'],
            isset($packageInfo['source']) ? $packageInfo['source'] : [],
            isset($packageInfo['dist']) ? $packageInfo['dist'] : [],
            isset($packageInfo['require']) ? $packageInfo['require'] : [],
            isset($packageInfo['require-dev']) ? $packageInfo['require-dev'] : [],
            isset($packageInfo['suggest']) ? $packageInfo['suggest'] : [],
            isset($packageInfo['type']) ? $packageInfo['type'] : '',
            isset($packageInfo['extra']) ? $packageInfo['extra'] : [],
            isset($packageInfo['autoload']) ? $packageInfo['autoload'] : [],
            isset($packageInfo['notification-url']) ? $packageInfo['notification-url'] : '',
            isset($packageInfo['license']) ? $packageInfo['license'] : [],
            isset($packageInfo['authors']) ? $packageInfo['authors'] : [],
            isset($packageInfo['description']) ? $packageInfo['description'] : '',
            isset($packageInfo['homepage']) ? $packageInfo['homepage'] : '',
            isset($packageInfo['keywords']) ? $packageInfo['keywords'] : [],
            isset($packageInfo['time']) ? new DateTime($packageInfo['time']) : null
        );
    }

    /**
     * @return string The name of the package that packagist uses.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string The version that is installed according to the lock file.
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array<string, string> The source information.
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return array<string, string> The distribution information.
     */
    public function getDist()
    {
        return $this->dist;
    }

    /**
     * @return array<string, string> List of required packages for this one, and the version constraint.
     */
    public function getRequire()
    {
        return $this->require;
    }

    /**
     * @return array<string, string> List of required development packages for this one, and the version constraint.
     */
    public function getRequireDev()
    {
        return $this->requireDev;
    }

    /**
     * @return array<string, string> List of suggested packages, or null if none.
     */
    public function getSuggest()
    {
        return $this->suggest;
    }

    /**
     * @return string The type of package, usually library, but can be others.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed> List of extra info for this package.
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return array<string, array<string, string>> The autoload paths for composer to use.
     */
    public function getAutoload()
    {
        return $this->autoload;
    }

    /**
     * @return string The notofication URL, usually points to packagist.
     */
    public function getNotificationUrl()
    {
        return $this->notificationUrl;
    }

    /**
     * @return array<int, string> The list of liceses this package uses.
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return array<int, array<string, mixed>> List of authors and their information.
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @return string Short description of this package.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string The url to the homepage for this package.
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return array<int, string> List of keywords to help categorize this package.
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return \DateTime Release date of this version.
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return string The PHP namespace for this package
     */
    public function getNamespace()
    {
        $namespace = [];

        if (isset($this->autoload['psr-0'])) {
            $namespace = $this->autoload['psr-0'];
        } elseif (isset($this->autoload['psr-4'])) {
            $namespace = $this->autoload['psr-4'];
        }

        if (is_array($namespace)) {
            $namespace = key($namespace);
        }
        if (!$namespace) {
          return '';
        }
        return trim($namespace, '\\');
    }
}
