<body>
<div class="grid-x">
    <div class="large-12 cell">
        <div class="top-bar">
            <ul class="menu">
                <li class="menu-text" onclick="window.location.href='@path/view/'">
                    <img src="@path/assets/svg/symbol.svg">
                    <span>raise</span>
                </li>
                <li>
                    <button data-open="explore-modal" class="mega-button">explore</button>
                </li>
            </ul>
            <div class="top-bar-right show-for-large show-for-medium">
                <span class="label secondary">0</span> new notifications
            </div>
        </div>
    </div>
</div>
<div class="grid-container">
    <div class="grid-x grid-padding-x">
        <div class="large-12 medium-12 cell hide-for-small-only">
            <br>
            <b class="saw">Announcement</b>
            <div style="display: flex;flex: 3">
                <div style="margin: 0;border-radius: 4px 0 0 4px;border: 2px solid #41444e;padding: 8px 10px;width:100%">
                    RAISe dashboard it's under development.
                </div>
                <button style="padding: 4px 40px;border: none;border-radius: 0 4px 4px 0;background: #41444e;color: #fff;" onclick="window.location.href='@path/manage/'">Logout</button>
            </div>
            <br>
        </div>
    </div>
</div>
<div class="reveal" id="explore-modal" data-reveal>
    <b class="saw">Explore at RAISe</b>
    <div style="display: flex;flex: 3">
        <input class="search_at" title="explore at raise" placeholder="search at raise..." type="text" style="margin: 0;border-radius: 4px 0 0 4px;border: 2px solid #8385D0;padding: 8px 10px;width:100%">
        <button style="padding: 4px 40px;border: none;border-radius: 0 4px 4px 0;background: #8385D0;color: #fff;">Search</button>
    </div>
    <br>
    <div class="grid-x">
        <div class="large-12 medium-12 small-12 cell">
            <ul class="search_results"></ul>
        </div>
    </div>
</div>