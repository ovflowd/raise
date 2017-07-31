<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">{{$service->name}}</h2>
            <pre class="see">[ {{empty($service->tags) ? 'No Tags' : implode(', ', $service->tags)}} ]</pre>
            <br>
            <div class="grid-x grid-padding-x">
                <div class="large-6 medium-6 small-12 cell">
                    <b>Details</b>
                    <span class="see">You can see details about this service above.</span>
                    <div class="callout info">
                        <b>Client Identifier:</b> {{$service->clientId}}<br>
                        <b>Parameters:</b> {{implode(', ', $service->parameters)}}<br>
                        <hr>
                        <b>Unique Identifier:</b> {{$service->id}}<br>
                        <b>Registered at:</b> {{date('d/m/Y h:i:s', $service->clientTime)}}
                    </div>
                </div>
                <div class="large-6 medium-6 small-12 cell">
                    <br>
                    <div class="callout primary">
                        Here you can see all <b>data</b> entries of a specific <b>service</b>.
                        The limit of data visualization it's to the last 100 entries. (For performance and security
                        reasons). You can see the tags from the <b>data</b>, and the values of it.
                    </div>
                    <div class="callout code">
                        Keep in mind that this page it's only a brief of what this service has.
                    </div>
                </div>
            </div>
            <b>Data Sets</b>
            <span class="see">You can see a Data Table with all Data records at <b>RAISe</b>.</span>
            <div class="callout table">
                <h4><span>List Data</span></h4>
                <div class="table-content">
                    <ul>
                        @foreach ($data as $item)
                            <li>
                                <div class="callout primary">
                                    <small style="float:right"><b>Added
                                            at:</b> {{date('d/m/Y h:i:s', $item->document->clientTime)}}</small>
                                    <h5 style="color:#7d8492">ID: {{$item->id}}</h5>
                                    <b class="saw">Values</b>
                                    <p class="callout code small">
                                        @foreach (array_combine($service->parameters, $item->document->values) as $key => $value)
                                            <b>{{$key}}:</b> {{$value}},
                                        @endforeach
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
