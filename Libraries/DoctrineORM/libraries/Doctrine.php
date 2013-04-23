<?php

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Symfony\Component\Console;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @property \Doctrine\ORM\EntityManager $em Gerenciador de Entidade
 */
class Doctrine {

    protected $em;
    private static $conn;
    private $config;
    private $connectionOptions = array();
    const PRODUCTION = "production";
    const DEFATUL = "default";
    

    protected function __construct($tipoConexao = Doctrine::PRODUCTION) {

        require_once("../System/Configuracao/ApplicationPath.php");
        require("../System/Configuracao/BancoDados.php");
// Set up class loading. You could use different autoloaders, provided by your favorite framework,
        // if you want to.
        require_once ApplicationPath::Libraries() . "DoctrineORM/libraries/Doctrine/Common/ClassLoader.php";
        require_once ApplicationPath::Libraries() . "DoctrineORM/libraries/Doctrine/ORM/Tools/Setup.php";
        Doctrine\ORM\Tools\Setup::registerAutoloadDirectory(ApplicationPath::Libraries() . "DoctrineORM/libraries/");
        $doctrineClassLoader = new ClassLoader('Doctrine', ApplicationPath::Libraries() . 'DoctrineORM/libraries');
        $doctrineClassLoader->register();
        $proxiesClassLoader = new ClassLoader('Proxies', ApplicationPath::Models() . 'Proxies');
        $proxiesClassLoader->register();

// Set up caches
        $this->config = new Configuration;
        //$config = new Configuration;
        $cache = new ArrayCache;
        $this->config->setMetadataCacheImpl($cache);
        $driverImpl = $this->config->newDefaultAnnotationDriver(array(ApplicationPath::Models() . 'Entities'));
        $this->config->setMetadataDriverImpl($driverImpl);
        $this->config->setQueryCacheImpl($cache);
        $this->config->setQueryCacheImpl($cache);
// Proxy configuration
        $this->config->setProxyDir(ApplicationPath::Models() . 'Proxies');
        $this->config->setProxyNamespace('Proxies');
// Set up logger
        #$logger = new EchoSQLLogger;
        #$config->setSQLLogger($logger);
        $this->config->setAutoGenerateProxyClasses(TRUE);

// Database connection information
        $this->connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' => $db[$tipoConexao]['username'],
            'password' => $db[$tipoConexao]['password'],
            'host' => $db[$tipoConexao]['hostname'],
            'dbname' => $db[$tipoConexao]['database'],
            'charset' => 'utf8',
            'port' => $db[$tipoConexao]['port'],
            'driverOptions' => array(1002 => 'SET NAMES utf8')
        );
        
        if(isset(self::$conn)){
            $this->em = self::$conn;
        }else{
            $this->em = EntityManager::create($this->connectionOptions, $this->config);
            self::$conn = $this->em;
        }

        
        
        //$this->conn = EntityManager::create($this->connectionOptions, $this->config);
        //$this->setEm();

        // Enforce connection character set. This is very important if you are
        // using MySQL and InnoDB tables!
        //Doctrine_Manager::connection()->setCharset('utf8');
        //Doctrine_Manager::connection()->setCollate('utf8_general_ci');
// Create EntityManager
        //$this->setEm(EntityManager::create($connectionOptions, $config));
    }
}