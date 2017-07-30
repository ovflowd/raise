<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 small-12 cell">
            <h2 class="title">list clients</h2>
            <pre class="see">[ Base Information: Server ]</pre>
            <br>
            <div class="callout warning">
                Here you can list the clients that are registered at <b>raise</b>.
                You can select a specific <b>client</b> to hook more about it, like its services.
                You can also see the data from each service by clicking on a service.
            </div>
            <div class="callout table">
                <h4>List Clients</h4>
                <ul style="margin: 20px;list-style: none;">
                    <?php foreach($clients as $client): ?>
                        <li>
                            <div class="callout primary">
                                <a href="<?php echo e($client->id); ?>" class="see-button">Watch</a>
                                <h5><?php echo e($client->document->name); ?></h5>
                                [<?php echo e(empty($client->document->tags) ? 'No Tags' : implode(', ', $client->document->tags)); ?>]
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
