<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            @if($client->token->expireTime < time())
                <div class="callout alert small">
                    <b>Warning:</b> Your Client Token has already expired on <b><?= date('d/m/Y h:i:s',
                            $client->token->expireTime) ?></b>.
                    It's recommended to revalidate the Client.
                </div>
            @endif
        </div>
        <div class="large-6 medium-6 small-12 cell">
            @if($client->token->expireTime < time()) <h2 class="title" style="color:rgba(59, 65, 81, 0.52)">
                <s>{{$client->name}}</s></h2> @else <h2 class="title">{{$client->name}}</h2> @endif
            <pre class="see">[ {{empty($client->tags) ? 'No Tags' : implode(', ', $client->tags)}} ]</pre>
            <br>
            <b>Details</b>
            <span class="see">You can see details about this client above.</span>
            <div class="callout warning">
                <b>Chipset:</b> {{$client->chipset}}<br>
                <b>Mac Address:</b> {{$client->mac}}<br>
                <b>Channel:</b> {{$client->channel}}<br>
                <b>Processor:</b> {{$client->processor}}<br>
                <hr>
                <b>Registered at:</b> {{date('d/m/Y h:i:s', $client->clientTime)}}<br>
                <b>Unique Identifier:</b> {{$client->id}}
            </div>
            <b>Data Stream</b>
            <span class="see">You can see a list of last <b>100</b> data records of this client above.</span>
            <div class="callout primary">
                <canvas id="client_data" width="auto" height="150"></canvas>
            </div>
        </div>
        <div class="large-6 medium-6 small-12 cell">
            <b>Location</b>
            <span class="see">You can see the location of the client above.</span>
            <div id="map_canvas"></div>
            <br>
            <b>Services</b>
            <span class="see">You can list the <b>client</b> services on the table above.</span>
            <div class="callout table">
                <h4><span>List Services</span></h4>
                <div class="table-content">
                    <ul>
                        @foreach ($services as $service)
                            <li>
                                <div class="callout primary">
                                    <a href="/view/client/{{$service->id}}/data" class="see-button">Watch</a>
                                    <h5>{{$service->document->name}}</h5>
                                    <small>[ ID: {{$service->id}} ]</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
