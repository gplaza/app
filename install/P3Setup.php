<?php

namespace install;

use Composer\Script\Event;

class P3Setup
{

    public static function preInstall(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
        echo "Welcome to Phundament Installation 3 via composer\n\n";
   #     echo "This setup script will download all packages specified in composer.json. It will also trigger the creation of an " .
    #    "Yii web application, please answer the upcoming confirmation questions with [y]es.\n\n";
        #if (self::confirm("Install Phundament 3 now?")) {
#
 #       } else {
  #          exit("Installation aborted.\n");
   #     }
    }

    public static function postInstall(Event $event)
    {
        $app = self::getYiiApplication();

        $args = array('yiic', 'p3webapp', realpath(dirname(__FILE__) . '/..'));
        $app->commandRunner->run($args);

        $args = array('yiic', 'migrate');
        $app->commandRunner->run($args);

        #echo "\nUpdating config in index.php...\n";
        #$indexPhp = file_get_contents(dirname(__FILE__) . "/../index.php");
        #$indexPhp = str_replace("/protected/config/main.php", "/protected/config/main.p3.php", $indexPhp);
        #file_put_contents(dirname(__FILE__) . "/../index.php", $indexPhp);

        #echo "\nUpdating config in protected/yiic.php...\n";
        #$yiicPhp = file_get_contents(dirname(__FILE__) . "/../protected/yiic.php");
        #$yiicPhp = str_replace("/config/console.php", "/config/console.p3.php", $yiicPhp);
        #file_put_contents(dirname(__FILE__) . "/../protected/yiic.php", $yiicPhp);

        #        $app = self::getYiiApplication();
        #$app->commandRunner->run($args);


        $composer = $event->getComposer();
        // do stuff
        echo "\n\nInstallation completed.\n\nThank you for choosing Phundament 3!\n\n";
    }

    public static function preUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
        echo "Welcome to Phundament Installation 3 via composer\n\nUpdating your application to the lastest available packages...\n";
    }

    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
        echo "\n\nUpdate completed.\n\n";
    }

    /* public static function postUpdate(Event $event)
      {
      $composer = $event->getComposer();
      // do stuff
      } */

    public static function postPackageInstall(Event $event)
    {
        $installedPackage = $event->getOperation()->getPackage();

        // do stuff
        switch ($installedPackage->getName()) {
            case "yiisoft/yii":
                @mkdir(dirname(__FILE__) . '/../runtime', 0777);
                @chmod(dirname(__FILE__) . '/../runtime', 0777);


                return;
                break;
            /*
              case "mishamx/yii-user":
              $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3admin.modules-install.user.migrations', '--migrationTable=migration_module_user', '--interactive=0');
              break;
              case "crisu83/yii-rights":
              #exit();
              $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3admin.modules-install.rights.migrations', '--migrationTable=migration_module_rights', '--interactive=0');
              break;
              case "phundament/p3media":
              @mkdir(dirname(__FILE__) . '/../protected/data/p3media', 0777);
              @mkdir(dirname(__FILE__) . '/../protected/data/p3media-import', 0777);
              @chmod(dirname(__FILE__) . '/../protected/data/p3media', 0777);
              @chmod(dirname(__FILE__) . '/../protected/data/p3media-import', 0777);
              $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3media.migrations', '--migrationTable=migration_module_p3media', '--interactive=0');
              break;
              case "phundament/p3widgets":
              $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3widgets.migrations', '--migrationTable=migration_module_p3widgets', '--interactive=0');
              break;
              case "phundament/p3pages":
              $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3pages.migrations', '--migrationTable=migration_module_p3pages', '--interactive=0');
              break;
              case "phundament/themes/p3bootstrap":
              $app = self::getYiiApplication();
              $args = array('yiic', 'composerPackage');
              $commandPath = \Yii::app()->basePath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . $installedPackage->getName() . DIRECTORY_SEPARATOR . "commands";
              $app->commandRunner->addCommands($commandPath);
              break; */
            default:
                return;
        }

    }

    public static function postPackageUpdate(Event $event)
    {
        $installedPackage = $event->getOperation()->getTargetPackage();

        $app = self::getYiiApplication();
        $commandPath = \Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';

        switch ($installedPackage->getName()) {
            case "yiisoft/yii":
                return;
                break;
            case "mishamx/yii-user":
                $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3admin.modules-install.user.migrations', '--migrationTable=migration_module_user', '--interactive=0');
                break;
            case "crisu83/yii-rights":
                $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3admin.modules-install.rights.migrations', '--migrationTable=migration_module_rights', '--interactive=0');
                break;
            case "phundament/p3media":
                $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3media.migrations', '--migrationTable=migration_module_p3media', '--interactive=0');
                break;
            case "phundament/p3widgets":
                $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3widgets.migrations', '--migrationTable=migration_module_p3widgets', '--interactive=0');
                break;
            case "phundament/p3pages":
                $args = array('yiic', 'migrate', '--migrationPath=ext.phundament.p3pages.migrations', '--migrationTable=migration_module_p3pages', '--interactive=0');
                break;
            case "phundament/themes/p3bootstrap":
                $args = array('yiic', 'composerPackage');
                $commandPath = \Yii::app()->basePath . DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR . $installedPackage->getName() . DIRECTORY_SEPARATOR . "commands";
                break;
            default:
                return;
        }

        $app->commandRunner->addCommands($commandPath);
        #$app->commandRunner->run($args);
    }

    /**
     * Asks user to confirm by typing y or n.
     *
     * Credits to Yii CConsoleCommand
     *
     * @param string $message to echo out before waiting for user input
     * @return bool if user confirmed
     *
     * @since 0.5
     */
    public static function confirm($message)
    {
        echo $message . ' [yes|no] ';
        return !strncasecmp(trim(fgets(STDIN)), 'y', 1);
    }

    private static function getYiiApplication()
    {
        require_once(dirname(__FILE__) . '/../protected/extensions/yiisoft/yii/framework/yii.php');
        spl_autoload_register(array('YiiBase', 'autoload'));

        if (\Yii::app() === null) {
            $config = dirname(__FILE__) . '/../config/console.p3.php';
            $app = \Yii::createConsoleApplication($config);
        } else {
            $app = \Yii::app();
        }
        return $app;
    }

}
