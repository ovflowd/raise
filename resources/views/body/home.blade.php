<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">see <b style="color:#7d8492">content</b></h2>
            <pre class="see">[ Base Information: Couchbase ]</pre>
            <br>
            <ul class="tabs" data-tabs id="items-tabs">
                <li class="tabs-title is-active"><a data-tabs-target="welcome">Welcome</a></li>
                <li class="tabs-title"><a data-tabs-target="list-clients" href="#list-clients">List Clients</a></li>
                <li class="tabs-title"><a data-tabs-target="list-logs" href="#list-logs">List Logs</a></li>
                <li class="tabs-title"><a data-tabs-target="list-statistics" href="#list-statistics">See statistics</a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="items-tabs">
                <div class="tabs-panel is-active" id="welcome">
                    <div class="grid-x grid-padding-x">
                        <div class="large-4 medium-4 small-12 cell">
                            <div class="callout info">
                                <h5>Welcome to RAISe visualizer.</h5>
                                On this page you can list logs, clients, and other base content provided by RAISe.
                                You also can list some statistics from RAISe. You also can hook inside a specific client
                                or check other stuff on this page.
                            </div>
                        </div>
                        <div class="large-8 medium-8 small-12 cell">
                            <b>Available Content</b>
                            <span class="see">Check what you can do on this page.</span>
                            <div class="grid-x grid-padding-x">
                                <div class="large-4 medium-4 small-12 cell">
                                    <div class="callout primary">
                                        <h5>Clients</h5>
                                        On this page you can list all the clients, sorted by last registered client to
                                        older clients.
                                    </div>
                                </div>
                                <div class="large-4 medium-4 small-12 cell">
                                    <div class="callout primary">
                                        <h5>Logs</h5>
                                        On this page you can list all the last triggered log & events records from this
                                        raise
                                        instance.
                                    </div>
                                </div>
                                <div class="large-4 medium-4 small-12 cell">
                                    <div class="callout primary">
                                        <h5>Statistics</h5>
                                        You can see things like last registered data, last registered service, and other
                                        statistics.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs-panel" id="list-clients">
                    @foreach ($clients as $client)
                        <div class="callout primary">
                            <a href="{{$client->id}}" class="see-button">Watch</a>
                            <h5>{{$client->document->name}}</h5>
                            <small>
                                [ {{empty($client->document->tags) ? 'No Tags' : implode(', ', $client->document->tags)}}
                                ]
                            </small>
                        </div>
                    @endforeach
                </div>
                <div class="tabs-panel" id="list-logs">
                    @foreach ($logs as $log)
                        <div class="callout primary">
                            <h5>ID: {{$log->id}}
                                <small>({{$log->document->table}})</small>
                            </h5>
                            <small>
                                <b>details:</b> {{$log->document->details}}<br>
                                <b>logged at:</b> {{date('d/m/Y h:i:s', $log->document->serverTime)}}
                            </small>
                        </div>
                    @endforeach
                </div>
                <div class="tabs-panel" id="list-statistics">
                    <b>No content yet.</b>
                </div>
            </div>
        </div>
    </div>
</div>
