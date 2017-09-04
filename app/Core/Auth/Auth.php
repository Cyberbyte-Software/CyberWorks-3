<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 15:17
 */

namespace CyberWorks\Core\Auth;

use CyberWorks\Core\Models\Permissons;
use CyberWorks\Core\Models\User;

class Auth
{
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function attempt($username, $password) {
        if ($this->container->config->get('useIps', false)) {
            $this->ips_login($username, $password);
        } else {
            $this->normal_login($username, $password);
        }
    }

    private function normal_login($username, $password) {
        $user = User::where('name', $username)->orWhere('email', $username)->first();
        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            return true;
        }

        return false;
    }

    private function ips_login($username, $password) {
        $IPSConnectResponse = $this->container->slave->attempt($username, $password);

        if (!$IPSConnectResponse) {
            return false;
        } else {
            $user = User::where('connect_id', $IPSConnectResponse->connect_id)->first();

            $apiResults = $this->container->slave->doGetRequest("api/core/members/" .  $IPSConnectResponse->connect_id);

            if (!in_array($apiResults->primaryGroup->id, $this->container->config->get('ips.allowedGroups'))) {
                return false;
            }

            if (!$user) {
                if ($apiResults->validating) return false; //user is in validating, they cant login.

                $user = User::create([
                    'email' => $IPSConnectResponse->email,
                    'name' => $IPSConnectResponse->name,
                    'connect_id' => $IPSConnectResponse->connect_id,
                    'primaryGroup' => json_encode($apiResults->primaryGroup),
                    'secondaryGroups' => json_encode($apiResults->secondaryGroups),
                    'profilePicture' => $apiResults->photoUrl,
                    'profileUrl' => $apiResults->profileUrl,
                ]);

                $_SESSION['user_id'] = $user->id;

                $this->container->logger->info($IPSConnectResponse->name . "(" . $IPSConnectResponse->connect_id . ") Signed in to CyberWorks For The First Time!");

                return true;
            } else {
                $primaryGroup = json_decode($user->primaryGroup);
                $secondaryGroups = json_decode($user->secondaryGroups);

                if ($primaryGroup->id != $apiResults->primaryGroup->id) $user->primaryGroup = json_encode($apiResults->primaryGroup);
                if (count($secondaryGroups) != count($apiResults->secondaryGroups)) $user->secondaryGroups = json_encode($apiResults->secondaryGroups);
                if ($user->name != $IPSConnectResponse->name) $user->name = $IPSConnectResponse->name;
                if ($user->email != $IPSConnectResponse->email) $user->email = $IPSConnectResponse->email;
                if ($user->profileUrl != $apiResults->profileUrl) $user->profileUrl = $apiResults->profileUrl;
                if ($user->profilePicture != $apiResults->photoUrl) $user->profilePicture = $apiResults->photoUrl;

                if ($user->isDirty()) {
                    $this->container->logger->info($user->name . "(" . $user->connect_id . ") CyberWorks Cache Data Was Updated!");
                    $user->save();
                }

                $this->container->logger->info($user->name . "(" . $user->connect_id . ") Logged In To CyberWorks!");

                $_SESSION['user_id'] = $user->id;
                return true;
            }
        }
    }

    public function isAuthed() {
        return isset($_SESSION['user_id']);
    }

    public function user() {

        if ($this->isAuthed()) {
            return User::find($_SESSION['user_id']);
        }

        return false;
    }

    public function primaryGroup() {
        if ($this->isAuthed()) {
            $user = User::find($_SESSION['user_id']);
            return json_decode($user->primaryGroup);
        }

        return false;
    }

    public function permissions() {
        if ($this->isAuthed()) {
            $group = $this->primaryGroup();

            $perms = Permissons::find($group->id);

            return $perms;
        }

        return false;
    }

    public function isSuperUser() {
        $group = $this->primaryGroup();

        if (!$group) {
            return false;
        }

        $perms = $this->permissions();

        if ($perms->is_superUser) {
            return true;
        }

        return false;
    }

    public function logout() {
        unset($_SESSION['user_id']);
    }
}