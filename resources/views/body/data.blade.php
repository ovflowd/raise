<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">{{$service->name}}</h2>
            <pre class="see">[ {{empty($service->tags) ? 'No Tags' : implode(', ', $service->tags)}} ]</pre>
            <br>
            <div class="grid-x">
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout info">
                        <b>Client Identifier:</b> {{$service->clientId}}<br>
                        <b>Service Parameters:</b> {{implode(', ', $service->parameters)}}<br>
                        <b>Registered at:</b> {{date('d/m/Y h:i:s', $service->serverTime)}}
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <div class="callout primary">
                        Here you can see all <b>data</b> entries of a specific <b>service</b>.
                        The limit of data visualization it's to the last 100 entries. (For performance and security
                        reasons). You can see the tags from the <b>data</b>, and the values of it.
                    </div>
                </div>
            </div>
            <div class="callout table">
                <h4>List Data</h4>
                <ul style="margin: 20px;list-style: none;">
                    @foreach ($data as $item)
                        <li>
                            <div class='callout primary'>
                                <h5>ID: {$item->id}</h5>
                                @foreach (array_combine($service->parameters, $item->document->values) as $key => $value)
                                    <b>{{$key}}:</b> {{$value}}
                                @endforeach
                                |
                                <small>Added at: {{date('d/m/Y h:i:s', $item->document->serverTime)}}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
