<section class="hero jumbotron rounded-0 bg-dark text-light">
    <div class="container">
        <h1 class="jumbotron-heading text-bold">
         Stories
        </h1>
        <p class="text-muted-light">
            Stories and real experiences from people affected by COVID-19
        </p>

    </div>
</section>

<div class="container">
    <div class="col-md-4">

    </div>

    <div class="col-md-8">
        <ul class="nav mb-4 nav-pills">
            <li class="nav-item pt-1 text-bold pr-4">
                Filter By Type:
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/stories">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/stories#">Stories Added Here</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/stories#">Twitter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/stories#">Youtube</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/stories#">Instgram</a>
            </li>
        </ul>

        <div class="row">
            <% if $getStoriesFromTwitter %>
                <% loop $getStoriesFromTwitter %>
                <div class="col-md-4 mb-3">
                    <p class="text-lead">
                        $Text
                    </p>
                </div>
                <% end_loop %>
            <% end_if %>
        </div>
    </div>
</div>
