<aside class="widget">
    <h1 class="widget-title">
        Rechercher une formation
    </h1>
    <form role="search" method="post" class="search-form" action="<?php echo get_page_link(get_option("sygefor3_session_list_page")) ?>">
        <label>
            <span class="screen-reader-text">Rechercher une formation</span>
            <input type="search" class="search-field" placeholder="Recherche une formation" name="search" value="<?php echo isset($_POST['search']) ? stripslashes($_POST['search']) : null; ?>" title="Rechercher une formation">
        </label>
        <input type="submit" class="search-submit" value="Rechercher">
    </form>
</aside>