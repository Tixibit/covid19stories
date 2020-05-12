<section class="hero jumbotron rounded-0 bg-dark text-light">
    <div class="container">
        <h1 class="jumbotron-heading text-bold">
         Tell Your COVID-19 Story
        </h1>
        <p class="text-muted-light">
            The stories on this website are collected automatically from social media and made available on this website.
            However, you can also submit your own story on this page
        </p>

    </div>
</section>

<div class="container">
    <% if not $CurrentUser %>
    <div class="col-md-7">
        <p>
        You must be logged in to tell and submit your COVID-19 story. Please login <a href="/Security/login?BackURL=/tell-your-story">here</a>
        </p>
        <p>
            <a class="btn btn-info my-2 my-sm-0" href="/Security/login?BackURL=/tell-your-story">Login</a>
    </div>
    <% else %>
    $addCovidStroyForm
    <% end_if %>
</div>
