<?php
namespace CyberWorks\Core\Controllers;


class PatchController extends Controller
{
    public function doGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CyberWorks 3');
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function checkForUpdate($request, $response)
    {
        $latestVersion = $this->doGetRequest("https://api.github.com/repos/Cyberbyte-Studios/CyberWorks-3/releases/latest")->tag_name;
        $currentVersion = $this->container->config->get('version','1.1.3');
        $updatedNeeded = false;

        if ($latestVersion != $currentVersion) $updatedNeeded = true;

        return $response->withJson(['latest_version' => $latestVersion, 'current_version' => $currentVersion, 'needs_update' => $updatedNeeded]);
    }
}