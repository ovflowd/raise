<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">{{$service->name}}</h2>
            <pre class="see hide-for-small-only">[ {{empty($service->tags) ? 'No Tags' : implode(', ', $service->tags)}} ]</pre>
            <br>
            <div class="grid-x grid-padding-x">
                <div class="large-6 medium-6 small-12 cell">
                    <b>Details</b>
                    <span class="see">You can see details about this service above.</span>
                    <div class="callout info">
                        <div class="hide-for-small-only"><b>Client Identifier:</b> {{$service->clientId}}<br></div>
                        <b>Parameters:</b> {{implode(', ', $service->parameters)}}<br>
                        <hr>
                        <b>Registered at:</b> {{date('d/m/Y h:i:s', $service->clientTime)}}<br>
                        <div class="hide-for-small-only"><b>Unique Identifier:</b> {{$service->id}}</div>
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
            <b>Data Graph</b>
            <span class="see">You can see a Graph with all Data records at <b>RAISe</b>.</span>
            <div class="callout box">
                <canvas id="service_data" width="auto" height="50"></canvas>
            </div>
            <b>Data Sets</b>
            <span class="see">You can see a Data Table with all Data records at <b>RAISe</b>.</span>
            <div class="callout table">
                <h4><span>List Data</span></h4>
                <div class="table-content" id="list-data">
                    <ul>
                        <li>
                            <b>Filter Data</b>
                            <span class="see">Search Data by date or values.</span>
                            <input type="text" class="data-search" style="padding:20px" maxlength="100" placeholder="Search a Data entry.."/>
                        </li>
                    </ul>
                    <ul class="list">
                        @foreach ($data as $item)
                            <li>
                                <div class="callout primary">
                                    <small style="float:right" class="data-date"><b>Added
                                            at:</b> {{date('d/m/Y h:i:s', $item->document->clientTime)}}</small>
                                    <h5 style="color:#7d8492" class="hide-for-small-only">ID: {{$item->id}}</h5>
                                    <b class="saw">Values</b>
                                    <p class="callout code small">
                                        @foreach (array_combine((array)$service->parameters, (array)$item->document->values) as $key => $value)
                                            <b>{{$key}}:</b> {{$value}},
                                        @endforeach
                                    </p>
                                    <input type="hidden" class="data-values" value="{{implode(', ', $item->document->values)}}"/>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="pagination"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
