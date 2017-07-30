<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 small-12 cell">
            <h2 class="title">{{$client->name}}</h2>
            <pre class="see">[ {{empty($client->tags) ? 'No Tags' : implode(', ', $client->tags)}} ]</pre>
            <br>
            <div class="callout warning">
                <b>Chipset:</b> {{$client->chipset}}<br>
                <b>Mac Address:</b> {{$client->mac}}<br>
                <b>Channel:</b> {{$client->channel}}<br>
                <b>Processor:</b> {{$client->processor}}<br>
                <hr>
                <b>Registered at:</b> {{date('d/m/Y h:i:s', $client->serverTime)}}<br>
                <b>Unique Identifier:</b> {{$client->id}}
            </div>
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
            <div style="margin-top:0" class="callout table">
                <h4>List Services</h4>
                <ul style="margin: 20px;list-style: none;">
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
