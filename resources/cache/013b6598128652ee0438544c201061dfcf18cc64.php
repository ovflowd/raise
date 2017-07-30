<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-6 medium-6 small-12 cell">
            <h2 class="title"><?php echo e($client->name); ?></h2>
            <pre class="see">[ <?php echo e(empty($client->tags) ? 'No Tags' : implode(', ', $client->tags)); ?> ]</pre>
            <br>
            <div class="callout warning">
                <b>Chipset:</b> <?php echo e($client->chipset); ?><br>
                <b>Mac Address:</b> <?php echo e($client->mac); ?><br>
                <b>Channel:</b> <?php echo e($client->channel); ?><br>
                <b>Processor:</b> <?php echo e($client->processor); ?><br>
                <hr>
                <b>Registered at:</b> <?php echo e(date('d/m/Y h:i:s', $client->serverTime)); ?><br>
                <b>Unique Identifier:</b> <?php echo e($client->id); ?>

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
                    <?php foreach($services as $service): ?>
                        <li>
                            <div class="callout primary">
                                <a href="/view/client/<?php echo e($service->id); ?>/data" class="see-button">Watch</a>
                                <h5><?php echo e($service->document->name); ?></h5>
                                <small>[ ID: <?php echo e($service->id); ?> ]</small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
