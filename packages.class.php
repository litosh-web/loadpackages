<?php

class Packages
{
    public $modx;

    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
    }

    public function find($query, $provider)
    {
        $response = $this->modx->runProcessor('workspace/packages/rest/getlist', array(
            'provider' => $provider,
            'query' => $query,
        ));

        if ($response->isError()) {
            return $response->getMessage();
        }

        $res = $response->response;
        $res = $this->modx->fromJSON($res);

        if ($res['total']) {
            $info = $res['results'][0]['location'] . '::' . $res['results'][0]['signature'];
            return $info;
        }
    }

    public function exist($query)
    {
        $response = $this->modx->runProcessor('workspace/packages/getlist', array(
            'search' => $query,
        ));

        if ($response->isError()) {
            return $response->getMessage();
        }

        $res = $response->response;
        $res = $this->modx->fromJSON($res);

        if ($res['total']) {
            return true;
        }
    }

    public function download($info, $provider)
    {
        $response = $this->modx->runProcessor('workspace/packages/rest/download', array(
            'info' => $info,
            'provider' => $provider,
        ));

        if ($response->isError()) {
            return $response->getMessage();
        }

        $res = $response->getObject();

        if ($res->success) {
            return $res['signature'];
        }
    }

    public function install($signature)
    {
        $response = $this->modx->runProcessor('workspace/packages/install', array(
            'signature' => $signature,
        ));

        if ($response->isError()) {
            return $response->getMessage();
        }

        $res = $response->getObject();

        if ($res->success) {
            return true;
        }

    }
}

return 'Packages';