<div class="grid-container" style="margin: 50px 0;">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">list clients</h2>
            <pre class="see" style="margin-left:20px">[ Base Information: Server ]</pre>
            <br>
            <div class="callout warning" style="margin-left:20px">
                Here you can list the clients that are registered at <b>raise</b>.
                You can select a specific <b>client</b> to hook more about it, like its services.
                You can also see the data from each service by clicking on a service.
            </div>
            <div class="callout table" style="margin-left:20px">
                <h4>List Clients</h4>
                <ul style="margin: 20px;list-style: none;">
                    <?php if (empty($clients)) {
    return;
}

                    foreach ($clients as $client):
                        echo "<li><div class='callout primary'>".
                            "<a href='{$client->id}' style='float:right' class='see-button'>Watch</a>".
                            "<h5>{$client->document->name}</h5>[{$client->document->tags}]</div></li>";
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
