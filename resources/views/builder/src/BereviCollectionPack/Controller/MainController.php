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

namespace src\BereviCollectionPack\Controller;

use \app\library\Controller;
use \app\library\Requirements;
use \app\library\CurlRequest;

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
            case "login":
                $this->loginAction($action, $httpGetAutorization);
                break;
            case "loginControl":
                $this->loginControlAction($action, $httpGetAutorization);
                break;
            case "loginAuthentication":
                $this->loginAuthenticationAction($action, $httpGetAutorization);
                break;
            case "account":
                $this->loginAction($action, $httpGetAutorization);
                break;
            case "adminPanel":
                $this->adminPanelAction($action, $httpGetAutorization);
                break;
            case "adminLogout":
                $this->adminLogoutAction($action, $httpGetAutorization);
                break;
            case "adminSettings":
                $this->adminSettingsAction($action, $httpGetAutorization);
                break;
            case "adminSettingsLoad":
                $this->adminSettingsLoadAction($action, $httpGetAutorization);
                break;
            case "adminEnvatoApi":
                $this->adminEnvatoApiAction($action, $httpGetAutorization);
                break;
        }
    }

    public function loginAction($action, $httpGetAutorization)
    {
        $this->view->render("backend", $action, [
            "httpGetAutorization" => $httpGetAutorization
        ]);
    }

    public function loginControlAction($action, $httpGetAutorization)
    {
        $referer = $this->request->realURL().substr($this->request->requestURI(), 0, -8);
        $securityToken = $this->services->logEncryption()->getToken();
        $isAuthorized = "http://ehlo-mailing.com/data/optimail_cleaner/envato/api/collection/index.php";
        $response = !empty($referer) ? $isAuthorized."?referer=".$referer."&token=".$securityToken : "ERROR";
        $response != "ERROR" ? $this->response->setCookie("_token", $securityToken, 0, "/") : null;

        echo $response;

        exit();
    }

    public function loginAuthenticationAction($action, $httpGetAutorization)
    {
        $authorizationCode = $this->view->getData($httpGetAutorization);
        $tokens = explode("-", $authorizationCode);

        list($accessToken, $securityToken) = $tokens;

        $controlToken = $_COOKIE['_token'];
        if ($controlToken != $securityToken) {
            $this->response->addHeader('HTTP/1.0 401 Unauthorized');
            die();
        }

        $_SESSION["authorization"] = $accessToken;

        $this->response->redirect("/admin/panel/optimail");
    }

    public function adminPanelAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $this->view->render("backend", $action, [
            "httpGetAutorization" => $httpGetAutorization
        ]);
    }

    public function adminSettingsAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $columns = [
            [
                "smtp_sender" => $this->request->getPOST('smtpSender'),
                "domain_name" => $this->request->getPOST('domainName'),
                "bounce_mail_handler_email" => $this->request->getPOST('bounceMailHandlerEmail'),
                "bounce_mail_handler_password" => $this->request->getPOST('bounceMailHandlerPassword'),
                "server_type" => $this->request->getPOST('serverType'),
                "bounce_times" => $this->request->getPOST('bounceTimes')
            ]
        ];

        $database = dirname(__FILE__)."/../Resources/config/data/settings.xml";
        (!file_exists($database)) ?
            $this->dataEngine->createDatabase("settings", "global", $columns, true, "BereviCollectionPack", "prod") :
            $lastSettings = $this->dataEngine->readLast("settings", true, "BereviCollectionPack")
        ;

        if (isset($lastSettings)) {
            $this->dataEngine->updateData("settings", $lastSettings["id"], $columns, true, "BereviCollectionPack");
        }

        return json_encode('{}');
    }

    public function adminEnvatoApiAction($action, $httpGetAutorization)
    {
        //$this->security->returnAuthorization();

        $results = [];

        return print vsprintf("%s", [json_encode($results)]);
    }

    public function adminSettingsLoadAction()
    {
        //$this->security->returnAuthorization();

        $database = dirname(__FILE__)."/../Resources/config/data/settings.xml";
        if (file_exists($database)) {
            $lastSettings = $this->dataEngine->readLast("settings", true, "BereviCollectionPack");
        }

        $smtpSender = (isset($lastSettings)) ? $lastSettings->{"smtp_sender"} : "";
        $domainName = (isset($lastSettings)) ? $lastSettings->{"domain_name"} : "";
        $bounceMailHandlerEmail = (isset($lastSettings)) ? $lastSettings->{"bounce_mail_handler_email"} : "";
        $bounceMailHandlerPassword = (isset($lastSettings)) ? $lastSettings->{"bounce_mail_handler_password"} : "";
        $serverType = (isset($lastSettings)) ? $lastSettings->{"server_type"} : "";
        $bounceTimes = (isset($lastSettings)) ? $lastSettings->{"bounce_times"} : "";

        $results = [
            "smtp_sender" => $smtpSender,
            "domain_name" => $domainName,
            "bounce_mail_handler_email" => $bounceMailHandlerEmail,
            "bounce_mail_handler_password" => $bounceMailHandlerPassword,
            "server_type" => $serverType,
            "bounce_times" => $bounceTimes
        ];

        return print vsprintf("%s", [json_encode($results)]);
    }

    public function adminLogoutAction()
    {
        //$this->security->revokeAuthorization();
        $this->response->redirect("/login");
    }
}
