<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 small-12 cell">
            <h2 class="title">list <b style="color:#7d8492">clients</b></h2>
            <pre class="see">[ Base Information: Couchbase{Client} ]</pre>
            <br>
            <div class="callout primary">
                Here you can list the clients that are registered at <b>raise</b>.
                You can select a specific <b>client</b> to hook more about it, like its services.
                You can also see the data from each service by clicking on a service.
            </div>
            <div class="callout table">
                <h4><span>List Clients</span></h4>
                <div class="table-content">
                    <ul>
                        @foreach ($clients as $client)
                            <li>
                                <div class="callout primary">
                                    <a href="{{$client->id}}" class="see-button">Watch</a>
                                    <h5>{{$client->document->name}}</h5>
                                    <small>[{{empty($client->document->tags) ? 'No Tags' : implode(', ', $client->document->tags)}}]</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="large-6 medium-6 small-12 cell">
            <h2 class="title">list <b style="color:#7d8492">logs</b></h2>
            <pre class="see">[ Base Information: Couchbase{Log} ]</pre>
            <br>
            <div class="callout primary">
                Here you can list the clients that are registered at <b>raise</b>.
                You can select a specific <b>client</b> to hook more about it, like its services.
                You can also see the data from each service by clicking on a service.
            </div>
            <div class="callout table">
                <h4><span>List Logs</span></h4>
                <div class="table-content">
                    <ul>
                        @foreach ($logs as $log)
                            <li>
                                <div class="callout primary">
                                    <h5>ID: {{$log->id}} <small>({{$log->document->table}})</small></h5>
                                    <small>
                                        <b>details:</b> {{$log->document->details}}<br>
                                        <b>logged at:</b> {{date('d/m/Y h:i:s', $log->document->serverTime)}}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
