<aside class="widget">
    <h1 class="widget-title">Tags :
    </h1>
    <?php if (count($sessions["facets"]["tags"]["terms"])): ?>
        <ul style="margin: 0 0 0 0;">
            <?php foreach ($sessions["facets"]["tags"]["terms"] as $tag): ?>
                <li>
                    <?php if ($_GET['tag'] === $tag["term"]): ?>
                        <a href="<?php echo get_page_link(get_option("sygefor3_session_list_page"));?>?search=<?php echo $_GET['search'];?>">
                            <b>X <?php echo $tag["term"];?> (<?php echo $tag["count"];?>)</b>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo get_page_link(get_option("sygefor3_session_list_page"));?>?theme=<?php echo $_GET["theme"];?>&tag=<?php echo $tag["term"];?>&search=<?php echo $_GET['search'];?>">
                            <?php echo $tag["term"];?> (<?php echo $tag["count"];?>)
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside>