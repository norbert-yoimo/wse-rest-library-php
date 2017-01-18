<?php
//
// This code and all components (c) Copyright 2006 - 2016, Wowza Media Systems, LLC. All rights reserved.
// This code is licensed pursuant to the Wowza Public License version 1.0, available at www.wowza.com/legal.
//
namespace com\wowza;

use com\wowza\entities\application\helpers\Settings;

class Application extends Wowza
{
    private $restURI = "";
    private $appType = "Live";
    private $name = "";
    private $clientStreamReadAccess = "*";
    private $clientStreamWriteAccess = "*";
    private $description = "";

    public function __construct(
        Settings $settings,
        $name = "live",
        $appType = "Live",
        $clientStreamReadAccess = "*",
        $clientStreamWriteAccess = "*",
        $description = "*"
    ) {
        parent::__construct($settings);
        $this->name = $name;
        $this->appType = $appType;
        $this->clientStreamReadAccess = $clientStreamReadAccess;
        $this->clientStreamWriteAccess = $clientStreamWriteAccess;
        $this->description = $description;
        $this->restURI = $this->getHost() . "/servers/" . $this->getServerInstance() . "/vhosts/" . $this->getVHostInstance() . "/applications/{$name}";
    }

    public function get()
    {
        $this->_skip["name"] = true;
        $this->_skip["clientStreamReadAccess"] = true;
        $this->_skip["appType"] = true;
        $this->_skip["clientStreamWriteAccess"] = true;
        $this->_skip["description"] = true;

        return $this->sendRequest($this->preparePropertiesForRequest(), [], self::VERB_GET);
    }

    public function getAll()
    {
        $this->_skip["name"] = true;
        $this->_skip["clientStreamReadAccess"] = true;
        $this->_skip["appType"] = true;
        $this->_skip["clientStreamWriteAccess"] = true;
        $this->_skip["description"] = true;
        $this->restURI = $this->getHost() . "/servers/" . $this->getServerInstance() . "/vhosts/" . $this->getVHostInstance() . "/applications";

        return $this->sendRequest($this->preparePropertiesForRequest(), [], self::VERB_GET);
    }

    public function create(
        entities\application\StreamConfig $streamConfig,
        entities\application\SecurityConfig $securityConfig = null,
        entities\application\Modules $modules = null,
        entities\application\DvrConfig $dvrConfig = null,
        entities\application\TranscoderConfig $transConfig = null,
        entities\application\DrmConfig $drmConfig = null
    ) {
        $entities = $this->getEntites(func_get_args(), $this->restURI);

        return $this->sendRequest($this->preparePropertiesForRequest(), $entities);
    }

    public function update(
        entities\application\StreamConfig $streamConfig,
        entities\application\SecurityConfig $securityConfig = null,
        entities\application\Modules $modules = null,
        entities\application\DvrConfig $dvrConfig = null,
        entities\application\TranscoderConfig $transConfig = null,
        entities\application\DrmConfig $drmConfig = null
    ) {
        $entities = $this->getEntites(func_get_args(), $this->restURI);

        return $this->sendRequest($this->preparePropertiesForRequest(), $entities, self::VERB_PUT);
    }

    public function remove()
    {
        return $this->sendRequest($this->preparePropertiesForRequest(), [], self::VERB_DELETE);
    }

    public function getRestURI()
    {
        return $this->restURI;
    }

    public function getName()
    {
        return $this->name;
    }
}