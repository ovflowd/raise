<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 small-8 cell">
            <h2 class="title"><b style="color:#7d8492">raise</b> settings</h2>
            <pre class="see">[ RAISe Version: 2.0.0 ]</pre>
            <br>
            <b>System Details</b>
            <small class="see">You can see the details about the host os behind raise.</small>
            <div class="callout code small">
                <b>System Version:</b> {{php_uname()}}<br>
                <b>PHP Version:</b> {{phpversion()}}<br>
                <b>Allocated Memory:</b> {{memory_get_usage() >> 10}}KB
            </div>
            <b>RAISe Details</b>
            <small class="see">You can see the details about your server configuration here.</small>
            <div class="callout table">
                <h4><span>RAISe Configuration Schema</span></h4>
                <div class="table-content">
                    <ul>
                        <li>
                            <b class="see">raise internal settings</b>
                            <div class="callout primary">
                                <small>
                                    <b>Database Type:</b> {{$settings->raise->databaseType}}<br>
                                    <b>Base Path:</b> {{empty($settings->raise->path) ? '/' : $settings->raise->path}}<br>
                                    <b>Working Directory:</b> {{$_SERVER['DOCUMENT_ROOT']}}
                                </small>
                            </div>
                        </li>
                        <li>
                            <b class="see">raise database settings</b>
                            <div class="callout primary">
                                <small>
                                    <b>Server Address: </b> {{$settings->database->address}}<br>
                                    <b>Server Username:</b> {{$settings->database->username}}<br>
                                    <b>Server Password:</b> ****** <sup>(hidden)</sup>
                                </small>
                            </div>
                        </li>
                        <li>
                            <b class="see">raise security settings</b>
                            <div class="callout primary">
                                <small>
                                    <b>Token Refresh Time:</b> {{$settings->security->expireTime}}<br>
                                    <b>Server Secret Key:</b> ****** <sup>(hidden)</sup><br>
                                    <b>Debug Mode:</b> {{$settings->security->debug ? 'Enabled' : 'Disabled'}}
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="large-6 medium-6 small-4 cell">
            <div class="callout primary">
                <h5>Welcome</h5>
                Welcome to the RAISe settings dashboard. Remember that all information displayed here it's crucial for
                the operation of your raise instance.
            </div>
            <b>System Alerts</b>
            <small class="see">This are you can see RAISe system alerts</small>
            <hr style="margin-top: 0;margin-bottom:17px">
            <div class="callout success small">
                <h5>Success</h5>
                Congratulations! You're using the latest version of <b>RAISe</b>.
                Using the latest version it's good for the environment.
            </div>
            @if($settings->security->secretKey == 'default-raise-secret-key')
                <div class="callout alert small">
                    <h5>Danger</h5>
                    Your <b>raise</b> instance it's using the default <b>crypto key</b> built in with
                    raise. Please consider changing it on your settings file.
                </div>
            @endif
            @if((empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off'))
                <div class="callout warning small">
                    <h5>Warning</h5>
                    This <b>raise</b> instance it's not running under <b>HTTPS</b> protocol. This means that all the
                    data can be leaked
                    or intercepted be steal. Please enable https to ensure a proper tunnel and security on your raise
                    instance.
                </div>
            @endif
            @if($settings->security->debug == true)
                <div class="callout info small">
                    <h5>Information</h5>
                    It seems that your server has debug mode enabled. If you're using this <b>raise</b> instance for
                    production purposes, consider disabling it.
                </div>
            @endif
            <b>Couchbase Environment</b>
            <small class="see">Check the Couchbase Buckets Status</small>
            <hr style="margin-top: 0;margin-bottom:17px">
            <div class="grid-x grid-padding-x">
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout primary">
                        <h5>Client Bucket</h5>
                        <small>
                            <b>Using CPU:</b> {{round($couchbase['client']['nodes'][0]['systemStats']['cpu_utilization_rate'])}}%<br>
                            <b>Uptime:</b> {{gmdate("H:i:s", $couchbase['client']['nodes'][0]['uptime'])}} <small>(hours:minutes:seconds)</small><br>
                            <b>Status: </b> {{$couchbase['client']['nodes'][0]['status']}}
                        </small>
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout primary">
                        <h5>Token Bucket</h5>
                        <small>
                            <b>Using CPU:</b> {{round($couchbase['token']['nodes'][0]['systemStats']['cpu_utilization_rate'])}}%<br>
                            <b>Uptime:</b> {{gmdate("H:i:s", $couchbase['token']['nodes'][0]['uptime'])}} <small>(hours:minutes:seconds)</small><br>
                            <b>Status: </b> {{$couchbase['token']['nodes'][0]['status']}}
                        </small>
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout primary">
                        <h5>Data Bucket</h5>
                        <small>
                            <b>Using CPU:</b> {{round($couchbase['data']['nodes'][0]['systemStats']['cpu_utilization_rate'])}}%<br>
                            <b>Uptime:</b> {{gmdate("H:i:s", $couchbase['data']['nodes'][0]['uptime'])}} <small>(hours:minutes:seconds)</small><br>
                            <b>Status: </b> {{$couchbase['data']['nodes'][0]['status']}}
                        </small>
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout primary">
                        <h5>Service Bucket</h5>
                        <small>
                            <b>Using CPU:</b> {{round($couchbase['service']['nodes'][0]['systemStats']['cpu_utilization_rate'])}}%<br>
                            <b>Uptime:</b> {{gmdate("H:i:s", $couchbase['service']['nodes'][0]['uptime'])}} <small>(hours:minutes:seconds)</small><br>
                            <b>Status: </b> {{$couchbase['service']['nodes'][0]['status']}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>