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
                <li class="tabs-title"><a data-tabs-target="list-statistics" href="#list-statistics">See statistics</a>
                </li>
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
                    <b>Search Clients</b>
                    <span class="see">Search a client by tags or by the name.</span>
                    <input type="text" class="client-search" maxlength="100" placeholder="Search a Client.."/>
                    <br>
                    <ul class="list">
                        @foreach ($clients as $client)
                            <li>
                                <div class="callout primary">
                                    <a href="@path/view/client/{{$client->id}}" class="see-button">Watch</a>
                                    <h5 class="client-name">{{$client->document->name}}</h5>
                                    <small style="margin-top: -5px;display: block"><b>Added
                                            at:</b> {{date('d/m/Y h:i:s', $client->document->clientTime)}}</small>
                                    <small>
                                        [ {{empty($client->document->tags) ? 'No Tags' : 'Tags: ' . implode(', ', $client->document->tags)}} ]
                                    </small>
                                    <input type="hidden" class="client-tags" value="{{implode(', ', $client->document->tags)}}"/>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="pagination"></ul>
                </div>
                <div class="tabs-panel" id="list-logs">
                    <ul class="list">
                        @foreach ($logs as $log)
                            <li>
                                <div class="callout primary">
                                    <small style="float: right"><b>Added
                                            at:</b> {{date('d/m/Y h:i:s', $client->document->clientTime)}}</small>
                                    <h5>ID: {{$log->id}}
                                        <small>({{$log->document->table}})</small>
                                    </h5>
                                    <small>
                                        <b>Details:</b> {{$log->document->details}}
                                        <b>Document:</b> {{$log->document->element}}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="pagination"></ul>
                </div>
                <div class="tabs-panel" id="list-statistics">
                    <b>Last Client</b>
                    <span class="see">Last Client that sent a data Stream.</span>
                    <div class="callout primary">
                        <a href="@path/view/client/{{$clients[0]->id}}" class="see-button">Watch Client</a>
                        <h5>{{$clients[0]->document->name}}</h5>
                        <small style="margin-top: -5px;display: block"><b>Added
                                at:</b> {{date('d/m/Y h:i:s', $clients[0]->document->clientTime)}}</small>
                        <small>
                            [ {{empty($clients[0]->document->tags) ? 'No Tags' : 'Tags: ' . implode(', ', $clients[0]->document->tags)}} ]
                        </small>
                    </div>
                    <b>Last Data</b>
                    <span class="see">Last Data Document registered at RAISe</span>
                    <div class="callout primary">
                        <small style="float:right"><b>Added
                                at:</b> {{date('d/m/Y h:i:s', $data->document->clientTime)}}</small>
                        <h5 style="color:#7d8492">ID: {{$data->id}}
                            <small>(service: {{$service->name}})</small>
                        </h5>
                        <b class="saw">Values</b>
                        <a href="@path/view/service/{{$data->document->serviceId}}" class="see-button">Watch Service</a>
                        <p class="callout code small" style="max-width: 80%">
                            @foreach (array_combine($service->parameters, $data->document->values) as $key => $value)
                                <b>{{$key}}:</b> {{$value}},
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
