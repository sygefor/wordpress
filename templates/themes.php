<aside class="widget">
    <h1 class="widget-title">Thèmes :
    </h1>
    <?php if (count($sessions["facets"]["theme"]["terms"])): ?>
        <ul style="margin: 0 0 0 0;">
            <?php foreach ($sessions["facets"]["theme"]["terms"] as $theme): ?>
                <li>
                    <?php if (isset($_GET['theme']) && stripslashes($_GET['theme']) === $theme["term"]): ?>
		                    <a href="<?php echo get_page_link(get_option("sygefor3_session_list_page"));?>?search=<?php echo $_GET['search'];?>">
		                        <b>X <?php echo $theme["term"];?> (<?php echo $theme["count"];?>)</b>
		                    </a>
                    <?php else: ?>
		                    <a href="<?php echo get_page_link(get_option("sygefor3_session_list_page"));?>?theme=<?php echo $theme["term"];?>&tag=<?php echo $_GET['tag'];?>&search=<?php echo $_GET['search'];?>">
		                        <?php echo $theme["term"];?> (<?php echo $theme["count"];?>)
		                    </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside>