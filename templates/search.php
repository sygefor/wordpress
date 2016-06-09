<aside class="widget">
    <h1 class="widget-title">
        Rechercher une formation
    </h1>
    <form role="search" method="post" class="search-form" action="/liste-des-sessions">
        <label>
            <span class="screen-reader-text">Rechercher une formation</span>
            <input type="search" class="search-field" placeholder="Recherche une formation" name="search" value="<?php echo $_GET['search']; ?>" title="Rechercher une formation">
        </label>
        <input type="submit" class="search-submit" value="Rechercher">
    </form>
</aside>