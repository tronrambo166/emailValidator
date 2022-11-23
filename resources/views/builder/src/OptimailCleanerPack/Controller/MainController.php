<?php

/**
 * This file is part of Berevi Collection applications.
 *
 * (c) Alan Da Silva
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or on Codecanyon
 *
 * @see https://codecanyon.net/licenses/terms/regular
 */

namespace src\OptimailCleanerPack\Controller;

use \app\library\Controller;
use \app\library\Requirements;
use \app\library\Standardize;
use \src\OptimailCleanerPack\Validation\MailCleaner;
use \src\OptimailCleanerPack\Validation\BounceMailHandler;

class MainController extends Controller
{
    public function indexAction($action, $requirements)
    {
        $isRequirements = new Requirements;

        $httpGetAutorization = boolval(
            $isRequirements->httpGetAutorization(
                $action,
                $requirements
            )
        ) ? 'true' : 'false';

        switch ($action) {
            case "ocIndex":
                $this->ocIndexAction($action, $httpGetAutorization);
                break;
            case "ocAdvanced":
                $this->ocAdvancedAction($action, $httpGetAutorization);
                break;
            case "ocRuntime":
                $this->ocRuntimeAction($action, $httpGetAutorization);
                break;
            case "ocTimer":
                $this->ocTimerAction($action, $httpGetAutorization);
                break;
            case "ocTables":
                $this->ocTablesAction($action, $httpGetAutorization);
                break;
            case "ocTablesObjects":
                $this->ocTablesObjectsAction($action, $httpGetAutorization);
                break;
            case "ocTablesDownloadGood":
                $this->ocTablesDownloadGoodAction($action, $httpGetAutorization);
                break;
            case "ocTablesDownloadBad":
                $this->ocTablesDownloadBadAction($action, $httpGetAutorization);
                break;
            case "ocTablesDeleteFiles":
                $this->ocTablesDeleteFilesAction($action, $httpGetAutorization);
                break;
            case "ocBounceMail":
                $this->ocBounceMailAction($action, $httpGetAutorization);
                break;
            case "ocTablesBounce":
                $this->ocTablesBounceAction($action, $httpGetAutorization);
                break;
            case "ocTablesBounceObjects":
                $this->ocTablesBounceObjectsAction($action, $httpGetAutorization);
                break;
            case "ocTablesBounceDownloadBad":
                $this->ocTablesBounceDownloadBadAction($action, $httpGetAutorization);
                break;
            case "ocTablesBounceDeleteFiles":
                $this->ocTablesBounceDeleteFilesAction($action, $httpGetAutorization);
                break;
        }
    }

    public function ocIndexAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        return $this->view->render("backend", $action, [
            "httpGetAutorization" => $httpGetAutorization
        ]);
    }

    public function ocAdvancedAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $columns = [["percent" => "0", "active" => "0", "reload" => "1"]];
        $database = dirname(__FILE__)."/../Resources/config/data/timer.xml";
        (!file_exists($database)) ?
            $this->dataEngine->createDatabase("timer", "mail_cleaner", $columns, true, "OptimailCleanerPack", "prod") :
            $timer = $this->dataEngine->readLast("timer", true, "OptimailCleanerPack")
        ;

        (isset($timer)) ?
            $startTimer = ($timer->{"percent"} < 100 && $timer->{"active"} == 1 && $timer->{"reload"} == 1) ?
            "startTimer();$('#timer').modal('show');" : "" :
            $startTimer = ""
        ;

        (isset($timer)) ?
            $showModal = ($timer->{"percent"} == 100 && $timer->{"active"} == 1 && $timer->{"reload"} == 0) ?
            "startTimer();$('#timer').modal('show');" : "" :
            $showModal = ""
        ;

        return $this->view->render("backend", $action, [
            "httpGetAutorization" => $httpGetAutorization,
            "startTimer" => $startTimer,
            "showModal" => $showModal
        ]);
    }

    public function ocTimerAction()
    {
        //$this->security->returnAuthorization();

        $database = dirname(__FILE__)."/../Resources/config/data/timer.xml";
        if (file_exists($database)) {
            $timer = $this->dataEngine->readLast("timer", true, "OptimailCleanerPack");

            return print vsprintf("%s", [
                json_encode([
                    "percent" => $timer->{"percent"},
                    "active"  => $timer->{"active"},
                    "reload"  => $timer->{"reload"}
                ])
            ]);
        }

        return false;
    }

    public function ocRuntimeAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $mailCleaner = new MailCleaner(
            new Standardize,
            $this->services->loadServices()->convertCsvToArray
        );

        $options = [
            "fileName"  => $this->request->getPOST('fileName'),
            "txtEmails" => $this->request->getPOST('txtEmails'),
            "level" 	=> $this->request->getPOST('level'),
            "ascOrDesc" => $this->request->getPOST('ascOrDesc'),
            "tldAndSld" => $this->request->getPOST('tldAndSld'),
            "aeoTld" 	=> $this->request->getPOST('aeoTld'),
            "aeoSld" 	=> $this->request->getPOST('aeoSld')
        ];

        $fileInputName = isset($_FILES['fileInput']['name']) ? $_FILES['fileInput']['name'] : null;
        $fileInputTmpN = isset($_FILES['fileInput']['tmp_name']) ? $_FILES['fileInput']['tmp_name'] : null;

        $mailCleaner->run($fileInputName, $fileInputTmpN, $this->getSMTPSender(), $options["level"], $options, $this->dataEngine);

        return print vsprintf("%s", ['{}']);
    }

    public function ocTablesAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $database = dirname(__FILE__)."/../Resources/config/data/timer.xml";
        if (file_exists($database)) {
            $columns = [["percent" => "0", "active" => "0", "reload" => "1"]];
            $lastTimer = $this->dataEngine->readLast("timer", true, "OptimailCleanerPack");

            $this->dataEngine->updateData("timer", $lastTimer["id"], $columns, true, "OptimailCleanerPack");

            $isRecords = $this->isRecords("import") ? "" : "display:none;";
            $isRecordsMsg = $this->isRecords("import") ? "display:none;" : "";

            return $this->view->render("backend", $action, [
                "httpGetAutorization" => $httpGetAutorization,
                "isRecords" => $isRecords,
                "isRecordsMsg" => $isRecordsMsg
            ]);
        }
    }

    public function ocTablesObjectsAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $a = [];
        $dir = dirname(__FILE__)."/../Resources/config/data/import/";
        foreach (glob($dir."*.*") as $filename) {
            $file = explode("/", $filename);
            $data = dirname(__FILE__)."/../Resources/config/data/import/".end($file);
            if (file_exists($data)) {
                $a[] = json_decode(file_get_contents($data), true);
            }
        }

        $objects = json_encode($a);
        $objects = str_replace('}]},{"data":[', '},', $objects);
        $objects = str_replace('[{"data":', '{"data":', $objects);
        $objects = str_replace('}]}]', '}]}', $objects);

        return print vsprintf("%s", [$objects]);
    }

    public function ocTablesDownloadGoodAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $filename = $this->view->getData($httpGetAutorization);
        if ($filename) {
            $file = dirname(__FILE__)."/../Resources/config/data/import/".$filename.'-good';
            if (file_exists($file)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file.'.txt'));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.filesize($file));
                readfile($file);

                exit();
            } else {
                $this->response->redirect("/admin/panel/optimail/tables");
            }
        }

        exit();
    }

    public function ocTablesDownloadBadAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $filename = $this->view->getData($httpGetAutorization);
        if ($filename) {
            $file = dirname(__FILE__)."/../Resources/config/data/import/".$filename.'-bad';
            if (file_exists($file)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file.'.txt'));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.filesize($file));
                readfile($file);

                exit();
            } else {
                $this->response->redirect("/admin/panel/optimail/tables");
            }
        }

        exit();
    }

    public function ocTablesDeleteFilesAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $a = [];
        $filename = $this->view->getData($httpGetAutorization);
        $dir = dirname(__FILE__)."/../Resources/config/data/import/";
        if ($filename) {
            $originFile  = dirname(__FILE__)."/../Resources/config/data/import/".$filename;
            $detailsFile = dirname(__FILE__)."/../Resources/config/data/import/".$filename.'.brv';
            $goodFile    = dirname(__FILE__)."/../Resources/config/data/import/".$filename.'-good';
            $badFile     = dirname(__FILE__)."/../Resources/config/data/import/".$filename.'-bad';
            if (file_exists($originFile)) {
                unlink($originFile);
            }

            if (file_exists($detailsFile)) {
                unlink($detailsFile);
            }

            if (file_exists($goodFile)) {
                unlink($goodFile);
            }

            if (file_exists($badFile)) {
                unlink($badFile);
            }
        }

        foreach (glob($dir."*") as $isFile) {
            $file = explode("/", $isFile);
            $data = dirname(__FILE__)."/../Resources/config/data/import/".end($file);
            if (file_exists($data)) {
                $a[] = $data;
            }
        }

        if (empty($a)) {
            $this->response->redirect("/admin/panel/optimail/advanced");
        }

        $this->response->redirect("/admin/panel/optimail/tables");
    }

    public function ocBounceMailAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $dir = __DIR__."/../Resources/config/data/bounce";
        $database = dirname(__FILE__)."/../../BereviCollectionPack/Resources/config/data/settings.xml";
        if (file_exists($database)) {
            $lastSettings = $this->dataEngine->readLast("settings", true, "BereviCollectionPack");
        }

        $smtpSender = (isset($lastSettings)) ? $lastSettings->{"smtp_sender"} : "";
        $domainName = (isset($lastSettings)) ? $lastSettings->{"domain_name"} : "";
        $bounceMailHandlerEmail = (isset($lastSettings)) ? $lastSettings->{"bounce_mail_handler_email"} : "";
        $bounceMailHandlerPassword = (isset($lastSettings)) ? $lastSettings->{"bounce_mail_handler_password"} : "";
        $serverType = (isset($lastSettings)) ? $lastSettings->{"server_type"} : "";
        $bounceTimes = (isset($lastSettings)) ? $lastSettings->{"bounce_times"} : "";
        if ($serverType == "gmail" || $serverType == "hotmail" || $serverType == "yahoo" || $serverType == "aol" || $serverType == "ssl") {
            $serverType = "993/imap/ssl";
            if ($serverType == "gmail") {
                $domainName = "imap.gmail.com";
            } elseif ($serverType == "hotmail") {
                $domainName = "imap-mail.outlook.com";
            } elseif ($serverType == "yahoo") {
                $domainName = "imap.yahoo.com";
            } elseif ($serverType == "aol") {
                $domainName = "imap.aol.com";
            } elseif ($serverType == "ssl") {
                $domainName = $domainName;
            }
        } elseif ($serverType == "self" || $serverType == "other" || $serverType == "") {
            $serverType = "995/pop3/ssl/novalidate-cert";
        } elseif ($serverType == "imap") {
            $serverType = "143";
        } elseif ($serverType == "pop3") {
            $serverType = "110/pop3";
        } elseif ($serverType == "nntp") {
            $serverType = "119/nntp";
        }

        $bounceTimes = (isset($bounceTimes)) ? $bounceTimes : 3;
        $bounceMailHandler = new BounceMailHandler(
            $domainName,
            $serverType,
            $bounceMailHandlerEmail,
            $bounceMailHandlerPassword,
            $bounceTimes
        );

        return $bounceMailHandler->processBouncedEmails($dir);
    }

    public function ocTablesBounceAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $isRecords = $this->isRecords("bounce") ? "" : "display:none;";
        $isRecordsMsg = $this->isRecords("bounce") ? "display:none;" : "";

        return $this->view->render("backend", $action, [
            "httpGetAutorization" => $httpGetAutorization,
            "isRecords" => $isRecords,
            "isRecordsMsg" => $isRecordsMsg
        ]);
    }

    public function ocTablesBounceObjectsAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $a = [];
        $dir = dirname(__FILE__)."/../Resources/config/data/bounce/";
        foreach (glob($dir."*.brv") as $filename) {
            $file = explode("/", $filename);
            $data = dirname(__FILE__)."/../Resources/config/data/bounce/".end($file);
            if (file_exists($data)) {
                $a[] = json_decode(file_get_contents($data), true);
            }
        }

        $objects = json_encode($a);
        $objects = str_replace('}]},{"data":[', '},', $objects);
        $objects = str_replace('[{"data":', '{"data":', $objects);
        $objects = str_replace('}]}]', '}]}', $objects);

        return print vsprintf("%s", [$objects]);
    }

    public function ocTablesBounceDownloadBadAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $filename = $this->view->getData($httpGetAutorization);
        if ($filename) {
            $file = dirname(__FILE__)."/../Resources/config/data/bounce/".$filename.'-bad';
            if (file_exists($file)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file.'.txt'));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.filesize($file));
                readfile($file);

                exit();
            } else {
                $this->response->redirect("/admin/panel/optimail/tables/bounce");
            }
        }

        exit();
    }

    public function ocTablesBounceDeleteFilesAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $a = [];
        $filename = $this->view->getData($httpGetAutorization);
        $dir = dirname(__FILE__)."/../Resources/config/data/bounce/";
        if ($filename) {
            $detailsFile = dirname(__FILE__)."/../Resources/config/data/bounce/".$filename.'.brv';
            $badFile     = dirname(__FILE__)."/../Resources/config/data/bounce/".$filename.'-bad';
            if (file_exists($detailsFile)) {
                unlink($detailsFile);
            }

            if (file_exists($badFile)) {
                unlink($badFile);
            }
        }

        foreach (glob($dir."*") as $isFile) {
            $file = explode("/", $isFile);
            $data = dirname(__FILE__)."/../Resources/config/data/bounce/".end($file);
            if (file_exists($data)) {
                $a[] = $data;
            }
        }

        if (empty($a)) {
            $this->response->redirect("/admin/panel/optimail/advanced");
        }

        $this->response->redirect("/admin/panel/optimail/tables/bounce");
    }

    private function isRecords($folder)
    {
        $records = [];
        $dir = dirname(__FILE__)."/../Resources/config/data/".$folder."/";
        foreach (glob($dir."*.*") as $filename) {
            $file = explode("/", $filename);
            $data = dirname(__FILE__)."/../Resources/config/data/".$folder."/".end($file);
            if (file_exists($data)) {
                $records[] = $data;
            }
        }

        if (empty($records)) {
            return false;
        }

        return true;
    }

    private function getSMTPSender()
    {
        $database = dirname(__FILE__)."/../../BereviCollectionPack/Resources/config/data/settings.xml";
        if (file_exists($database)) {
            $lastSettings = $this->dataEngine->readLast("settings", true, "BereviCollectionPack");
        }

        $smtpSender = (isset($lastSettings)) ? $lastSettings->{"smtp_sender"} : "";

        return $smtpSender;
    }
}
