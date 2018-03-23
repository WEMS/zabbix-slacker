<?php

namespace Wems\Zabbix;

class GraphService
{
    private $zabbix_baseurl;
    private $zabbix_username;
    private $zabbix_password;
    private $chart_period;
    private $chart_width;
    private $chart_height;
    private $chart_baseurl;
    private $chart_basedir;
    private $chart_cookie;
    private $timestamp;

    /** @var Params */
    protected $params;

    public function __construct()
    {
        $this->zabbix_baseurl = getenv('ZABBIX_BASE_URL');
        $this->zabbix_username = getenv('ZABBIX_USERNAME');
        $this->zabbix_password = getenv('ZABBIX_PASSWORD');
        $this->chart_period = 3600;
        $this->chart_width = 600;
        $this->chart_height = 390;
        $this->chart_baseurl = substr($this->zabbix_baseurl, 0, -strlen('/zabbix')) . '/slack_charts';
        $this->chart_basedir = getenv('SLACK_CHART_WEB_ROOT') . '/slack_charts';
        $this->chart_cookie = sys_get_temp_dir() . '/zcookies.txt';
        $this->timestamp = time();
    }

    public function setParams(Params $params)
    {
        $this->params = $params;
    }

    public function canProvideGraph(): bool
    {
        return $this->params->TYPE !== 'ACK';
    }

    public function getGraphImageUrl(): string
    {
        if (!is_dir($this->chart_basedir)) {
            mkdir($this->chart_basedir);
        }

        shell_exec('wget --save-cookies=' . $this->chart_cookie . '_' . $this->timestamp . ' --keep-session-cookies --post-data "name=' . $this->zabbix_username . '&password=' . $this->zabbix_password . '&enter=Sign+in" -O /dev/null -q ' . $this->zabbix_baseurl . '/index.php?login=1');
        shell_exec('wget --load-cookies=' . $this->chart_cookie . '_' . $this->timestamp . '  -O ' . $this->chart_basedir . '/graph-' . $this->params->ITEM_ID . '-' . $this->timestamp . '.png -q ' . $this->zabbix_baseurl . '/chart.php?itemids=' . $this->params->ITEM_ID . '&width=' . $this->chart_width . '&period=' . $this->chart_period);

        return $this->chart_baseurl. '/graph-' . $this->params->ITEM_ID . '-' . $this->timestamp . '.png';
    }
}
